<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PlanPaymentController extends Controller
{
    private array $planPrices = ['basic' => 55, 'smart' => 99, 'pro' => 139];

    private array $planCheckoutUrls = [];

    public function __construct()
    {
        $this->planCheckoutUrls = [
            'basic' => env('SALLA_CHECKOUT_BASIC', ''),
            'smart' => env('SALLA_CHECKOUT_SMART', ''),
            'pro'   => env('SALLA_CHECKOUT_PRO', ''),
        ];
    }

    public function redirect(Request $request)
    {
        $request->validate(['plan' => 'required|in:basic,smart,pro']);
        $plan = $request->plan;
        $user = Auth::user();

        // Generate unique token to match payment back to user
        $token = Str::random(48);
        $user->update([
            'pending_plan'       => $plan,
            'pending_plan_token' => $token,
        ]);

        $checkoutUrl = $this->planCheckoutUrls[$plan];

        if (!$checkoutUrl) {
            // Fallback if no Salla URL configured yet
            return back()->with('error', 'صفحة الدفع غير متاحة حالياً، تواصل مع الدعم.');
        }

        // Append token as query param so webhook can identify the user
        $separator = str_contains($checkoutUrl, '?') ? '&' : '?';
        return redirect($checkoutUrl . $separator . 'ref=' . $token);
    }

    // Called by Salla webhook when order.completed fires for a plan product
    public static function activateFromWebhook(string $token, string $sallaOrderId): bool
    {
        $user = User::where('pending_plan_token', $token)->first();
        if (!$user || !$user->pending_plan) return false;

        $user->update([
            'plan'               => $user->pending_plan,
            'pending_plan'       => null,
            'pending_plan_token' => null,
        ]);

        \Illuminate\Support\Facades\Log::info("Plan activated for user {$user->id}: {$user->plan} via order {$sallaOrderId}");
        return true;
    }
}
