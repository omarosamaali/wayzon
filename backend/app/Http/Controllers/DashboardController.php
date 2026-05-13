<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SallaStore;
use App\Services\SallaTokenService;
use App\Support\SallaOrderPresenter;
use App\Support\SallaProductPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $monthlySalesDb = (float) Order::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $monthlyOrdersDb = (int) Order::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $monthlySales  = $monthlySalesDb;
        $monthlyOrders = $monthlyOrdersDb;

        $totalCustomers = (int) Order::where('user_id', $userId)
            ->whereNotNull('customer_phone')
            ->where('customer_phone', '!=', '')
            ->distinct()
            ->count('customer_phone');

        $waSent = Order::where('user_id', $userId)
            ->where('whatsapp_sent', true)
            ->count();

        $recentOrders = Order::where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get();

        $orderCounts = [
            'all'       => Order::where('user_id', $userId)->count(),
            'new'       => Order::where('user_id', $userId)->where('status', 'new')->count(),
            'shipped'   => Order::where('user_id', $userId)->whereIn('status', ['shipped', 'processing'])->count(),
            'delivered' => Order::where('user_id', $userId)->where('status', 'delivered')->count(),
            'canceled'  => Order::where('user_id', $userId)->where('status', 'canceled')->count(),
        ];

        $store = SallaStore::where('user_id', $userId)->first();

        if ($store?->access_token) {
            $remote = Cache::remember(
                'wayzon_salla_month_stats_'.$userId,
                300,
                fn () => $this->sallaMonthOrderAggregates($store)
            );
            if (is_array($remote)) {
                $monthlySales = max($monthlySales, (float) ($remote['sales'] ?? 0));
                // Prefer طلبات Wayzon المحفوظة محلياً عند وجودها؛ وإلا استخدم إجمالي سلة للشهر.
                if ($monthlyOrdersDb < 1) {
                    $monthlyOrders = max($monthlyOrders, (int) ($remote['orders'] ?? 0));
                }
            }
        }

        $customerRows = Order::query()
            ->where('user_id', $userId)
            ->whereNotNull('customer_phone')
            ->where('customer_phone', '!=', '')
            ->selectRaw('customer_phone as phone, MAX(customer_name) as name, COUNT(*) as orders_count, SUM(COALESCE(total, 0)) as spent, MAX(created_at) as last_order_at')
            ->groupBy('customer_phone')
            ->orderByDesc('spent')
            ->limit(80)
            ->get();

        $topCustomers = $customerRows->take(6);

        $rows = Order::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->selectRaw('DATE(created_at) as d, SUM(total) as sales, COUNT(*) as cnt')
            ->groupBy('d')
            ->get()
            ->keyBy('d');

        $chartLabels = [];
        $chartSales  = [];
        $chartOrders = [];
        for ($i = 29; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = (string) (30 - $i);
            $row = $rows->get($day);
            $chartSales[]  = $row ? (float) $row->sales : 0.0;
            $chartOrders[] = $row ? (int) $row->cnt : 0;
        }

        $categoryWeights = [];
        Order::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(90))
            ->get()
            ->each(function (Order $o) use (&$categoryWeights) {
                $items = $o->raw_payload['items'] ?? [];
                if (! is_array($items) || $items === []) {
                    return;
                }
                foreach ($items as $it) {
                    $cat = data_get($it, 'product.category.name')
                        ?? data_get($it, 'product.main_category.name')
                        ?? data_get($it, 'categories.0.name')
                        ?? 'عام';
                    $qty = (int) ($it['quantity'] ?? 1);
                    $categoryWeights[$cat] = ($categoryWeights[$cat] ?? 0) + max(1, $qty);
                }
            });

        $categoryChart = $this->buildCategoryChartRows($categoryWeights);

        $shipDelivering = Order::where('user_id', $userId)->whereIn('status', ['shipped', 'delivering', 'out_for_delivery'])->count();
        $shipDone        = Order::where('user_id', $userId)->where('status', 'delivered')->count();
        $shipProblem     = Order::where('user_id', $userId)->whereIn('status', ['canceled', 'returned', 'refunded'])->count();

        $greetingDate = now()->locale('ar')->translatedFormat('l، j F Y');

        return view('dashboard', compact(
            'monthlySales',
            'monthlyOrders',
            'totalCustomers',
            'waSent',
            'recentOrders',
            'orderCounts',
            'store',
            'chartLabels',
            'chartSales',
            'chartOrders',
            'categoryChart',
            'shipDelivering',
            'shipDone',
            'shipProblem',
            'greetingDate',
            'customerRows',
            'topCustomers'
        ));
    }

    /**
     * @param  array<string,int|float>  $weights
     * @return array<int, array{name: string, pct: int, color: string}>
     */
    private function buildCategoryChartRows(array $weights): array
    {
        if ($weights === []) {
            return [['name' => 'لا بيانات بعد', 'pct' => 100, 'color' => '#64748b']];
        }

        arsort($weights);
        $top = array_slice($weights, 0, 5, true);
        $rest = array_slice($weights, 5, null, true);
        $other = array_sum($rest);
        if ($other > 0) {
            $top['أخرى'] = $other;
        }

        $total = array_sum($top);
        $colors = ['#6366f1', '#10b981', '#f59e0b', '#8b5cf6', '#06b6d4', '#ec4899'];
        $out    = [];
        $i      = 0;
        foreach ($top as $name => $w) {
            $pct       = $total > 0 ? (int) round($w / $total * 100) : 0;
            $out[]     = [
                'name'  => (string) $name,
                'pct'   => max(0, min(100, $pct)),
                'color' => $colors[$i % count($colors)],
            ];
            $i++;
        }

        return $out;
    }

    private function sallaMonthOrderAggregates(SallaStore $store): ?array
    {
        try {
            $token = (new SallaTokenService())->getValidToken($store);
            $from  = now()->startOfMonth()->format('Y-m-d');
            $to    = now()->format('Y-m-d');
            $sales = 0.0;
            $count = 0;
            $page  = 1;
            $lastPage = 1;
            $reportedTotal = 0;

            do {
                $response = Http::withToken($token)->timeout(25)->get('https://api.salla.dev/admin/v2/orders', [
                    'from_date' => $from,
                    'to_date'   => $to,
                    'per_page'  => 60,
                    'page'      => $page,
                ]);
                if (! $response->successful()) {
                    return null;
                }
                $data = $response->json('data', []);
                $pag  = $response->json('pagination', []);
                if ($reportedTotal < 1) {
                    $reportedTotal = (int) ($pag['total'] ?? 0);
                }
                foreach ($data as $o) {
                    if (! is_array($o)) {
                        continue;
                    }
                    $sales += SallaOrderPresenter::orderTotalFromPayload($o);
                    $count++;
                }
                $lastPage = (int) ($pag['totalPages'] ?? $pag['total_pages'] ?? 1);
                $page++;
                if ($page > 60) {
                    break;
                }
            } while ($page <= $lastPage);

            $orderCount = $reportedTotal > 0 ? $reportedTotal : $count;

            return ['sales' => $sales, 'orders' => $orderCount];
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('sallaMonthOrderAggregates: '.$e->getMessage());

            return null;
        }
    }

    /**
     * @param  array<string,mixed>  $pag
     * @return array{total: int, last_page: int, per_page: int}
     */
    private function sallaPaginationMeta(array $pag, int $itemCountFallback = 0): array
    {
        $total   = (int) ($pag['total'] ?? $itemCountFallback);
        $perPage = (int) ($pag['perPage'] ?? $pag['per_page'] ?? 20);
        $perPage = max(1, $perPage);
        $last    = (int) ($pag['totalPages'] ?? $pag['total_pages'] ?? 0);
        if ($last < 1) {
            $last = max(1, (int) ceil($total / $perPage));
        }

        return ['total' => $total, 'last_page' => max(1, $last), 'per_page' => $perPage];
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email,'.$user->id,
            'store_name' => 'nullable|string|max:100',
            'password'   => 'nullable|string|min:8|confirmed',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if ($request->filled('store_name')) {
            SallaStore::where('user_id', $user->id)
                ->update(['store_name' => $request->store_name]);
        }

        return back()->with('success', 'تم حفظ الإعدادات بنجاح ✅');
    }

    public function changePlan(Request $request)
    {
        $request->validate(['plan' => 'required|in:basic,smart,pro']);
        Auth::user()->update(['plan' => $request->plan]);

        return back()->with('success', 'تم تغيير الخطة بنجاح ✅');
    }

    public function sallaOrders(Request $request)
    {
        $store = SallaStore::where('user_id', Auth::id())->first();
        if (! $store || ! $store->access_token) {
            return response()->json(['success' => false, 'error' => 'no_store']);
        }

        try {
            $token  = (new SallaTokenService())->getValidToken($store);
            $page   = max(1, (int) $request->query('page', 1));
            $status = $request->query('status', '');

            $params = ['per_page' => 20, 'page' => $page];
            if ($status) {
                $params['status'] = $status;
            }

            $response = Http::withToken($token)
                ->timeout(10)
                ->get('https://api.salla.dev/admin/v2/orders', $params);

            if (! $response->successful()) {
                return response()->json(['success' => false, 'error' => 'salla_error']);
            }

            $data     = $response->json('data', []);
            $paginate = $response->json('pagination', []);
            $meta     = $this->sallaPaginationMeta($paginate, count($data));

            $orders = collect($data)->map(fn ($o) => [
                'id'             => $o['id'] ?? null,
                'reference_id'   => $o['reference_id'] ?? $o['id'],
                'status'         => $o['status']['slug'] ?? 'unknown',
                'status_label'   => $o['status']['name'] ?? '',
                'customer_name'  => trim(($o['customer']['first_name'] ?? '').' '.($o['customer']['last_name'] ?? '')),
                'customer_phone' => ltrim($o['customer']['mobile_code'] ?? '', '+').($o['customer']['mobile'] ?? ''),
                'total'          => SallaOrderPresenter::orderTotalFromPayload($o),
                'products'       => collect($o['items'] ?? [])->map(fn ($i) => ($i['product']['name'] ?? '').' × '.($i['quantity'] ?? 1))->implode('، '),
                'created_at'     => $o['date']['date'] ?? null,
            ])->values();

            return response()->json([
                'success'   => true,
                'orders'    => $orders,
                'total'     => $meta['total'],
                'page'      => $page,
                'last_page' => $meta['last_page'],
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('sallaOrders error: '.$e->getMessage());

            return response()->json(['success' => false, 'error' => 'exception']);
        }
    }

    public function sallaProducts(Request $request)
    {
        $store = SallaStore::where('user_id', Auth::id())->first();
        if (! $store || ! $store->access_token) {
            return response()->json(['success' => false, 'error' => 'no_store']);
        }

        try {
            $token    = (new SallaTokenService())->getValidToken($store);
            $page     = max(1, (int) $request->query('page', 1));
            $response = Http::withToken($token)
                ->timeout(10)
                ->get('https://api.salla.dev/admin/v2/products', [
                    'per_page' => 20,
                    'page'     => $page,
                ]);

            if (! $response->successful()) {
                return response()->json(['success' => false, 'error' => 'salla_error']);
            }

            $data     = $response->json('data', []);
            $paginate = $response->json('pagination', []);
            $meta     = $this->sallaPaginationMeta($paginate, count($data));

            $products = collect($data)->map(function ($p) {
                $avail = SallaProductPresenter::availability($p);
                $priceRaw = $p['price'] ?? $p['regular_price'] ?? null;
                $price      = is_array($priceRaw)
                    ? ($priceRaw['amount'] ?? $priceRaw['min']['amount'] ?? null)
                    : $priceRaw;

                return [
                    'id'       => $p['id'] ?? null,
                    'name'     => $p['name'] ?? '',
                    'sku'      => $p['sku'] ?? null,
                    'price'    => $price,
                    'url'      => $p['url'] ?? null,
                    'stock'    => $avail['quantity'],
                    'unlimited'=> $avail['unlimited'],
                    'in_stock' => $avail['in_stock'],
                    'image'    => SallaProductPresenter::imageUrl($p),
                    'status'   => $p['status'] ?? 'active',
                ];
            })->filter(fn ($p) => $p['name'])->values();

            return response()->json([
                'success'    => true,
                'products'   => $products,
                'total'      => $meta['total'],
                'page'       => $page,
                'last_page'  => $meta['last_page'],
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('sallaProducts error: '.$e->getMessage());

            return response()->json(['success' => false, 'error' => 'exception']);
        }
    }
}
