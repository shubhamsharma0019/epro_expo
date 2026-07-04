<?php

namespace App\Support;

use App\Domain\Visitor\Models\EventTicketVisitorRegistration;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use Illuminate\Http\RedirectResponse;

class EventTicketFlow
{
    public static function visitorPassEntryUrl(?string $eventSlug): string
    {
        if (! filled($eventSlug)) {
            return route('events.listings.index');
        }

        if (auth()->check()) {
            return self::ticketSelectionUrl($eventSlug);
        }

        return route('events.tickets.visitor-details', ['event' => $eventSlug]);
    }

    public static function bookingEntryUrl(?string $eventSlug): string
    {
        return self::visitorPassEntryUrl($eventSlug);
    }

    public static function ticketSelectionUrl(?string $eventSlug): string
    {
        if (! filled($eventSlug)) {
            return route('events.listings.index');
        }

        return route('events.tickets.attendee-details', ['event' => $eventSlug]);
    }

    public static function sessionRegistrationKey(?string $eventSlug): string
    {
        return 'event_visitor_registered_' . ($eventSlug ?: 'unknown');
    }

    public static function refreshAttendeePrefillKey(?string $eventSlug): string
    {
        return 'event_visitor_refresh_attendees_' . ($eventSlug ?: 'unknown');
    }

    public static function hasVisitorRegistration(?string $eventSlug): bool
    {
        if (! filled($eventSlug)) {
            return false;
        }

        if (auth()->check()) {
            return true;
        }

        return (bool) session(self::sessionRegistrationKey($eventSlug), false);
    }

    public static function redirectAuthenticatedVisitor(string $eventSlug): ?RedirectResponse
    {
        if (! auth()->check() || ! filled($eventSlug)) {
            return null;
        }

        $event = CompanyEvent::query()->where('slug', $eventSlug)->first();

        self::ensureAuthenticatedRegistration($eventSlug, $event);

        return redirect()->route('events.tickets.attendee-details', ['event' => $eventSlug]);
    }

    public static function ensureAuthenticatedRegistration(string $eventSlug, ?CompanyEvent $event = null): void
    {
        if (! auth()->check()) {
            return;
        }

        $user = auth()->user();
        $event ??= CompanyEvent::query()->where('slug', $eventSlug)->first();

        session([
            self::sessionRegistrationKey($eventSlug) => true,
            self::refreshAttendeePrefillKey($eventSlug) => true,
            'event_booking_path' => self::ticketSelectionUrl($eventSlug),
            'user_flow_context' => 'event_ticket',
        ]);

        self::storeVisitorRegistration(
            (int) $user->id,
            $eventSlug,
            $event?->id,
            [
                'name' => (string) ($user->name ?? ''),
                'email' => (string) ($user->email ?? ''),
                'phone' => $user->phone,
                'gender' => $user->gender,
                'city' => $user->city,
            ]
        );
    }

    /** @return array{name: string, email: string, phone: string, gender: string, city: string}|null */
    public static function resolveAttendeePrefill(?string $eventSlug, ?CompanyEvent $event = null): ?array
    {
        if (! filled($eventSlug) || ! auth()->check()) {
            return null;
        }

        $user = auth()->user();

        if (DbGuard::hasTable('event_ticket_visitor_registrations')) {
            $registration = EventTicketVisitorRegistration::query()
                ->where('user_id', $user->id)
                ->where('event_slug', $eventSlug)
                ->first();

            if ($registration) {
                return $registration->toAttendeePrefill();
            }
        }

        if (! $user->name && ! $user->email) {
            return null;
        }

        return [
            'name' => (string) ($user->name ?? ''),
            'email' => (string) ($user->email ?? ''),
            'phone' => (string) ($user->phone ?? ''),
            'gender' => (string) ($user->gender ?? ''),
            'city' => (string) ($user->city ?? ''),
        ];
    }

    public static function storeVisitorRegistration(
        int $userId,
        string $eventSlug,
        ?int $companyEventId,
        array $details
    ): void {
        if (! DbGuard::hasTable('event_ticket_visitor_registrations')) {
            return;
        }

        EventTicketVisitorRegistration::query()->updateOrCreate(
            [
                'user_id' => $userId,
                'event_slug' => $eventSlug,
            ],
            [
                'company_event_id' => $companyEventId,
                'name' => $details['name'] ?? '',
                'email' => $details['email'] ?? '',
                'phone' => $details['phone'] ?? null,
                'gender' => $details['gender'] ?? null,
                'city' => $details['city'] ?? null,
            ]
        );
    }
}
