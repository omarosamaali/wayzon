<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\SallaStore;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;

class SendSubscriptionReminders extends Command
{
    protected $signature   = 'wayzon:subscription-reminders';
    protected $description = 'Send WhatsApp reminders before/after subscription expiry';

    public function handle(WhatsAppService $whatsapp): void
    {
        $renewUrl = config('app.url') . '/dashboard#plans';

        // 1. Plans expiring in ~24 hours (between 23h and 25h from now)
        $expiringSoon = User::whereNotNull('plan')
            ->whereBetween('trial_ends_at', [now()->addHours(23), now()->addHours(25)])
            ->get();

        foreach ($expiringSoon as $user) {
            $phone = $this->getUserPhone($user);
            if (!$phone) continue;

            $msg = "أهلاً {$user->name} 👋\n\nباقتك في وايزون ستنتهي خلال *يوم واحد* ⏰\n\nجدد اشتراكك الآن للاستمرار في الاستفادة من جميع الخدمات:\n{$renewUrl}";
            $whatsapp->send((string) $user->id, $phone, $msg);
        }

        // 2. Trials expiring in ~24 hours
        $trialsExpiringSoon = User::whereNull('plan')
            ->whereNotNull('trial_ends_at')
            ->whereBetween('trial_ends_at', [now()->addHours(23), now()->addHours(25)])
            ->get();

        foreach ($trialsExpiringSoon as $user) {
            $phone = $this->getUserPhone($user);
            if (!$phone) continue;

            $msg = "أهلاً {$user->name} 👋\n\nفترة تجربتك المجانية في وايزون ستنتهي خلال *يوم واحد* ⏰\n\nاشترك الآن واستمر في الاستمتاع بكل المزايا:\n{$renewUrl}";
            $whatsapp->send((string) $user->id, $phone, $msg);
        }

        // 3. Subscriptions that just expired (within last hour)
        $justExpired = User::whereNotNull('plan')
            ->whereBetween('trial_ends_at', [now()->subHour(), now()])
            ->get();

        foreach ($justExpired as $user) {
            $phone = $this->getUserPhone($user);
            if (!$phone) continue;

            $msg = "أهلاً {$user->name} 👋\n\nانتهى اشتراكك في وايزون 😔\n\nجدد اشتراكك الآن لتستمر في تلقي رسائل الطلبات وإدارة متجرك بذكاء:\n{$renewUrl}";
            $whatsapp->send((string) $user->id, $phone, $msg);
            $user->update(['plan' => null]);
        }

        $this->info('Subscription reminders sent.');
    }

    private function getUserPhone(User $user): ?string
    {
        $store = SallaStore::where('user_id', $user->id)->first();
        return $store?->owner_phone ?? null;
    }
}
