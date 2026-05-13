<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SallaStore;
use App\Models\User;
use App\Services\SallaTokenService;
use App\Support\SallaOrderPresenter;
use App\Support\SallaProductPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InternalApiController extends Controller
{
    public function orderStatus(Request $request)
    {
        $secret = config('services.internal.secret', 'wyns-internal-2024');
        if ($request->header('X-Internal-Secret') !== $secret) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tenantId = $request->query('tenant_id');
        $search   = trim((string) $request->query('order_id', ''));

        if (! $tenantId || $search === '') {
            return response()->json(['found' => false, 'error' => 'missing params'], 400);
        }

        $store = SallaStore::where('user_id', $tenantId)->first();

        if ($store?->access_token) {
            try {
                $sallaOrder = $this->fetchSallaOrderPayload($store, $tenantId, $search);
                if (is_array($sallaOrder) && $sallaOrder !== []) {
                    $slug = SallaOrderPresenter::statusSlugFromOrder($sallaOrder);

                    return response()->json([
                        'found'         => true,
                        'order_id'      => (string) ($sallaOrder['reference_id'] ?? $sallaOrder['id'] ?? $search),
                        'customer_name' => trim(($sallaOrder['customer']['first_name'] ?? '').' '.($sallaOrder['customer']['last_name'] ?? '')),
                        'status'        => $slug,
                        'status_label'  => SallaOrderPresenter::statusLabelFromOrder($sallaOrder),
                        'total'         => SallaOrderPresenter::orderTotalFromPayload($sallaOrder),
                    ]);
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('orderStatus Salla: '.$e->getMessage());
            }
        }

        $order = Order::where('user_id', $tenantId)
            ->where(function ($q) use ($search) {
                $q->where('reference_id', $search)
                    ->orWhere('salla_order_id', $search);
            })
            ->latest()
            ->first();

        if (! $order) {
            return response()->json(['found' => false]);
        }

        $payload = is_array($order->raw_payload) ? $order->raw_payload : [];
        $fromApi = SallaOrderPresenter::orderTotalFromPayload($payload);
        $total   = $fromApi > 0 ? $fromApi : (float) $order->total;
        $slug    = $payload !== [] ? SallaOrderPresenter::statusSlugFromOrder($payload) : $order->status;
        $label   = $payload !== [] ? SallaOrderPresenter::statusLabelFromOrder($payload) : SallaOrderPresenter::arabicStatusFromSlug((string) $order->status);

        return response()->json([
            'found'         => true,
            'order_id'      => $order->reference_id ?: $order->salla_order_id,
            'customer_name' => $order->customer_name,
            'status'        => $slug,
            'status_label'  => $label,
            'total'         => $total,
        ]);
    }

    /**
     * Live order JSON from Salla (preferred over local DB for totals / Arabic status).
     */
    private function fetchSallaOrderPayload(SallaStore $store, mixed $tenantId, string $search): ?array
    {
        $token = (new SallaTokenService())->getValidToken($store);

        $response = Http::withToken($token)->timeout(12)->get('https://api.salla.dev/admin/v2/orders', [
            'reference_id' => $search,
            'per_page'     => 10,
        ]);
        if ($response->successful()) {
            $items = $response->json('data', []);
            foreach ($items as $row) {
                if (! is_array($row)) {
                    continue;
                }
                $ref = (string) ($row['reference_id'] ?? '');
                if ($ref === $search || $ref === ltrim($search, '#')) {
                    return $row;
                }
            }
            if (! empty($items[0]) && is_array($items[0])) {
                return $items[0];
            }
        }

        if (ctype_digit($search)) {
            $response = Http::withToken($token)->timeout(12)->get("https://api.salla.dev/admin/v2/orders/{$search}");
            if ($response->successful()) {
                $data = $response->json('data');
                if (is_array($data) && $data !== []) {
                    return $data;
                }
            }
        }

        $order = Order::where('user_id', $tenantId)
            ->where(function ($q) use ($search) {
                $q->where('reference_id', $search)->orWhere('salla_order_id', $search);
            })
            ->whereNotNull('salla_order_id')
            ->latest()
            ->first();

        if ($order && $order->salla_order_id !== '') {
            $response = Http::withToken($token)->timeout(12)->get('https://api.salla.dev/admin/v2/orders/'.$order->salla_order_id);
            if ($response->successful()) {
                $data = $response->json('data');
                if (is_array($data) && $data !== []) {
                    return $data;
                }
            }
        }

        return null;
    }

    public function productSearch(Request $request)
    {
        $secret = config('services.internal.secret', 'wyns-internal-2024');
        if ($request->header('X-Internal-Secret') !== $secret) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tenantId = $request->query('tenant_id');
        $query     = trim($request->query('q', ''));
        $catalog   = filter_var($request->query('catalog', false), FILTER_VALIDATE_BOOLEAN);

        if (! $tenantId) {
            return response()->json(['found' => false, 'error' => 'missing params'], 400);
        }

        $store = SallaStore::where('user_id', $tenantId)->first();
        if (! $store || ! $store->access_token) {
            return response()->json(['found' => false, 'error' => 'no store']);
        }

        $token = (new SallaTokenService())->getValidToken($store);

        $clean = preg_replace('/\s+/u', ' ', $query);
        $clean = trim((string) preg_replace(
            '/\s*(ويش|وش|ايش|شنو|عندكم|عندك|بكم|بكام|السعر|سعر|منتجات?|متوفرة?|تتوفر|متوفر|موجود|الأسعار|اسعار|ر\s*يال|ر\s*\.?\s*س|ريال|طلب|عرض|كتالوج|قائمة)\s*/iu',
            ' ',
            $clean
        ));

        $useCatalog = $catalog
            || mb_strlen($clean) < 2
            || mb_strlen($query) > 140
            || (bool) preg_match('/^(عندكم|وش\s*عندكم|ايش\s*عندكم|شنو\s*عندكم|منتجات|عرض\s*المنتجات|كل\s*المنتجات)/iu', $query);

        try {
            if ($useCatalog) {
                $response = \Illuminate\Support\Facades\Http::withToken($token)
                    ->timeout(12)
                    ->get('https://api.salla.dev/admin/v2/products', [
                        'per_page' => 8,
                        'page'     => 1,
                    ]);
            } else {
                $response = \Illuminate\Support\Facades\Http::withToken($token)
                    ->timeout(12)
                    ->get('https://api.salla.dev/admin/v2/products', [
                        'search'   => mb_substr($clean, 0, 80),
                        'per_page' => 8,
                        'page'     => 1,
                    ]);
            }

            if (! $response->successful()) {
                return response()->json(['found' => false]);
            }

            $items = $response->json('data', []);
            if ($items === []) {
                return response()->json(['found' => false]);
            }

            $products = collect($items)->map(function ($p) {
                $priceRaw = $p['price'] ?? $p['regular_price'] ?? null;
                $price = is_array($priceRaw)
                    ? ($priceRaw['amount'] ?? $priceRaw['min']['amount'] ?? null)
                    : $priceRaw;
                $avail = SallaProductPresenter::availability($p);

                return [
                    'name'      => $p['name'] ?? '',
                    'price'     => $price ? (float) $price : null,
                    'url'       => $p['url'] ?? null,
                    'sku'       => $p['sku'] ?? null,
                    'stock'     => $avail['quantity'],
                    'unlimited' => $avail['unlimited'],
                    'in_stock'  => $avail['in_stock'],
                ];
            })->filter(fn ($p) => $p['name'])->values();

            return response()->json(['found' => true, 'products' => $products]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('productSearch error: '.$e->getMessage());

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
