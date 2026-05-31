<?php

namespace App\Http\Controllers\CompanyEvent;

use App\Models\CompanyEvent\CompanyEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class PaymentController extends BaseCompanyEventController
{
    public function show(CompanyEvent $companyEvent): View
    {
        if ($companyEvent->company_id !== $this->companyId()) {
            abort(403);
        }

        $razorpayKey = config('services.razorpay.key');
        $razorpayCurrency = config('services.razorpay.currency', 'INR');
        $razorpayEnabled = filled($razorpayKey) && filled(config('services.razorpay.secret'));

        return view('company.event-company-flow.payment', compact('companyEvent', 'razorpayKey', 'razorpayCurrency', 'razorpayEnabled'));
    }

    public function createRazorpayOrder(Request $request, CompanyEvent $companyEvent)
    {
        if ($companyEvent->company_id !== $this->companyId()) {
            abort(403);
        }

        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');
        $currency = config('services.razorpay.currency', 'INR');

        if (! filled($key) || ! filled($secret)) {
            return response()->json(['message' => 'Razorpay keys are not configured.'], 422);
        }

        // Suppose standard event publishing fee is ₹150
        $amountInPaise = 150 * 100;

        $response = Http::withBasicAuth($key, $secret)
            ->acceptJson()
            ->post('https://api.razorpay.com/v1/orders', [
                'amount' => $amountInPaise,
                'currency' => $currency,
                'receipt' => 'event_' . $companyEvent->id . '_' . now()->format('YmdHis'),
            ]);

        if ($response->failed()) {
            return response()->json([
                'message' => $response->json('error.description') ?: 'Unable to create Razorpay order.',
            ], 422);
        }

        $order = $response->json();

        return response()->json([
            'key' => $key,
            'order_id' => $order['id'] ?? null,
            'amount' => $amountInPaise,
            'currency' => $currency,
            'name' => 'EproExpo',
            'description' => 'Event Publishing Fee',
        ]);
    }

    public function pay(Request $request, CompanyEvent $companyEvent): RedirectResponse
    {
        if ($companyEvent->company_id !== $this->companyId()) {
            abort(403);
        }

        $companyEvent->loadMissing('latestPublishRequest');
        if ($companyEvent->latestPublishRequest?->status !== 'approved') {
            return redirect()
                ->route('company.event-company-flow.dashboard')
                ->with('status', 'Your event is waiting for admin approval before it can go live.');
        }

        $secret = config('services.razorpay.secret');
        if (filled($secret) && $request->filled('razorpay_signature')) {
            $expectedSignature = hash_hmac(
                'sha256',
                $request->input('razorpay_order_id') . '|' . $request->input('razorpay_payment_id'),
                $secret
            );

            if (! hash_equals($expectedSignature, $request->input('razorpay_signature'))) {
                return redirect()->back()->with('error', 'Payment verification failed.');
            }
        }

        $companyEvent->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()
            ->route('company.event-company-flow.dashboard')
            ->with('status', 'Your event has been successfully paid and published!');
    }
}
