@extends('layouts.admin')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')
    <section class="admin-page-section space-y-6 px-5 py-6 sm:px-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="min-w-0">
                <h2 class="admin-page-title font-bold text-[#0B132C]">Reports & Insights</h2>
                <p class="admin-page-description mt-2 text-gray-500">Detailed platform analytics, revenue, enquiries, and activity logs.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-200 px-5 text-[14px] font-semibold text-[#0B132C] transition hover:bg-gray-50">
                Back to Dashboard
            </a>
        </div>

        @if (! empty($platform_highlights))
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($platform_highlights as $highlight)
                    <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                        <p class="text-[12px] font-semibold uppercase tracking-[0.14em] text-gray-400">{{ $highlight['label'] }}</p>
                        <p class="admin-stat-value mt-3 font-bold text-[#0B132C]">{{ $highlight['value'] }}</p>
                        <p class="mt-1 text-[12px] font-medium text-gray-500">{{ $highlight['hint'] }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($stat_cards as $card)
                <a href="{{ $card['href'] ?? '#' }}" class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:border-[#3723db]/20 hover:shadow-md">
                    <p class="text-[12px] font-semibold uppercase tracking-[0.14em] text-gray-400">{{ $card['label'] }}</p>
                    <p class="admin-stat-value mt-3 font-bold text-[#0B132C]">{{ $card['value'] }}</p>
                </a>
            @endforeach
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-[18px] font-bold text-[#0B132C]">Visitor Signups (7 days)</h3>
                @include('admin.partials.visitor-signups-chart', [
                    'visitor_overview' => $visitor_overview,
                    'chartId' => 'admin-reports-visitor-signups-chart',
                ])

                <div class="mt-4 flex flex-wrap gap-4 text-[12px] text-gray-500">
                    <span>Total visitors: <strong class="text-[#0B132C]">{{ $visitor_overview['total'] }}</strong></span>
                    <span>This week: <strong class="text-[#0B132C]">{{ $visitor_overview['this_week'] }}</strong></span>
                    <span>This month: <strong class="text-[#0B132C]">{{ $visitor_overview['this_month'] }}</strong></span>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-[18px] font-bold text-[#0B132C]">Revenue Breakdown</h3>
                <div class="mt-5 space-y-4">
                    @foreach ($revenue_breakdown as $row)
                        @php
                            $segment = collect($revenue_chart ?? [])->firstWhere('label', $row['label']);
                            $percent = ($revenue_total ?? 0) > 0 && $segment
                                ? round(((float) $segment['amount'] / (float) $revenue_total) * 100)
                                : 0;
                        @endphp
                        <div>
                            <div class="mb-1 flex items-center justify-between text-[14px]">
                                <span class="text-gray-600">{{ $row['label'] }}</span>
                                <strong class="text-[#0B132C]">{{ $row['value'] }}</strong>
                            </div>
                            <div class="h-2 overflow-hidden rounded-full bg-gray-100">
                                <div class="h-full rounded-full bg-[#3723db]" style="width: {{ $percent }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex items-center justify-between rounded-2xl border border-[#3723db]/15 bg-[#F4F2FF] px-4 py-3">
                        <span class="text-[14px] font-semibold text-[#3723db]">Total Revenue</span>
                        <strong class="text-[#3723db]">{{ $stats['total_revenue'] }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-[18px] font-bold text-[#0B132C]">Recent Enquiries</h3>
                    <a href="{{ route('admin.enquiries.index') }}" class="text-[13px] font-semibold text-[#3723db]">View all</a>
                </div>
                <div class="mt-5 space-y-3">
                    @forelse ($recent_enquiries as $enquiry)
                        <div class="rounded-2xl bg-[#F8F9FC] px-4 py-3">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                <div class="min-w-0">
                                    <p class="truncate text-[14px] font-semibold text-[#0B132C]">{{ $enquiry['subject'] }}</p>
                                    <p class="mt-1 text-[13px] text-gray-500">{{ $enquiry['name'] }} · {{ $enquiry['company'] }}</p>
                                </div>
                                <span class="inline-flex shrink-0 rounded-full px-3 py-1 text-[11px] font-semibold {{ $enquiry['status_class'] }}">{{ $enquiry['status'] }}</span>
                            </div>
                            <p class="mt-2 text-[12px] text-gray-400">{{ $enquiry['created_on'] }}</p>
                        </div>
                    @empty
                        <p class="text-[13px] text-gray-500">No enquiries received yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-[18px] font-bold text-[#0B132C]">Recent Payments</h3>
                    <a href="{{ route('admin.payments.index') }}" class="text-[13px] font-semibold text-[#3723db]">View all</a>
                </div>
                <div class="mt-5 space-y-3">
                    @forelse ($recent_payments as $payment)
                        <div class="rounded-2xl border border-gray-100 px-4 py-3">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0">
                                    <p class="text-[13px] font-semibold text-[#3723db]">{{ $payment['type'] }}</p>
                                    <p class="mt-1 truncate text-[14px] font-bold text-[#0B132C]">{{ $payment['customer'] }}</p>
                                    <p class="mt-1 truncate text-[13px] text-gray-500">{{ $payment['item'] }}</p>
                                </div>
                                <div class="shrink-0 sm:text-right">
                                    <p class="text-[15px] font-bold text-[#0B132C]">{{ $payment['amount'] }}</p>
                                    <p class="mt-1 text-[12px] text-gray-500">{{ $payment['status'] }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-[13px] text-gray-500">No payments recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-[18px] font-bold text-[#0B132C]">Platform Summary</h3>
                <div class="mt-5 space-y-3">
                    @foreach ($stats as $label => $value)
                        <div class="flex items-center justify-between rounded-2xl bg-[#F8F9FC] px-4 py-3">
                            <span class="text-[14px] text-gray-600">{{ ucwords(str_replace('_', ' ', $label)) }}</span>
                            <strong class="text-[#0B132C]">{{ $value }}</strong>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-[18px] font-bold text-[#0B132C]">Recent Companies</h3>
                    <a href="{{ route('admin.companies.index') }}" class="text-[13px] font-semibold text-[#3723db]">View all</a>
                </div>
                <div class="mt-5 space-y-4">
                    @forelse ($recent_companies as $company)
                        <div class="rounded-2xl border border-gray-100 px-4 py-3">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="text-[15px] font-bold text-[#0B132C]">{{ $company['name'] }}</p>
                                    <p class="mt-1 text-[13px] text-gray-500">{{ $company['contact'] }} · {{ $company['email'] }}</p>
                                </div>
                                <span class="inline-flex shrink-0 rounded-full px-3 py-1 text-[12px] font-semibold {{ $company['status_class'] }}">{{ $company['status'] }}</span>
                            </div>
                            <p class="mt-3 text-[12px] text-gray-400">Registered {{ $company['registered_on'] }}</p>
                        </div>
                    @empty
                        <p class="text-[13px] text-gray-500">No companies registered yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
