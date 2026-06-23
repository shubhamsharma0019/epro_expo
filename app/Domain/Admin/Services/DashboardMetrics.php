<?php

namespace App\Domain\Admin\Services;

use App\Domain\Admin\Models\Admin;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothPublishRequest;
use App\Domain\Company\Models\Company;
use App\Domain\Company\Models\Enquiry;
use App\Domain\Event\Models\CompanyEvent\CompanyEventPublishRequest;
use App\Domain\Shared\Models\User;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Support\LiveContent;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class DashboardMetrics
{
    public function data(): array
    {
        $rangeEnd = now();
        $rangeStart = now()->subDays(6);
        $weekStart = $rangeStart->copy()->startOfDay();
        $weekEnd = $rangeEnd->copy()->endOfDay();

        $boothRevenue = (float) BoothBooking::query()
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $ticketRevenue = (float) VisitorTicket::query()
            ->whereIn('status', ['confirmed', 'paid', 'completed'])
            ->sum('total_amount');

        $exhibitionPassRevenue = (float) Visitor::query()
            ->where('payment_status', 'completed')
            ->sum('amount');

        $totalRevenue = $boothRevenue + $ticketRevenue + $exhibitionPassRevenue;

        $totalVisitors = User::query()->count();
        $thisWeekVisitors = User::query()
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->count();

        $thisMonthVisitors = User::query()
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        $pendingBookingsCount = BoothBooking::query()
            ->where('payment_status', 'paid')
            ->where('admin_status', 'pending')
            ->count();

        $pendingApprovalsCount = BoothPublishRequest::query()->where('status', 'pending')->count();
        $pendingEventApprovalsCount = CompanyEventPublishRequest::query()->where('status', 'pending')->count();

        $stats = [
            'total_companies' => $this->formatNumber(Company::query()->count()),
            'total_tickets' => $this->formatNumber(
                VisitorTicket::query()->count() + Visitor::query()->count()
            ),
            'published_events' => $this->formatNumber(
                LiveContent::companyEventQuery()->count()
            ),
            'published_exhibitions' => $this->formatNumber(
                LiveContent::exhibitionQuery()->count()
            ),
            'total_visitors' => $this->formatNumber($totalVisitors),
            'total_revenue' => $this->formatMoney($totalRevenue),
            'total_meetings' => $this->formatNumber(VisitorMeetingBooking::query()->count()),
            'total_enquiries' => $this->formatNumber(Enquiry::query()->count()),
        ];

        $admin = $this->currentAdmin();

        return [
            'header' => [
                'title' => 'Welcome back, ' . $this->adminFirstName($admin),
                'subtitle' => $this->headerSubtitle(
                    $pendingBookingsCount,
                    $pendingApprovalsCount,
                    $pendingEventApprovalsCount
                ),
            ],
            'admin' => [
                'name' => $admin?->name ?: 'Admin',
                'role' => ucwords(str_replace('_', ' ', $admin?->role ?: 'admin')),
                'email' => $admin?->email,
            ],
            'date_range' => $rangeStart->format('M d') . ' - ' . $rangeEnd->format('M d, Y'),
            'quick_actions' => $this->quickActions(),
            'links' => [
                'companies' => route('admin.companies.index'),
                'visitor_report' => route('admin.reports.index'),
            ],
            'stats' => $stats,
            'stat_cards' => $this->statCards($stats),
            'platform_highlights' => $this->platformHighlights($weekStart, $weekEnd),
            'badges' => [
                'notifications' => $pendingBookingsCount + $pendingApprovalsCount + $pendingEventApprovalsCount,
                'messages' => Enquiry::query()->whereIn('status', ['new', 'pending', 'open'])->count(),
            ],
            'recent_companies' => $this->recentCompanies(),
            'recent_companies_count' => Company::query()->count(),
            'recent_enquiries' => $this->recentEnquiries(),
            'recent_payments' => $this->recentPayments(),
            'visitor_overview' => [
                'total' => $this->formatNumber($totalVisitors),
                'this_week' => '+' . $this->formatNumber($thisWeekVisitors),
                'this_month' => '+' . $this->formatNumber($thisMonthVisitors),
                'tooltip_value' => $this->formatNumber($totalVisitors),
                'tooltip_date' => $rangeEnd->format('M d, Y'),
                'labels' => collect(CarbonPeriod::create($rangeStart, $rangeEnd))
                    ->map(fn ($date) => $date->format('M d'))
                    ->values(),
                'signups' => $this->visitorSignups($rangeStart, $rangeEnd),
            ],
            'revenue_breakdown' => [
                ['label' => 'Booth Bookings', 'value' => $this->formatMoney($boothRevenue)],
                ['label' => 'Event Tickets', 'value' => $this->formatMoney($ticketRevenue)],
                ['label' => 'Exhibition Passes', 'value' => $this->formatMoney($exhibitionPassRevenue)],
            ],
            'revenue_chart' => [
                ['label' => 'Booth Bookings', 'amount' => $boothRevenue, 'color' => '#3723db'],
                ['label' => 'Event Tickets', 'amount' => $ticketRevenue, 'color' => '#6366f1'],
                ['label' => 'Exhibition Passes', 'amount' => $exhibitionPassRevenue, 'color' => '#10b981'],
            ],
            'revenue_total' => $totalRevenue,
            'pendingBookingsCount' => $pendingBookingsCount,
            'pendingApprovalsCount' => $pendingApprovalsCount,
            'pendingEventApprovalsCount' => $pendingEventApprovalsCount,
        ];
    }

    public function forDashboard(): array
    {
        $data = $this->data();
        $pendingTotal = $data['pendingBookingsCount']
            + $data['pendingApprovalsCount']
            + $data['pendingEventApprovalsCount'];

        $data['stat_cards'] = [
            collect($data['stat_cards'])->firstWhere('label', 'Total Companies'),
            collect($data['stat_cards'])->firstWhere('label', 'Total Revenue'),
            collect($data['stat_cards'])->firstWhere('label', 'Total Tickets'),
            [
                'value' => $this->formatNumber($pendingTotal),
                'label' => 'Pending Reviews',
                'href' => route('admin.booth-approvals.index'),
                'icon' => 'ph ph-clock-countdown',
            ],
        ];

        $data['recent_companies'] = $data['recent_companies']->take(4);
        $data['quick_actions'] = array_slice($data['quick_actions'], 0, 4);

        return $data;
    }

    private function currentAdmin(): ?Admin
    {
        $adminId = session('admin_id');

        return $adminId ? Admin::query()->find($adminId) : null;
    }

    private function adminFirstName(?Admin $admin = null): string
    {
        $admin ??= $this->currentAdmin();
        $name = $admin?->name ?: 'Admin';

        return str($name)->before(' ')->toString();
    }

    private function headerSubtitle(int $pendingBookings, int $pendingBoothReviews, int $pendingEventReviews): string
    {
        $pendingTotal = $pendingBookings + $pendingBoothReviews + $pendingEventReviews;

        if ($pendingTotal === 0) {
            return 'All queues are clear. Here is your live platform snapshot.';
        }

        return "You have {$pendingTotal} pending review" . ($pendingTotal === 1 ? '' : 's') . ' across bookings, booths, and events.';
    }

    private function platformHighlights($weekStart, $weekEnd): array
    {
        return [
            [
                'label' => 'New Companies',
                'value' => $this->formatNumber(
                    Company::query()->whereBetween('created_at', [$weekStart, $weekEnd])->count()
                ),
                'hint' => 'This week',
            ],
            [
                'label' => 'Tickets Sold',
                'value' => $this->formatNumber(
                    VisitorTicket::query()->whereBetween('created_at', [$weekStart, $weekEnd])->count()
                ),
                'hint' => 'This week',
            ],
            [
                'label' => 'Exhibition Passes',
                'value' => $this->formatNumber(
                    Visitor::query()->whereBetween('created_at', [$weekStart, $weekEnd])->count()
                ),
                'hint' => 'This week',
            ],
            [
                'label' => 'Open Enquiries',
                'value' => $this->formatNumber(
                    Enquiry::query()->whereIn('status', ['new', 'pending', 'open'])->count()
                ),
                'hint' => 'Needs response',
            ],
        ];
    }

    private function recentCompanies(): Collection
    {
        return Company::query()
            ->latest()
            ->take(5)
            ->get()
            ->map(function (Company $company): array {
                $status = $company->status ?: 'pending';

                return [
                    'name' => $company->company_name ?: $company->name ?: 'Company',
                    'contact' => $company->contact_person_name ?: $company->owner_name ?: 'N/A',
                    'email' => $company->email ?: 'N/A',
                    'status' => ucfirst(str_replace('_', ' ', $status)),
                    'status_class' => $this->statusClass($status),
                    'registered_on' => $company->created_at?->format('M d, Y') ?? 'N/A',
                    'href' => route('admin.companies.manage', $company),
                ];
            });
    }

    private function recentEnquiries(): Collection
    {
        return Enquiry::query()
            ->with('company')
            ->latest()
            ->take(5)
            ->get()
            ->map(function (Enquiry $enquiry): array {
                $status = $enquiry->status ?: 'new';

                return [
                    'name' => $enquiry->name ?: 'Visitor',
                    'subject' => $enquiry->subject ?: 'General enquiry',
                    'company' => $enquiry->company?->company_name ?: 'Platform enquiry',
                    'status' => ucfirst(str_replace('_', ' ', $status)),
                    'status_class' => $this->statusClass($status),
                    'created_on' => $enquiry->created_at?->format('M d, Y') ?? 'N/A',
                    'href' => route('admin.enquiries.index'),
                ];
            });
    }

    private function recentPayments(): Collection
    {
        $boothPayments = BoothBooking::query()
            ->with(['company', 'exhibition'])
            ->where('payment_status', 'paid')
            ->latest()
            ->take(4)
            ->get()
            ->map(fn (BoothBooking $booking) => [
                'type' => 'Booth Booking',
                'customer' => $booking->company?->company_name ?: 'Company',
                'item' => $booking->exhibition?->title ?? ($booking->exhibition?->name ?? 'Exhibition'),
                'amount' => $this->formatMoney((float) $booking->total_amount),
                'status' => ucfirst(str_replace('_', ' ', $booking->admin_status ?: 'paid')),
                'created_at' => $booking->created_at,
                'href' => route('admin.payments.index'),
            ]);

        $ticketPayments = VisitorTicket::query()
            ->with(['user', 'companyEvent'])
            ->whereIn('status', ['paid', 'confirmed', 'completed'])
            ->latest()
            ->take(4)
            ->get()
            ->map(fn (VisitorTicket $ticket) => [
                'type' => 'Event Ticket',
                'customer' => $ticket->attendee_name ?: ($ticket->user?->name ?? 'Visitor'),
                'item' => $ticket->companyEvent?->title ?? 'Event',
                'amount' => $this->formatMoney((float) $ticket->total_amount),
                'status' => ucfirst(str_replace('_', ' ', $ticket->status ?: 'paid')),
                'created_at' => $ticket->created_at,
                'href' => route('admin.payments.index'),
            ]);

        $passPayments = Visitor::query()
            ->with('exhibition')
            ->where('payment_status', 'completed')
            ->latest()
            ->take(4)
            ->get()
            ->map(fn (Visitor $visitor) => [
                'type' => 'Exhibition Pass',
                'customer' => trim(($visitor->first_name ?? '') . ' ' . ($visitor->last_name ?? '')) ?: ($visitor->email ?: 'Visitor'),
                'item' => $visitor->exhibition?->title ?? ($visitor->exhibition?->name ?? 'Exhibition'),
                'amount' => $this->formatMoney((float) $visitor->amount),
                'status' => 'Completed',
                'created_at' => $visitor->created_at,
                'href' => route('admin.payments.index'),
            ]);

        return $boothPayments
            ->concat($ticketPayments)
            ->concat($passPayments)
            ->sortByDesc('created_at')
            ->take(6)
            ->values()
            ->map(function (array $payment) {
                unset($payment['created_at']);

                return $payment;
            });
    }

    private function visitorSignups($rangeStart, $rangeEnd): Collection
    {
        return collect(CarbonPeriod::create($rangeStart, $rangeEnd))
            ->map(function ($date): array {
                $count = User::query()->whereDate('created_at', $date)->count();

                return [
                    'label' => $date->format('M d'),
                    'value' => $count,
                ];
            })
            ->values();
    }

    private function quickActions(): array
    {
        return [
            [
                'label' => 'Add New Company',
                'icon' => 'ph ph-buildings',
                'href' => route('admin.companies.create'),
            ],
            [
                'label' => 'New Exhibition',
                'icon' => 'ph ph-calendar-blank',
                'href' => route('admin.exhibitions.create'),
            ],
            [
                'label' => 'Review Booth Bookings',
                'icon' => 'ph ph-package',
                'href' => route('admin.booth-bookings.index'),
            ],
            [
                'label' => 'Review Events',
                'icon' => 'ph ph-ticket',
                'href' => route('admin.event-approvals.index'),
            ],
            [
                'label' => 'View Payments',
                'icon' => 'ph ph-currency-circle-dollar',
                'href' => route('admin.payments.index'),
            ],
            [
                'label' => 'Open Enquiries',
                'icon' => 'ph ph-envelope',
                'href' => route('admin.enquiries.index'),
            ],
        ];
    }

    private function statCards(array $stats): array
    {
        return [
            [
                'value' => $stats['total_companies'],
                'label' => 'Total Companies',
                'href' => route('admin.companies.index'),
                'icon' => 'ph ph-buildings',
            ],
            [
                'value' => $stats['total_tickets'],
                'label' => 'Total Tickets',
                'href' => route('admin.event-tickets.index'),
                'icon' => 'ph ph-ticket',
            ],
            [
                'value' => $stats['published_events'],
                'label' => 'Published Events',
                'href' => route('admin.events.index'),
                'icon' => 'ph ph-calendar-check',
            ],
            [
                'value' => $stats['published_exhibitions'],
                'label' => 'Published Exhibitions',
                'href' => route('admin.exhibitions.index'),
                'icon' => 'ph ph-cube',
            ],
            [
                'value' => $stats['total_visitors'],
                'label' => 'Total Visitors',
                'href' => route('admin.users.index'),
                'icon' => 'ph ph-users-three',
            ],
            [
                'value' => $stats['total_revenue'],
                'label' => 'Total Revenue',
                'href' => route('admin.payments.index'),
                'icon' => 'ph ph-currency-circle-dollar',
            ],
            [
                'value' => $stats['total_meetings'],
                'label' => 'Total Meetings',
                'href' => route('admin.meetings.index'),
                'icon' => 'ph ph-calendar-check',
            ],
            [
                'value' => $stats['total_enquiries'],
                'label' => 'Total Enquiries',
                'href' => route('admin.enquiries.index'),
                'icon' => 'ph ph-chat-circle-question',
            ],
        ];
    }

    private function statusClass(string $status): string
    {
        return match ($status) {
            'approved', 'active', 'published', 'live', 'completed', 'paid', 'confirmed', 'closed' => 'bg-[#E6FBF0] text-[#10B981]',
            'rejected', 'inactive', 'blocked' => 'bg-[#FFE6EB] text-[#FF3B6A]',
            default => 'bg-[#FFF5E6] text-[#FF8A00]',
        };
    }

    private function formatNumber(int|float $value): string
    {
        return number_format($value);
    }

    private function formatMoney(float $value): string
    {
        return 'Rs. ' . number_format($value, 0);
    }
}
