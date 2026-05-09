<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\SallaController;
use App\Http\Controllers\SallaWebhookController;
use App\Http\Controllers\BotConfigController;
use App\Http\Controllers\PlanPaymentController;
use App\Http\Controllers\AdminController;

// Landing page
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/privacy', fn() => view('privacy'))->name('privacy');
Route::get('/terms',   fn() => view('terms'))->name('terms');

// SEO
Route::get('/robots.txt', function () {
    return response("User-agent: *\nAllow: /\nSitemap: https://wayzon.online/sitemap.xml\n", 200)
        ->header('Content-Type', 'text/plain');
});
Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => 'https://wayzon.online/',          'priority' => '1.0', 'changefreq' => 'weekly'],
        ['loc' => 'https://wayzon.online/pricing',   'priority' => '0.8', 'changefreq' => 'monthly'],
        ['loc' => 'https://wayzon.online/privacy',   'priority' => '0.4', 'changefreq' => 'yearly'],
        ['loc' => 'https://wayzon.online/terms',     'priority' => '0.4', 'changefreq' => 'yearly'],
    ];
    return response(view('sitemap', compact('urls')), 200)
        ->header('Content-Type', 'application/xml');
});

// Auth routes (guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
    Route::get('/reset-password/{token}',  [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password',         [AuthController::class, 'resetPassword'])->name('password.update');
});

// Salla Webhook (no CSRF, no auth)
Route::post('/salla/webhook', [SallaWebhookController::class, 'handle'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Salla OAuth — Easy Mode: works with or without prior login (auto-creates merchant account)
Route::get('/salla/connect',  [SallaController::class, 'redirect'])->name('salla.connect');
Route::get('/salla/callback', [SallaController::class, 'callback'])->name('salla.callback');

// Internal API for WhatsApp bot (no CSRF, secured by secret key)
Route::get('/internal/order-status', [\App\Http\Controllers\InternalApiController::class, 'orderStatus'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::get('/internal/product-search', [\App\Http\Controllers\InternalApiController::class, 'productSearch'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::get('/internal/bot-config', [BotConfigController::class, 'getForTenant'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::post('/internal/wa-disconnected', [\App\Http\Controllers\InternalApiController::class, 'waDisconnected'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Admin routes
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/',                      [AdminController::class, 'index'])->name('admin.index');
    Route::post('/users/{user}/plan',    [AdminController::class, 'setPlan'])->name('admin.setPlan');
    Route::post('/users/{user}/impersonate', [AdminController::class, 'impersonate'])->name('admin.impersonate');
    Route::post('/stop-impersonate',          [AdminController::class, 'stopImpersonate'])->name('admin.stopImpersonate');
    Route::get('/bot-training',               [AdminController::class, 'botTraining'])->name('admin.botTraining');
    Route::post('/bot-training',              [AdminController::class, 'saveBotTraining'])->name('admin.saveBotTraining');
    Route::post('/users/{user}/trial',        [AdminController::class, 'setTrial'])->name('admin.setTrial');
    // Admin's own WhatsApp — not behind subscription middleware
    Route::get('/wa-status',  [WhatsAppController::class, 'status'])->name('admin.wa.status');
    Route::post('/wa-logout', [WhatsAppController::class, 'logout'])->name('admin.wa.logout');
    // AI model + delete user
    Route::post('/ai-model',                    [AdminController::class, 'saveAiModel'])->name('admin.saveAiModel');
    Route::post('/users/{user}/model',          [AdminController::class, 'setUserModel'])->name('admin.setUserModel');
    Route::delete('/users/{user}',              [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
});

// Auth-only routes (no subscription check needed)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Pricing page — accessible without active subscription
    Route::get('/pricing', fn() => view('pricing'))->name('pricing');

    // Plan payment — must be accessible to non-subscribers so they can subscribe
    Route::post('/plan/change', [PlanPaymentController::class, 'redirect'])->name('plan.change');


});

// Protected routes — require active subscription
Route::middleware(['auth', 'subscription'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Settings
    Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');

    // Bot config (training page)
    Route::post('/bot-config', [BotConfigController::class, 'save'])->name('bot.config.save');
    Route::get('/bot-config',  [BotConfigController::class, 'get'])->name('bot.config.get');

    // WhatsApp
    Route::get('/whatsapp',        fn() => view('whatsapp'))->name('whatsapp');
    Route::get('/whatsapp/status', [WhatsAppController::class, 'status'])->name('whatsapp.status');
    Route::post('/whatsapp/send',  [WhatsAppController::class, 'send'])->name('whatsapp.send');
    Route::post('/whatsapp/logout',[WhatsAppController::class, 'logout'])->name('whatsapp.logout');
    Route::post('/whatsapp/pairing', [WhatsAppController::class, 'requestPairing'])->name('whatsapp.pairing');
    Route::get('/whatsapp/manual-paused',              [WhatsAppController::class, 'manualPaused'])->name('whatsapp.manual.paused');
    Route::post('/whatsapp/manual-resume/{phone}',     [WhatsAppController::class, 'manualResume'])->name('whatsapp.manual.resume');
    Route::post('/whatsapp/manual-resume-all',         [WhatsAppController::class, 'manualResumeAll'])->name('whatsapp.manual.resumeAll');
});
