@extends('layouts.exhibition')

@section('title', 'Visitor Dashboard - EproExpo')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')
@php
    $slug = $slug ?? '';
    $exhibition = $exhibition ?? null;
    $visitor = $visitor ?? null;
    $isPassActive = $isPassActive ?? ($visitor ? $visitor->payment_status === 'completed' : false);
    $exhTitle = $exhibition ? ($exhibition->title ?: $exhibition->name) : 'Exhibition';
    $passId = $visitor?->booking_id ?? '—';
    $dateStr = ($exhibition && $exhibition->start_date && $exhibition->end_date)
        ? $exhibition->start_date->format('M d') . ' - ' . $exhibition->end_date->format('d, Y')
        : 'Date TBD';
    $visitorName = auth()->check()
        ? str(auth()->user()->name)->before(' ')->toString()
        : ($visitor?->first_name ?: 'Guest');
    $meetingsCount = $meetingsCount ?? 0;
    $sessionsJoinedCount = $sessionsJoinedCount ?? 0;
    $recommendedCompanies = $recommendedCompanies ?? collect();
    $todaySessions = $todaySessions ?? collect();
    $unreadNotificationsCount = $unreadNotificationsCount ?? 0;
    $quickActions = [
        ['label' => 'Explore Companies', 'href' => $slug ? route('exhibitions.visitor.companies', $slug) : '#', 'icon' => 'fa-solid fa-store'],
        ['label' => 'My Meetings', 'href' => $slug ? route('exhibitions.visitor.meetings', $slug) : '#', 'icon' => 'fa-regular fa-calendar-check'],
        ['label' => 'QR Pass', 'href' => $slug ? route('exhibitions.visitor.qr-pass', $slug) : '#', 'icon' => 'fa-solid fa-qrcode'],
    ];
    $visitorAccessItems = [
        ['label' => 'Pass Status', 'value' => $isPassActive ? 'Active' : 'Inactive'],
        ['label' => 'Unread Notifications', 'value' => (string) $unreadNotificationsCount],
        ['label' => 'Protected Tools', 'value' => $isPassActive ? 'Unlocked' : 'Locked'],
    ];
@endphp

