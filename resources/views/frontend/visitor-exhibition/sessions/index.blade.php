@extends('layouts.exhibition')

@section('title', 'Sessions & Webinars - EproExpo')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')
@php
    $slug = $slug ?? '';
    $isPassActive = $isPassActive ?? false;
    $sessions = collect($sessions ?? []);
    $typeLabels = [
        'live_demo' => 'Live Demo',
        'webinar' => 'Webinar',
        'talk' => 'Talk',
        'qna' => 'Q&A',
    ];
    $typeStyles = [
        'live_demo' => 'border-[#DDD6FE] bg-[#F5F3FF] text-[#6D28D9]',
        'webinar' => 'border-[#BFDBFE] bg-[#EFF6FF] text-[#2563EB]',
        'talk' => 'border-[#FDE68A] bg-[#FEF3C7] text-[#B45309]',
        'qna' => 'border-[#A7F3D0] bg-[#ECFDF5] text-[#047857]',
    ];
    $statusLabels = [
        'live' => 'Live Now',
        'upcoming' => 'Upcoming',
        'completed' => 'Completed',
    ];
    $statusStyles = [
        'live' => 'border-[#A7F3D0] bg-[#ECFDF5] text-[#047857]',
        'upcoming' => 'border-[#C7D2FE] bg-[#EEF2FF] text-[#4338CA]',
        'completed' => 'border-[#E5E7EB] bg-[#F3F4F6] text-[#4B5563]',
    ];
    $sessionStats = [
        [$sessions->count(), 'Total Sessions'],
        [$sessions->where('status', 'live')->count(), 'Live Now'],
        [$sessions->where('status', 'upcoming')->count(), 'Upcoming'],
        [$sessions->pluck('booth_booking_id')->unique()->count(), 'Exhibitors'],
    ];
@endphp

