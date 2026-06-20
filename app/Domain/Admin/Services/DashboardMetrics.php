<?php

namespace App\Domain\Admin\Services;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothPublishRequest;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\CompanyEvent\CompanyEventPublishRequest;
use App\Domain\Admin\Models\Admin;
use App\Domain\Company\Models\Enquiry;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Shared\Models\User;
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

        $boothRevenue = (float) BoothBooking::query()
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $ticketRevenue = (float) VisitorTicket::query()
            ->whereIn('status', ['confirmed', 'paid', 'completed'])
            ->sum('total_amount');

        $totalVisitors = User::query()->count();
        $thisWeekVisitors = User::query()
            ->whereBetween('created_at', [$rangeStart->copy()->startOfDay(), $rangeEnd->copy()->endOfDay()])
            ->count();

        $thisMonthVisitors = User::query()
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        $stats = [
            'total_companies' => $this->formatNumber(Company::query()->count()),
            'total_tickets' => $this->formatNumber(
                VisitorTicket::query()->count() + \App\Domain\Visitor\Models\Visitor::query()->count()
            ),
            'published_events' => $this->formatNumber(
                LiveContent::companyEventQuery()->count()
            ),
            'published_exhibitions' => $this->formatNumber(
                LiveContent::exhibitionQuery()->count()
            ),
            'total_visitors' => $this->formatNumber($totalVisitors),
            'total_revenue' => $this->formatMoney($boothRevenue + $ticketRevenue),
            'total_meetings' => $this->formatNumber(VisitorMeetingBooking::query()->count()),
            'total_enquiries' => $this->formatNumber(Enquiry::query()->count()),
        ];

        return [
            'header' => [
                'title' => 'Welcome back, ' . $this->adminFirstName(),
                'subtitle' => "Here's what's happening with your platform today.",
            ],
            'date_range' => $rangeStart->format('M d') . ' - ' . $rangeEnd->format('M d, Y'),
            'quick_actions' => $this->quickActions(),
            'links' => [
                'companies' => route('admin.companies.index'),
                'visitor_report' => route('admin.reports.index'),
            ],
            'stats' => $stats,
            'stat_cards' => $this->statCards($stats),
            'badges' => [
                'notifications' => $this->formatNumber(
                    BoothBooking::query()->where('payment_status', 'paid')->where('admin_status', 'pending')->count()
                    + BoothPublishRequest::query()->where('status', 'pending')->count()
                    + CompanyEventPublishRequest::query()->where('status', 'pending')->count()
                ),
                'messages' => $this->formatNumber(Enquiry::query()->whereIn('status', ['new', 'pending', 'open'])->count()),
            ],
            'recent_companies' => $this->recentCompanies(),
            'recent_companies_count' => Company::query()->count(),
            'visitor_overview' => [
                'total' => $this->formatNumber($totalVisitors),
                'this_week' => '+' . $this->formatNumber($thisWeekVisitors),
                'this_month' => '+' . $this->formatNumber($thisMonthVisitors),
                'tooltip_value' => $this->formatNumber($totalVisitors),
                'tooltip_date' => $rangeEnd->format('M d, Y'),
                'labels' => collect(CarbonPeriod::create($rangeStart, $rangeEnd))
                    ->map(fn ($date) => $date->format('M d'))
                    ->values(),
            ],
            'pendingBookingsCount' => BoothBooking::query()
                ->where('payment_status', 'paid')
                ->where('admin_status', 'pending')
                ->count(),
            'pendingApprovalsCount' => BoothPublishRequest::query()->where('status', 'pending')->count(),
            'pendingEventApprovalsCount' => CompanyEventPublishRequest::query()->where('status', 'pending')->count(),
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
                    'status' => ucfirst(str_replace('_', ' ', $status)),
                    'status_class' => $this->statusClass($status),
                    'registered_on' => $company->created_at?->format('M d, Y') ?? 'N/A',
                ];
            });
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
                'label' => 'New Pavilion',
                'icon' => 'ph ph-flag',
                'href' => route('admin.pavilions.create'),
            ],
            [
                'label' => 'New Booth',
                'icon' => 'ph ph-package',
                'href' => route('admin.booths.create'),
            ],
            [
                'label' => 'New Event',
                'icon' => 'ph ph-ticket',
                'href' => route('admin.events.index'),
            ],
            [
                'label' => 'New Pass',
                'icon' => 'ph ph-tag',
                'href' => route('admin.event-tickets.index'),
            ],
            [
                'label' => 'New User',
                'icon' => 'ph ph-user-plus',
                'href' => route('admin.users.index'),
            ],
            [
                'label' => 'Mass Notification',
                'icon' => 'ph ph-paper-plane-tilt',
                'href' => route('admin.notifications.index'),
            ],
        ];
    }

    private function statCards(array $stats): array
    {
        return [
            [
                'value' => $stats['total_companies'],
                'label' => 'Total Companies',
                'value_class' => 'text-[#0B132C]',
                'icon_bg' => 'bg-[#F4F2FF]',
                'icon_text' => 'text-[#5A42E9]',
                'icon' => 'ph ph-buildings',
            ],
            [
                'value' => $stats['total_tickets'],
                'label' => 'Total Tickets',
                'value_class' => 'text-[#0B132C]',
                'icon_bg' => 'bg-[#FFF5E6]',
                'icon_text' => 'text-[#FF8A00]',
                'icon' => 'ph ph-ticket',
            ],
            [
                'value' => $stats['published_events'],
                'label' => 'Published Events',
                'value_class' => 'text-[#0B132C]',
                'icon_bg' => 'bg-[#EFF2FF]',
                'icon_text' => 'text-[#3B66FF]',
                'icon' => 'ph ph-calendar-check',
            ],
            [
                'value' => $stats['published_exhibitions'],
                'label' => 'Published Exhibitions',
                'value_class' => 'text-[#0B132C]',
                'icon_bg' => 'bg-[#E6FBF0]',
                'icon_text' => 'text-[#10B981]',
                'icon' => 'ph ph-cube',
            ],
            [
                'value' => $stats['total_visitors'],
                'label' => 'Total Visitors',
                'value_class' => 'text-[#0B132C]',
                'icon_bg' => 'bg-[#F4F2FF]',
                'icon_text' => 'text-[#5A42E9]',
                'icon' => 'ph ph-users-three',
            ],
            [
                'value' => $stats['total_revenue'],
                'label' => 'Total Revenue',
                'value_class' => 'text-[#0B132C]',
                'icon_bg' => 'bg-[#E6FBF0]',
                'icon_text' => 'text-[#10B981]',
                'icon' => 'ph ph-currency-circle-dollar',
            ],
            [
                'value' => $stats['total_meetings'],
                'label' => 'Total Meetings',
                'value_class' => 'text-[#0B132C]',
                'icon_bg' => 'bg-[#EFF2FF]',
                'icon_text' => 'text-[#3B66FF]',
                'icon' => 'ph ph-user-plus',
            ],
            [
                'value' => $stats['total_enquiries'],
                'label' => 'Total Enquiries',
                'value_class' => 'text-[#FF3B6A]',
                'icon_bg' => 'bg-[#FFE6EB]',
                'icon_text' => 'text-[#FF3B6A]',
                'icon' => 'ph ph-chat-circle-question',
            ],
        ];
    }

    private function adminFirstName(): string
    {
        $admin = session('admin_id') ? Admin::query()->find(session('admin_id')) : null;
        $name = $admin?->name ?: 'Admin';

        return str($name)->before(' ')->toString();
    }

    private function statusClass(string $status): string
    {
        return match ($status) {
            'approved', 'active', 'published', 'live' => 'bg-[#E6FBF0] text-[#10B981]',
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
        return number_format($value, 0);
    }
}
