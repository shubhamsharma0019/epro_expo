<?php

namespace App\Domain\Event\Controllers;

use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\CompanyEvent\CompanyEventPublishRequest;
use App\Support\CompanyEventFlowProgress;
use App\Domain\Visitor\Models\VisitorTicket;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends BaseCompanyEventController
{
    public function __invoke(): View
    {
        $currentCompany = Company::query()->find($this->companyId());
        $allEvents = CompanyEvent::query()
            ->with(['branding', 'latestPublishRequest', 'ticketTypes'])
            ->withCount(['ticketTypes', 'sessions', 'speakers'])
            ->where('company_id', $this->companyId())
            ->latest()
            ->get();

        $events = $allEvents
            ->filter(fn (CompanyEvent $event) => CompanyEventFlowProgress::shouldShowOnDashboard($event))
            ->values();

        $events = $this->addDashboardMetrics($events);
        $eventIds = $events->pluck('id');

        $confirmedTickets = VisitorTicket::query()
            ->whereIn('company_event_id', $eventIds)
            ->where('status', 'confirmed')
            ->get();

        $currentMonthTickets = $confirmedTickets->filter(fn (VisitorTicket $ticket) => $ticket->created_at?->isCurrentMonth());
        $previousMonthTickets = $confirmedTickets->filter(function (VisitorTicket $ticket) {
            return $ticket->created_at
                && $ticket->created_at->year === now()->subMonthNoOverflow()->year
                && $ticket->created_at->month === now()->subMonthNoOverflow()->month;
        });

        $publishRequests = CompanyEventPublishRequest::query()
            ->with('companyEvent')
            ->where('company_id', $this->companyId())
            ->whereIn('company_event_id', $eventIds)
            ->latest()
            ->get();

        $recentTickets = VisitorTicket::query()
            ->with('companyEvent')
            ->whereIn('company_event_id', $eventIds)
            ->latest()
            ->take(5)
            ->get();

        $upcomingEvents = $events
            ->filter(fn (CompanyEvent $event) => $event->starts_at && $event->starts_at->greaterThanOrEqualTo(now()->startOfDay()))
            ->sortBy('starts_at')
            ->values();

        if ($upcomingEvents->isEmpty()) {
            $upcomingEvents = $events->sortByDesc('updated_at')->values();
        }

        $pendingEventIds = $events
            ->filter(function (CompanyEvent $event) {
                return in_array($event->status, ['submitted', 'pending_review'], true)
                    || $event->latestPublishRequest?->status === 'pending';
            })
            ->pluck('id')
            ->unique();

        $recentActivities = $this->recentActivities($events, $recentTickets, $publishRequests);

        $stats = [
            'total_events' => $events->count(),
            'draft_events' => $events->where('status', 'draft')->count(),
            'submitted_events' => $events->whereIn('status', ['submitted', 'pending_review'])->count(),
            'published_events' => $events->filter(fn (CompanyEvent $event) => $event->isLiveForVisitors() || $event->status === 'approved')->count(),
            'countries_count' => $events->pluck('country')->filter()->unique()->count(),
            'upcoming_events_count' => $upcomingEvents->count(),
            'ticket_types' => $events->sum('ticket_types_count'),
            'sessions' => $events->sum('sessions_count'),
            'speakers' => $events->sum('speakers_count'),
            'registrations' => $confirmedTickets->sum('quantity'),
            'current_month_registrations' => $currentMonthTickets->sum('quantity'),
            'previous_month_registrations' => $previousMonthTickets->sum('quantity'),
            'revenue' => $confirmedTickets->sum('total_amount'),
            'current_month_revenue' => $currentMonthTickets->sum('total_amount'),
            'previous_month_revenue' => $previousMonthTickets->sum('total_amount'),
            'tickets_sold' => $confirmedTickets->sum('quantity'),
            'ticket_capacity' => $events->flatMap->ticketTypes->sum('quantity_total'),
            'pending_requests' => $pendingEventIds->count(),
            'approved_requests' => $publishRequests->where('status', 'approved')->count(),
            'recent_activities_count' => $recentActivities->count(),
            'currency' => $confirmedTickets->first()?->ticketType?->currency
                ?? $events->flatMap->ticketTypes->first()?->currency
                ?? config('services.razorpay.currency', 'INR'),
        ];

        return view('backend.company.event-company-flow.event-dashboard', compact(
            'events',
            'upcomingEvents',
            'recentActivities',
            'stats',
            'currentCompany'
        ));
    }

    private function addDashboardMetrics(Collection $events): Collection
    {
        return $events->map(function (CompanyEvent $event) {
            $filledFields = collect([
                filled($event->title) && $event->title !== 'Untitled Company Event',
                filled($event->category),
                filled($event->starts_at),
                filled($event->ends_at),
                CompanyEventFlowProgress::hasLocationDetails($event),
                filled($event->summary) || filled($event->description),
                (bool) $event->branding,
                $event->ticket_types_count > 0,
            ])->filter()->count();

            $event->dashboard_completion = (int) round(($filledFields / 8) * 100);
            $event->dashboard_tickets_sold = (int) $event->visitorTickets()
                ->where('status', 'confirmed')
                ->sum('quantity');
            $event->dashboard_revenue = (float) $event->visitorTickets()
                ->where('status', 'confirmed')
                ->sum('total_amount');
            $event->dashboard_capacity = (int) $event->ticketTypes->sum('quantity_total');
            $event->dashboard_banner_url = $this->resolveStorageAssetUrl($event->branding?->banner_path)
                ?: $this->resolveStorageAssetUrl($event->branding?->logo_path);

            return $event;
        });
    }

    private function resolveStorageAssetUrl(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $normalized = ltrim($path, '/');

        if (str_starts_with($normalized, 'storage/')) {
            return asset($normalized);
        }

        return asset('storage/' . $normalized);
    }

    private function recentActivities(Collection $events, Collection $recentTickets, Collection $publishRequests): Collection
    {
        $eventActivities = $events->map(function (CompanyEvent $event) {
            return [
                'title' => ucfirst(str_replace('_', ' ', $event->status)) . ' event',
                'body' => "{$event->title} was updated in your event setup.",
                'time' => $event->updated_at,
                'icon' => 'calendar',
            ];
        });

        $ticketActivities = $recentTickets->map(function (VisitorTicket $ticket) {
            return [
                'title' => 'New registration',
                'body' => trim(($ticket->attendee_name ?: 'A visitor') . ' booked ' . $ticket->quantity . ' ' . str($ticket->ticket_name)->plural($ticket->quantity) . ' for ' . ($ticket->companyEvent?->title ?: 'your event') . '.'),
                'time' => $ticket->created_at,
                'icon' => 'user',
            ];
        });

        $reviewActivities = $publishRequests->map(function (CompanyEventPublishRequest $request) {
            return [
                'title' => ucfirst($request->status) . ' review request',
                'body' => ($request->companyEvent?->title ?: 'Your event') . ' review request is ' . $request->status . '.',
                'time' => $request->updated_at,
                'icon' => 'paper-plane',
            ];
        });

        return $eventActivities
            ->concat($ticketActivities)
            ->concat($reviewActivities)
            ->filter(fn (array $activity) => filled($activity['time']))
            ->sortByDesc('time')
            ->take(6)
            ->values();
    }
}
