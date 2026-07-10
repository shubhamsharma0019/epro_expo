<?php

namespace App\Domain\Visitor\Controllers;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Http\Controllers\Controller;
use App\Support\EventTicketFlow;
use App\Support\LiveContent;
use Illuminate\Support\Carbon;

class UserBrowseController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $now = Carbon::now();

        $ownedEventTickets = VisitorTicket::query()
            ->where('user_id', $user->id)
            ->whereIn('status', ['confirmed', 'paid', 'completed'])
            ->latest()
            ->get()
            ->unique('company_event_id')
            ->keyBy('company_event_id');

        $events = LiveContent::databaseCompanyEventsQuery()
            ->with('branding')
            ->orderBy('starts_at')
            ->orderBy('title')
            ->get()
            ->map(fn (CompanyEvent $event) => $this->formatEvent($event, $now, $user, $ownedEventTickets))
            ->values();

        $exhibitions = LiveContent::databaseExhibitionsQuery()
            ->orderBy('start_date')
            ->orderBy('title')
            ->get()
            ->map(fn (Exhibition $exhibition) => $this->formatExhibition($exhibition, $now, $user))
            ->values();

        return view('frontend.user.browse.index', [
            'user' => $user,
            'events' => $events,
            'exhibitions' => $exhibitions,
            'eventsCount' => $events->count(),
            'exhibitionsCount' => $exhibitions->count(),
            'upcomingEventsCount' => $events->where('category', 'upcoming')->count(),
            'upcomingExhibitionsCount' => $exhibitions->where('category', 'upcoming')->count(),
            'liveEventsCount' => $events->where('category', 'live')->count(),
            'liveExhibitionsCount' => $exhibitions->where('category', 'live')->count(),
        ]);
    }

    /** @return array<string, mixed> */
    private function formatEvent(CompanyEvent $event, Carbon $now, $user, $ownedEventTickets): array
    {
        $start = $event->starts_at;
        $end = $event->ends_at;
        $category = $this->resolveCategory($start, $end, $now);
        $ownedTicket = $ownedEventTickets->get($event->id);

        return [
            'type' => 'event',
            'name' => $event->title ?: 'Event',
            'category' => $category,
            'date_label' => $this->formatEventDateRange($start, $end),
            'location' => $event->venue_name
                ?: ($event->city ? trim($event->city . ($event->country ? ', ' . $event->country : '')) : null)
                ?: 'Location TBD',
            'has_ticket' => $ownedTicket !== null,
            'ticket_id' => $ownedTicket?->id,
            'ticket_url' => $ownedTicket
                ? route('frontend.user.tickets.e-ticket', $ownedTicket->id)
                : null,
            'book_url' => $this->eventBookUrl($event, $user),
            'explore_url' => $event->slug
                ? route('events.listings.show', $event->slug)
                : route('events.listings.index'),
        ];
    }

    private function eventBookUrl(CompanyEvent $event, $user): string
    {
        if (! $event->slug) {
            return route('events.listings.index');
        }

        if ($user && EventTicketFlow::hasVisitorRegistration($event->slug)) {
            return EventTicketFlow::ticketSelectionUrl($event->slug);
        }

        return route('events.tickets.visitor-details', ['event' => $event->slug]);
    }

    /** @return array<string, mixed> */
    private function formatExhibition(Exhibition $exhibition, Carbon $now, $user = null): array
    {
        $start = $exhibition->start_date;
        $end = $exhibition->end_date;
        $category = $this->resolveCategory($start, $end, $now);
        $slug = $exhibition->slug ?: '';

        return [
            'type' => 'exhibition',
            'name' => $exhibition->title ?: $exhibition->name ?: 'Exhibition',
            'slug' => $slug,
            'category' => $category,
            'date_label' => $this->formatExhibitionDateRange($start, $end),
            'location' => $exhibition->venue ?: $exhibition->location ?: 'Location TBD',
            'explore_url' => $this->exhibitionExploreUrl($exhibition, $user),
            'book_url' => $slug
                ? route('exhibitions.tickets.visitor-details', $slug)
                : route('exhibitions.index'),
        ];
    }

    private function exhibitionExploreUrl(Exhibition $exhibition, $user): string
    {
        $slug = $exhibition->slug ?: '';

        if ($slug === '') {
            return route('exhibitions.index');
        }

        if ($user && $this->userHasExhibitionPass($user, $exhibition)) {
            return route('frontend.user.exhibitions.halls', $slug);
        }

        return route('exhibitions.tickets.visitor-details', $slug);
    }

    private function userHasExhibitionPass($user, Exhibition $exhibition): bool
    {
        return \App\Support\UserVisitorPasses::hasActivePassForExhibition($user, $exhibition);
    }

    private function resolveCategory($start, $end, Carbon $now): string
    {
        if ($end && Carbon::parse($end)->lt($now)) {
            return 'completed';
        }

        if ($start && Carbon::parse($start)->gt($now)) {
            return 'upcoming';
        }

        return 'live';
    }

    private function formatEventDateRange(?Carbon $start, ?Carbon $end): string
    {
        if (! $start) {
            return 'Date TBD';
        }

        if ($end && ! $start->isSameDay($end)) {
            if ($start->month === $end->month && $start->year === $end->year) {
                return $start->format('M d') . '–' . $end->format('d, Y');
            }

            return $start->format('M d') . '–' . $end->format('M d, Y');
        }

        return $start->format('M d, Y');
    }

    private function formatExhibitionDateRange(?Carbon $start, ?Carbon $end): string
    {
        if (! $start) {
            return 'Date TBD';
        }

        if ($end && ! $start->isSameDay($end)) {
            if ($start->month === $end->month && $start->year === $end->year) {
                return $start->format('M d') . '–' . $end->format('d, Y');
            }

            return $start->format('M d') . '–' . $end->format('M d, Y');
        }

        return $start->format('M d, Y');
    }
}
