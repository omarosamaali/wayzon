<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('services.whatsapp.url', 'http://localhost:3000'), '/');
    }

    public function status(string $tenantId): array
    {
        $response = Http::get("{$this->baseUrl}/status/{$tenantId}");
        return $response->json();
    }

    public function send(string $tenantId, string $phone, string $message): bool
    {
        $response = Http::post("{$this->baseUrl}/send", [
            'tenantId' => $tenantId,
            'phone'    => $phone,
            'message'  => $message,
        ]);

        return $response->json('success', false);
    }

    public function logout(string $tenantId): void
    {
        Http::post("{$this->baseUrl}/logout/{$tenantId}");
    }

    public function manualPaused(string $tenantId): array
    {
        $response = Http::get("{$this->baseUrl}/manual-paused/{$tenantId}");
        return $response->json() ?? ['pauses' => []];
    }

    public function manualResume(string $tenantId, string $phone): void
    {
        Http::post("{$this->baseUrl}/manual-resume/{$tenantId}/" . urlencode($phone));
    }

    public function manualResumeAll(string $tenantId): void
    {
        Http::post("{$this->baseUrl}/manual-resume-all/{$tenantId}");
    }

    public function clearConfigCache(string $tenantId): void
    {
        Http::timeout(5)->post("{$this->baseUrl}/cache/clear/{$tenantId}");
    }

    /**
     * بدء ربط واتساب برمز الرقم (بديل الـ QR عند فشل المسح).
     */
    public function startPairing(string $tenantId, string $phoneDigits): array
    {
        $response = Http::timeout(120)->post("{$this->baseUrl}/pairing/start", [
            'tenantId' => $tenantId,
            'phone' => $phoneDigits,
        ]);

        return $response->json() ?? ['success' => false, 'error' => 'No response'];
    }
}
