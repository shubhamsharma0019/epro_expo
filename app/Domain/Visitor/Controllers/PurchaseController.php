<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use App\Support\LiveContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PurchaseController extends Controller
{
    public function attendeeDetails(Request $request)
    {
        $slug = $request->query('event');
        $dbEvent = null;
        if ($slug) {
            $dbEvent = LiveContent::companyEventQuery()
                ->with('ticketTypes')
                ->where('slug', $slug)
                ->first();
        }
        return view('frontend.events.tickets.attendee-details', compact('dbEvent', 'slug'));
    }

    public function summary(Request $request)
    {
        $slug = $request->query('event');
        $dbEvent = null;
        if ($slug) {
            $dbEvent = LiveContent::companyEventQuery()
                ->with('ticketTypes')
                ->where('slug', $slug)
                ->first();
        }
        return view('frontend.events.tickets.summary', compact('dbEvent', 'slug'));
    }

    public function payment(Request $request)
    {
        $slug = $request->query('event');
        $dbEvent = null;
        if ($slug) {
            $dbEvent = LiveContent::companyEventQuery()
                ->with('ticketTypes')
                ->where('slug', $slug)
                ->first();
        }
        $razorpayKey = config('services.razorpay.key');
        $razorpayCurrency = config('services.razorpay.currency', 'INR');
        $razorpayEnabled = filled($razorpayKey) && filled(config('services.razorpay.secret'));

        return view('frontend.events.tickets.payment', compact('dbEvent', 'slug', 'razorpayKey', 'razorpayCurrency', 'razorpayEnabled'));
    }

    public function createRazorpayOrder(Request $request)
    {
        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');
        $currency = config('services.razorpay.currency', 'INR');

        if (! filled($key) || ! filled($secret)) {
            return response()->json(['message' => 'Razorpay keys are not configured.'], 422);
        }

        $amountInPaise = (int) round((float) $request->input('amount') * 100);
        if ($amountInPaise < 100) {
            return response()->json(['message' => 'Payment amount must be at least INR 1.'], 422);
        }

        $response = Http::withBasicAuth($key, $secret)
            ->acceptJson()
            ->post('https://api.razorpay.com/v1/orders', [
                'amount' => $amountInPaise,
                'currency' => $currency,
                'receipt' => 'ticket_' . auth()->id() . '_' . now()->format('YmdHis'),
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
            'description' => 'Event Ticket Purchase',
        ]);
    }

    public function confirmPayment(Request $request)
    {
        // Check Razorpay signature if enabled
        $secret = config('services.razorpay.secret');
        if (filled($secret) && $request->filled('razorpay_signature')) {
            $expectedSignature = hash_hmac(
                'sha256',
                $request->input('razorpay_order_id') . '|' . $request->input('razorpay_payment_id'),
                $secret
            );

            if (! hash_equals($expectedSignature, $request->input('razorpay_signature'))) {
                return redirect()->route('events.home')->with('error', 'Payment verification failed.');
            }
        }

        $orderData = json_decode($request->input('orderData'), true);
        
        if (!$orderData) {
            return redirect()->route('events.home')->with('error', 'Invalid order data.');
        }

        $eventSlug = $orderData['eventSlug'] ?? null;
        $companyEventId = null;
        $ticketTypeId = null;

        if ($eventSlug && $eventSlug !== 'global-tech-summit-2024') {
            $dbEvent = LiveContent::companyEventQuery()->where('slug', $eventSlug)->first();
            if ($dbEvent) {
                $companyEventId = $dbEvent->id;
                $ticketTypeModel = \App\Domain\Event\Models\CompanyEvent\CompanyEventTicketType::where('company_event_id', $dbEvent->id)
                    ->where('name', $orderData['passName'])
                    ->first();
                if ($ticketTypeModel) {
                    $ticketTypeId = $ticketTypeModel->id;
                }
            }
        }

        // Generate unique order number
        $orderNumber = 'ORD-' . strtoupper(uniqid());

        // Create the ticket
        $ticket = \App\Domain\Visitor\Models\VisitorTicket::create([
            'user_id' => auth()->id(),
            'company_event_id' => $companyEventId,
            'ticket_type_id' => $ticketTypeId,
            'event_slug' => $eventSlug,
            'ticket_name' => $orderData['passName'],
            'order_number' => $orderNumber,
            'quantity' => $orderData['quantity'],
            'total_amount' => $orderData['totalAmount'],
            'status' => 'confirmed',
            'qr_code_path' => null, // We'll generate QR later
            'attendee_name' => $orderData['attendee_name'] ?? auth()->user()->name ?? 'Attendee',
            'attendee_email' => $orderData['attendee_email'] ?? auth()->user()->email ?? '',
            'attendee_phone' => $orderData['attendee_phone'] ?? auth()->user()->phone ?? '',
        ]);

        session()->forget('event_booking_path');

        return redirect()->route('events.tickets.confirmed', ['order' => $orderNumber]);
    }

    public function confirmed(Request $request)
    {
        $orderNumber = $request->query('order');
        $ticketQuery = \App\Domain\Visitor\Models\VisitorTicket::query()
            ->where('user_id', auth()->id());

        $ticket = $orderNumber
            ? (clone $ticketQuery)->where('order_number', $orderNumber)->first()
            : null;

        if (! $ticket) {
            $ticket = (clone $ticketQuery)
                ->where('status', 'confirmed')
                ->latest()
                ->first();
        }

        abort_unless($ticket, 404);

        return view('frontend.events.tickets.confirmed', compact('ticket'));
    }

    public function eTicket(Request $request)
    {
        // For previewing or downloading
        return view('frontend.events.tickets.e-ticket');
    }
}
