<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SallaStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private const ADMIN_EMAILS = ['faisal@1212.com', 'omar@gmail.com'];

    private function guard(): bool
    {
        return in_array(Auth::user()?->email, self::ADMIN_EMAILS);
    }

    public function index(Request $request)
    {
        if (!$this->guard()) abort(403);

        $q = $request->query('q');

        $users = User::with(['sallaStore'])
            ->when($q, function ($query) use ($q) {
                $query->where('email', 'like', "%{$q}%")
                      ->orWhere('name', 'like', "%{$q}%")
                      ->orWhereHas('sallaStore', fn($s) => $s->where('store_name', 'like', "%{$q}%"));
            })
            ->orderByDesc('created_at')
            ->paginate(25);

        return view('admin', compact('users', 'q'));
    }

    public function setPlan(Request $request, User $user)
    {
        if (!$this->guard()) abort(403);
        $request->validate(['plan' => 'required|in:basic,smart,pro,none']);
        $plan = $request->plan === 'none' ? null : $request->plan;
        $updates = ['plan' => $plan];
        if ($plan === null) {
            $updates['subscription_ends_at'] = null;
        }
        $user->update($updates);
        return back()->with('success', "تم تغيير الباقة إلى {$request->plan}");
    }

    public function impersonate(User $user)
    {
        if (!$this->guard()) abort(403);
        session(['impersonating_admin_id' => Auth::id()]);
        Auth::login($user);
        return redirect('/dashboard');
    }

    public function stopImpersonate()
    {
        $adminId = session('impersonating_admin_id');
        if (!$adminId) return redirect('/dashboard');
        session()->forget('impersonating_admin_id');
        Auth::loginUsingId($adminId);
        return redirect('/admin');
    }

    public function botTraining()
    {
        if (!$this->guard()) abort(403);
        $prompt   = Storage::disk('local')->exists('wayzon_system_prompt.txt')
            ? Storage::disk('local')->get('wayzon_system_prompt.txt') : '';
        $aiModel  = Storage::disk('local')->exists('wayzon_ai_model.txt')
            ? Storage::disk('local')->get('wayzon_ai_model.txt') : 'gpt-4o-mini';
        return view('admin-bot-training', compact('prompt', 'aiModel'));
    }

    public function saveBotTraining(Request $request)
    {
        if (!$this->guard()) abort(403);
        $request->validate(['prompt' => 'required|string|max:8000']);
        Storage::disk('local')->put('wayzon_system_prompt.txt', $request->prompt);
        return back()->with('success', 'تم حفظ تدريب البوت بنجاح ✅');
    }

    public function saveAiModel(Request $request)
    {
        if (!$this->guard()) abort(403);
        $request->validate(['model' => 'required|string|max:100']);
        Storage::disk('local')->put('wayzon_ai_model.txt', $request->model);
        return back()->with('success', "تم تغيير نموذج الذكاء إلى {$request->model} ✅");
    }

    public function setUserModel(Request $request, User $user)
    {
        if (!$this->guard()) abort(403);
        $request->validate(['model' => 'nullable|string|max:50']);
        $config = $user->bot_config ?? [];
        if ($request->model) {
            $config['ai_model_override'] = $request->model;
        } else {
            unset($config['ai_model_override']);
        }
        $user->update(['bot_config' => $config]);
        return back()->with('success', "تم تغيير نموذج {$user->email} إلى " . ($request->model ?: 'النموذج العام'));
    }

    public function deleteUser(User $user)
    {
        if (!$this->guard()) abort(403);
        if (in_array($user->email, self::ADMIN_EMAILS)) {
            return back()->with('error', 'لا يمكن حذف حساب الأدمن');
        }
        $user->delete();
        return back()->with('success', "تم حذف حساب {$user->email} بنجاح");
    }

    public function setTrial(Request $request, User $user)
    {
        if (!$this->guard()) abort(403);
        $data = $request->validate(['days' => 'required|integer|min:1|max:365']);
        $days  = (int) $data['days'];

        $base = now();
        if ($user->subscription_ends_at && $user->subscription_ends_at->isFuture()) {
            $base = $user->subscription_ends_at->copy();
        }

        $updates = ['subscription_ends_at' => $base->copy()->addDays($days)];
        if (!$user->plan) {
            $updates['plan'] = 'basic';
        }
        $user->update($updates);

        return back()->with('success', "تم تفعيل الاشتراك {$days} يوم للمستخدم {$user->email}");
    }
}
