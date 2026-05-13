<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SallaStore;
use App\Models\User;
use App\Services\OpenAIOrderMessageService;
use App\Services\SallaTokenService;
use App\Services\WhatsAppService;
use App\Support\SallaOrderPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class SallaWebhookController extends Controller
{
    public function __construct(
        private WhatsAppService $whatsapp,
        private OpenAIOrderMessageService $openAI,
    ) {}

    public function handle(Request $request)
    {
        $event = $request->input('event');
        $data  = $request->input('data', []);

        // Log full request for debugging
        \Illuminate\Support\Facades\Log::info('Salla webhook received', [
            'event'   => $event,
            'headers' => $request->headers->all(),
            'data'    => $data,
        ]);

        \Illuminate\Support\Facades\Log::info("Salla webhook: {$event}", ['data' => $data]);

        match ($event) {
            'app.store.authorize'           => $this->handleStoreAuthorize($data),
            'order.created'                 => $this->handleOrderCreated($data),
            'order.status.updated'          => $this->handleOrderUpdated($data),
            'order.completed'               => $this->handleOrderCompleted($data),
            'app.subscription.created',
            'app.subscription.updated'      => $this->handleSubscriptionCreated($data),
            'communication.whatsapp.send'   => $this->handleCommunicationWhatsapp($request->all()),
            default                         => null,
        };

        return response()->json(['status' => 'ok']);
    }

    private function handleStoreAuthorize(array $data): void
    {
        $storeId   = (string) ($data['merchant']['id'] ?? $data['id'] ?? '');
        $storeName = $data['merchant']['name'] ?? $data['name'] ?? 'متجر سلة';
        $token     = $data['token'] ?? $data['access_token'] ?? null;
        $refresh   = $data['refresh_token'] ?? null;
        $expires   = $data['expires'] ?? $data['expires_in'] ?? 3600;

        if (!$storeId || !$token) {
            \Illuminate\Support\Facades\Log::warning('app.store.authorize missing data', $data);
            return;
        }

        // Try to find existing store owner, otherwise leave unlinked (user must connect via OAuth)
        $existingStore = SallaStore::where('store_id', $storeId)->first();
        $userId = $existingStore?->user_id;

        if (!$userId) {
            \Illuminate\Support\Facades\Log::warning("Store {$storeId} authorized but no matching user found — skipping user link.");
            return;
        }

        SallaStore::updateOrCreate(
            ['store_id' => $storeId],
            [
                'user_id'          => $userId,
                'store_name'       => $storeName,
                'access_token'     => $token,
                'refresh_token'    => $refresh,
                'token_expires_at' => now()->addSeconds(is_numeric($expires) ? $expires : 3600),
            ]
        );

        \Illuminate\Support\Facades\Log::info("Store {$storeId} ({$storeName}) authorized ✅");
    }

    private function handleOrderCreated(array $data): void
    {
        $storeId = $data['store']['id'] ?? $data['store']['store_id'] ?? $data['merchant'] ?? null;
        $store   = SallaStore::where('store_id', $storeId)->first();
        if (!$store) {
            \Illuminate\Support\Facades\Log::warning('handleOrderCreated: store not found', ['store_id' => $storeId]);
            return;
        }

        $mobileCode  = ltrim($data['customer']['mobile_code'] ?? '', '+');
        $mobile      = (string) ($data['customer']['mobile'] ?? '');
        $phone       = $mobileCode ? $mobileCode . $mobile : $mobile;

        $order = Order::updateOrCreate(
            ['salla_order_id' => (string) ($data['id'] ?? '')],
            [
                'user_id'        => $store->user_id,
                'reference_id'   => (string) ($data['reference_id'] ?? ''),
                'status'         => $data['status']['slug'] ?? 'new',
                'customer_name'  => trim(($data['customer']['first_name'] ?? '') . ' ' . ($data['customer']['last_name'] ?? '')),
                'customer_phone' => $phone ?: null,
                'total'          => SallaOrderPresenter::orderTotalFromPayload($data),
                'payment_method' => $data['payment_method'] ?? null,
                'raw_payload'    => $data,
            ]
        );

        Cache::forget('wayzon_salla_month_stats_'.$store->user_id);

        // Send WhatsApp notification to customer
        if ($order->customer_phone) {
            $this->sendWhatsApp($store->user_id, $order);
        }

        $user      = \App\Models\User::find($store->user_id);
        $botConfig = $user?->bot_config ?? [];

        // COD notification
        $paymentMethod = strtolower((string) ($data['payment_method'] ?? $data['payment']['type'] ?? ''));
        $isCOD = str_contains($paymentMethod, 'cod') || str_contains($paymentMethod, 'cash');
        if ($isCOD && !empty($botConfig['cod_enabled']) && $order->customer_phone) {
            $storeName = $store->store_name ?? '';
            $codMsg = $botConfig['msg_cod'] ?? "📦 تم استلام طلبك بنجاح\n\nطلبك حاليًا قيد التجهيز 🙏\nبما أن طريقة الدفع هي الدفع عند الاستلام، سيتم التواصل معك لتأكيد الطلب قبل الشحن.\n\nشكراً لثقتك ❤️";
            $codMsg = str_replace(
                ['@{{customer_name}}', '@{{order_id}}', '@{{store_name}}', '@{{order_total}}', '@{{store_phone}}'],
                [$order->customer_name ?? 'عزيزي العميل', $order->reference_id ?: $order->salla_order_id, $storeName, $order->total, $botConfig['support_phone'] ?? ''],
                $codMsg
            );
            try {
                $this->whatsapp->send((string) $store->user_id, (string) $order->customer_phone, $codMsg);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('COD msg send failed: ' . $e->getMessage());
            }
        }

        // Notify merchant if configured
        $botConfig = $user?->bot_config ?? [];
        if (!empty($botConfig['notify_orders']) && !empty($botConfig['notify_phone'])) {
            $products = collect($data['items'] ?? [])->map(
                fn($i) => ($i['product']['name'] ?? '') . ' × ' . ($i['quantity'] ?? 1)
            )->implode('، ');
            $city = $data['shipping_address']['city'] ?? '';
            $notifyMsg = "🛒 *طلب جديد*\n\n"
                . "👤 العميل: " . ($order->customer_name ?: 'غير محدد') . "\n"
                . "📱 الرقم: +" . ($order->customer_phone ?? '') . "\n"
                . ($products ? "📦 الطلب: {$products}\n" : '')
                . "💰 المبلغ: " . ($order->total) . " ريال"
                . ($city ? "\n📍 المدينة: {$city}" : '');
            $phones = array_filter(array_map('trim', explode(',', $botConfig['notify_phone'])));
            foreach ($phones as $notifyPhone) {
                try {
                    $this->whatsapp->send((string) $store->user_id, $notifyPhone, $notifyMsg);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error('Merchant order notify failed (' . $notifyPhone . '): ' . $e->getMessage());
                }
            }
        }
    }

    private function handleOrderUpdated(array $data): void
    {
        $order = Order::where('salla_order_id', (string) ($data['id'] ?? ''))->first();
        if (!$order) return;

        $newStatus = $data['status']['slug'] ?? $order->status;
        $newTotal  = SallaOrderPresenter::orderTotalFromPayload($data);
        $order->update([
            'status'      => $newStatus,
            'total'       => $newTotal > 0 ? $newTotal : $order->total,
            'raw_payload' => $data,
        ]);

        Cache::forget('wayzon_salla_month_stats_'.$order->user_id);

        // لا نرسل واتساب لحالة جديد أو بانتظار عرض سعر
        $skipStatuses = ['new', 'pending_quote', 'pending_quotation'];
        if ($order->customer_phone && !in_array($newStatus, $skipStatuses)) {
            $this->sendWhatsApp($order->user_id, $order);
        }
    }

    private function handleOrderCompleted(array $data): void
    {
        // Check if this order matches a pending plan payment (via ref token)
        $ref = $data['source']['ref'] ?? $data['note'] ?? $data['ref'] ?? null;
        $orderId = (string) ($data['id'] ?? '');

        if ($ref) {
            \App\Http\Controllers\PlanPaymentController::activateFromWebhook($ref, $orderId);
        }

        // Also handle as normal order update
        $this->handleOrderUpdated($data);
    }

    private function sendWhatsApp(int $userId, Order $order): void
    {
        $store     = SallaStore::where('user_id', $userId)->first();
        $storeName = $store?->store_name ?? '';
        $user      = User::find($userId);
        $botConfig = $user?->bot_config ?? [];

        $message = $this->buildTemplateMessage($order, $storeName, $botConfig)
            ?? $this->openAI->generate($order, $storeName)
            ?? $this->buildFallbackMessage($order);

        try {
            $ok = $this->whatsapp->send((string) $userId, (string) $order->customer_phone, $message);
            if ($ok) {
                $order->update(['whatsapp_sent' => true]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('WhatsApp send failed: ' . $e->getMessage());
        }
    }

    private function buildTemplateMessage(Order $order, string $storeName, array $cfg): ?string
    {
        $statusTemplateMap = [
            'new'               => 'msg_order_created',
            'in_progress'       => 'msg_order_created',
            'paid'              => 'msg_order_created',
            'payment_confirmed' => 'msg_order_created',
            'shipped'           => 'msg_order_shipped',
            'delivering'        => 'msg_order_shipped',
            'out_for_delivery'  => 'msg_order_shipped',
            'delivered'         => 'msg_order_delivered',
            'canceled'          => 'msg_order_canceled',
        ];

        $key      = $statusTemplateMap[$order->status] ?? null;
        $template = $key ? ($cfg[$key] ?? null) : null;

        if (!$template) return null;

        $vars = [
            '@{{customer_name}}' => $order->customer_name ?? 'عزيزي العميل',
            '@{{store_name}}'    => $storeName,
            '@{{order_id}}'      => $order->reference_id ?: $order->salla_order_id,
            '@{{order_total}}'   => $order->total,
            '@{{store_phone}}'   => $cfg['support_phone'] ?? '',
        ];

        return str_replace(array_keys($vars), array_values($vars), $template);
    }

    private function handleSubscriptionCreated(array $data): void
    {
        $merchantId = (string) ($data['merchant']['id'] ?? $data['store_id'] ?? '');
        $email      = $data['merchant']['email'] ?? $data['email'] ?? null;
        $name       = $data['merchant']['name']  ?? $data['name']  ?? 'تاجر';
        $phone      = $data['merchant']['mobile'] ?? null;

        if (!$email) {
            \Illuminate\Support\Facades\Log::warning('handleSubscriptionCreated: no email', $data);
            return;
        }

        // Determine plan from subscription data — log raw key for debugging
        $planKey = strtolower($data['plan']['key'] ?? $data['plan']['slug'] ?? $data['package'] ?? '');
        \Illuminate\Support\Facades\Log::info("handleSubscriptionCreated planKey={$planKey}", ['data' => $data]);

        $planMap = ['basic' => 'basic', 'smart' => 'smart', 'pro' => 'pro'];
        $plan    = $planMap[$planKey] ?? 'basic';

        $existingUser = User::where('email', $email)->first();
        $isNew        = !$existingUser;

        if ($existingUser) {
            // Only update plan for existing users — never reset password or trial
            $existingUser->update(['plan' => $plan]);
            $user = $existingUser;
        } else {
            $password = 'Aa' . $merchantId;
            $user = User::create([
                'name'          => $name,
                'email'         => $email,
                'password'      => Hash::make($password),
                'plan'          => $plan,
                'trial_ends_at' => now()->addDays(3),
            ]);

            // Send welcome WhatsApp message for new users
            if ($phone) {
                $dashUrl   = config('app.url') . '/login';
                $planLabel = match($plan) {
                    'basic' => '🚀 الأساسية',
                    'smart' => '🧠 الذكية',
                    'pro'   => '🏆 الاحترافية',
                    default => $plan,
                };
                $msg = "أهلاً {$name} 👋\n\nشكراً لاشتراكك في *وايزون* {$planLabel}\n\nتم إنشاء حسابك تلقائياً.\n\nسجّل الدخول من هنا:\n{$dashUrl}\n\nنتمنى لك تجربة رائعة! 🚀";
                $this->whatsapp->send((string) $user->id, $phone, $msg);
            }
        }

        // Link SallaStore
        if ($merchantId) {
            SallaStore::updateOrCreate(
                ['store_id' => $merchantId],
                ['user_id' => $user->id, 'store_name' => $name]
            );
        }

        \Illuminate\Support\Facades\Log::info("Subscription handled for {$email} — plan={$plan} new={$isNew}");
    }

    private function handleCommunicationWhatsapp(array $payload): void
    {
        $merchantId = (string) ($payload['merchant'] ?? '');
        $data       = $payload['data'] ?? [];
        $phones     = $data['notifiable'] ?? [];
        $message    = $data['message'] ?? $data['content'] ?? '';

        if (!$merchantId || empty($phones) || !$message) {
            \Illuminate\Support\Facades\Log::warning('communication.whatsapp.send: missing data', $payload);
            return;
        }

        $store = SallaStore::where('store_id', $merchantId)->first();
        if (!$store) {
            \Illuminate\Support\Facades\Log::warning("communication.whatsapp.send: store {$merchantId} not found");
            return;
        }

        foreach ($phones as $phone) {
            $phone = ltrim((string) $phone, '+');
            if (!$phone) continue;
            try {
                $this->whatsapp->send((string) $store->user_id, $phone, $message);
                \Illuminate\Support\Facades\Log::info("communication.whatsapp.send: sent to {$phone} for store {$merchantId}");
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("communication.whatsapp.send: failed for {$phone} — " . $e->getMessage());
            }
        }
    }

    private function buildFallbackMessage(Order $order): string
    {
        $name   = $order->customer_name ?? 'عزيزي العميل';
        $id     = $order->salla_order_id;
        $total  = $order->total;
        $status = $order->status;

        $statusMap = [
            'in_progress'       => 'طلبك الآن قيد التنفيذ 🔄',
            'under_review'      => 'طلبك بانتظار المراجعة ⏳',
            'pending_review'    => 'طلبك بانتظار المراجعة ⏳',
            'pending_payment'   => 'طلبك بانتظار الدفع 💳',
            'paid'              => 'تم تأكيد دفع طلبك ✅',
            'payment_confirmed' => 'تم تأكيد دفع طلبك ✅',
            'shipped'           => 'تم شحن طلبك 🚚',
            'delivering'        => 'طلبك في الطريق إليك 🛵',
            'out_for_delivery'  => 'طلبك في الطريق إليك 🛵',
            'delivered'         => 'تم توصيل طلبك بنجاح 🎉',
            'canceled'          => 'تم إلغاء طلبك ❌',
            'returned'          => 'تم استرجاع طلبك 🔁',
            'refunded'          => 'تم استرجاع طلبك 🔁',
            'under_return'      => 'طلبك قيد الاسترجاع 🔄',
            'return_in_progress'=> 'طلبك قيد الاسترجاع 🔄',
        ];

        $statusText = $statusMap[$status] ?? "حالة الطلب: {$status}";

        return "أهلاً {$name} 👋\n\n{$statusText}\n\nرقم الطلب: #{$id}\nالإجمالي: {$total} ريال\n\nشكراً لثقتك بنا 💙";
    }
}
