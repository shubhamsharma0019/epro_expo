<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Shared\Models\User;
use App\Domain\Shared\Services\EventTicketVisitorDetailsPageData;
use App\Http\Requests\Visitor\EventVisitorRegistrationRequest;
use App\Mail\EventTicketConfirmationMail;
use App\Support\EventTicketFlow;
use App\Support\EventTicketQr;
use App\Support\LiveContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class PurchaseController extends Controller
{
    public function visitorDetails(Request $request, EventTicketVisitorDetailsPageData $pageData)
    {
        $slug = $request->query('event');
        abort_unless(filled($slug), 404);

        $data = $pageData->build($slug);
        abort_if($data === null, 404);

        session([
            'event_booking_path' => EventTicketFlow::visitorPassEntryUrl($slug),
            'user_flow_context' => 'event_ticket',
        ]);

        return view('frontend.events.tickets.visitor-details', $data);
    }

    public function storeVisitorDetails(EventVisitorRegistrationRequest $request)
    {
        $slug = $request->input('event');
        $data = app(EventTicketVisitorDetailsPageData::class)->build($slug);
        abort_if($data === null, 404);

        $existingUser = User::query()->where('email', $request->input('email'))->first();

        if ($existingUser) {
            if (! Hash::check($request->input('password'), $existingUser->password)) {
                return back()
                    ->withInput($request->except('password'))
                    ->withErrors(['email' => 'An account with this email already exists. Please enter the correct password.']);
            }

            $existingUser->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'gender' => $request->input('gender'),
                'city' => $request->input('city'),
            ]);

            $user = $existingUser;
        } else {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'gender' => $request->input('gender'),
                'city' => $request->input('city'),
                'password' => $request->input('password'),
                'role' => 'user',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        session([
            EventTicketFlow::sessionRegistrationKey($slug) => true,
            'event_booking_path' => EventTicketFlow::ticketSelectionUrl($slug),
            'user_flow_context' => 'event_ticket',
        ]);

        return redirect()->route('events.tickets.attendee-details', ['event' => $slug])
            ->with('success', 'Visitor details saved. Select your ticket type to continue.');
    }

    public function attendeeDetails(Request $request)
    {
        $slug = $request->query('event');
        abort_unless(filled($slug), 404);

        if (! EventTicketFlow::hasVisitorRegistration($slug)) {
            return redirect()->route('events.tickets.visitor-details', ['event' => $slug]);
        }

        session([
            'event_booking_path' => EventTicketFlow::ticketSelectionUrl($slug),
            'user_flow_context' => 'event_ticket',
        ]);

        $dbEvent = LiveContent::companyEventQuery()
            ->with('ticketTypes')
            ->where('slug', $slug)
            ->first();

        abort_if(! $dbEvent, 404);

        return view('frontend.events.tickets.attendee-details', [
            'dbEvent' => $dbEvent,
            'slug' => $slug,
        ]);
    }

    public function summary(Request $request)
    {
        $slug = $request->query('event');

        return redirect()->route('events.tickets.attendee-details', ['event' => $slug]);
    }

    public function payment(Request $request)
    {
        $slug = $request->query('event');
        abort_unless(filled($slug), 404);

        if (! EventTicketFlow::hasVisitorRegistration($slug)) {
            return redirect()->route('events.tickets.visitor-details', ['event' => $slug]);
        }

        $dbEvent = LiveContent::companyEventQuery()
            ->with('ticketTypes')
            ->where('slug', $slug)
            ->first();

        abort_if(! $dbEvent, 404);

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
                'receipt' => 'ticket_' . now()->format('YmdHis') . '_' . Str::lower(Str::random(6)),
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

        if (! $orderData) {
            return redirect()->route('events.home')->with('error', 'Invalid order data.');
        }

        $eventSlug = $orderData['eventSlug'] ?? null;
        $companyEventId = null;
        $ticketTypeId = null;

        if ($eventSlug) {
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

        $user = $this->resolveBookingUser($orderData);

        $orderNumber = 'ORD-' . strtoupper(uniqid());
        $paymentStatus = ((float) ($orderData['totalAmount'] ?? 0)) > 0 ? 'paid' : 'paid';
        $razorpayOrderId = $request->input('razorpay_order_id');
        $razorpayPaymentId = $request->input('razorpay_payment_id');

        $ticket = \App\Domain\Visitor\Models\VisitorTicket::create([
            'user_id' => $user->id,
            'company_event_id' => $companyEventId,
            'ticket_type_id' => $ticketTypeId,
            'event_slug' => $eventSlug,
            'ticket_name' => $orderData['passName'],
            'order_number' => $orderNumber,
            'quantity' => $orderData['quantity'],
            'total_amount' => $orderData['totalAmount'],
            'status' => 'confirmed',
            'payment_status' => $paymentStatus,
            'razorpay_order_id' => $razorpayOrderId,
            'razorpay_payment_id' => $razorpayPaymentId,
            'qr_code_path' => null,
            'attendee_name' => $orderData['attendee_name'] ?? $user->name ?? 'Attendee',
            'attendee_email' => $orderData['attendee_email'] ?? $user->email ?? '',
            'attendee_phone' => $orderData['attendee_phone'] ?? $user->phone ?? '',
            'attendee_gender' => $orderData['attendee_gender'] ?? $user->gender,
            'attendee_city' => $orderData['attendee_city'] ?? $user->city,
        ]);

        $ticket->update([
            'qr_code_path' => EventTicketQr::payload($ticket),
        ]);

        session([
            'event_ticket_order' => $orderNumber,
        ]);
        session()->forget('event_booking_path');

        $this->dispatchTicketEmail($ticket);

        return redirect()->route('events.tickets.confirmed', ['order' => $orderNumber]);
    }

    public function confirmed(Request $request)
    {
        $orderNumber = $request->query('order') ?: session('event_ticket_order');
        $ticket = $this->resolveTicket($orderNumber);

        abort_unless($ticket, 404);

        session(['event_ticket_order' => $ticket->order_number]);

        $emailSent = (bool) session('event_ticket_email_sent_' . $ticket->order_number, false);
        $emailConfigured = filled(config('mail.default')) && config('mail.default') !== 'log';

        return view('frontend.events.tickets.confirmed', compact('ticket', 'emailSent', 'emailConfigured'));
    }

    public function eTicket(Request $request)
    {
        $orderNumber = $request->query('order') ?: session('event_ticket_order');
        $ticket = $this->resolveTicket($orderNumber);

        abort_unless($ticket, 404);

        $emailSent = (bool) session('event_ticket_email_sent_' . $ticket->order_number, false);
        $emailConfigured = filled(config('mail.default')) && config('mail.default') !== 'log';

        return view('frontend.events.tickets.e-ticket', compact('ticket', 'emailSent', 'emailConfigured'));
    }

    public function sendTicketEmail(Request $request)
    {
        $orderNumber = $request->input('order') ?: session('event_ticket_order');
        $ticket = $this->resolveTicket($orderNumber);

        abort_unless($ticket, 404);

        $sent = $this->dispatchTicketEmail($ticket);

        if ($request->expectsJson()) {
            return response()->json([
                'sent' => $sent,
                'message' => $sent
                    ? 'Ticket email sent successfully.'
                    : 'Email could not be sent. Please configure mail settings or download your QR ticket below.',
            ]);
        }

        return back()->with(
            $sent ? 'success' : 'warning',
            $sent
                ? 'Ticket email sent successfully.'
                : 'Email could not be sent. Please configure mail settings or download your QR ticket below.'
        );
    }

    private function resolveTicket(?string $orderNumber): ?\App\Domain\Visitor\Models\VisitorTicket
    {
        if ($orderNumber) {
            $ticket = \App\Domain\Visitor\Models\VisitorTicket::query()
                ->with(['companyEvent', 'ticketType', 'user'])
                ->where('order_number', $orderNumber)
                ->first();

            if ($ticket) {
                return $ticket;
            }
        }

        if (auth()->check()) {
            return \App\Domain\Visitor\Models\VisitorTicket::query()
                ->with(['companyEvent', 'ticketType', 'user'])
                ->where('user_id', auth()->id())
                ->where('status', 'confirmed')
                ->latest()
                ->first();
        }

        return null;
    }

    private function dispatchTicketEmail(\App\Domain\Visitor\Models\VisitorTicket $ticket): bool
    {
        $recipient = $ticket->attendee_email ?: $ticket->user?->email;

        if (! filled($recipient)) {
            return false;
        }

        try {
            Mail::to($recipient)->send(new EventTicketConfirmationMail($ticket));
            session(['event_ticket_email_sent_' . $ticket->order_number => true]);

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    private function resolveBookingUser(array $orderData): User
    {
        if (auth()->check()) {
            $user = auth()->user();

            if (filled($orderData['attendee_name'] ?? null) && $user->name !== $orderData['attendee_name']) {
                $user->update(['name' => $orderData['attendee_name']]);
            }

            if (filled($orderData['attendee_phone'] ?? null)) {
                $user->update(['phone' => $orderData['attendee_phone']]);
            }

            return $user;
        }

        $email = trim((string) ($orderData['attendee_email'] ?? ''));

        if ($email === '') {
            abort(422, 'Attendee email is required.');
        }

        $user = User::query()->firstOrCreate(
            ['email' => $email],
            [
                'name' => $orderData['attendee_name'] ?? 'Event Guest',
                'password' => Hash::make(Str::random(32)),
                'role' => 'user',
            ]
        );

        if (filled($orderData['attendee_name'] ?? null) && $user->name !== $orderData['attendee_name']) {
            $user->update(['name' => $orderData['attendee_name']]);
        }

        Auth::login($user);

        return $user;
    }
}
