@extends('layouts.company-event')

@section('title', 'Company Event Dashboard | eproexpo')
@section('hideTopbar', 'true')

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
    $eventGrowth = number_format($stats['total_events'] ?? 0) . ' total';
    $registrationGrowth = $growth($stats['current_month_registrations'] ?? 0, $stats['previous_month_registrations'] ?? 0);
    $revenueGrowth = $growth($stats['current_month_revenue'] ?? 0, $stats['previous_month_revenue'] ?? 0);
    $countries = $events->pluck('country')->filter()->unique()->count();
@endphp

<div class="mx-auto w-full max-w-[1200px] px-4 py-6 sm:px-8 lg:px-10 lg:py-8">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold mb-2">Company Dashboard</h1>
            <p class="text-sm text-gray-500">Welcome back, {{ $contactName }}! Here's what's happening with your events.</p>
        </div>
        <a href="{{ route('company.event-company-flow.create') }}" style="background-color: #5B32F6; color: #FFFFFF;" class="inline-flex h-11 items-center justify-center rounded-lg px-5 text-sm font-semibold shadow-sm hover:bg-primary">
            Create Event
        </a>
    </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
            <div class="p-6 border border-gray-200 rounded-xl flex gap-4 bg-white">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-primary-light text-primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <div class="flex-1">
                    <div class="text-[13px] text-gray-500 font-medium mb-2">Total Events</div>
                    <div id="stat-total-events" class="text-2xl font-bold mb-2">{{ number_format($stats['total_events'] ?? 0) }}</div>
                    <div class="text-xs font-medium flex items-center gap-1 text-success">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        {{ $eventGrowth }}
                    </div>
                </div>
            </div>
            
            <div class="p-6 border border-gray-200 rounded-xl flex gap-4 bg-white">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-success-light text-success">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <div class="flex-1">
                    <div class="text-[13px] text-gray-500 font-medium mb-2">Registrations</div>
                    <div id="stat-registrations" class="text-2xl font-bold mb-2">{{ number_format($stats['registrations'] ?? 0) }}</div>
                    <div class="text-xs font-medium flex items-center gap-1 text-success">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        {{ $registrationGrowth }}
                    </div>
                </div>
            </div>

            <div class="p-6 border border-gray-200 rounded-xl flex gap-4 bg-white">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-warning-light text-warning">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
                <div class="flex-1">
                    <div class="text-[13px] text-gray-500 font-medium mb-2">Revenue</div>
                    <div id="stat-revenue" class="text-2xl font-bold mb-2">{{ $money }}</div>
                    <div class="text-xs font-medium flex items-center gap-1 text-success">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        {{ $revenueGrowth }}
                    </div>
                </div>
            </div>

            <div class="p-6 border border-gray-200 rounded-xl flex gap-4 bg-white">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-primary-light text-primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div class="flex-1">
                    <div class="text-[13px] text-gray-500 font-medium mb-2">Pending Approvals</div>
                    <div id="stat-pending-approvals" class="text-2xl font-bold mb-2">{{ number_format($stats['pending_requests'] ?? 0) }}</div>
                    <a href="{{ $latestEvent ? route('company.event-company-flow.submit', $latestEvent) : route('company.event-company-flow.create') }}" class="text-[13px] text-primary font-medium hover:underline inline-block mt-1">Review status</a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
            <div class="border border-gray-200 rounded-xl p-6 bg-white">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-base font-semibold">Upcoming Events</h3>
                    <a href="#upcoming-events-list" class="text-[13px] text-primary font-medium hover:underline">View all events</a>
                </div>
                <div id="upcoming-events-list" class="flex flex-col gap-4">
                    @forelse ($upcomingEvents->take(3) as $event)
                        <a href="{{ route('company.event-company-flow.basic', $event) }}" class="flex gap-4 rounded-lg hover:bg-gray-50 transition-colors">
                            <img src="{{ $event->branding?->banner_path ? asset('storage/' . $event->branding->banner_path) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=200&h=120&fit=crop' }}" alt="{{ $event->title }}" class="w-[90px] h-[60px] rounded-lg object-cover bg-gray-200 shrink-0">
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
                    <a href="#upcoming-events-list" class="text-[13px] text-primary font-medium hover:underline">View all events</a>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl p-6 bg-white relative">
                <div class="flex justify-between items-center mb-5 relative z-10 bg-white">
                    <h3 class="text-base font-semibold">Recent Activity</h3>
                    <span class="text-[13px] text-gray-400 font-medium">{{ $recentActivities->count() }} latest</span>
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
                                <div class="flex justify-between gap-3 mb-1">
                                    <h4 class="text-[13px] font-semibold">{{ $activity['title'] }}</h4>
                                    <span class="text-xs text-gray-500 shrink-0">{{ $activity['time']?->diffForHumans() }}</span>
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

        <div class="border border-gray-200 rounded-xl bg-white relative mt-10">
            <h3 class="absolute -top-3 left-6 bg-white px-2 font-semibold text-[15px]">At a Glance</h3>
            <div class="grid grid-cols-2 gap-6 py-8 px-6 md:px-12">
                <div class="flex items-center gap-4">
                    <svg class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    <div>
                        <h4 class="text-[13px] text-gray-500 font-medium mb-1">Published</h4>
                        <p class="text-2xl font-bold">{{ number_format($stats['published_events'] ?? 0) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <svg class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <div>
                        <h4 class="text-[13px] text-gray-500 font-medium mb-1">Countries</h4>
                        <p class="text-2xl font-bold">{{ number_format($countries) }}</p>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
