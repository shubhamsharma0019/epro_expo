@extends('layouts.company-event')

@section('title', 'Company Event Dashboard | eproexpo')

@push('styles')
    @include('company.event-company-flow.partials.event-dashboard-styles')
@endpush

@section('content')
@php
    $companyName = $currentCompany->company_name ?? $currentCompany->name ?? 'Company';
    $contactName = $currentCompany->contact_person_name ?? $currentCompany->owner_name ?? $companyName;
    $latestEvent = $events->first();
    $currency = strtoupper($stats['currency'] ?? 'INR');
    $currencySymbols = ['INR' => 'Rs. ', 'USD' => '$', 'EUR' => 'EUR ', 'GBP' => 'GBP '];
    $formatMoney = function ($amount, $currencyCode = null) use ($currencySymbols, $currency) {
        $currencyCode = strtoupper($currencyCode ?: $currency);
        return ($currencySymbols[$currencyCode] ?? $currencyCode . ' ') . number_format((float) $amount, 2);
    };
    $money = $formatMoney($stats['revenue'] ?? 0);
    $growth = function ($current, $previous) {
        if ((float) $previous <= 0) {
            return (float) $current > 0 ? 'New this month' : 'No change';
        }
        $value = (((float) $current - (float) $previous) / (float) $previous) * 100;
        return ($value >= 0 ? '+' : '') . number_format($value, 1) . '%';
    };
    $trendMeta = function ($current, $previous, $defaultText) {
        if ((float) $previous <= 0) {
            if ((float) $current > 0) {
                return [
                    'text' => 'New this month',
                    'class' => 'text-success',
                    'icon' => '<line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline>',
                ];
            }

            return [
                'text' => $defaultText,
                'class' => 'text-gray-400',
                'icon' => '<line x1="5" y1="12" x2="19" y2="12"></line>',
            ];
        }

        $value = (((float) $current - (float) $previous) / (float) $previous) * 100;
        if ($value > 0) {
            return [
                'text' => '+' . number_format($value, 1) . '%',
                'class' => 'text-success',
                'icon' => '<line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline>',
            ];
        }
        if ($value < 0) {
            return [
                'text' => number_format($value, 1) . '%',
                'class' => 'text-red-500',
                'icon' => '<line x1="12" y1="5" x2="12" y2="19"></line><polyline points="5 12 12 19 19 12"></polyline>',
            ];
        }

        return [
            'text' => $defaultText,
            'class' => 'text-gray-400',
            'icon' => '<line x1="5" y1="12" x2="19" y2="12"></line>',
        ];
    };
    $eventGrowth = number_format($stats['total_events'] ?? 0) . ' total';
    $eventTrend = [
        'text' => $eventGrowth,
        'class' => ($stats['total_events'] ?? 0) > 0 ? 'text-success' : 'text-gray-400',
        'icon' => ($stats['total_events'] ?? 0) > 0
            ? '<line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline>'
            : '<line x1="5" y1="12" x2="19" y2="12"></line>',
    ];
    $registrationTrend = $trendMeta($stats['current_month_registrations'] ?? 0, $stats['previous_month_registrations'] ?? 0, 'No change');
    $revenueTrend = $trendMeta($stats['current_month_revenue'] ?? 0, $stats['previous_month_revenue'] ?? 0, 'No change');
    $dashboardEventsUrl = route('company.event-company-flow.dashboard', ['all' => 'true']);
    $monthlyChartHasData = (bool) ($charts['monthly']['has_data'] ?? false);
    $pipelineTotal = (int) ($charts['event_status']['total'] ?? 0);
    $pipelineItems = $charts['event_status']['items'] ?? [];
    $topEventsHasData = (bool) ($charts['top_events']['has_data'] ?? false);
    $sixMonthRegistrationTotal = (int) ($charts['monthly']['total_registrations'] ?? 0);
    $sixMonthRevenueTotal = (float) ($charts['monthly']['total_revenue'] ?? 0);
@endphp

