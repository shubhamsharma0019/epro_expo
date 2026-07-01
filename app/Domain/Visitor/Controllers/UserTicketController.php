<?php

namespace App\Domain\Visitor\Controllers;

use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Http\Controllers\Controller;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Support\UserVisitorPasses;
use App\Support\VisitorFloorMap;
use App\Support\EventTicketMail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class UserTicketController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userEmail = $user->email;
        $bookingId = UserVisitorPasses::normalizeBookingId(request()->query('booking_id'));

        UserVisitorPasses::linkPassesToUser($user, $bookingId);

        // 1. Fetch Event Tickets
        $eventTickets = VisitorTicket::where('user_id', $user->id)
            ->with(['companyEvent.branding', 'ticketType'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Fetch Exhibition Passes
        $exhibitionPasses = UserVisitorPasses::forUser($user, $bookingId);

        // 3. Combine them into a unified list
        $passes = collect();

        foreach ($eventTickets as $ticket) {
            $passes->push([
                'type' => 'event',
                'id' => $ticket->id,
                'pass_type' => 'Event Ticket',
                'name' => $ticket->companyEvent->title ?? $ticket->ticket_name ?? 'Event',
                'date' => $ticket->companyEvent?->starts_at,
                'ends_at' => $ticket->companyEvent?->ends_at,
                'status' => $ticket->status,
                'number' => $ticket->order_number,
                'quantity' => $ticket->quantity,
                'ticket_name' => $ticket->ticket_name,
                'email' => $userEmail,
                'raw' => $ticket
            ]);
        }

        foreach ($exhibitionPasses as $pass) {
            $slug = $pass->exhibition->slug ?? '';
            $hasPass = $pass->payment_status === 'completed' && filled($slug);

            $passes->push([
                'type' => 'exhibition',
                'id' => $pass->id,
                'pass_type' => 'Exhibition Pass',
                'name' => $pass->exhibition->title ?? $pass->exhibition->name ?? 'Exhibition',
                'date' => $pass->exhibition?->start_date,
                'ends_at' => $pass->exhibition?->end_date,
                'status' => $pass->payment_status === 'completed' ? 'confirmed' : $pass->payment_status,
                'number' => $pass->booking_id,
                'quantity' => 1,
                'ticket_name' => 'Visitor Pass',
                'email' => $pass->email,
                'slug' => $slug,
                'explore_url' => $hasPass
                    ? route('frontend.user.exhibitions.halls', $slug)
                    : ($slug ? route('exhibitions.tickets.visitor-details', $slug) : null),
                'raw' => $pass
            ]);
        }

        $now = Carbon::now();
        $sortedPasses = $this->categorizeItems($passes, $now);

        $exhibitions = $this->buildExhibitionBrowseList($now, $user);
        $openExhibitionsCount = $exhibitions->whereIn('category', ['upcoming', 'live'])->count();
        $activeEventPassesCount = $sortedPasses->where('type', 'event')->whereIn('category', ['upcoming', 'live'])->count();
        $ownedExhibitionPasses = $sortedPasses
            ->where('type', 'exhibition')
            ->where('status', 'confirmed')
            ->values();
        $ownedExhibitionSlugs = $ownedExhibitionPasses->pluck('slug')->filter()->unique()->values();
        $openExhibitions = $exhibitions
            ->reject(fn (array $item) => $ownedExhibitionSlugs->contains($item['slug'] ?? ''))
            ->values();

        return view('frontend.user.passes.index', [
            'user' => $user,
            'passes' => $sortedPasses,
            'exhibitions' => $exhibitions,
            'ownedExhibitionPasses' => $ownedExhibitionPasses,
            'openExhibitions' => $openExhibitions,
            'totalCount' => $sortedPasses->count(),
            'openExhibitionsCount' => $openExhibitionsCount,
            'activeEventPassesCount' => $activeEventPassesCount,
        ]);
    }

    public function show($id)
    {
        return redirect()->route('frontend.user.tickets.e-ticket', $id);
    }

    public function download($id)
    {
        $ticket = VisitorTicket::where('user_id', auth()->id())
            ->with(['companyEvent', 'ticketType'])
            ->findOrFail($id);

        return view('frontend.user.tickets.e-ticket', [
            'ticket' => $ticket,
            'user' => auth()->user(),
            'emailConfigured' => EventTicketMail::isDeliverable(),
        ]);
    }

    public function sendTicketEmail(int $id)
    {
        $ticket = VisitorTicket::query()
            ->with(['companyEvent', 'ticketType', 'user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $result = EventTicketMail::sendTicket($ticket);

        if ($result['sent']) {
            session(['event_ticket_email_sent_' . $ticket->order_number => true]);
        }

        return back()->with(
            $result['sent'] ? 'success' : 'warning',
            $result['message'] ?? ($result['sent']
                ? 'Ticket sent to your email.'
                : 'Could not send ticket email. Please try again later.')
        );
    }

    public function showExhibitionPass(int $id)
    {
        $pass = UserVisitorPasses::queryForUser(auth()->user())
            ->with('exhibition')
            ->findOrFail($id);

        return view('frontend.user.tickets.exhibition-pass', [
            'pass' => $pass,
            'user' => auth()->user(),
        ]);
    }

    public function downloadExhibitionPass(int $id)
    {
        $pass = UserVisitorPasses::queryForUser(auth()->user())
            ->with('exhibition')
            ->findOrFail($id);

        return view('frontend.user.tickets.exhibition-pass', [
            'pass' => $pass,
            'user' => auth()->user(),
        ]);
    }

    public function exhibitionHalls(string $slug)
    {
        $user = auth()->user();
        $exhibition = Exhibition::query()->where('slug', $slug)->firstOrFail();

        if (! $this->hasExhibitionPass($user, $exhibition)) {
            return redirect()
                ->route('frontend.user.passes')
                ->with('error', 'Purchase an exhibition pass to explore halls and booths.');
        }

        $halls = Hall::query()
            ->whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $exhibition->id))
            ->where('status', 'active')
            ->with('pavilion')
            ->withCount([
                'booths as booths_count',
                'boothBookings as booked_booths_count' => fn (Builder $query) => $query
                    ->where('payment_status', 'paid')
                    ->whereIn('booking_status', ['confirmed', 'active'])
                    ->where('admin_status', 'approved'),
            ])
            ->orderBy('title')
            ->get()
            ->map(function (Hall $hall) use ($slug) {
                $total = max((int) ($hall->total_booths ?: $hall->booths_count), 0);
                $booked = (int) ($hall->booked_booths_count ?? 0);
                $available = max($total - $booked, 0);
                $hallSlug = $hall->slug ?: (string) $hall->id;

                return [
                    'title' => $hall->title ?: 'Hall',
                    'pavilion' => $hall->pavilion?->title ?: 'Exhibition Hall',
                    'image' => $hall->image,
                    'total_booths' => $total,
                    'booked_booths' => $booked,
                    'available_booths' => $available,
                    'is_available' => $available > 0,
                    'enter_url' => route('frontend.user.exhibitions.halls.show', [$slug, $hallSlug]),
                ];
            });

        return view('frontend.user.halls.index', [
            'user' => $user,
            'exhibition' => $exhibition,
            'halls' => $halls,
            'availableCount' => $halls->where('is_available', true)->count(),
            'totalCount' => $halls->count(),
            'slug' => $slug,
            'visitorNavActive' => 'passes',
        ]);
    }

    public function exhibitionHallLayout(string $slug, string $hallSlug)
    {
        $user = auth()->user();
        $exhibition = Exhibition::query()->where('slug', $slug)->firstOrFail();

        if (! $this->hasExhibitionPass($user, $exhibition)) {
            return redirect()
                ->route('frontend.user.passes')
                ->with('error', 'Purchase an exhibition pass to view hall layouts.');
        }

        $hall = Hall::query()
            ->whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $exhibition->id))
            ->where('status', 'active')
            ->where(fn ($query) => $query->where('slug', $hallSlug)->orWhere('id', $hallSlug))
            ->with(['booths.boothSize', 'pavilion'])
            ->firstOrFail();

        $floorMap = VisitorFloorMap::prepare($hall);
        $gridCells = $this->buildHallLayoutGrid($floorMap, $slug, $hallSlug);

        $visitorPass = UserVisitorPasses::queryForUser($user)
            ->where('exhibition_id', $exhibition->id)
            ->where('payment_status', 'completed')
            ->orderByDesc('created_at')
            ->first();

        $passLabel = $visitorPass?->booking_id
            ? 'My Pass · ' . $visitorPass->booking_id
            : 'Visitor Pass';

        return view('frontend.user.halls.show', [
            'user' => $user,
            'exhibition' => $exhibition,
            'hall' => $hall,
            'floorMap' => $floorMap,
            'gridCells' => $gridCells,
            'slug' => $slug,
            'passLabel' => $passLabel,
            'backUrl' => route('frontend.user.exhibitions.halls', $slug),
            'visitorNavActive' => 'passes',
        ]);
    }

    /** @return list<array{type:string,wide:bool,span:int,label:?string,initial:?string,number:?string,booth_id:?int,booking_id:?int,hub_url:?string}> */
    private function buildHallLayoutGrid(array $floorMap, string $slug, string $hallSlug): array
    {
        $cells = [];

        foreach ($floorMap['overlayBookedBoothGroups'] ?? [] as $group) {
            $boothIds = array_values(array_filter(array_map('intval', $group['booth_ids'] ?? [])));
            $boothCount = count($boothIds);
            $span = min(max($boothCount, 1), 4);
            $company = (string) ($group['company_name'] ?? 'Booked');
            $boothId = (int) ($boothIds[0] ?? 0);

            $cells[] = [
                'type' => 'booked',
                'wide' => $span >= 2,
                'span' => $span,
                'label' => $company,
                'initial' => strtoupper(substr($company, 0, 1)),
                'number' => null,
                'booth_id' => $boothId ?: null,
                'booking_id' => $group['booking_id'] ?? null,
                'hub_url' => $this->boothHubUrl($slug, $hallSlug, $boothId),
            ];
        }

        foreach ($floorMap['booths'] as $booth) {
            if ($booth['is_hidden'] ?? false) {
                continue;
            }

            $state = (string) ($booth['state'] ?? 'available');
            $company = filled($booth['company'] ?? null) ? (string) $booth['company'] : null;
            $boothId = (int) ($booth['booth_id'] ?? 0);

            if ($state === 'booked' && $boothId > 0) {
                $cells[] = [
                    'type' => 'booked',
                    'wide' => filled($company),
                    'span' => filled($company) ? 2 : 1,
                    'label' => $company ?: ('Booth ' . ($booth['label'] ?? $boothId)),
                    'initial' => strtoupper(substr($company ?: 'B', 0, 1)),
                    'number' => null,
                    'booth_id' => $boothId,
                    'booking_id' => $booth['booking_id'] ?? null,
                    'hub_url' => $this->boothHubUrl($slug, $hallSlug, $boothId),
                ];

                continue;
            }

            $cells[] = [
                'type' => in_array($state, ['available', 'booked', 'reserved', 'selected'], true) ? $state : 'available',
                'wide' => false,
                'span' => 1,
                'label' => null,
                'initial' => null,
                'number' => (string) ($booth['label'] ?? ''),
                'booth_id' => null,
                'booking_id' => null,
                'hub_url' => null,
            ];
        }

        return $cells;
    }

    private function boothHubUrl(string $slug, string $hallSlug, int $boothId): ?string
    {
        if ($boothId <= 0) {
            return null;
        }

        return route('frontend.user.exhibitions.booths.show', [$slug, $hallSlug, $boothId]);
    }

    private function hasExhibitionPass($user, Exhibition $exhibition): bool
    {
        return UserVisitorPasses::queryForUser($user)
            ->where('exhibition_id', $exhibition->id)
            ->where('payment_status', 'completed')
            ->exists();
    }

    private function categorizeItems($items, Carbon $now)
    {
        return $items->map(function ($item) use ($now) {
            $date = $item['date'] ?? null;
            $endsAt = $item['ends_at'] ?? null;

            if ($endsAt && $endsAt->lt($now)) {
                $category = 'completed';
                $priority = 3;
            } elseif ($date && $date->gt($now)) {
                $category = 'upcoming';
                $priority = 1;
            } else {
                $category = 'live';
                $priority = 2;
            }

            $item['category'] = $category;
            $item['priority'] = $priority;

            return $item;
        })->sortBy(fn ($item) => [
            $item['priority'],
            $item['date'] ? $item['date']->timestamp : PHP_INT_MAX,
        ])->values();
    }

    private function buildExhibitionBrowseList(Carbon $now, $user = null)
    {
        return Exhibition::query()
            ->whereIn('status', ['active', 'published', 'live'])
            ->orderBy('start_date')
            ->orderBy('title')
            ->get()
            ->map(function (Exhibition $exhibition) use ($now, $user) {
                $start = $exhibition->start_date;
                $end = $exhibition->end_date;

                if ($end && $end->lt($now)) {
                    $category = 'completed';
                } elseif ($start && $start->gt($now)) {
                    $category = 'upcoming';
                } else {
                    $category = 'live';
                }

                $slug = $exhibition->slug ?: '';

                return [
                    'name' => $exhibition->title ?: $exhibition->name ?: 'Exhibition',
                    'slug' => $slug,
                    'category' => $category,
                    'date_label' => $this->formatExhibitionDateRange($start, $end),
                    'location' => $exhibition->venue ?: $exhibition->location ?: 'Location TBD',
                    'explore_url' => $this->exhibitionExploreUrl($exhibition, $user),
                ];
            })
            ->sortBy(fn ($item) => match ($item['category']) {
                'upcoming' => 1,
                'live' => 2,
                default => 3,
            })
            ->values();
    }

    private function exhibitionExploreUrl(Exhibition $exhibition, $user): string
    {
        $slug = $exhibition->slug ?: '';

        if ($slug === '') {
            return route('exhibitions.index');
        }

        if ($user && $this->hasExhibitionPass($user, $exhibition)) {
            return route('frontend.user.exhibitions.halls', $slug);
        }

        return route('exhibitions.tickets.visitor-details', $slug);
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
