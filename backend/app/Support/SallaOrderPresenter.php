<?php

namespace App\Support;

/**
 * Normalizes Salla order payloads (totals + status) across webhooks, API, and bot.
 */
class SallaOrderPresenter
{
    /**
     * Extract numeric order total from various Salla v2 shapes.
     */
    public static function orderTotalFromPayload(array $o): float
    {
        // List-orders often uses `total: { amount, currency }` without `amounts.*`.
        // Never return sub_total=0 before checking real totals (common Salla shape).
        $candidates = [
            data_get($o, 'amounts.total.amount'),
            data_get($o, 'amounts.total'),
            data_get($o, 'total.amount'),
            data_get($o, 'total'),
            data_get($o, 'totals.total.amount'),
            data_get($o, 'totals.total'),
            data_get($o, 'amounts.sub_total.amount'),
            data_get($o, 'amounts.sub_total'),
        ];

        foreach ($candidates as $v) {
            if ($v === null || $v === '') {
                continue;
            }
            if (is_array($v)) {
                $v = $v['amount'] ?? $v['value'] ?? null;
            }
            if (! is_numeric($v)) {
                continue;
            }
            $f = (float) $v;
            if ($f > 0) {
                return $f;
            }
        }

        $items = $o['items'] ?? [];
        if (is_array($items) && $items !== []) {
            $sum = 0.0;
            foreach ($items as $it) {
                if (! is_array($it)) {
                    continue;
                }
                $line = data_get($it, 'total.amount')
                    ?? data_get($it, 'total')
                    ?? data_get($it, 'price.amount')
                    ?? data_get($it, 'price')
                    ?? data_get($it, 'amounts.total.amount')
                    ?? null;
                if (is_array($line)) {
                    $line = $line['amount'] ?? $line['value'] ?? null;
                }
                if (is_numeric($line)) {
                    $qty = (int) ($it['quantity'] ?? 1);
                    $sum += (float) $line * max(1, $qty);
                }
            }
            if ($sum > 0) {
                return $sum;
            }
        }

        return 0.0;
    }

    /**
     * Arabic label: prefer Salla's localized name, else internal map.
     */
    public static function statusLabelFromOrder(array $o): string
    {
        $slug = (string) (data_get($o, 'status.slug') ?? data_get($o, 'status') ?? 'unknown');
        $name  = data_get($o, 'status.name');
        if (is_string($name) && trim($name) !== '') {
            return trim($name);
        }

        return self::arabicStatusFromSlug($slug);
    }

    public static function statusSlugFromOrder(array $o): string
    {
        return (string) (data_get($o, 'status.slug') ?? data_get($o, 'status') ?? 'unknown');
    }

    public static function arabicStatusFromSlug(string $slug): string
    {
        $map = [
            'new'                  => 'جديد 🆕',
            'in_progress'          => 'قيد التنفيذ 🔄',
            'processing'           => 'قيد التجهيز 🔄',
            'under_review'         => 'بانتظار المراجعة ⏳',
            'pending_review'       => 'بانتظار المراجعة ⏳',
            'pending_payment'      => 'بانتظار الدفع 💳',
            'paid'                 => 'تم الدفع ✅',
            'payment_confirmed'    => 'تم الدفع ✅',
            'shipped'              => 'تم الشحن 🚚',
            'delivering'           => 'جاري التوصيل 🛵',
            'out_for_delivery'     => 'جاري التوصيل 🛵',
            'delivered'            => 'تم التوصيل 🎉',
            'completed'            => 'تم التوصيل 🎉',
            'canceled'             => 'ملغي ❌',
            'cancelled'            => 'ملغي ❌',
            'returned'             => 'مسترجع 🔁',
            'refunded'             => 'مسترجع 🔁',
            'under_return'         => 'قيد الاسترجاع 🔄',
            'return_in_progress'   => 'قيد الاسترجاع 🔄',
            'pending_quote'        => 'بانتظار عرض سعر 📋',
            'pending_quotation'    => 'بانتظار عرض سعر 📋',
        ];

        return $map[$slug] ?? $slug;
    }
}