<div id="company-event-dashboard" class="w-full max-w-[1200px] min-w-0 px-4 py-5 sm:px-8 sm:py-6 lg:px-8 lg:py-8">
    <div class="ced-page-header mb-6">
        <div class="ced-page-header__copy">
            <h1 class="mb-2 text-xl font-bold sm:text-2xl">Company Dashboard</h1>
            <p class="text-sm text-gray-500">Welcome back, {{ $contactName }}! Here's what's happening with your events.</p>
        </div>
        <a href="{{ route('company.event-company-flow.create') }}" style="background-color: #5B32F6; color: #FFFFFF;" class="ced-create-btn inline-flex h-11 items-center justify-center rounded-lg px-5 text-sm font-semibold shadow-sm hover:bg-primary">
            Create Event
        </a>
    </div>

        <div class="ced-stat-grid mb-6">
            <div class="ced-stat-card rounded-xl border border-gray-200 bg-white p-4 sm:p-6">
                <div class="ced-stat-card__icon w-12 h-12 rounded-xl flex items-center justify-center bg-primary-light text-primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <div class="ced-stat-card__body flex-1">
                    <div class="ced-stat-label text-[13px] text-gray-500 font-medium mb-2">Total Events</div>
                    <div id="stat-total-events" class="text-2xl font-bold mb-2">{{ number_format($stats['total_events'] ?? 0) }}</div>
                    <div class="text-xs font-medium flex items-center gap-1 {{ $eventTrend['class'] }}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $eventTrend['icon'] !!}</svg>
                        {{ $eventTrend['text'] }}
                    </div>
                </div>
            </div>
            
            <div class="ced-stat-card rounded-xl border border-gray-200 bg-white p-4 sm:p-6">
                <div class="ced-stat-card__icon w-12 h-12 rounded-xl flex items-center justify-center bg-success-light text-success">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <div class="ced-stat-card__body flex-1">
                    <div class="ced-stat-label text-[13px] text-gray-500 font-medium mb-2">Registrations</div>
                    <div id="stat-registrations" class="text-2xl font-bold mb-2">{{ number_format($stats['registrations'] ?? 0) }}</div>
                    <div class="text-xs font-medium flex items-center gap-1 {{ $registrationTrend['class'] }}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $registrationTrend['icon'] !!}</svg>
                        {{ $registrationTrend['text'] }}
                    </div>
                </div>
            </div>

            <div class="ced-stat-card rounded-xl border border-gray-200 bg-white p-4 sm:p-6">
                <div class="ced-stat-card__icon w-12 h-12 rounded-xl flex items-center justify-center bg-warning-light text-warning">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18"></path><path d="M7 7h8a2 2 0 0 1 0 4H9a2 2 0 0 0 0 4h8"></path></svg>
                </div>
                <div class="ced-stat-card__body flex-1">
                    <div class="ced-stat-label text-[13px] text-gray-500 font-medium mb-2">Revenue</div>
                    <div id="stat-revenue" class="mb-2 break-words text-xl font-bold sm:text-2xl">{{ $money }}</div>
                    <div class="text-xs font-medium flex items-center gap-1 {{ $revenueTrend['class'] }}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $revenueTrend['icon'] !!}</svg>
                        {{ $revenueTrend['text'] }}
                    </div>
                </div>
            </div>

            <div class="ced-stat-card rounded-xl border border-gray-200 bg-white p-4 sm:p-6">
                <div class="ced-stat-card__icon w-12 h-12 rounded-xl flex items-center justify-center bg-primary-light text-primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div class="ced-stat-card__body min-w-0 flex-1">
                    <div class="ced-stat-label text-[13px] text-gray-500 font-medium mb-2">Pending Approvals</div>
                    <div id="stat-pending-approvals" class="text-2xl font-bold mb-2">{{ number_format($stats['pending_requests'] ?? 0) }}</div>
                    <a href="{{ $latestEvent ? route('company.event-company-flow.submit', $latestEvent) : route('company.event-company-flow.create') }}" class="text-[13px] text-primary font-medium hover:underline inline-block mt-1">Review status</a>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-bold text-[#1C1364]">Performance Overview</h2>
            <p class="mt-1 text-sm text-gray-500">Track ticket sales momentum and event lifecycle at a glance.</p>
        </div>

        <div class="ced-performance-grid mb-6">
            <div class="flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 bg-gradient-to-r from-[#FBFAFF] via-white to-[#F0FDF9] px-5 py-4 sm:px-6">
                    <div class="ced-chart-head">
                        <div class="min-w-0">
                            <h3 class="text-base font-semibold text-[#1C1364]">Registrations & Revenue</h3>
                            <p class="mt-0.5 text-xs text-gray-500">Last 6 months ticket performance</p>
                        </div>
                        <div class="ced-chart-legend">
                            <div class="ced-chart-legend__item rounded-xl border border-[#E8E3FF] bg-white px-3 py-2 shadow-sm">
                                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-[#F3EEFF] text-[#5B32F6]">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-bold uppercase tracking-wide text-gray-400">Registrations</p>
                                    <p class="truncate text-lg font-bold leading-none text-[#5B32F6]">{{ number_format($sixMonthRegistrationTotal) }}</p>
                                </div>
                            </div>
                            <div class="ced-chart-legend__item rounded-xl border border-emerald-100 bg-white px-3 py-2 shadow-sm">
                                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-emerald-50 text-emerald-600">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v18"></path><path d="M7 7h8a2 2 0 0 1 0 4H9a2 2 0 0 0 0 4h8"></path></svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-bold uppercase tracking-wide text-gray-400">Revenue</p>
                                    <p class="truncate text-lg font-bold leading-none text-emerald-600">{{ $formatMoney($sixMonthRevenueTotal) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="{{ $monthlyChartHasData ? 'p-5 sm:p-6' : 'px-5 pb-5 pt-4 sm:px-6 sm:pb-6' }}">
                    @if ($monthlyChartHasData)
                        <div class="relative h-[240px] sm:h-[280px]">
                            <canvas id="event-dashboard-monthly-chart" aria-label="Registrations and revenue trend chart"></canvas>
                        </div>
                    @else
                        @php
                            $previewBars = [38, 54, 42, 68, 48, 44];
                            $monthLabels = $charts['monthly']['labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                        @endphp
                        <div class="relative overflow-hidden rounded-xl border border-[#EEF2FF] bg-gradient-to-b from-[#FBFAFF] to-white px-4 pb-3 pt-4 sm:px-5">
                            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(91,50,246,0.08),transparent_45%)]"></div>
                            <div class="relative flex h-[168px] items-end gap-2 sm:h-[190px] sm:gap-3">
                                @foreach ($previewBars as $index => $height)
                                    <div class="flex flex-1 flex-col items-center gap-1.5">
                                        <div class="relative w-full max-w-[40px] rounded-t-[12px] bg-gradient-to-t from-[#5B32F6]/20 to-[#5B32F6]/8" style="height: {{ $height }}%"></div>
                                        <span class="text-[11px] font-semibold text-gray-400">{{ $monthLabels[$index] ?? '' }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="relative mt-3 flex flex-col items-center gap-2 rounded-xl border border-[#E8E3FF] bg-white/90 px-4 py-2.5 text-center shadow-sm sm:flex-row sm:justify-between sm:text-left">
                                <div>
                                    <p class="text-sm font-semibold text-[#1C1364]">Preview chart — waiting for live ticket data</p>
                                    <p class="mt-0.5 text-xs text-gray-500">Publish tickets and start getting registrations to unlock real monthly trends.</p>
                                </div>
                                <a href="{{ route('company.event-company-flow.create') }}" class="inline-flex h-9 shrink-0 items-center justify-center rounded-lg bg-[#5B32F6] px-4 text-xs font-semibold text-white hover:bg-[#4C10D0]">Set up event</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 bg-gradient-to-r from-white to-[#FAFBFC] px-5 py-4 sm:px-6">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h3 class="text-base font-semibold text-[#1C1364]">Event Pipeline</h3>
                            <p class="mt-0.5 text-xs text-gray-500">Draft to published journey</p>
                        </div>
                        <span class="shrink-0 rounded-full bg-[#F3EEFF] px-2.5 py-1 text-xs font-bold text-[#5B32F6]">{{ number_format($pipelineTotal) }} total</span>
                    </div>
                </div>

                <div class="flex flex-1 flex-col space-y-2.5 px-5 py-4 sm:px-6 sm:py-5">
                    @foreach ($pipelineItems as $index => $item)
                        @php
                            $itemValue = (int) ($item['value'] ?? 0);
                            $itemPercent = $pipelineTotal > 0 ? round(($itemValue / $pipelineTotal) * 100) : 0;
                            $stepIcons = [
                                'Draft' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline>',
                                'In Review' => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>',
                                'Published' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>',
                            ];
                        @endphp
                        <div class="rounded-xl border border-gray-100 bg-[#FAFBFC] p-3.5">
                            <div class="mb-2 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2.5">
                                    <span class="grid h-9 w-9 place-items-center rounded-xl text-white" style="background-color: {{ $item['color'] }}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $stepIcons[$item['label']] ?? $stepIcons['Draft'] !!}</svg>
                                    </span>
                                    <div>
                                        <p class="text-sm font-semibold leading-tight text-[#1C1364]">{{ $item['label'] }}</p>
                                        <p class="text-[11px] font-medium text-gray-400">Step {{ $index + 1 }} of 3</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-[#1C1364]">{{ number_format($itemValue) }}</span>
                            </div>
                            <div class="h-1.5 overflow-hidden rounded-full bg-white">
                                <div class="h-full rounded-full transition-all duration-500" style="width: {{ $pipelineTotal > 0 ? max($itemPercent, $itemValue > 0 ? 8 : 0) : 0 }}%; background-color: {{ $item['color'] }}"></div>
                            </div>
                            <p class="mt-1.5 text-[11px] font-medium text-gray-400">
                                @if ($pipelineTotal > 0)
                                    {{ $itemPercent }}% of your active events
                                @else
                                    No events in this stage yet
                                @endif
                            </p>
                        </div>
                    @endforeach

                    @if ($pipelineTotal === 0)
                        <a href="{{ route('company.event-company-flow.create') }}" class="mt-1 flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#5B32F6] to-[#4C10D0] text-sm font-semibold text-white shadow-sm hover:opacity-95">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Create your first event
                        </a>
                    @endif
                </div>
            </div>
        </div>

        @if (! empty($charts['top_events']['labels']))
            <div class="mb-6 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 bg-gradient-to-r from-[#FBFAFF] to-white px-4 py-4 sm:px-6 sm:py-5">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-[#1C1364]">Top Events by Registrations</h3>
                            <p class="mt-1 text-xs text-gray-500">Best performing events from confirmed ticket sales</p>
                        </div>
                        @if ($topEventsHasData)
                            <span class="inline-flex w-fit rounded-full bg-[#F3EEFF] px-3 py-1 text-xs font-semibold text-[#5B32F6]">Live ranking</span>
                        @endif
                    </div>
                </div>

                <div class="p-4 sm:p-6">
                    @if ($topEventsHasData)
                        <div class="relative h-[220px] sm:h-[260px]">
                            <canvas id="event-dashboard-top-events-chart" aria-label="Top events by registrations chart"></canvas>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach (collect($charts['top_events']['labels'])->take(5) as $index => $eventLabel)
                                @php
                                    $rankColors = ['#5B32F6', '#7C5CFF', '#9B87FF', '#B8A9FF', '#D4CCFF'];
                                @endphp
                                <div class="rounded-xl border border-gray-100 bg-[#FAFBFC] p-4">
                                    <div class="mb-2 flex items-center justify-between gap-3">
                                        <div class="flex min-w-0 items-center gap-3">
                                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg text-xs font-bold text-white" style="background-color: {{ $rankColors[$index] ?? '#D4CCFF' }}">{{ $index + 1 }}</span>
                                            <span class="truncate text-sm font-semibold text-[#1C1364]">{{ $eventLabel }}</span>
                                        </div>
                                        <span class="shrink-0 text-sm font-bold text-gray-400">0</span>
                                    </div>
                                    <div class="h-2 overflow-hidden rounded-full bg-white">
                                        <div class="h-full w-[8%] rounded-full bg-gradient-to-r from-[#5B32F6]/30 to-[#5B32F6]/10"></div>
                                    </div>
                                </div>
                            @endforeach
                            <p class="text-center text-xs text-gray-500">Rankings will update automatically once ticket sales begin.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div class="mb-6 grid grid-cols-1 gap-5 md:grid-cols-2">
            <div class="rounded-xl border border-gray-200 bg-white p-4 sm:p-6">
                <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-base font-semibold">{{ request()->query('all') ? 'All Events' : 'Upcoming Events' }}</h3>
                    @if (request()->query('all'))
                        <a href="{{ route('company.event-company-flow.dashboard') }}" class="text-[13px] text-primary font-medium hover:underline">Show less</a>
                    @else
                        <a href="{{ route('company.event-company-flow.dashboard', ['all' => 'true']) }}" class="text-[13px] text-primary font-medium hover:underline">View all events</a>
                    @endif
                </div>
                <div id="upcoming-events-list" class="flex flex-col gap-4">
                    @forelse ((request()->query('all') ? $events : $upcomingEvents)->take(request()->query('all') ? 100 : 3) as $event)
                        <a href="{{ route('company.event-company-flow.basic', $event) }}" class="flex gap-3 rounded-lg transition-colors hover:bg-gray-50 sm:gap-4">
                            @if ($event->dashboard_banner_url)
                                <img src="{{ $event->dashboard_banner_url }}" alt="{{ $event->title }}" class="w-[90px] h-[60px] rounded-lg object-cover bg-gray-200 shrink-0">
                            @else
                                <div class="flex h-[60px] w-[90px] shrink-0 items-center justify-center rounded-lg bg-gray-100 text-lg font-bold text-primary">
                                    {{ strtoupper(substr($event->title ?? 'E', 0, 1)) }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <h4 class="text-sm font-semibold mb-1 truncate">{{ $event->title }}</h4>
                                <p class="text-xs text-gray-500 mb-1">{{ $event->starts_at ? $event->starts_at->format('M d, Y') : 'Date TBD' }}</p>
                                <span class="text-xs text-gray-500">{{ number_format($event->dashboard_tickets_sold ?? 0) }} Registrations</span>
                            </div>
                        </a>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-200 p-5 text-xs text-gray-500">No events yet. Create your first event to see it here.</div>
                    @endforelse
                </div>
                <div class="text-center mt-5">
                    @if (request()->query('all'))
                        <a href="{{ route('company.event-company-flow.dashboard') }}" class="text-[13px] text-primary font-medium hover:underline">Show less</a>
                    @else
                        <a href="{{ route('company.event-company-flow.dashboard', ['all' => 'true']) }}" class="text-[13px] text-primary font-medium hover:underline">View all events</a>
                    @endif
                </div>
            </div>

            <div class="relative rounded-xl border border-gray-200 bg-white p-4 sm:p-6">
                <div class="relative z-10 mb-5 flex flex-col gap-2 bg-white sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-base font-semibold">Recent Activity</h3>
                    <span class="text-[13px] text-gray-400 font-medium">{{ number_format($stats['recent_activities_count'] ?? $recentActivities->count()) }} latest</span>
                </div>
                <div class="relative pl-[14px]">
                    @if ($recentActivities->isNotEmpty())
                        <div class="absolute left-[29px] top-4 bottom-4 w-0 border-l-2 border-dashed border-gray-200 z-0"></div>
                    @endif
                    @forelse ($recentActivities->take(5) as $activity)
                        <div class="flex gap-4 mb-6 last:mb-0 relative z-10">
                            <div class="w-8 h-8 rounded-full bg-primary-light text-primary flex items-center justify-center shrink-0 border-[3px] border-white">
                                @switch($activity['icon'] ?? 'calendar')
                                    @case('user')
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        @break
                                    @case('paper-plane')
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                        @break
                                    @default
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                @endswitch
                            </div>
                            <div class="flex-1 mt-1 min-w-0">
                                <div class="mb-1 flex flex-col gap-1 sm:flex-row sm:justify-between sm:gap-3">
                                    <h4 class="text-[13px] font-semibold">{{ $activity['title'] }}</h4>
                                    <span class="shrink-0 text-xs text-gray-500">{{ $activity['time']?->diffForHumans() }}</span>
                                </div>
                                <div class="text-xs text-gray-500">{{ $activity['body'] }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-200 p-5 text-xs text-gray-500">No recent activity yet.</div>
                    @endforelse
                </div>
            </div>

        </div>

</div>
@endsection

@push('scripts')
@if ($monthlyChartHasData || $topEventsHasData)
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    (() => {
        if (typeof Chart === 'undefined') {
            return;
        }

        const chartData = @json($charts ?? []);
        const currency = @json(strtoupper($stats['currency'] ?? 'INR'));
        const currencyPrefix = { INR: 'Rs. ', USD: '$', EUR: 'EUR ', GBP: 'GBP ' }[currency] || (currency + ' ');
        const chartFont = "'Inter', sans-serif";
        const gridColor = '#EEF2F7';
        const textColor = '#6B7280';
        const isMobile = () => window.innerWidth < 640;
        const mobileChartOptions = () => ({
            tickFontSize: isMobile() ? 10 : 12,
            legendPadding: isMobile() ? 12 : 18,
            maxBarThickness: isMobile() ? 18 : 28,
        });

        Chart.defaults.font.family = chartFont;
        Chart.defaults.color = textColor;
        Chart.defaults.plugins.tooltip.backgroundColor = '#1C1364';
        Chart.defaults.plugins.tooltip.padding = 12;
        Chart.defaults.plugins.tooltip.cornerRadius = 10;

        const buildGradient = (context, fromColor, toColor) => {
            const { chart } = context;
            const { ctx, chartArea } = chart;

            if (!chartArea) {
                return fromColor;
            }

            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
            gradient.addColorStop(0, fromColor);
            gradient.addColorStop(1, toColor);

            return gradient;
        };

        const monthlyCanvas = document.getElementById('event-dashboard-monthly-chart');
        if (monthlyCanvas && chartData.monthly?.has_data) {
            const registrations = chartData.monthly.registrations || [];
            const revenue = chartData.monthly.revenue || [];
            const regMax = Math.max(...registrations, 0);
            const revMax = Math.max(...revenue, 0);

            new Chart(monthlyCanvas, {
                type: 'bar',
                data: {
                    labels: chartData.monthly.labels || [],
                    datasets: [
                        {
                            label: 'Registrations',
                            data: registrations,
                            backgroundColor: (context) => buildGradient(context, 'rgba(91, 50, 246, 0.35)', '#5B32F6'),
                            borderRadius: 8,
                            maxBarThickness: mobileChartOptions().maxBarThickness,
                            yAxisID: 'y',
                        },
                        {
                            label: 'Revenue',
                            data: revenue,
                            backgroundColor: (context) => buildGradient(context, 'rgba(16, 185, 129, 0.25)', '#10B981'),
                            borderRadius: 8,
                            maxBarThickness: mobileChartOptions().maxBarThickness,
                            yAxisID: 'y1',
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8,
                                padding: mobileChartOptions().legendPadding,
                                font: { size: mobileChartOptions().tickFontSize },
                            },
                        },
                        tooltip: {
                            callbacks: {
                                label(context) {
                                    if (context.dataset.label === 'Revenue') {
                                        return `${context.dataset.label}: ${currencyPrefix}${Number(context.parsed.y || 0).toLocaleString()}`;
                                    }

                                    return `${context.dataset.label}: ${Number(context.parsed.y || 0).toLocaleString()}`;
                                },
                            },
                        },
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: {
                                maxRotation: isMobile() ? 45 : 0,
                                font: { size: mobileChartOptions().tickFontSize },
                            },
                        },
                        y: {
                            beginAtZero: true,
                            suggestedMax: regMax > 0 ? undefined : 5,
                            grid: { color: gridColor },
                            ticks: { precision: 0, padding: 8, font: { size: mobileChartOptions().tickFontSize } },
                            border: { display: false },
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            suggestedMax: revMax > 0 ? undefined : 1000,
                            grid: { drawOnChartArea: false },
                            ticks: {
                                padding: 8,
                                maxTicksLimit: isMobile() ? 4 : 8,
                                font: { size: mobileChartOptions().tickFontSize },
                                callback(value) {
                                    return currencyPrefix + Number(value).toLocaleString();
                                },
                            },
                            border: { display: false },
                        },
                    },
                },
            });
        }

        const topEventsCanvas = document.getElementById('event-dashboard-top-events-chart');
        if (topEventsCanvas && chartData.top_events?.has_data) {
            const values = chartData.top_events.registrations || [];
            const maxValue = Math.max(...values, 0);

            new Chart(topEventsCanvas, {
                type: 'bar',
                data: {
                    labels: chartData.top_events.labels || [],
                    datasets: [{
                        label: 'Registrations',
                        data: values,
                        backgroundColor: (context) => buildGradient(context, 'rgba(91, 50, 246, 0.35)', '#5B32F6'),
                        borderRadius: 10,
                        maxBarThickness: isMobile() ? 16 : 22,
                    }],
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label(context) {
                                    return `${Number(context.parsed.x || 0).toLocaleString()} registrations`;
                                },
                            },
                        },
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            suggestedMax: maxValue > 0 ? undefined : 5,
                            grid: { color: gridColor },
                            ticks: { precision: 0, padding: 8, font: { size: mobileChartOptions().tickFontSize } },
                            border: { display: false },
                        },
                        y: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { padding: 8, font: { size: mobileChartOptions().tickFontSize } },
                        },
                    },
                },
            });
        }
    })();
</script>
@endif
@endpush
