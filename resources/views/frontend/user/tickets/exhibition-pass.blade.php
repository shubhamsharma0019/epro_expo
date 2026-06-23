@extends('layouts.user')

@section('title', 'Exhibition Pass')
@section('page-title', 'Exhibition Pass')

@section('content')
@php
    $exhibitionName = $pass->exhibition->title ?? $pass->exhibition->name ?? 'Exhibition';
    $dateInfo = $pass->exhibition?->start_date?->format('M d, Y') ?? 'Date TBD';
    $qrData = urlencode($pass->booking_id . '|' . $exhibitionName . '|' . $pass->email);
@endphp

<section class="space-y-6 px-4 py-6 sm:px-8">
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <article class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="grid lg:grid-cols-[1fr_260px]">
                <div class="bg-gradient-to-br from-[#0B132C] via-[#1A2A78] to-[#3723db] p-6 text-white sm:p-8">
                    <span class="inline-flex rounded-full bg-white/12 px-4 py-2 text-[12px] font-semibold uppercase tracking-[0.12em] text-white/80">Exhibition Pass</span>
                    <h1 class="mt-6 text-[28px] font-bold leading-tight sm:text-[36px]">{{ $exhibitionName }}</h1>
                    <p class="mt-3 text-[14px] leading-7 text-white/75">Present this pass at the exhibition entry desk for verification.</p>
                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/14 bg-white/10 p-4">
                            <p class="text-[12px] text-white/60">Pass ID</p>
                            <p class="mt-2 font-mono text-[15px] font-semibold">{{ $pass->booking_id }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/14 bg-white/10 p-4">
                            <p class="text-[12px] text-white/60">Date</p>
                            <p class="mt-2 text-[15px] font-semibold">{{ $dateInfo }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-center justify-center border-t border-dashed border-gray-200 bg-[#F8F9FC] p-6 text-center lg:border-l lg:border-t-0">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&margin=12&data={{ $qrData }}" alt="Exhibition pass QR code" class="h-[180px] w-[180px] rounded-xl bg-white p-2 shadow-sm" />
                    <p class="mt-4 text-[12px] font-semibold uppercase tracking-[0.14em] text-gray-400">Visitor Pass</p>
                    <p class="mt-2 font-mono text-[15px] font-bold text-[#0B132C]">{{ $pass->booking_id }}</p>
                </div>
            </div>
        </article>

        <aside class="space-y-4">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-[18px] font-bold text-[#0B132C]">Visitor Details</h2>
                <div class="mt-5 space-y-3 text-[14px] text-gray-600">
                    <p class="ticket-detail-row flex justify-between gap-4"><span>Name</span><strong class="text-[#0B132C]">{{ trim($pass->first_name . ' ' . $pass->last_name) ?: auth()->user()->name }}</strong></p>
                    <p class="ticket-detail-row flex justify-between gap-4"><span>Email</span><strong class="break-all text-[#0B132C]">{{ $pass->email }}</strong></p>
                    <p class="ticket-detail-row flex justify-between gap-4"><span>Status</span><strong class="text-emerald-700">{{ $pass->payment_status === 'completed' ? 'Confirmed' : ucfirst($pass->payment_status) }}</strong></p>
                </div>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="grid gap-3">
                    @if ($pass->exhibition?->slug)
                        <a href="{{ route('exhibitions.visit', $pass->exhibition->slug) }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#3723db] px-5 text-[13px] font-semibold text-white transition hover:bg-[#2b1bb8]">Enter Exhibition Lobby</a>
                    @endif
                    <a href="{{ route('frontend.user.tickets.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-200 px-5 text-[13px] font-semibold text-[#0B132C] transition hover:bg-gray-50">Back to My Passes</a>
                </div>
            </div>
        </aside>
    </div>
</section>
@endsection
