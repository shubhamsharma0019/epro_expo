@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <section class="space-y-6 px-5 py-6 sm:px-8">
        <div class="rounded-3xl bg-[#0B132C] px-6 py-7 text-white">
            <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-white/60">{{ $date_range ?? now()->format('M d, Y') }}</p>
            <h2 class="mt-3 text-[30px] font-bold">{{ $header['title'] ?? 'Welcome back, Admin' }}</h2>
            <p class="mt-2 max-w-2xl text-[14px] text-white/70">{{ $header['subtitle'] ?? 'Platform snapshot for the admin team.' }}</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach (($stat_cards ?? []) as $card)
                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-[12px] font-semibold uppercase tracking-[0.14em] text-gray-400">{{ $card['label'] }}</p>
                    <p class="mt-3 text-[28px] font-bold text-[#0B132C]">{{ $card['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.3fr,0.7fr]">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-[18px] font-bold text-[#0B132C]">Recent Companies</h3>
                        <p class="mt-1 text-[13px] text-gray-500">Latest registrations and approval state.</p>
                    </div>
                    <a href="{{ url('/admin/companies') }}" class="text-[13px] font-semibold text-[#3723db]">View all</a>
                </div>

                <div class="mt-5 space-y-4">
                    @foreach (($recent_companies ?? collect()) as $company)
                        <div class="rounded-2xl border border-gray-100 px-4 py-3">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[15px] font-bold text-[#0B132C]">{{ $company['name'] }}</p>
                                    <p class="mt-1 text-[13px] text-gray-500">{{ $company['contact'] }}</p>
                                </div>
                                <span class="inline-flex rounded-full px-3 py-1 text-[12px] font-semibold {{ $company['status_class'] }}">
                                    {{ $company['status'] }}
                                </span>
                            </div>
                            <p class="mt-3 text-[12px] text-gray-400">Registered {{ $company['registered_on'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-[18px] font-bold text-[#0B132C]">Quick Actions</h3>
                    <div class="mt-5 grid gap-3">
                        @foreach (($quick_actions ?? []) as $action)
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
                    <h3 class="text-[18px] font-bold text-[#0B132C]">Approvals Queue</h3>
                    <div class="mt-5 space-y-3 text-[14px]">
                        <div class="flex items-center justify-between rounded-2xl bg-[#F8F9FC] px-4 py-3">
                            <span>Booth Bookings Pending</span>
                            <strong>{{ $pendingBookingsCount ?? 0 }}</strong>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-[#F8F9FC] px-4 py-3">
                            <span>Booth Setup Reviews</span>
                            <strong>{{ $pendingApprovalsCount ?? 0 }}</strong>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-[#F8F9FC] px-4 py-3">
                            <span>Event Publish Reviews</span>
                            <strong>{{ $pendingEventApprovalsCount ?? 0 }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
