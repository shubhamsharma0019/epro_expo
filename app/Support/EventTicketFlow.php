<?php

namespace App\Support;

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
}
