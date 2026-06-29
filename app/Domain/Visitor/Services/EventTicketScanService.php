<?php

namespace App\Domain\Visitor\Services;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Visitor\Models\Ticket;
use App\Domain\Visitor\Models\TicketScanLog;
use App\Domain\Visitor\Models\VisitorCheckin;
use App\Support\TicketScanDevice;
use Illuminate\Http\Request;

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

        if ($windowState === 'not_started') {
            return 'not_started';
        }

        if ($windowState === 'expired') {
            return 'expired';
        }

        if ($this->hasCheckedInToday($ticket)) {
            return 'used_today';
        }

        return 'valid';
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

        $log = TicketScanLog::query()->create([
            'ticket_id' => $ticket->id,
            'visitor_id' => $ticket->visitor_id,
            'company_event_id' => $ticket->event_id,
            'qr_token' => $ticket->qr_token,
            'action' => $action,
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

        if ($request) {
            $this->logQrScan($ticket, $request, 'check_in');
        }

        $scannedToday = $this->todayCheckin($ticket, 'scanned');

        $payload = [
            'user_id' => $ticket->visitor_id,
            'visitor_ticket_id' => $visitorTicket?->id,
            'ticket_id' => $ticket->id,
            'company_event_id' => $ticket->event_id,
            'entry_gate' => $entryGate,
            'checkin_type' => 'qr',
            'device_type' => $device['device_type'],
            'device_name' => $device['device_name'],
            'user_agent' => $device['user_agent'],
            'ip_address' => $device['ip_address'],
            'status' => 'checked_in',
            'checked_in_at' => $checkedInAt,
        ];

        if ($scannedToday) {
            $scannedToday->update($payload);
            $checkin = $scannedToday->fresh();
        } else {
            $checkin = VisitorCheckin::query()->create($payload);
        }

        $meta = $ticket->meta ?? [];
        $meta['last_checkin_at'] = $checkedInAt->toIso8601String();
        $meta['total_checkins'] = (int) ($meta['total_checkins'] ?? 0) + 1;

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

        $payload = [
            'user_id' => $ticket->visitor_id,
            'visitor_ticket_id' => $visitorTicket?->id,
            'ticket_id' => $ticket->id,
            'company_event_id' => $ticket->event_id,
            'checkin_type' => 'qr',
            'device_type' => $device['device_type'],
            'device_name' => $device['device_name'],
            'user_agent' => $device['user_agent'],
            'ip_address' => $device['ip_address'],
            'status' => 'scanned',
            'checked_in_at' => $scannedAt,
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
}
