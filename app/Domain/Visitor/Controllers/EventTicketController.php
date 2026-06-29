<?php

namespace App\Domain\Visitor\Controllers;

use App\Domain\Visitor\Models\Ticket;
use App\Domain\Visitor\Services\EventTicketIssuanceService;
use App\Domain\Visitor\Services\EventTicketScanService;
use App\Http\Controllers\Controller;
use App\Mail\EventTicketConfirmationMail;
use App\Support\EventTicketMail;
use App\Support\EventTicketQr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class EventTicketController extends Controller
{
    public function __construct(
        private readonly EventTicketScanService $scanService,
    ) {
    }

    public function showQrTicket(Ticket $ticket): View
    {
        $ticket->load(['booking.visitorTicket', 'visitor', 'event.branding']);

        $visitorTicket = $ticket->booking?->visitorTicket;
        $emailSent = $visitorTicket
            ? (bool) session('event_ticket_email_sent_' . $visitorTicket->order_number, false)
            : false;
        $emailConfigured = EventTicketMail::isDeliverable();

        if ($visitorTicket) {
            session(['event_ticket_order' => $visitorTicket->order_number]);
        }

        return view('frontend.events.tickets.qr-ticket', compact('ticket', 'visitorTicket', 'emailSent', 'emailConfigured'));
    }

    public function qrImage(string $qr_token): Response
    {
        $content = EventTicketQr::resolveContentForToken($qr_token);

        abort_unless(filled($content), 404);

        $size = min(max((int) request()->query('size', 512), 200), 1024);
        $svg = EventTicketQr::generateSvg($content, $size);

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    public function verify(Request $request, string $qr_token): View
    {
        $ticket = Ticket::query()
            ->with(['visitor', 'event', 'booking.visitorTicket'])
            ->where('qr_token', $qr_token)
            ->first();

        $state = $this->scanService->resolveVerifyState($ticket);
        $eventWindow = $this->scanService->formatEventWindow($ticket?->event);
        $todayCheckin = $ticket ? $this->scanService->todayCheckin($ticket) : null;

        if ($ticket) {
            $this->scanService->logQrScan($ticket, $request, 'verify');
        }

        return view('frontend.events.tickets.verify-ticket', compact('ticket', 'state', 'eventWindow', 'todayCheckin'));
    }

    public function checkIn(Request $request, string $qr_token): RedirectResponse
    {
        $ticket = Ticket::query()
            ->with(['visitor', 'event', 'booking.visitorTicket'])
            ->where('qr_token', $qr_token)
            ->first();

        if (! $ticket) {
            return redirect()
                ->route('verify-ticket.show', $qr_token)
                ->withErrors(['ticket' => 'Invalid ticket.']);
        }

        $state = $this->scanService->resolveVerifyState($ticket);

        if ($state === 'used_today') {
            return redirect()
                ->route('verify-ticket.show', $qr_token)
                ->with('warning', 'Visitor already checked in today.');
        }

        if ($state !== 'valid') {
            $message = match ($state) {
                'not_started' => 'Check-in is not open yet. Event has not started.',
                'expired' => 'Event has ended. This ticket can no longer be used.',
                'cancelled' => 'This ticket has been cancelled.',
                'unpaid' => 'Payment is not confirmed for this ticket.',
                'invalid_visitor' => 'Visitor details could not be verified.',
                default => 'This ticket cannot be checked in.',
            };

            return redirect()
                ->route('verify-ticket.show', $qr_token)
                ->with('warning', $message);
        }

        $this->scanService->recordCheckIn($ticket, $request, $request->input('entry_gate'));

        return redirect()
            ->route('verify-ticket.show', $qr_token)
            ->with('success', 'Check-in successful.');
    }

    public function sendTicketEmail(Request $request, Ticket $ticket): RedirectResponse
    {
        $visitorTicket = $ticket->booking?->visitorTicket;

        abort_unless($visitorTicket, 404);

        $recipient = EventTicketMail::resolveRecipient($visitorTicket);

        if ($recipient === null) {
            return back()->with('warning', 'Email could not be sent. No valid visitor email found on this booking.');
        }

        $visitorTicket->loadMissing('user');

        if ($visitorTicket->user) {
            app(EventTicketIssuanceService::class)->issueFromVisitorTicket($visitorTicket, $visitorTicket->user);
        }

        if (! EventTicketMail::isDeliverable()) {
            return back()->with('warning', EventTicketMail::configurationHint());
        }

        try {
            Mail::to($recipient)->send(new EventTicketConfirmationMail($visitorTicket));
            session(['event_ticket_email_sent_' . $visitorTicket->order_number => true]);

            return back()->with('success', 'Ticket email sent successfully.');
        } catch (Throwable) {
            return back()->with('warning', 'Email could not be sent. Check SMTP settings in .env and try again.');
        }
    }
}
