@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <section class="space-y-6 px-5 py-6 sm:px-8">
        <div class="rounded-3xl bg-[#0B132C] px-6 py-7 text-white">
            <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-white/60">{{ $date_range }}</p>
            <h2 class="mt-3 text-[30px] font-bold">{{ $header['title'] }}</h2>
            <p class="mt-2 max-w-2xl text-[14px] text-white/70">{{ $header['subtitle'] }}</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stat_cards as $card)
                <a href="{{ $card['href'] ?? '#' }}" class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:border-[#3723db]/20 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-[12px] font-semibold uppercase tracking-[0.14em] text-gray-400">{{ $card['label'] }}</p>
                        @if (! empty($card['icon']))
                            <i class="{{ $card['icon'] }} text-lg text-[#3723db]/70 transition group-hover:text-[#3723db]"></i>
                        @endif
                    </div>
                    <p class="mt-3 text-[28px] font-bold text-[#0B132C]">{{ $card['value'] }}</p>
                </a>
            @endforeach
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-[18px] font-bold text-[#0B132C]">Visitor Signups</h3>
                        <p class="mt-1 text-[13px] text-gray-500">Last 7 days · {{ $visitor_overview['total'] }} total visitors</p>
                    </div>
                    <a href="{{ route('admin.reports.index') }}" class="shrink-0 text-[13px] font-semibold text-[#3723db]">Full report</a>
                </div>

                @php
                    $maxSignup = max(1, collect($visitor_overview['signups'] ?? [])->max('value') ?? 1);
                @endphp
                <div class="mt-6 flex h-44 items-end gap-3 border-b border-gray-100 pb-2">
                    @foreach (($visitor_overview['signups'] ?? []) as $signup)
                        <div class="flex min-w-0 flex-1 flex-col items-center gap-2">
                            <span class="text-[11px] font-semibold text-[#3723db]">{{ $signup['value'] }}</span>
                            <div
                                class="w-full max-w-[42px] rounded-t-xl bg-gradient-to-t from-[#3723db] to-[#6366f1] transition hover:opacity-90"
                                style="height: {{ max(12, ($signup['value'] / $maxSignup) * 100) }}%;"
                                title="{{ $signup['value'] }} signups on {{ $signup['label'] }}"
                            ></div>
                            <span class="text-[10px] font-medium text-gray-500">{{ $signup['label'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 flex flex-wrap gap-4 text-[12px] text-gray-500">
                    <span>This week: <strong class="text-[#0B132C]">{{ $visitor_overview['this_week'] }}</strong></span>
                    <span>This month: <strong class="text-[#0B132C]">{{ $visitor_overview['this_month'] }}</strong></span>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-[18px] font-bold text-[#0B132C]">Revenue Mix</h3>
                        <p class="mt-1 text-[13px] text-gray-500">Live split across platform revenue streams</p>
                    </div>
                    <a href="{{ route('admin.payments.index') }}" class="shrink-0 text-[13px] font-semibold text-[#3723db]">View payments</a>
                </div>

                @php
                    $chartTotal = max(1, (float) ($revenue_total ?? 0));
                    $gradientParts = [];
                    $cursor = 0;
                    foreach ($revenue_chart ?? [] as $segment) {
                        $pct = ((float) $segment['amount'] / $chartTotal) * 100;
                        $start = $cursor;
                        $cursor += $pct;
                        $gradientParts[] = $segment['color'] . ' ' . $start . '% ' . $cursor . '%';
                    }
                @endphp

                <div class="mt-6 flex flex-col items-center gap-6 sm:flex-row sm:items-center">
                    <div class="relative flex h-40 w-40 shrink-0 items-center justify-center rounded-full" style="background: conic-gradient({{ implode(', ', $gradientParts) ?: '#e5e7eb 0% 100%' }});">
                        <div class="flex h-24 w-24 flex-col items-center justify-center rounded-full bg-white text-center shadow-inner">
                            <span class="text-[10px] font-semibold uppercase tracking-[0.12em] text-gray-400">Total</span>
                            <span class="mt-1 text-[13px] font-bold text-[#0B132C]">{{ $stats['total_revenue'] }}</span>
                        </div>
                    </div>

                    <div class="w-full space-y-3">
                        @foreach ($revenue_chart ?? [] as $segment)
                            @php
                                $percent = $chartTotal > 0 ? round(((float) $segment['amount'] / $chartTotal) * 100) : 0;
                            @endphp
                            <div>
                                <div class="mb-1 flex items-center justify-between text-[13px]">
                                    <span class="flex items-center gap-2 text-gray-600">
                                        <span class="h-2.5 w-2.5 rounded-full" style="background: {{ $segment['color'] }}"></span>
                                        {{ $segment['label'] }}
                                    </span>
                                    <strong class="text-[#0B132C]">{{ $percent }}%</strong>
                                </div>
                                <div class="h-2 overflow-hidden rounded-full bg-gray-100">
                                    <div class="h-full rounded-full" style="width: {{ $percent }}%; background: {{ $segment['color'] }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.3fr_0.7fr]">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-[18px] font-bold text-[#0B132C]">Recent Companies</h3>
                        <p class="mt-1 text-[13px] text-gray-500">Latest registrations on the platform.</p>
                    </div>
                    <a href="{{ route('admin.companies.index') }}" class="shrink-0 text-[13px] font-semibold text-[#3723db]">View all</a>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse ($recent_companies as $company)
                        <a href="{{ $company['href'] ?? route('admin.companies.index') }}" class="flex flex-col gap-3 rounded-2xl border border-gray-100 px-4 py-3 transition hover:bg-gray-50 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <p class="truncate text-[15px] font-bold text-[#0B132C]">{{ $company['name'] }}</p>
                                <p class="mt-1 text-[13px] text-gray-500">{{ $company['contact'] }} · {{ $company['registered_on'] }}</p>
                            </div>
                            <span class="inline-flex shrink-0 rounded-full px-3 py-1 text-[12px] font-semibold {{ $company['status_class'] }}">
                                {{ $company['status'] }}
                            </span>
                        </a>
                    @empty
                        <div class="rounded-2xl border border-dashed border-gray-200 px-4 py-8 text-center text-[13px] text-gray-500">
                            No companies registered yet.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-[18px] font-bold text-[#0B132C]">Quick Actions</h3>
                    <div class="mt-5 grid gap-3">
                        @foreach ($quick_actions as $action)
                            <a href="{{ $action['href'] }}" class="inline-flex items-center justify-between rounded-2xl border border-gray-100 px-4 py-3 transition hover:bg-gray-50">
                                <span class="flex items-center gap-3">
                                    <i class="{{ $action['icon'] }} text-lg text-[#3723db]"></i>
                                    <span class="text-[14px] font-semibold text-[#0B132C]">{{ $action['label'] }}</span>
                                </span>
                                <i class="ph ph-arrow-right text-gray-400"></i>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-[18px] font-bold text-[#0B132C]">Needs Attention</h3>
                    <div class="mt-5 space-y-3 text-[14px]">
                        <a href="{{ route('admin.booth-bookings.index') }}" class="flex items-center justify-between rounded-2xl bg-[#F8F9FC] px-4 py-3 transition hover:bg-gray-100">
                            <span>Booth Bookings</span>
                            <strong>{{ number_format($pendingBookingsCount) }}</strong>
                        </a>
                        <a href="{{ route('admin.booth-approvals.index') }}" class="flex items-center justify-between rounded-2xl bg-[#F8F9FC] px-4 py-3 transition hover:bg-gray-100">
                            <span>Booth Reviews</span>
                            <strong>{{ number_format($pendingApprovalsCount) }}</strong>
                        </a>
                        <a href="{{ route('admin.event-approvals.index') }}" class="flex items-center justify-between rounded-2xl bg-[#F8F9FC] px-4 py-3 transition hover:bg-gray-100">
                            <span>Event Reviews</span>
                            <strong>{{ number_format($pendingEventApprovalsCount) }}</strong>
                        </a>
                    </div>
                    <a href="{{ route('admin.reports.index') }}" class="mt-5 inline-flex h-10 w-full items-center justify-center rounded-xl border border-[#3723db]/20 bg-[#F4F2FF] text-[13px] font-semibold text-[#3723db] transition hover:bg-[#EDE9FE]">
                        Open detailed reports
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
