<?php

namespace App\Domain\Visitor\Controllers;

use App\Domain\Visitor\Models\Ticket;
use App\Domain\Visitor\Services\EventTicketIssuanceService;
use App\Domain\Visitor\Services\EventTicketScanService;
use App\Http\Controllers\Controller;
use App\Support\EventTicketMail;
use App\Support\EventTicketQr;
use App\Support\PlatformMailSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class EventTicketController extends Controller
{
    public function __construct(
        private readonly EventTicketScanService $scanService,
    ) {
    }

    public function showQrTicket(Ticket $ticket): View
    {
        $this->authorizeTicketOwner($ticket);

        $ticket->load(['booking.visitorTicket', 'visitor', 'event.branding']);

        $visitorTicket = $ticket->booking?->visitorTicket;
        $ticketRecipientEmail = $visitorTicket
            ? EventTicketMail::resolveRecipient($visitorTicket)
            : null;
        $emailConfigured = EventTicketMail::isDeliverable();
        $emailSent = $visitorTicket
            ? (bool) session('event_ticket_email_sent_' . $visitorTicket->order_number, false)
            : false;

        if ($visitorTicket) {
            session(['event_ticket_order' => $visitorTicket->order_number]);

            if (! $emailSent && $emailConfigured) {
                $autoSend = EventTicketMail::attemptAutoSend($visitorTicket);
                $emailSent = (bool) ($autoSend['sent'] ?? false);

                if (($autoSend['sent'] ?? false) && ! ($autoSend['skipped'] ?? false) && filled($autoSend['message'] ?? null)) {
                    session()->flash('success', $autoSend['message']);
                } elseif (! ($autoSend['sent'] ?? false) && ! ($autoSend['skipped'] ?? false)) {
                    session()->flash('warning', $autoSend['message'] ?? EventTicketMail::visitorSendFailureMessage($ticketRecipientEmail));
                }
            }
        }

        return view('frontend.events.tickets.qr-ticket', compact(
            'ticket',
            'visitorTicket',
            'emailSent',
            'emailConfigured',
            'ticketRecipientEmail',
        ));
    }

    public function qrImage(string $qr_token): Response
    {
        $ticket = Ticket::query()->where('qr_token', $qr_token)->first();

        abort_unless($ticket && $this->scanService->canAcceptScannerAction($ticket), 404);

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
        $todayCheckin = $ticket ? $this->scanService->todayCheckin($ticket, 'checked_in') : null;
        $checkinCount = $ticket ? $this->scanService->totalCheckIns($ticket) : 0;
        $scanCount = $ticket ? $this->scanService->totalScans($ticket) : 0;

        if ($ticket && $this->scanService->canAcceptScannerAction($ticket)) {
            $this->scanService->logQrScan($ticket, $request, 'verify');
        }

        return view('frontend.events.tickets.verify-ticket', compact(
            'ticket',
            'state',
            'eventWindow',
            'todayCheckin',
            'checkinCount',
            'scanCount',
        ));
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
        $this->authorizeTicketOwner($ticket);

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

        $wasSent = (bool) session('event_ticket_email_sent_' . $visitorTicket->order_number, false);

        PlatformMailSettings::applyToConfig();

        $result = EventTicketMail::sendTicket($visitorTicket);

        if ($result['sent']) {
            session(['event_ticket_email_sent_' . $visitorTicket->order_number => true]);

            return back()->with('success', $wasSent
                ? 'Ticket resent to ' . ($result['recipient'] ?? 'your email') . '.'
                : $result['message']);
        }

        if (filled($result['admin_message'] ?? null)) {
            \Illuminate\Support\Facades\Log::warning('Event ticket email failed.', [
                'order_number' => $visitorTicket->order_number,
                'recipient' => $result['recipient'],
                'error' => $result['admin_message'],
            ]);
        }

        return back()->with('warning', $result['message']);
    }

    private function authorizeTicketOwner(Ticket $ticket): void
    {
        $ticket->loadMissing('booking');

        if (! $this->scanService->isTicketOwner($ticket)) {
            abort(403, 'You are not authorized to view this ticket.');
        }
    }
}
