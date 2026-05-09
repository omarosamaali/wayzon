<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BotConfigController extends Controller
{
    // Internal endpoint for Node.js to fetch bot config
    public function getForTenant(Request $request)
    {
        $secret = $request->header('X-Internal-Secret') ?? $request->query('secret');
        if ($secret !== (env('INTERNAL_SECRET', 'wyns-internal-2024'))) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        $tenantId = $request->query('tenant_id');
        $user = \App\Models\User::find($tenantId);
        if (!$user) {
            return response()->json(['config' => null]);
        }

        $config = $user->bot_config ?? [];
        $store  = \App\Models\SallaStore::where('user_id', $tenantId)->first();

        $globalPrompt = \Illuminate\Support\Facades\Storage::disk('local')->exists('wayzon_system_prompt.txt')
            ? \Illuminate\Support\Facades\Storage::disk('local')->get('wayzon_system_prompt.txt')
            : null;

        $globalModel = \Illuminate\Support\Facades\Storage::disk('local')->exists('wayzon_ai_model.txt')
            ? trim(\Illuminate\Support\Facades\Storage::disk('local')->get('wayzon_ai_model.txt'))
            : 'gpt-4-turbo';
        // Per-user override takes priority over global model
        $aiModel = !empty($config['ai_model_override']) ? $config['ai_model_override'] : $globalModel;

        $adminEmails = ['faisal@1212.com', 'omar@gmail.com'];
        if (in_array($user->email, $adminEmails)) {
            $effectivePlan = 'pro';
        } elseif ($user->plan) {
            $effectivePlan = $user->plan;
        } elseif ($user->trial_ends_at && $user->trial_ends_at->isFuture()) {
            $effectivePlan = 'trial';
        } else {
            $effectivePlan = 'basic';
        }

        return response()->json([
            'config'        => $config,
            'store_name'    => $store?->store_name ?? ($config['store_name'] ?? null),
            'plan'          => $effectivePlan,
            'global_prompt' => $globalPrompt,
            'ai_model'      => $aiModel,
        ]);
    }

    // Save bot config from training form
    public function save(Request $request)
    {
        $data = $request->validate([
            'store_name'          => 'nullable|string|max:200',
            'store_training'      => 'nullable|string|max:5000',
            'store_desc'          => 'nullable|string|max:1000',
            'work_hours'          => 'nullable|string|max:300',
            'shipping_policy'     => 'nullable|string|max:500',
            'return_policy'       => 'nullable|string|max:500',
            'payment_methods'     => 'nullable|string|max:300',
            'whatsapp_channel'    => 'nullable|string|max:300',
            'reply_with_name'     => 'nullable|boolean',
            'stop_on_manual'      => 'nullable|boolean',
            'manual_resume_after' => 'nullable|integer|in:5,20,30,60,300,720,1440',
            'multi_lang'          => 'nullable|boolean',
            'link_products'       => 'nullable|boolean',
            'faqs'                => 'nullable|array',
            'faqs.*.q'            => 'nullable|string|max:300',
            'faqs.*.a'            => 'nullable|string|max:500',
        ]);

        Auth::user()->update(['bot_config' => $data]);

        // Clear Node.js bot config cache so next message uses the new config immediately
        try {
            app(WhatsAppService::class)->clearConfigCache((string) Auth::id());
        } catch (\Throwable) {}

        return response()->json(['status' => 'ok']);
    }

    // Get current config for the form
    public function get()
    {
        return response()->json(Auth::user()->bot_config ?? []);
    }
}
