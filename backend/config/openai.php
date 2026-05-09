<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI (مرحلة الذكاء الاصطناعي — رسائل واتساب حسب حالة الطلب)
    |--------------------------------------------------------------------------
    |
    | ضع OPENAI_API_KEY في .env على السيرفر بعد التسليم. أثناء التطوير يمكن
    | استخدام مفتاح المطوّر محلياً.
    |
    */

    'api_key' => env('OPENAI_API_KEY'),

    'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),

    'enabled' => filter_var(env('OPENAI_ENABLED', true), FILTER_VALIDATE_BOOLEAN),

    'timeout' => (int) env('OPENAI_TIMEOUT', 15),

    'max_tokens' => (int) env('OPENAI_MAX_TOKENS', 400),

];
