<?php

namespace App\Domain\Visitor\Services;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Visitor\Models\Ticket;
use App\Domain\Visitor\Models\TicketScanLog;
use App\Domain\Visitor\Models\VisitorCheckin;
use App\Support\TicketScanDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EventTicketScanService
{
    public function resolveVerifyState(?Ticket $ticket): string
    {
        if (! $ticket) {
            return 'invalid';
        }

        if ($ticket->status === 'cancelled') {
            return 'cancelled';
        }

        if (! $this->isPaymentValid($ticket)) {
            return 'unpaid';
        }

        if (! $this->isVisitorValid($ticket)) {
            return 'invalid_visitor';
        }

        $windowState = $this->eventWindowState($ticket->event);

        if ($windowState === 'expired') {
            return 'expired';
        }

        if ($this->hasCheckedInToday($ticket)) {
            return 'used_today';
        }

        if ($this->hasExceededEventDayLimit($ticket)) {
            return 'limit_reached';
        }

        return 'valid';
    }

    public function eventDayCount(?CompanyEvent $event): int
    {
        if (! $event?->starts_at) {
            return 1;
        }

        $timezone = $event->timezone ?: (string) config('app.timezone');
        $start = $event->starts_at->copy()->timezone($timezone)->startOfDay();
        $end = ($event->ends_at ?? $event->starts_at)->copy()->timezone($timezone)->startOfDay();

        return max(1, $start->diffInDays($end) + 1);
    }

    public function hasExceededEventDayLimit(Ticket $ticket): bool
    {
        return $this->totalCheckIns($ticket) >= $this->eventDayCount($ticket->event);
    }

    public function remainingCheckIns(Ticket $ticket): int
    {
        return max(0, $this->eventDayCount($ticket->event) - $this->totalCheckIns($ticket));
    }

    public function scannerUsername(): ?string
    {
        $username = session('ticket_scanner_username');

        if (filled($username)) {
            return (string) $username;
        }

        return 'QR Gate';
    }

    public function scanLocation(?Request $request = null): ?string
    {
        $request ??= request();
        $fromRequest = trim((string) ($request?->input('entry_gate') ?? $request?->input('scan_location') ?? ''));

        if ($fromRequest !== '') {
            return $fromRequest;
        }

        $fromSession = trim((string) session('ticket_scanner_location', ''));

        return $fromSession !== '' ? $fromSession : null;
    }

    public function visitorSnapshot(Ticket $ticket): array
    {
        $visitorTicket = $ticket->booking?->visitorTicket;

        return [
            'visitor_name' => $this->visitorDisplayName($ticket),
            'visitor_email' => $this->visitorDisplayEmail($ticket),
            'visitor_phone' => trim((string) (
                $ticket->meta['attendee_phone']
                ?? $visitorTicket?->attendee_phone
                ?? $ticket->visitor?->phone
                ?? ''
            )) ?: null,
        ];
    }

    public function eventWindowState(?CompanyEvent $event): string
    {
        if (! $event || ! $event->starts_at) {
            return 'active';
        }

        $timezone = $event->timezone ?: (string) config('app.timezone');
        $now = now($timezone);
        $start = $event->starts_at->copy()->timezone($timezone)->startOfDay();
        $end = ($event->ends_at ?? $event->starts_at)->copy()->timezone($timezone)->endOfDay();

        if ($now->lt($start)) {
            return 'not_started';
        }

        if ($now->gt($end)) {
            return 'expired';
        }

        return 'active';
    }

    public function isWithinEventWindow(?CompanyEvent $event): bool
    {
        return $this->eventWindowState($event) === 'active';
    }

    public function isTicketOwner(Ticket $ticket, ?int $userId = null): bool
    {
        $userId ??= auth()->id();

        if (! $userId) {
            return false;
        }

        if ((int) $ticket->visitor_id === (int) $userId) {
            return true;
        }

        return $ticket->booking && (int) $ticket->booking->user_id === (int) $userId;
    }

    public function canAcceptScannerAction(Ticket $ticket): bool
    {
        if ($ticket->status === 'cancelled') {
            return false;
        }

        if (! $this->isPaymentValid($ticket)) {
            return false;
        }

        if (! $this->isVisitorValid($ticket)) {
            return false;
        }

        return $this->eventWindowState($ticket->event) !== 'expired';
    }

    public function isPaymentValid(Ticket $ticket): bool
    {
        return in_array(strtolower((string) $ticket->payment_status), ['paid', 'confirmed', 'completed'], true);
    }

    public function isVisitorValid(Ticket $ticket): bool
    {
        if (! $ticket->visitor_id || ! $ticket->visitor) {
            return false;
        }

        if ($ticket->booking && (int) $ticket->booking->user_id !== (int) $ticket->visitor_id) {
            return false;
        }

        return in_array($ticket->status, ['confirmed', 'used', 'pending'], true);
    }

    public function hasCheckedInToday(Ticket $ticket): bool
    {
        return $this->todayCheckin($ticket, 'checked_in') !== null;
    }

    public function todayCheckin(Ticket $ticket, ?string $status = null): ?VisitorCheckin
    {
        $timezone = $ticket->event?->timezone ?: (string) config('app.timezone');
        $todayStart = now($timezone)->startOfDay()->utc();
        $todayEnd = now($timezone)->endOfDay()->utc();

        return VisitorCheckin::query()
            ->where('ticket_id', $ticket->id)
            ->when($status, fn ($query) => $query->where('status', $status))
            ->whereBetween('checked_in_at', [$todayStart, $todayEnd])
            ->latest('checked_in_at')
            ->first();
    }

    public function totalCheckIns(Ticket $ticket): int
    {
        $query = VisitorCheckin::query()
            ->where('ticket_id', $ticket->id)
            ->where('status', 'checked_in');

        if (Schema::hasColumn('visitor_checkins', 'checkin_date')) {
            return (int) $query
                ->whereNotNull('checkin_date')
                ->distinct()
                ->count('checkin_date');
        }

        return $query->count();
    }

    public function totalScans(Ticket $ticket): int
    {
        return TicketScanLog::query()
            ->where('ticket_id', $ticket->id)
            ->count();
    }

    public function visitorDisplayName(Ticket $ticket): string
    {
        $visitorTicket = $ticket->booking?->visitorTicket;

        return trim((string) (
            $ticket->meta['attendee_name']
            ?? $visitorTicket?->attendee_name
            ?? $ticket->visitor?->name
            ?? 'Visitor'
        ));
    }

    public function visitorDisplayEmail(Ticket $ticket): ?string
    {
        $visitorTicket = $ticket->booking?->visitorTicket;
        $email = trim((string) (
            $ticket->meta['attendee_email']
            ?? $visitorTicket?->attendee_email
            ?? $ticket->visitor?->email
            ?? ''
        ));

        return $email !== '' ? $email : null;
    }

    public function formatEventWindow(?CompanyEvent $event): ?string
    {
        if (! $event?->starts_at) {
            return null;
        }

        $start = $event->starts_at->format('M d, Y');
        $end = $event->ends_at?->format('M d, Y') ?? $start;

        return $start === $end ? $start : "{$start} - {$end}";
    }

    public function logQrScan(Ticket $ticket, Request $request, string $action = 'verify'): TicketScanLog
    {
        $device = TicketScanDevice::fromRequest($request);
        $scannedAt = now();
        $visitor = $this->visitorSnapshot($ticket);
        $scanLocation = $this->scanLocation($request);

        $log = TicketScanLog::query()->create([
            'ticket_id' => $ticket->id,
            'visitor_id' => $ticket->visitor_id,
            'company_event_id' => $ticket->event_id,
            'visitor_name' => $visitor['visitor_name'],
            'visitor_email' => $visitor['visitor_email'],
            'visitor_phone' => $visitor['visitor_phone'],
            'qr_token' => $ticket->qr_token,
            'action' => $action,
            'scanner_username' => $this->scannerUsername(),
            'scan_location' => $scanLocation,
            'device_type' => $device['device_type'],
            'device_name' => $device['device_name'],
            'user_agent' => $device['user_agent'],
            'ip_address' => $device['ip_address'],
            'scanned_at' => $scannedAt,
        ]);

        if ($action === 'verify') {
            $this->upsertScanCheckin($ticket, $device, $scannedAt);
        }

        return $log;
    }

    public function recordCheckIn(Ticket $ticket, ?Request $request = null, ?string $entryGate = null): VisitorCheckin
    {
        $checkedInAt = now();
        $visitorTicket = $ticket->booking?->visitorTicket;
        $device = TicketScanDevice::fromRequest($request);
        $visitor = $this->visitorSnapshot($ticket);
        $scanLocation = $this->scanLocation($request);

        if ($request) {
            $this->logQrScan($ticket, $request, 'check_in');
        }

        $payload = [
            'user_id' => $ticket->visitor_id,
            'visitor_ticket_id' => $visitorTicket?->id,
            'ticket_id' => $ticket->id,
            'company_event_id' => $ticket->event_id,
            'visitor_name' => $visitor['visitor_name'],
            'visitor_email' => $visitor['visitor_email'],
            'visitor_phone' => $visitor['visitor_phone'],
            'entry_gate' => $entryGate ?: $scanLocation,
            'checkin_type' => 'qr',
            'device_type' => $device['device_type'],
            'device_name' => $device['device_name'],
            'user_agent' => $device['user_agent'],
            'ip_address' => $device['ip_address'],
            'scanner_username' => $this->scannerUsername(),
            'scan_location' => $scanLocation,
            'status' => 'checked_in',
            'checked_in_at' => $checkedInAt,
            'checkin_date' => $this->eventCheckinDate($ticket, $checkedInAt),
        ];

        $checkin = VisitorCheckin::query()->create($payload);

        $meta = $ticket->meta ?? [];
        $meta['last_checkin_at'] = $checkedInAt->toIso8601String();
        $meta['total_checkins'] = $this->totalCheckIns($ticket);

        $ticket->update([
            'checked_in' => true,
            'checked_in_at' => $ticket->checked_in_at ?? $checkedInAt,
            'status' => $this->eventWindowState($ticket->event) === 'expired' ? 'used' : 'confirmed',
            'meta' => $meta,
        ]);

        if ($visitorTicket && $visitorTicket->status !== 'cancelled') {
            $visitorTicket->update(['status' => 'confirmed']);
        }

        return $checkin;
    }

    private function upsertScanCheckin(Ticket $ticket, array $device, $scannedAt): VisitorCheckin
    {
        $visitorTicket = $ticket->booking?->visitorTicket;
        $existing = $this->todayCheckin($ticket, 'scanned');
        $visitor = $this->visitorSnapshot($ticket);
        $scanLocation = $this->scanLocation();

        $payload = [
            'user_id' => $ticket->visitor_id,
            'visitor_ticket_id' => $visitorTicket?->id,
            'ticket_id' => $ticket->id,
            'company_event_id' => $ticket->event_id,
            'visitor_name' => $visitor['visitor_name'],
            'visitor_email' => $visitor['visitor_email'],
            'visitor_phone' => $visitor['visitor_phone'],
            'checkin_type' => 'qr',
            'device_type' => $device['device_type'],
            'device_name' => $device['device_name'],
            'user_agent' => $device['user_agent'],
            'ip_address' => $device['ip_address'],
            'scanner_username' => $this->scannerUsername(),
            'scan_location' => $scanLocation,
            'status' => 'scanned',
            'checked_in_at' => $scannedAt,
            'checkin_date' => $this->eventCheckinDate($ticket, $scannedAt),
        ];

        if ($existing) {
            $existing->update($payload);

            return $existing->fresh();
        }

        return VisitorCheckin::query()->create($payload);
    }

    public function canCheckIn(Ticket $ticket): bool
    {
        return $this->resolveVerifyState($ticket) === 'valid';
    }

    private function eventCheckinDate(Ticket $ticket, $moment): string
    {
        $timezone = $ticket->event?->timezone ?: (string) config('app.timezone');

        return $moment->copy()->timezone($timezone)->toDateString();
    }
}
