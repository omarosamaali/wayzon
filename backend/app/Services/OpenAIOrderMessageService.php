<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIOrderMessageService
{
    public function generate(Order $order, ?string $storeName = null): ?string
    {
        $apiKey = config('openai.api_key');
        if (! config('openai.enabled') || ! is_string($apiKey) || $apiKey === '') {
            return null;
        }

        $payload = [
            'model' => config('openai.model', 'gpt-4o-mini'),
            'messages' => [
                [
                    'role' => 'system',
                    'content' => <<<'SYSTEM'
أنت مساعد خدمة عملاء لمتجر إلكتروني على منصة سلة (السعودية).
اكتب رسالة واتساب قصيرة وواضحة بالعربية (فصحى مبسطة أو عامية مهذبة مناسبة للعملاء السعوديين).
- لا تستخدم Markdown ولا رموز تنسيق مثل ** أو #.
- اذكر اسم العميل إن وُجد، ورقم الطلب، والإجمالي بالريال، واشرح حالة الطلب بلطف حسب الحالة المُعطاة.
- ختام دافئ بجملة شكر قصيرة.
- الرسالة جاهزة للإرسال كما هي، بدون عنوان أو تعليق.
SYSTEM,
                ],
                [
                    'role' => 'user',
                    'content' => json_encode([
                        'store_name' => $storeName ?? 'المتجر',
                        'customer_name' => $order->customer_name,
                        'order_id' => $order->salla_order_id,
                        'status_slug' => $order->status,
                        'total_sar' => $order->total,
                        'payment_method' => $order->payment_method,
                    ], JSON_UNESCAPED_UNICODE),
                ],
            ],
            'max_tokens' => config('openai.max_tokens', 400),
            'temperature' => 0.65,
        ];

        try {
            $response = Http::withToken($apiKey)
                ->timeout((int) config('openai.timeout', 15))
                ->acceptJson()
                ->post('https://api.openai.com/v1/chat/completions', $payload);

            if (! $response->successful()) {
                Log::warning('OpenAI chat completion failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return null;
            }

            $text = $response->json('choices.0.message.content');
            if (! is_string($text) || trim($text) === '') {
                return null;
            }

            return trim($text);
        } catch (\Throwable $e) {
            Log::error('OpenAI order message: '.$e->getMessage());

            return null;
        }
    }
}
