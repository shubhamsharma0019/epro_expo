@extends('layouts.exhibition')

@section('title', 'Hall Details - EproExpo')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')

@php
    $hallTitle = $hall?->title ?? str($hallSlug ?? '')->replace('-', ' ')->title();
    $hallDescription = $hall?->description ?: 'Browse companies, booth activity, product demos and floor map highlights inside this hall.';
@endphp

<section class="visitor-flow-page bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1500px]">
        <div class="grid gap-6 rounded-[20px] border border-[#E7EAF3] bg-white p-6 shadow-[0_14px_34px_rgba(7,16,68,0.07)] lg:grid-cols-[1fr_420px] lg:p-8">
            <div class="min-w-0">
                <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Hall details</p>
                <h1 class="mt-3 text-[38px] font-bold text-[#071044]">{{ $hallTitle }}</h1>
                <p class="mt-4 max-w-[760px] text-[16px] font-medium leading-7 text-[#5A6480]">{{ $hallDescription }}</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('exhibitions.visitor.companies', $slug) }}" class="inline-flex h-11 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[14px] font-bold text-white">View Companies</a>
                    <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}{{ $hall ? '?hall='.$hall->id : '' }}" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#E7EAF3] bg-white px-5 text-[14px] font-bold text-[#071044]">Floor Map</a>
                </div>
            </div>
            <aside class="rounded-[16px] bg-[#FBFAFF] p-5">
                <h2 class="text-[18px] font-bold text-[#071044]">Hall snapshot</h2>
                <ul class="mt-4 space-y-3 text-[14px] font-medium text-[#5A6480]">
                    <li><strong class="text-[#071044]">{{ $featuredBooths->count() }}</strong> active booths listed</li>
                    <li><strong class="text-[#071044]">{{ $hallSessions->count() }}</strong> upcoming sessions</li>
                    <li>Pavilion: <strong class="text-[#071044]">{{ $hall?->pavilion?->name ?? '—' }}</strong></li>
                </ul>
            </aside>
        </div>

        <div class="mt-7 grid gap-6 lg:grid-cols-[1fr_360px]">
            <div>
                <h2 class="text-[24px] font-bold text-[#071044]">Featured companies</h2>
                <div class="mt-5 grid gap-4 md:grid-cols-2">
                    @forelse ($featuredBooths as $booking)
                        @php
                            $companyName = $booking->boothProfile?->company_name
                                ?: $booking->company?->company_name
                                ?: $booking->company?->name
                                ?: 'Company';
                            $companySlugItem = \Illuminate\Support\Str::slug($companyName);
                            $copy = $booking->boothProfile?->tagline
                                ?: $booking->boothProfile?->about_company
                                ?: 'Explore products, catalogues and live sessions.';
                        @endphp
                        <div class="visitor-flow-card">
                            <div class="flex items-start gap-4">
                                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-[#F4F0FF] text-[18px] font-bold text-[#5b2eff]">{{ substr($companyName, 0, 1) }}</div>
                                <div class="min-w-0">
                                    <h3 class="text-[18px] font-bold text-[#071044]">{{ $companyName }}</h3>
                                    <p class="mt-2 text-[13px] font-medium leading-5 text-[#5A6480]">{{ \Illuminate\Support\Str::limit($copy, 120) }}</p>
                                </div>
                            </div>
                            <a href="{{ route('exhibitions.visitor.companies.show', [$slug, $companySlugItem]) }}" class="mt-4 inline-flex h-10 items-center justify-center rounded-lg bg-[#F4F0FF] px-4 text-[13px] font-bold text-[#5b2eff]">Visit Booth</a>
                        </div>
                    @empty
                        <div class="visitor-flow-empty md:col-span-2">
                            <p class="text-[15px] font-semibold text-[#071044]">No booths in this hall yet</p>
                            <p class="mt-2 text-[14px] text-[#5A6480]">Published exhibitor booths will appear here automatically.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <aside class="visitor-flow-card h-fit">
                <h2 class="text-[20px] font-bold text-[#071044]">Hall activity</h2>
                <div class="mt-5 space-y-3">
                    @forelse ($hallSessions as $session)
                        <div class="rounded-[12px] bg-[#FBFAFF] p-4">
                            <p class="text-[13px] font-bold text-[#5b2eff]">{{ $session->status === 'live' ? 'Live now' : 'Upcoming' }}</p>
                            <p class="mt-1 text-[14px] font-medium text-[#5A6480]">{{ $session->title }}</p>
                        </div>
                    @empty
                        <p class="text-[14px] font-medium text-[#5A6480]">No live sessions scheduled in this hall right now.</p>
                    @endforelse
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
