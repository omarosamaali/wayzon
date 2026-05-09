<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMerchantMail;
use App\Models\SallaStore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SallaController extends Controller
{
    public function redirect()
    {
        $state = Str::random(32);
        session(['salla_oauth_state' => $state]);

        $query = http_build_query([
            'client_id'     => config('salla.client_id'),
            'redirect_uri'  => config('salla.redirect_uri'),
            'response_type' => 'code',
            'scope'         => 'offline_access',
            'state'         => $state,
        ]);

        return redirect('https://accounts.salla.sa/oauth2/auth?' . $query);
    }

    public function callback(Request $request)
    {
        $code = $request->query('code');
        if (!$code) {
            return redirect('/')->with('error', 'فشل الربط مع سلة — لم يتم استلام رمز التفويض');
        }

        // Exchange code for tokens
        $tokenResponse = Http::asForm()->post('https://accounts.salla.sa/oauth2/token', [
            'client_id'     => config('salla.client_id'),
            'client_secret' => config('salla.client_secret'),
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'redirect_uri'  => config('salla.redirect_uri'),
        ]);

        if (!$tokenResponse->successful()) {
            Log::error('Salla token exchange failed', $tokenResponse->json() ?? []);
            return redirect('/')->with('error', 'فشل استلام رمز الوصول من سلة');
        }

        $tokens = $tokenResponse->json();
        $accessToken  = $tokens['access_token'];
        $refreshToken = $tokens['refresh_token'] ?? null;
        $expiresIn    = $tokens['expires_in'] ?? 3600;

        // Fetch store info
        $storeInfo = Http::withToken($accessToken)->get('https://api.salla.dev/admin/v2/store/info');
        $storeId   = $storeInfo->json('data.id')   ?? null;
        $storeName = $storeInfo->json('data.name') ?? 'متجر سلة';

        // Fetch merchant profile (email + name) — used for auto-registration
        $profileInfo  = Http::withToken($accessToken)->get('https://api.salla.dev/admin/v2/oauth2/user/info');
        $merchantEmail = $profileInfo->json('data.email') ?? null;
        $merchantName  = $profileInfo->json('data.name')  ?? $storeName;

        if (!$merchantEmail) {
            return redirect('/login')->with('error', 'تعذّر جلب بريد التاجر من سلة — يرجى المحاولة مجدداً');
        }

        $isNewUser = false;
        $tempPassword = null;

        // Always find or create merchant by Salla email — never reuse an existing session
        $user = User::where('email', $merchantEmail)->first();

        if (!$user) {
            $isNewUser    = true;
            $tempPassword = Str::random(12);
            $user = User::create([
                'name'          => $merchantName,
                'email'         => $merchantEmail,
                'password'      => Hash::make($tempPassword),
                'trial_ends_at' => now()->addDays(3),
            ]);
        }

        // Log out any existing session (e.g. admin) and log in as the merchant
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::login($user, true);

        // Save / update store tokens
        SallaStore::updateOrCreate(
            ['user_id' => $user->id],
            [
                'store_id'         => $storeId,
                'store_name'       => $storeName,
                'access_token'     => $accessToken,
                'refresh_token'    => $refreshToken,
                'token_expires_at' => now()->addSeconds($expiresIn),
            ]
        );

        // Send welcome email for new merchants
        if ($isNewUser && $merchantEmail) {
            try {
                Mail::to($merchantEmail)->send(new WelcomeMerchantMail($user, $tempPassword));
            } catch (\Throwable $e) {
                Log::error('Welcome email failed: ' . $e->getMessage());
            }
        }

        $message = $isNewUser
            ? 'مرحباً بك! تم إنشاء حسابك وربط متجرك بنجاح 🎉 تحقق من بريدك الإلكتروني لمعرفة كلمة المرور'
            : 'تم ربط متجر سلة بنجاح ✅';

        return redirect()->route('dashboard')->with('success', $message);
    }
}
