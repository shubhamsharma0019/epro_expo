@extends('layouts.admin')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')
    <section class="space-y-6 px-5 py-6 sm:px-8">
        <div>
            <h2 class="text-[28px] font-bold text-[#0B132C]">Reports & Insights</h2>
            <p class="mt-2 text-[14px] text-gray-500">High-level performance snapshot across companies, events, visitors, and revenue.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach (($stat_cards ?? []) as $card)
                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-[12px] font-semibold uppercase tracking-[0.14em] text-gray-400">{{ $card['label'] }}</p>
                    <p class="mt-3 text-[28px] font-bold text-[#0B132C]">{{ $card['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-[18px] font-bold text-[#0B132C]">Platform Summary</h3>
                <div class="mt-5 space-y-3">
                    @foreach (($stats ?? []) as $label => $value)
                        <div class="flex items-center justify-between rounded-2xl bg-[#F8F9FC] px-4 py-3">
                            <span class="text-[14px] text-gray-600">{{ ucwords(str_replace('_', ' ', $label)) }}</span>
                            <strong class="text-[#0B132C]">{{ $value }}</strong>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-[18px] font-bold text-[#0B132C]">Recent Company Activity</h3>
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
        </div>
    </section>
@endsection
