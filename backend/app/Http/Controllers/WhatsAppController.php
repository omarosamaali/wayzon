<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    public function __construct(private WhatsAppService $wa) {}

    // Get QR / connection status
    public function status()
    {
        $tenantId = (string) auth()->id();
        $data     = $this->wa->status($tenantId);

        // Clear disconnect flag once WA is back online
        if (($data['state'] ?? '') === 'ready' && auth()->user()->wa_disconnected) {
            auth()->user()->update(['wa_disconnected' => false]);
        }

        return response()->json($data);
    }

    // Send message manually
    public function send(Request $request)
    {
        $request->validate([
            'phone'   => 'required|string',
            'message' => 'required|string',
        ]);

        $tenantId = (string) auth()->id();
        $success  = $this->wa->send($tenantId, $request->phone, $request->message);

        return response()->json(['success' => $success]);
    }

    // Logout
    public function logout()
    {
        $tenantId = (string) auth()->id();
        $this->wa->logout($tenantId);
        return response()->json(['success' => true]);
    }

    public function manualPaused()
    {
        return response()->json($this->wa->manualPaused((string) auth()->id()));
    }

    public function manualResume(string $phone)
    {
        $this->wa->manualResume((string) auth()->id(), $phone);
        return response()->json(['success' => true]);
    }

    public function manualResumeAll()
    {
        $this->wa->manualResumeAll((string) auth()->id());
        return response()->json(['success' => true]);
    }

    /** طلب رمز ربط بالرقم (الخدمة تعيد تهيئة الجلسة ثم توليد الرمز) */
    public function requestPairing(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:20',
        ]);

        $digits = preg_replace('/\D+/', '', $request->input('phone'));
        if (strlen($digits) < 10) {
            return response()->json(['success' => false, 'error' => 'رقم غير صالح (مع كود الدولة، بدون +)'], 422);
        }

        $tenantId = (string) auth()->id();

        return response()->json(
            $this->wa->startPairing($tenantId, $digits)
        );
    }
}
