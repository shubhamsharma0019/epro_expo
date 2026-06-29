@extends('layouts.exhibition')

@section('title', 'Exhibition Lobby - EproExpo')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')

<section class="visitor-flow-page bg-[#FBFAFF] px-4 py-6 sm:px-8 sm:py-8 lg:px-10">
    <div class="mx-auto max-w-[1500px] visitor-flow-grid-safe">
        <div class="relative grid gap-6 overflow-hidden rounded-[22px] bg-[#0A0D26] p-5 text-white shadow-[0_18px_44px_rgba(7,16,68,0.16)] sm:p-7 lg:grid-cols-[1fr_420px] lg:p-8">
            <div class="absolute inset-0 bg-cover bg-center opacity-80 z-0" style="background-image: url('{{ $bannerImage }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-[#0A0D26]/92 via-[#0A0D26]/82 to-[#0A0D26]/72 lg:bg-gradient-to-r lg:from-[#0A0D26]/96 lg:via-[#0A0D26]/82 lg:to-[#0A0D26]/38 z-0"></div>

            <div class="min-w-0 relative z-10">
                <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-indigo-200">Visitor lobby</p>
                <h1 class="mt-3 max-w-[760px] text-[28px] font-bold leading-tight tracking-[-0.03em] sm:text-[40px] lg:text-[52px]">{{ $exhibitionName }}</h1>
                <p class="mt-4 max-w-[700px] text-[15px] font-medium leading-7 text-white/76">{{ $exhibitionDesc }}</p>
                <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                    <a href="{{ route('exhibitions.visitor.companies', $slug) }}" class="visitor-flow-btn inline-flex h-12 w-full items-center justify-center rounded-lg bg-white px-6 text-[14px] font-bold text-[#5b2eff] shadow transition-colors hover:bg-gray-50 sm:w-auto">View Companies</a>
                    <a href="{{ route('exhibitions.visitor.floor-map', $slug) }}" class="visitor-flow-btn inline-flex h-12 w-full items-center justify-center rounded-lg border border-white/35 px-6 text-[14px] font-bold text-white transition-colors hover:bg-white/10 sm:w-auto">Floor Map</a>
                    <a href="{{ $passAction['href'] }}" class="visitor-flow-btn inline-flex h-12 w-full items-center justify-center rounded-lg border border-white/35 px-6 text-[14px] font-bold text-white transition-colors hover:bg-white/10 sm:w-auto">{{ $passAction['label'] }}</a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 relative z-10">
                <div class="col-span-2 rounded-[14px] border border-white/15 bg-white p-5 text-[#071044] shadow-sm">
                    <p class="text-[12px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Visitor Pass</p>
                    <p class="mt-2 text-[20px] font-bold">{{ $isPassActive ? $passName . ' active' : 'No active pass' }}</p>
                    <p class="mt-1 text-[13px] font-medium text-[#5A6480]">
                        {{ $isPassActive ? 'Use your QR pass for halls, meetings, sessions and protected booth content.' : 'Get your visitor pass to unlock QR access for this exhibition.' }}
                    </p>
                </div>
                @foreach ($heroStats as [$value, $label])
                    <div class="rounded-[14px] border border-white/15 bg-white/10 p-5 backdrop-blur shadow-sm">
                        <p class="text-[28px] font-bold">{{ $value }}</p>
                        <p class="mt-1 text-[13px] font-medium text-white/70">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-7 grid grid-cols-1 gap-4 rounded-[16px] border border-[#E7EAF3] bg-white p-4 shadow-[0_8px_22px_rgba(7,16,68,0.05)] sm:grid-cols-2 sm:p-5 lg:grid-cols-3 xl:grid-cols-5">
            @foreach ($lobbyEssentials as [$label, $value, $href, $icon])
                <a href="{{ $href }}" class="flex min-h-[92px] items-center gap-3 rounded-[12px] bg-[#FBFAFF] p-4 transition hover:bg-[#F4F0FF]">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-[12px] bg-white text-[#5b2eff] shadow-sm">
                        <i class="{{ $icon }}"></i>
                    </span>
                    <div class="min-w-0">
                        <p class="text-[13px] font-bold text-[#5b2eff]">{{ $label }}</p>
                        <p class="mt-1 text-[14px] font-bold text-[#071044]">{{ $value }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-7 grid gap-6 lg:grid-cols-[minmax(0,1fr)_380px]">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                @foreach ($lobbyCards as [$title, $copy, $href])
                    <article class="visitor-flow-card flex flex-col justify-between rounded-[16px] p-5 sm:p-6">
                        <div>
                            <h2 class="text-[20px] font-bold text-[#071044]">{{ $title }}</h2>
                            <p class="mt-3 text-[14px] font-medium leading-6 text-[#5A6480]">{{ $copy }}</p>
                        </div>
                        <a href="{{ $href }}" class="mt-5 inline-flex h-10 items-center justify-center rounded-lg bg-[#F4F0FF] px-4 text-[13px] font-bold text-[#5b2eff] w-fit hover:bg-[#6D28D9] hover:text-white transition-colors">Open</a>
                    </article>
                @endforeach
            </div>

            <aside class="rounded-[16px] border border-[#E7EAF3] bg-white p-6 shadow-[0_8px_22px_rgba(7,16,68,0.05)]">
                <h2 class="text-[20px] font-bold text-[#071044]">{{ $liveBooths->isNotEmpty() ? 'Live booths' : 'Live now' }}</h2>
                <div class="mt-5 space-y-4">
                    @forelse ($liveBooths as $booking)
                        @php
                            $companyName = $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name;
                            $companySlug = \Illuminate\Support\Str::slug($companyName);
                        @endphp
                        <a href="{{ route('exhibitions.booths.show', [$slug, $companySlug]) }}" class="block rounded-[12px] bg-[#FBFAFF] p-4 transition hover:bg-[#F4F0FF]">
                            <p class="text-[13px] font-bold text-[#5b2eff]">{{ $companyName }}</p>
                            <p class="mt-1 text-[14px] font-medium text-[#34405F]">
                                {{ $booking->hall?->title ?: 'Hall' }}@if($booking->booth?->booth_number) / Booth {{ $booking->booth->booth_number }}@endif
                            </p>
                            <p class="mt-2 text-[12px] font-bold text-[#0A7A58]">{{ $booking->published_products_count ?? 0 }} products live</p>
                        </a>
                    @empty
                        <div class="visitor-flow-empty">
                            <p class="text-[14px] font-semibold text-[#071044]">No live booths yet</p>
                            <p class="mt-2 text-[13px] font-medium text-[#5A6480]">Published exhibitor booths will appear here when available in the database.</p>
                        </div>
                    @endforelse
                </div>
            </aside>
        </div>

        @include('frontend.visitor-exhibition.booths.partials.quick-links', [
            'quickLinks' => \App\Support\ExhibitionQuickLinks::lobbyLinks($slug),
            'quickLinksSectionClass' => 'mt-7',
        ])
    </div>
</section>
@endsection
