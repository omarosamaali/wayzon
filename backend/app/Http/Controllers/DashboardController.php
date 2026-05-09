<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SallaStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $monthlySales  = Order::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $monthlyOrders = Order::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalCustomers = Order::where('user_id', $userId)
            ->whereNotNull('customer_phone')
            ->distinct('customer_phone')
            ->count('customer_phone');

        $waSent = Order::where('user_id', $userId)
            ->where('whatsapp_sent', true)
            ->count();

        $recentOrders = Order::where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get();

        $allOrders = Order::where('user_id', $userId)
            ->latest()
            ->paginate(20);

        $orderCounts = [
            'all'       => Order::where('user_id', $userId)->count(),
            'new'       => Order::where('user_id', $userId)->where('status', 'new')->count(),
            'shipped'   => Order::where('user_id', $userId)->whereIn('status', ['shipped', 'processing'])->count(),
            'delivered' => Order::where('user_id', $userId)->where('status', 'delivered')->count(),
            'canceled'  => Order::where('user_id', $userId)->where('status', 'canceled')->count(),
        ];

        $store = SallaStore::where('user_id', $userId)->first();

        return view('dashboard', compact(
            'monthlySales',
            'monthlyOrders',
            'totalCustomers',
            'waSent',
            'recentOrders',
            'allOrders',
            'orderCounts',
            'store'
        ));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email,' . $user->id,
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
}