<section class="visitor-flow-page mx-auto w-full max-w-[1500px] px-5 py-6 sm:px-8 lg:px-10 lg:py-8">
    <div class="mb-6 overflow-hidden rounded-[14px] border border-[#E7EAF3] bg-white shadow-[0_10px_28px_rgba(7,16,68,0.07)]">
        <div class="grid gap-0 xl:grid-cols-[minmax(0,1fr)_320px]">
            <div class="p-5 lg:p-7">
                <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-[#F4F0FF] px-3 py-1.5 text-[12px] font-semibold uppercase tracking-[0.12em] text-purple">
                    <i class="fa-regular fa-circle-play"></i>
                    Live program
                </div>

                <h1 class="text-[30px] font-black leading-[36px] text-navy sm:text-[42px] sm:leading-[48px]">
                    Sessions & Webinars
                </h1>

                <p class="mt-3 max-w-[820px] text-[15px] font-medium leading-6 text-[#5A6480]">
                    Join expert sessions, product launches, webinars and live demos from exhibitors synced directly from booth setup.
                </p>
            </div>

            <aside class="border-t border-borderColor bg-[#F8F9FD] p-5 xl:border-l xl:border-t-0">
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($sessionStats as [$value, $label])
                        <div class="rounded-xl border border-[#E7EAF3] bg-white p-4">
                            <p class="text-[24px] font-bold leading-none text-navy">{{ $value }}</p>
                            <p class="mt-1.5 text-[12px] font-semibold text-[#5A6480]">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>

    @unless ($isPassActive)
        <div class="mb-5 rounded-xl border border-[#EADCFD] bg-[#FBFAFF] p-4">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-[18px] font-semibold text-navy">Guest preview mode</h2>
                    <p class="mt-1 text-[14px] font-medium text-[#5A6480]">Register / Get Pass to join sessions and access protected demos.</p>
                </div>
                <a href="{{ route('exhibitions.tickets.select', $slug) }}" class="inline-flex h-[44px] items-center justify-center rounded-md bg-[#5b2eff] px-5 text-[13px] font-semibold text-white">Get Visitor Pass</a>
            </div>
        </div>
    @endunless

    <div class="grid gap-4 lg:grid-cols-2">
        @forelse ($sessions as $session)
            @php
                $booking = $session->boothBooking;
                $companyName = $booking?->boothProfile?->company_name ?: $booking?->company?->company_name ?: $booking?->company?->name ?: 'Exhibitor';
                $companySlug = \Illuminate\Support\Str::slug($companyName);
                $type = $session->type ?? 'live_demo';
                $status = $session->status ?? 'upcoming';
                $speaker = $session->teamMember;
                $startTime = $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('h:i A') : '--';
                $endTime = $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('h:i A') : '--';
                $joinHref = $isPassActive && $companySlug
                    ? route('exhibitions.visitor.companies.show', [$slug, $companySlug])
                    : route('exhibitions.tickets.select', $slug);
            @endphp

            <article class="flex min-h-[270px] flex-col rounded-xl border border-[#E7EAF3] bg-white p-5 shadow-[0_10px_28px_rgba(7,16,68,0.07)]">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="min-w-0">
                        <div class="mb-3 flex flex-wrap items-center gap-2">
                            <span class="inline-flex rounded-md border px-3 py-1 text-[11px] font-bold {{ $typeStyles[$type] ?? $typeStyles['live_demo'] }}">
                                {{ $typeLabels[$type] ?? ucfirst($type) }}
                            </span>
                            <span class="inline-flex rounded-md border px-3 py-1 text-[11px] font-bold {{ $statusStyles[$status] ?? $statusStyles['upcoming'] }}">
                                {{ $statusLabels[$status] ?? ucfirst($status) }}
                            </span>
                        </div>
                        <h2 class="text-[21px] font-extrabold leading-7 text-navy">{{ $session->title }}</h2>
                        <p class="mt-2 line-clamp-2 text-[14px] font-medium leading-6 text-[#5A6480]">{{ $session->description ?: 'Session details will be shared by the exhibitor.' }}</p>
                    </div>

                    <div class="shrink-0 rounded-lg border border-[#E7EAF3] bg-[#F8F9FD] px-4 py-3 text-left sm:w-[150px]">
                        <p class="text-[12px] font-bold uppercase tracking-[0.08em] text-[#6D28D9]">{{ $session->session_date?->format('M d') ?? 'Date TBA' }}</p>
                        <p class="mt-1 text-[13px] font-semibold text-navy">{{ $startTime }}</p>
                    </div>
                </div>

                <div class="mt-5 grid gap-3 sm:grid-cols-3">
                    <div class="rounded-lg border border-[#E7EAF3] px-4 py-3">
                        <p class="text-[11px] font-bold uppercase tracking-[0.08em] text-[#6B7280]">Time</p>
                        <p class="mt-1 text-[13px] font-semibold text-navy">{{ $startTime }} - {{ $endTime }}</p>
                    </div>
                    <div class="rounded-lg border border-[#E7EAF3] px-4 py-3">
                        <p class="text-[11px] font-bold uppercase tracking-[0.08em] text-[#6B7280]">Speaker</p>
                        <p class="mt-1 truncate text-[13px] font-semibold text-navy">{{ $speaker?->name ?? 'Exhibitor team' }}</p>
                    </div>
                    <div class="rounded-lg border border-[#E7EAF3] px-4 py-3">
                        <p class="text-[11px] font-bold uppercase tracking-[0.08em] text-[#6B7280]">Capacity</p>
                        <p class="mt-1 text-[13px] font-semibold text-navy">{{ $session->attendee_limit ?: 'Open' }}</p>
                    </div>
                </div>

                <div class="mt-auto flex flex-col gap-3 pt-5 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <p class="truncate text-[14px] font-bold text-navy">{{ $companyName }}</p>
                        <p class="mt-1 text-[12px] font-semibold text-[#5A6480]">{{ $booking?->hall?->title ?? 'Hall' }} / Booth {{ $booking?->booth?->booth_number ?? 'N/A' }}</p>
                    </div>
                    @if ($isPassActive)
                        @php
                            $visitorBooking = ($visitorSessionBookings ?? collect())[$session->id] ?? null;
                            $joinUrl = $session->companyMeeting?->zoom_join_url ?: $session->companyMeeting?->meeting_link;
                            $isRegistered = in_array($session->id, $registeredSessionIds ?? [], true);
                            $canJoin = $joinUrl && $visitorBooking && in_array($visitorBooking->status, ['confirmed', 'accepted'], true);
                            $requestSent = $visitorBooking?->join_requested_at;
                        @endphp
                        <div class="flex flex-wrap items-center gap-2">
                            @if ($canJoin)
                                <a href="{{ $joinUrl }}" target="_blank" class="inline-flex h-11 items-center justify-center rounded-md bg-[#059669] px-5 text-[13px] font-semibold text-white">Join Conference</a>
                            @elseif ($requestSent)
                                <span class="inline-flex h-11 items-center justify-center rounded-md border border-[#FDE68A] bg-[#FEF3C7] px-5 text-[13px] font-semibold text-[#B45309]">Request Sent</span>
                            @else
                                <form method="POST" action="{{ route('exhibitions.visitor.sessions.request-join', [$slug, $session->id]) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex h-11 items-center justify-center rounded-md bg-[#5b2eff] px-5 text-[13px] font-semibold text-white">
                                        {{ $status === 'live' ? 'Request to Join Live' : 'Request to Join' }}
                                    </button>
                                </form>
                            @endif
                            @unless ($isRegistered)
                                <form method="POST" action="{{ route('exhibitions.visitor.sessions.register', [$slug, $session->id]) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex h-11 items-center justify-center rounded-md border border-[#EADCFD] bg-[#FBFAFF] px-5 text-[13px] font-semibold text-purple">Register</button>
                                </form>
                            @else
                                <span class="inline-flex h-11 items-center justify-center rounded-md border border-[#A7F3D0] bg-[#ECFDF5] px-5 text-[13px] font-semibold text-[#047857]">Registered</span>
                            @endif
                        </div>
                    @else
                        <a href="{{ $joinHref }}" class="inline-flex h-11 items-center justify-center rounded-md border border-[#EADCFD] bg-[#FBFAFF] px-5 text-[13px] font-semibold text-purple">Get Pass</a>
                    @endif
                </div>
            </article>
        @empty
            <div class="lg:col-span-2 rounded-xl border border-[#E7EAF3] bg-white px-6 py-16 text-center shadow-sm">
                <div class="mx-auto grid h-14 w-14 place-items-center rounded-xl bg-[#F4F0FF] text-purple">
                    <i class="fa-regular fa-calendar"></i>
                </div>
                <h2 class="mt-4 text-[20px] font-bold text-navy">No sessions published yet</h2>
                <p class="mx-auto mt-2 max-w-[520px] text-[14px] font-medium leading-6 text-[#5A6480]">Once exhibitors add live demos or webinars from booth setup, they will appear here automatically.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
