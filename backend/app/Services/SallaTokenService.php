<?php

namespace App\Services;

use App\Models\SallaStore;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SallaTokenService
{
    public function getValidToken(SallaStore $store): ?string
    {
        // If token expires in less than 5 minutes, refresh it
        if ($store->token_expires_at && $store->token_expires_at->subMinutes(5)->isPast()) {
            return $this->refresh($store);
        }

        return $store->access_token;
    }

    private function refresh(SallaStore $store): ?string
    {
        if (!$store->refresh_token) {
            Log::warning("SallaTokenService: no refresh_token for store {$store->store_id}");
            return $store->access_token;
        }

        try {
            $response = Http::asForm()->post('https://accounts.salla.sa/oauth2/token', [
                'client_id'     => config('salla.client_id'),
                'client_secret' => config('salla.client_secret'),
                'grant_type'    => 'refresh_token',
                'refresh_token' => $store->refresh_token,
            ]);

            if (!$response->successful()) {
                Log::error("SallaTokenService: refresh failed for store {$store->store_id}", $response->json() ?? []);
                return $store->access_token;
            }

            $data = $response->json();

            $store->update([
                'access_token'     => $data['access_token'],
                'refresh_token'    => $data['refresh_token'] ?? $store->refresh_token,
                'token_expires_at' => now()->addSeconds($data['expires_in'] ?? 3600),
            ]);

            Log::info("SallaTokenService: token refreshed for store {$store->store_id}");

            return $data['access_token'];
        } catch (\Throwable $e) {
            Log::error("SallaTokenService: exception for store {$store->store_id}: " . $e->getMessage());
            return $store->access_token;
        }
    }
}