<div class="visitor-flow-page bg-[#F8F9FC] px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
    <div class="mx-auto max-w-[1400px] visitor-flow-grid-safe">
        @if (session('exhibition_booking_path') && !$isPassActive)
            <div class="mb-6 rounded-2xl border border-indigo-100 bg-indigo-50 p-5 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h4 class="text-[16px] font-bold text-indigo-900">Continue your pass booking</h4>
                    <p class="text-sm text-indigo-700 mt-1">You were in the middle of getting a visitor pass. Click the button to resume.</p>
                </div>
                <a href="{{ session('exhibition_booking_path') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#5A42E9] px-5 text-[13px] font-bold text-white shadow-sm hover:bg-[#4931D8] transition whitespace-nowrap">
                    Continue Booking
                </a>
            </div>
        @endif

        <div class="mb-8">
            <h1 class="mb-2 text-[26px] font-extrabold leading-tight tracking-[-0.02em] text-[#020A2D] sm:text-[34px]">Welcome back, {{ $visitorName }}!</h1>
            <p class="text-[16px] font-medium text-[#52607A]">Your visitor pass, saved booths, meetings and sessions are ready for the exhibition.</p>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="min-h-[210px] rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_1px_3px_rgba(15,23,42,0.08)] transition-shadow hover:shadow-md">
                <div class="mb-4 flex items-center justify-between gap-4">
                    <p class="text-[14px] font-semibold text-[#020A2D]">Active Visitor Pass</p>
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#F4F0FF] text-[#5A42E9]"><i class="fa-solid fa-ticket text-[24px]"></i></div>
                </div>
                <h3 class="mb-3 max-w-[180px] text-[21px] font-extrabold leading-[1.18] text-[#020A2D]">{{ $exhTitle }}</h3>
                <div class="space-y-1.5 text-[13px] font-semibold leading-5 text-[#52607A]">
                    <p class="{{ $isPassActive ? 'text-[#10B981]' : 'text-[#FF8A00]' }}">{{ $isPassActive ? 'Pass active' : 'Guest preview' }}</p>
                    <p class="break-words">Visitor ID: {{ $passId }}</p>
                    <p>{{ $dateStr }}</p>
                    @if (!$isPassActive)
                        <div class="mt-4">
                            <a href="{{ route('exhibitions.tickets.select', $slug) }}" class="inline-flex items-center justify-center rounded-lg bg-[#5A42E9] px-4 py-2 text-xs font-bold text-white shadow-sm hover:bg-[#4931D8]">
                                Continue Booking Flow
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex min-h-[210px] flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_1px_3px_rgba(15,23,42,0.08)] transition-shadow hover:shadow-md">
                <div class="mb-10 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EFF2FF] text-[#3B66FF]"><i class="fa-regular fa-calendar-check text-[28px]"></i></div>
                <div><h3 class="mb-1 text-[26px] font-extrabold text-[#020A2D]">{{ number_format($meetingsCount) }}</h3><p class="text-[14px] font-medium text-[#52607A]">Meetings</p></div>
            </div>

            <div class="flex min-h-[210px] flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-[0_1px_3px_rgba(15,23,42,0.08)] transition-shadow hover:shadow-md">
                <div class="mb-10 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#FFF5E6] text-[#FF8A00]"><i class="fa-regular fa-circle-play text-[28px]"></i></div>
                <div><h3 class="mb-1 text-[26px] font-extrabold text-[#020A2D]">{{ number_format($sessionsJoinedCount) }}</h3><p class="text-[14px] font-medium text-[#52607A]">Sessions Joined</p></div>
            </div>
        </div>

        <div class="mb-8">
            <h2 class="mb-4 text-[17px] font-bold text-[#0B132C]">Quick Actions</h2>
            <div class="flex flex-wrap gap-3">
                @foreach ($quickActions as $action)
                    <a href="{{ $action['href'] }}" class="flex items-center gap-2 rounded-[10px] border border-gray-200 bg-white px-5 py-2.5 text-[13px] font-semibold text-[#3723db] shadow-sm transition-all hover:bg-[#F4F2FF] hover:shadow-md">
                        <i class="{{ $action['icon'] }} text-lg"></i> {{ $action['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 pb-12 xl:grid-cols-3">
            <div class="rounded-[20px] border border-gray-100 bg-white p-6 shadow-sm xl:col-span-2">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-[17px] font-bold text-[#0B132C]">Recommended Companies</h2>
                    @if ($slug)
                        <a href="{{ route('exhibitions.visitor.companies', $slug) }}" class="flex items-center gap-1 text-[13px] font-bold text-[#3723db] hover:underline">View All <i class="fa-solid fa-arrow-right text-xs"></i></a>
                    @endif
                </div>
                @if ($recommendedCompanies->isNotEmpty())
                    <div class="space-y-4">
                        @foreach ($recommendedCompanies as $company)
                            <div class="flex min-h-[88px] flex-col justify-between gap-4 rounded-xl border border-gray-100 px-5 py-4 transition-colors hover:bg-gray-50/50 sm:flex-row sm:items-center">
                                <div>
                                    <h3 class="mb-3 text-[16px] font-semibold text-[#0B132C]">{{ $company['company'] }}</h3>
                                    <div class="flex flex-col gap-2 text-[13px] font-medium text-gray-500 sm:flex-row sm:gap-x-8">
                                        <span>{{ $company['location'] }}</span>
                                        <span class="flex items-center gap-2"><i class="fa-regular fa-calendar"></i>{{ $company['meta'] }}</span>
                                    </div>
                                </div>
                                <span class="shrink-0 rounded-full bg-[#E6FBF0] px-3 py-1 text-[12px] font-bold text-[#10B981]">{{ $company['status'] }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="visitor-flow-empty">
                        <p class="text-[15px] font-semibold text-[#071044]">No companies to recommend yet</p>
                        <p class="mt-2 text-[14px] text-[#5A6480]">Published exhibitor booths will appear here automatically.</p>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="rounded-[20px] border border-gray-100 bg-white p-6 shadow-sm">
                    <h2 class="mb-6 text-[17px] font-bold text-[#0B132C]">Visitor Access</h2>
                    <div class="space-y-6">
                        @foreach ($visitorAccessItems as $item)
                            <div class="flex items-center justify-between text-[14px] text-[#071044]">
                                <span>{{ $item['label'] }}</span>
                                <span class="font-medium">{{ $item['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    @if ($slug)
                        <a href="{{ route('exhibitions.visitor.qr-pass', $slug) }}" class="mt-7 inline-flex items-center gap-2 text-[13px] font-bold text-[#3723db] hover:underline">View QR Pass <i class="fa-solid fa-arrow-right text-xs"></i></a>
                    @endif
                </div>

                <div class="rounded-[20px] border border-gray-100 bg-white p-6 shadow-sm">
                    <h2 class="mb-4 text-[17px] font-bold text-[#0B132C]">Today's Sessions</h2>
                    <div class="mb-7 space-y-3 text-[13px] leading-5 text-gray-500">
                        @forelse ($todaySessions as $session)
                            <p><strong class="text-[#0B132C]">{{ $session['time'] }}</strong> {{ $session['title'] }}</p>
                        @empty
                            <p>No sessions scheduled yet.</p>
                        @endforelse
                    </div>
                    @if ($slug)
                        <a href="{{ route('exhibitions.visitor.sessions', $slug) }}" class="inline-flex h-[44px] items-center gap-3 rounded-[10px] border border-gray-200 bg-white px-5 text-[13px] font-semibold text-[#3723db] shadow-sm transition-all hover:bg-[#F4F2FF]">
                            <i class="fa-regular fa-circle-play text-lg"></i>{{ $isPassActive ? 'Join Session' : 'Register / Get Pass' }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
