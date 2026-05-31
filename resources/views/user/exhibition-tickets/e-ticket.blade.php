@extends('layouts.user')

@section('title', 'Exhibition E-Ticket')
@section('page-title', 'Exhibition E-Ticket')

@section('content')
<section class="min-w-0 px-5 py-6 sm:px-8 lg:px-10 lg:py-8">
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <article class="overflow-hidden rounded-[30px] border border-[#E7EAF3] bg-white shadow-[0_22px_60px_rgba(7,16,68,0.08)]">
            <div class="relative min-h-[220px] bg-[#071044] p-8 text-white sm:p-10">
                <div class="absolute inset-0 opacity-35" style="background-image: radial-gradient(circle at 22% 20%, rgba(91,46,255,.9), transparent 34%), radial-gradient(circle at 84% 8%, rgba(36,107,255,.75), transparent 28%);"></div>
                <div class="relative">
                    <span class="inline-flex rounded-full bg-white/12 px-4 py-2 text-[12px] font-medium uppercase tracking-[0.12em] text-white/80">Visitor Access</span>
                    <h1 class="mt-8 max-w-[620px] text-[32px] font-medium leading-tight sm:text-[42px]">Global Tech Expo 2024</h1>
                    <p class="mt-4 max-w-[560px] text-[15px] leading-7 text-white/74">Explore halls, save booths, and scan this ticket at the visitor counter for entry validation.</p>
                </div>
            </div>

            <div class="grid gap-0 lg:grid-cols-[280px_1fr]">
                <div class="flex flex-col items-center justify-center border-b border-dashed border-[#D8DDF0] bg-[#F8FAFF] p-8 text-center lg:border-b-0 lg:border-r">
                    <x-shared.qr-ticket-card
                        src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&margin=12&data=EXV-240516-000456%7CGlobal-Tech-Expo-2024%7CUnknown-User"
                        alt="Exhibition ticket QR code"
                        size-class="h-[150px] w-[150px]"
                        card-class="px-5 pb-6 pt-5"
                    />
                    <p class="mt-5 text-[12px] font-medium uppercase tracking-[0.16em] text-[#5A6480]">Ticket ID</p>
                    <p class="mt-2 text-[17px] font-medium text-[#071044]">EXV-240516-000456</p>
                </div>

                <div class="p-8 sm:p-10">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-[#E7EAF3] bg-white p-5">
                            <p class="text-[12px] text-[#5A6480]">Date Range</p>
                            <p class="mt-2 text-[16px] font-medium text-[#071044]">May 24 - 27, 2026</p>
                        </div>
                        <div class="rounded-2xl border border-[#E7EAF3] bg-white p-5">
                            <p class="text-[12px] text-[#5A6480]">Venue</p>
                            <p class="mt-2 text-[16px] font-medium text-[#071044]">Expo Center, Delhi</p>
                        </div>
                        <div class="rounded-2xl border border-[#E7EAF3] bg-white p-5">
                            <p class="text-[12px] text-[#5A6480]">Pass Type</p>
                            <p class="mt-2 text-[16px] font-medium text-[#071044]">4 Day Visitor</p>
                        </div>
                        <div class="rounded-2xl border border-[#E7EAF3] bg-white p-5">
                            <p class="text-[12px] text-[#5A6480]">Access</p>
                            <p class="mt-2 text-[16px] font-medium text-emerald-700">All Public Halls</p>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl bg-[#F4F0FF] p-5">
                        <p class="text-[13px] font-medium text-[#5b2eff]">Recommended next step</p>
                        <p class="mt-2 text-[14px] leading-6 text-[#34405F]">Open the exhibition visitor flow, shortlist booths, and plan your hall route before arrival.</p>
                    </div>
                </div>
            </div>
        </article>

        <aside class="space-y-5">
            <div class="rounded-[26px] border border-[#E7EAF3] bg-white p-6 shadow-[0_16px_42px_rgba(7,16,68,0.06)]">
                <h2 class="text-[18px] font-medium text-[#071044]">Visitor</h2>
                <div class="mt-5 flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F4F0FF] text-[18px] font-medium text-[#5b2eff]">US</div>
                    <div class="min-w-0">
                        <p class="truncate text-[15px] font-medium text-[#071044]">Unknown User</p>
                        <p class="truncate text-[13px] text-[#5A6480]">unknown@gmail.com</p>
                    </div>
                </div>
                <div class="mt-6 space-y-3 text-[14px] text-[#34405F]">
                    <p class="flex justify-between gap-4"><span>Saved booths</span><strong class="font-medium text-[#071044]">14</strong></p>
                    <p class="flex justify-between gap-4"><span>Meetings</span><strong class="font-medium text-[#071044]">3 booked</strong></p>
                    <p class="flex justify-between gap-4"><span>Status</span><strong class="font-medium text-emerald-700">Confirmed</strong></p>
                </div>
            </div>

            <div class="rounded-[26px] border border-[#E7EAF3] bg-white p-6 shadow-[0_16px_42px_rgba(7,16,68,0.06)]">
                <h2 class="text-[18px] font-medium text-[#071044]">Actions</h2>
                <div class="mt-5 grid gap-3">
                    <a href="{{ url('/exhibitions/global-tech-expo/visit') }}" class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[14px] font-medium text-white shadow-[0_14px_30px_rgba(91,46,255,0.25)]">
                        <i class="fa-solid fa-arrow-right"></i> Enter Exhibition
                    </a>
                    <a href="{{ url('/user/exhibition-tickets') }}" class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl border border-[#E7EAF3] bg-white px-5 text-[14px] font-medium text-[#071044]">
                        <i class="fa-solid fa-arrow-left"></i> Back to Tickets
                    </a>
                </div>
            </div>
        </aside>
    </div>
</section>
@endsection
