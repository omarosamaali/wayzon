<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SallaStore;
use App\Models\User;
use App\Services\SallaTokenService;
use Illuminate\Http\Request;

class InternalApiController extends Controller
{
    public function orderStatus(Request $request)
    {
        // Simple secret key check
        $secret = config('services.internal.secret', 'wyns-internal-2024');
        if ($request->header('X-Internal-Secret') !== $secret) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tenantId = $request->query('tenant_id');
        $search   = trim($request->query('order_id', ''));

        if (!$tenantId || !$search) {
            return response()->json(['found' => false, 'error' => 'missing params'], 400);
        }

        // Search by reference_id or salla_order_id
        $order = Order::where('user_id', $tenantId)
            ->where(function ($q) use ($search) {
                $q->where('reference_id', $search)
                  ->orWhere('salla_order_id', $search);
            })
            ->latest()
            ->first();

        $statusMap = [
            'new'                => 'جديد 🆕',
            'in_progress'        => 'قيد التنفيذ 🔄',
            'under_review'       => 'بانتظار المراجعة ⏳',
            'pending_review'     => 'بانتظار المراجعة ⏳',
            'pending_payment'    => 'بانتظار الدفع 💳',
            'paid'               => 'تم الدفع ✅',
            'payment_confirmed'  => 'تم الدفع ✅',
            'shipped'            => 'تم الشحن 🚚',
            'delivering'         => 'جاري التوصيل 🛵',
            'out_for_delivery'   => 'جاري التوصيل 🛵',
            'delivered'          => 'تم التوصيل 🎉',
            'canceled'           => 'ملغي ❌',
            'returned'           => 'مسترجع 🔁',
            'refunded'           => 'مسترجع 🔁',
            'under_return'       => 'قيد الاسترجاع 🔄',
            'return_in_progress' => 'قيد الاسترجاع 🔄',
            'pending_quote'      => 'بانتظار عرض سعر 📋',
            'pending_quotation'  => 'بانتظار عرض سعر 📋',
        ];

        if ($order) {
            return response()->json([
                'found'         => true,
                'order_id'      => $order->reference_id ?: $order->salla_order_id,
                'customer_name' => $order->customer_name,
                'status'        => $order->status,
                'status_label'  => $statusMap[$order->status] ?? $order->status,
                'total'         => $order->total,
            ]);
        }

        // Order not in DB — fetch directly from Salla API
        $store = SallaStore::where('user_id', $tenantId)->first();
        if (!$store) {
            return response()->json(['found' => false]);
        }

        try {
            $token    = (new SallaTokenService())->getValidToken($store);
            $response = \Illuminate\Support\Facades\Http::withToken($token)
                ->timeout(8)
                ->get("https://api.salla.dev/admin/v2/orders/{$search}");

            if (!$response->successful()) {
                // Try searching by reference_id
                $response = \Illuminate\Support\Facades\Http::withToken($token)
                    ->timeout(8)
                    ->get('https://api.salla.dev/admin/v2/orders', ['reference_id' => $search]);

                $items = $response->json('data', []);
                $sallaOrder = $items[0] ?? null;
            } else {
                $sallaOrder = $response->json('data');
            }

            if (!$sallaOrder) {
                return response()->json(['found' => false]);
            }

            $status = $sallaOrder['status']['slug'] ?? 'unknown';

            return response()->json([
                'found'         => true,
                'order_id'      => $sallaOrder['reference_id'] ?? $sallaOrder['id'],
                'customer_name' => trim(($sallaOrder['customer']['first_name'] ?? '') . ' ' . ($sallaOrder['customer']['last_name'] ?? '')),
                'status'        => $status,
                'status_label'  => $statusMap[$status] ?? $status,
                'total'         => $sallaOrder['amounts']['total']['amount'] ?? 0,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('orderStatus Salla fallback: ' . $e->getMessage());
            return response()->json(['found' => false]);
        }
    }

    public function productSearch(Request $request)
    {
        $secret = config('services.internal.secret', 'wyns-internal-2024');
        if ($request->header('X-Internal-Secret') !== $secret) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tenantId = $request->query('tenant_id');
        $query    = trim($request->query('q', ''));

        if (!$tenantId || !$query) {
            return response()->json(['found' => false, 'error' => 'missing params'], 400);
        }

        $store = SallaStore::where('user_id', $tenantId)->first();
        if (!$store || !$store->access_token) {
            return response()->json(['found' => false, 'error' => 'no store']);
        }

        $token = (new SallaTokenService())->getValidToken($store);

        try {
            $response = \Illuminate\Support\Facades\Http::withToken($token)
                ->timeout(8)
                ->get('https://api.salla.dev/admin/v2/products', ['search' => $query, 'per_page' => 5]);

            if (!$response->successful()) {
                return response()->json(['found' => false]);
            }

            $items = $response->json('data', []);
            if (empty($items)) {
                return response()->json(['found' => false]);
            }

            $products = collect($items)->map(fn($p) => [
                'name'  => $p['name'] ?? '',
                'price' => $p['price']['amount'] ?? ($p['regular_price']['amount'] ?? null),
                'url'   => $p['url'] ?? null,
                'sku'   => $p['sku'] ?? null,
                'stock' => $p['quantity'] ?? null,
            ])->filter(fn($p) => $p['name'])->values();

            return response()->json(['found' => true, 'products' => $products]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('productSearch error: ' . $e->getMessage());
            return response()->json(['found' => false]);
        }
    }

    public function waDisconnected(Request $request)
    {
        $secret = config('services.internal.secret', 'wyns-internal-2024');
        if ($request->header('X-Internal-Secret') !== $secret) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tenantId = $request->input('tenantId');
        if (!$tenantId) return response()->json(['ok' => false]);

        // Store disconnect flag so dashboard can show alert
        User::where('id', $tenantId)->update(['wa_disconnected' => true]);

        \Illuminate\Support\Facades\Log::warning("WhatsApp permanently disconnected for tenant {$tenantId}");

        return response()->json(['ok' => true]);
    }
}
