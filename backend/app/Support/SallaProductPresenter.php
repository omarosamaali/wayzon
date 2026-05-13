<?php

namespace App\Support;

/**
 * Normalizes Salla product payloads for dashboard + bot (images, stock, availability).
 */
class SallaProductPresenter
{
    public static function imageUrl(array $p): ?string
    {
        $img = $p['main_image'] ?? $p['thumbnail'] ?? $p['image'] ?? null;
        if (is_string($img)) {
            return $img !== '' ? $img : null;
        }
        if (is_array($img)) {
            return $img['url'] ?? $img['full_url'] ?? $img['origin'] ?? null;
        }

        return null;
    }

    /**
     * @return array{quantity: ?float, unlimited: bool, in_stock: bool}
     */
    public static function availability(array $p): array
    {
        $unlimited = ! empty($p['unlimited_quantity']);

        $qtyRaw = $p['quantity'] ?? null;
        if (is_array($qtyRaw)) {
            $qtyRaw = $qtyRaw['quantity'] ?? $qtyRaw['value'] ?? null;
        }
        $quantity = is_numeric($qtyRaw) ? (float) $qtyRaw : null;

        $status = (string) ($p['status'] ?? '');
        $explicitOut = in_array($status, ['out', 'hidden', 'deleted'], true);

        if ($explicitOut) {
            return ['quantity' => $quantity, 'unlimited' => $unlimited, 'in_stock' => false];
        }
        if ($unlimited) {
            return ['quantity' => $quantity, 'unlimited' => true, 'in_stock' => true];
        }
        if (array_key_exists('is_available', $p) && ! (bool) $p['is_available']) {
            return ['quantity' => $quantity, 'unlimited' => false, 'in_stock' => false];
        }

        $inStock = $quantity === null || $quantity > 0;

        return [
            'quantity'  => $quantity,
            'unlimited' => false,
            'in_stock'  => $inStock,
        ];
    }
}
