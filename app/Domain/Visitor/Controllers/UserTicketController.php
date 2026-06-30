<?php

namespace App\Domain\Visitor\Controllers;

use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Http\Controllers\Controller;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorTicket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class UserTicketController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userEmail = $user->email;

        // 1. Fetch Event Tickets
        $eventTickets = VisitorTicket::where('user_id', $user->id)
            ->with(['companyEvent.branding', 'ticketType'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Fetch Exhibition Passes
        $exhibitionPasses = Visitor::whereRaw('LOWER(email) = ?', [strtolower($userEmail)])
            ->with('exhibition')
            ->orderBy('created_at', 'desc')
            ->get();

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
                'slug' => $pass->exhibition->slug ?? '',
                'raw' => $pass
            ]);
        }

        $now = Carbon::now();
        $sortedPasses = $this->categorizeItems($passes, $now);

        $exhibitions = $this->buildExhibitionBrowseList($now);
        $openExhibitionsCount = $exhibitions->whereIn('category', ['upcoming', 'live'])->count();
        $activeEventPassesCount = $sortedPasses->where('type', 'event')->whereIn('category', ['upcoming', 'live'])->count();

        return view('frontend.user.passes.index', [
            'user' => $user,
            'passes' => $sortedPasses,
            'exhibitions' => $exhibitions,
            'totalCount' => $sortedPasses->count(),
            'openExhibitionsCount' => $openExhibitionsCount,
            'activeEventPassesCount' => $activeEventPassesCount,
        ]);
    }

    public function show($id)
    {
        $ticket = \App\Domain\Visitor\Models\VisitorTicket::where('user_id', auth()->id())
            ->with(['companyEvent', 'ticketType'])
            ->findOrFail($id);
            
        return view('frontend.user.tickets.show', compact('ticket'));
    }

    public function download($id)
    {
        $ticket = VisitorTicket::where('user_id', auth()->id())
            ->with(['companyEvent', 'ticketType'])
            ->findOrFail($id);
            
        return view('frontend.user.tickets.e-ticket', compact('ticket'));
    }

    public function showExhibitionPass(int $id)
    {
        $pass = Visitor::query()
            ->whereRaw('LOWER(email) = ?', [strtolower(auth()->user()->email)])
            ->with('exhibition')
            ->findOrFail($id);

        return view('frontend.user.tickets.exhibition-pass', compact('pass'));
    }

    public function downloadExhibitionPass(int $id)
    {
        $pass = Visitor::query()
            ->whereRaw('LOWER(email) = ?', [strtolower(auth()->user()->email)])
            ->with('exhibition')
            ->findOrFail($id);

        return view('frontend.user.tickets.exhibition-pass', compact('pass'));
    }

    public function exhibitionHalls(string $slug)
    {
        $user = auth()->user();
        $exhibition = Exhibition::query()->where('slug', $slug)->firstOrFail();

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
                    'enter_url' => route('exhibitions.visitor-halls.show', [$slug, $hallSlug]),
                ];
            });

        return view('frontend.user.halls.index', [
            'user' => $user,
            'exhibition' => $exhibition,
            'halls' => $halls,
            'availableCount' => $halls->where('is_available', true)->count(),
            'totalCount' => $halls->count(),
            'slug' => $slug,
        ]);
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

    private function buildExhibitionBrowseList(Carbon $now)
    {
        return Exhibition::query()
            ->orderBy('start_date')
            ->orderBy('title')
            ->get()
            ->map(function (Exhibition $exhibition) use ($now) {
                $start = $exhibition->start_date;
                $end = $exhibition->end_date;

                if ($end && $end->lt($now)) {
                    $category = 'completed';
                } elseif ($start && $start->gt($now)) {
                    $category = 'upcoming';
                } else {
                    $category = 'live';
                }

                return [
                    'name' => $exhibition->title ?: $exhibition->name ?: 'Exhibition',
                    'category' => $category,
                    'date_label' => $this->formatExhibitionDateRange($start, $end),
                    'location' => $exhibition->venue ?: $exhibition->location ?: 'Location TBD',
                    'explore_url' => $exhibition->slug
                        ? route('frontend.user.exhibitions.halls', $exhibition->slug)
                        : route('exhibitions.index'),
                ];
            })
            ->sortBy(fn ($item) => match ($item['category']) {
                'upcoming' => 1,
                'live' => 2,
                default => 3,
            })
            ->values();
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
