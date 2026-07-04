<?php

namespace App\Support;

use App\Domain\Visitor\Models\EventTicketVisitorRegistration;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;

class EventTicketFlow
{
    public static function visitorPassEntryUrl(?string $eventSlug): string
    {
        if (! filled($eventSlug)) {
            return route('events.listings.index');
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
