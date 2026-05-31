@extends('layouts.frontend')

@section('title', 'QR Visitor Pass - EproExpo')

@section('content')
@php
    $exhibition = \App\Models\Exhibition::where('slug', $slug)->first();
    $exhTitle = $exhibition ? ($exhibition->title ?: $exhibition->name) : 'Global Tech Expo 2026';
    
    $allVisitors = $exhibition ? \App\Models\Visitor::where('exhibition_id', $exhibition->id)->orderBy('created_at', 'desc')->get() : collect();
    
    $bookingIdParam = request()->query('booking_id');
    if ($bookingIdParam && $allVisitors->isNotEmpty()) {
        $allVisitors = $allVisitors->sortByDesc(function ($v) use ($bookingIdParam) {
            return $v->booking_id === $bookingIdParam;
        })->values();
    }
@endphp
<section class="bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="space-y-8">
        @forelse ($allVisitors as $v)
            @php
                $bookingId = $v->booking_id;
                $attendeeName = trim($v->first_name . ' ' . $v->last_name) ?: 'Guest';
                $passType = $v->pass_type ?: 'Free Visitor Pass';
                $dateStr = ($exhibition && $exhibition->start_date && $exhibition->end_date)
                    ? $exhibition->start_date->format('M d') . ' - ' . $exhibition->end_date->format('d, Y')
                    : 'June 12 - June 14, 2026';
                $location = $exhibition ? ($exhibition->venue ?: ($exhibition->location ?: 'Virtual Lobby')) : 'Virtual Lobby';
                $qrData = "EXP-TKT-" . $bookingId . "|" . str_replace(' ', '-', $exhTitle) . "|" . str_replace(' ', '-', $passType) . "|" . str_replace(' ', '-', $attendeeName);
            @endphp
            
            <div class="mx-auto grid max-w-[1200px] gap-6 rounded-[22px] border border-[#E7EAF3] bg-white p-6 shadow-[0_18px_44px_rgba(7,16,68,0.08)] lg:grid-cols-[330px_1fr] lg:p-8">
                <div class="rounded-[18px] bg-gradient-to-br from-[#071044] to-[#5b2eff] p-6 text-white flex flex-col justify-between">
                    <div>
                        <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-white/70">QR visitor pass</p>
                        <div class="mt-5">
                            <x-shared.qr-ticket-card
                                src="https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=14&data={{ urlencode($qrData) }}"
                                alt="Exhibition visitor QR code"
                                size-class="h-[210px] w-[210px]"
                                card-class="w-full"
                            />
                        </div>
                    </div>
                    <p class="mt-4 text-[13px] font-medium text-white/76">Scan this code at the lobby entry gate and inside protected visitor areas.</p>
                </div>

                <div class="min-w-0">
                    <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Active visitor pass</p>
                    <h1 class="mt-3 text-[34px] font-bold text-[#071044]">{{ $exhTitle }}</h1>
                    <div class="mt-6 grid gap-4 text-[14px] font-medium text-[#34405F] sm:grid-cols-2">
                        @foreach ([
                            ['Pass ID', $bookingId],
                            ['Visitor', $attendeeName],
                            ['Pass type', $passType],
                            ['Date/time', $dateStr],
                            ['Venue', $location],
                            ['Access', 'Lobby, companies, halls, booths, sessions']
                        ] as [$label, $value])
                            <p class="rounded-[12px] bg-[#FBFAFF] p-4 {{ $label === 'Access' || $label === 'Venue' ? 'sm:col-span-2' : '' }}">
                                <span class="block text-[12px] font-bold uppercase tracking-[0.08em] text-[#5A6480]">{{ $label }}</span>
                                <span class="mt-1 block font-bold text-[#071044]">{{ $value }}</span>
                            </p>
                        @endforeach
                    </div>
                    <div class="mt-5 rounded-[14px] border border-[#E7EAF3] bg-[#F8F7FF] p-5">
                        <h2 class="text-[18px] font-bold text-[#071044]">Entry instructions</h2>
                        <p class="mt-2 text-[14px] font-medium leading-6 text-[#34405F]">Keep this QR pass ready. You can enter the exhibition lobby, browse companies and halls, visit booths, book meetings, chat, download brochures and join sessions.</p>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('exhibitions.visit', ['slug' => $slug, 'booking_id' => $bookingId]) }}" class="inline-flex h-12 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-7 text-[14px] font-bold text-white">Enter Exhibition</a>
                        <a href="{{ route('exhibitions.visitor.dashboard', ['slug' => $slug, 'booking_id' => $bookingId]) }}" class="inline-flex h-12 items-center justify-center rounded-lg border border-[#E7EAF3] bg-white px-7 text-[14px] font-bold text-[#071044]">Visitor Dashboard</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="mx-auto grid max-w-[1200px] gap-6 rounded-[22px] border border-[#E7EAF3] bg-white p-6 shadow-[0_18px_44px_rgba(7,16,68,0.08)] lg:grid-cols-[330px_1fr] lg:p-8">
                <div class="rounded-[18px] bg-gradient-to-br from-[#071044] to-[#5b2eff] p-6 text-white">
                    <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-white/70">QR visitor pass</p>
                    <div class="mt-5">
                        <x-shared.qr-ticket-card
                            src="https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=14&data=EXP-TKT-20486%7CGlobal-Tech-Expo-2026%7CBusiness-Pass%7CJohn-Doe"
                            alt="Exhibition visitor QR code"
                            size-class="h-[210px] w-[210px]"
                            card-class="w-full"
                        />
                    </div>
                    <p class="mt-4 text-[13px] font-medium text-white/76">Scan this code at the lobby entry gate and inside protected visitor areas.</p>
                </div>

                <div class="min-w-0">
                    <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Active visitor pass</p>
                    <h1 class="mt-3 text-[34px] font-bold text-[#071044]">Global Tech Expo 2026</h1>
                    <div class="mt-6 grid gap-4 text-[14px] font-medium text-[#34405F] sm:grid-cols-2">
                        @foreach ([['Pass ID', 'EXP-TKT-20486'], ['Visitor', 'John Doe'], ['Pass type', 'Business Pass'], ['Date/time', 'June 12, 2026 | 10:00 AM'], ['Venue', 'Virtual Lobby + New Delhi Partner Venue'], ['Access', 'Lobby, companies, halls, booths, sessions']] as [$label, $value])
                            <p class="rounded-[12px] bg-[#FBFAFF] p-4 {{ $label === 'Access' || $label === 'Venue' ? 'sm:col-span-2' : '' }}">
                                <span class="block text-[12px] font-bold uppercase tracking-[0.08em] text-[#5A6480]">{{ $label }}</span>
                                <span class="mt-1 block font-bold text-[#071044]">{{ $value }}</span>
                            </p>
                        @endforeach
                    </div>
                    <div class="mt-5 rounded-[14px] border border-[#E7EAF3] bg-[#F8F7FF] p-5">
                        <h2 class="text-[18px] font-bold text-[#071044]">Entry instructions</h2>
                        <p class="mt-2 text-[14px] font-medium leading-6 text-[#34405F]">Keep this QR pass ready. You can enter the exhibition lobby, browse companies and halls, visit booths, book meetings, chat, download brochures and join sessions.</p>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('exhibitions.visit', $slug) }}" class="inline-flex h-12 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-7 text-[14px] font-bold text-white">Enter Exhibition</a>
                        <a href="{{ route('exhibitions.visitor.dashboard', $slug) }}" class="inline-flex h-12 items-center justify-center rounded-lg border border-[#E7EAF3] bg-white px-7 text-[14px] font-bold text-[#071044]">Visitor Dashboard</a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</section>
@endsection
