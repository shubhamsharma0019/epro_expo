@php
    $userName = $user->name ?? 'Visitor';
@endphp

@if (session('event_booking_path') && $eventTickets->isEmpty())
    <div class="flex flex-col gap-4 rounded-2xl border border-blue-100 bg-blue-50 p-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h4 class="text-[15px] font-bold text-blue-900">Continue your ticket booking</h4>
            <p class="mt-1 text-[13px] text-blue-700">You were in the middle of booking an event ticket.</p>
        </div>
        <a href="{{ session('event_booking_path') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#3723db] px-5 text-[13px] font-semibold text-white transition hover:bg-[#2b1bb8]">
            Continue Booking
        </a>
    </div>
@endif

@if (session('exhibition_booking_path') && $exhibitionPasses->isEmpty())
    <div class="flex flex-col gap-4 rounded-2xl border border-indigo-100 bg-indigo-50 p-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h4 class="text-[15px] font-bold text-indigo-900">Continue your pass booking</h4>
            <p class="mt-1 text-[13px] text-indigo-700">You were in the middle of getting a visitor pass.</p>
        </div>
        <a href="{{ session('exhibition_booking_path') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#3723db] px-5 text-[13px] font-semibold text-white transition hover:bg-[#2b1bb8]">
            Continue Booking
        </a>
    </div>
@endif

<div id="dashboard-home" class="scroll-mt-24 overflow-hidden rounded-2xl bg-[#0B132C] px-6 py-7 text-white">
    <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-white/60">{{ now()->format('M d, Y') }}</p>
    <h2 class="mt-3 text-[28px] font-bold sm:text-[32px]">Welcome back, {{ $userName }}</h2>
    <p class="mt-2 max-w-2xl text-[14px] text-white/70">
        Your event tickets, exhibition passes, and activity agenda are ready in one place.
    </p>
</div>

<div id="dashboard-stats" class="scroll-mt-24 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach ($statCards as $card)
        <div class="booth-stat-card">
            <p class="text-[11px] font-bold uppercase tracking-[0.14em] text-[#5A6480]">{{ $card['label'] }}</p>
            <p class="mt-3 text-[28px] font-bold text-[#071044]">{{ $card['value'] }}</p>
        </div>
    @endforeach
</div>

<div id="dashboard-passes" class="scroll-mt-24 visitor-flow-card">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-[18px] font-bold text-[#071044]">My Passes & Tickets</h3>
            <p class="mt-1 text-[13px] text-[#5A6480]">Event tickets and exhibition passes linked to your account.</p>
        </div>
        <a href="{{ route('frontend.user.tickets.index') }}" class="text-[13px] font-bold text-[#5B32F6] hover:underline">View all</a>
    </div>

    <div class="mt-5 space-y-4">
        @forelse ($passes->take(6) as $pass)
            @php
                $isEvent = $pass['type'] === 'event';
                $statusClass = $pass['status'] === 'confirmed'
                    ? 'bg-emerald-50 text-emerald-700'
                    : 'bg-gray-100 text-gray-600';
            @endphp
            <div class="pass-card rounded-2xl border border-[#E7EAF3] bg-[#FBFAFF] px-4 py-4">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex rounded-full px-3 py-1 text-[11px] font-semibold {{ $isEvent ? 'bg-blue-50 text-blue-700' : 'bg-indigo-50 text-indigo-700' }}">
                                {{ $pass['pass_type'] }}
                            </span>
                            <span class="inline-flex rounded-full bg-white px-3 py-1 text-[11px] font-semibold text-[#5A6480]">
                                {{ ucfirst($pass['category']) }}
                            </span>
                        </div>
                        <p class="mt-3 text-[15px] font-bold text-[#071044]">{{ $pass['name'] }}</p>
                        <p class="mt-1 text-[13px] text-[#5A6480]">
                            No: <span class="font-mono font-semibold">{{ $pass['number'] }}</span>
                            @if ($isEvent && $pass['quantity'] > 1)
                                &bull; Qty: {{ $pass['quantity'] }}
                            @endif
                            &bull; {{ $pass['date'] ? $pass['date']->format('M d, Y') : 'Date TBD' }}
                        </p>
                    </div>
                    <div class="visitor-pass-actions flex shrink-0 flex-wrap items-center gap-2">
                        <span class="inline-flex rounded-full px-3 py-1 text-[12px] font-semibold {{ $statusClass }}">
                            {{ ucfirst($pass['status']) }}
                        </span>
                        <button
                            type="button"
                            onclick="openQrModal('{{ $pass['number'] }}', '{{ addslashes($pass['name']) }}', '{{ $pass['ticket_name'] }}', '{{ $pass['email'] }}')"
                            class="inline-flex h-9 items-center justify-center rounded-xl border border-[#E7EAF3] bg-white px-3 text-[12px] font-semibold text-[#071044] transition hover:bg-[#F8F7FF]"
                        >
                            View QR
                        </button>
                        @if ($isEvent)
                            <a href="{{ route('frontend.user.tickets.e-ticket', ['id' => $pass['id'], 'download' => 1]) }}" class="inline-flex h-9 items-center justify-center rounded-xl bg-[#5B32F6] px-3 text-[12px] font-semibold text-white transition hover:bg-[#4C10D0]">
                                Download
                            </a>
                        @elseif (! empty($pass['slug']))
                            <a href="{{ route('frontend.user.tickets.exhibition.show', $pass['id']) }}" class="inline-flex h-9 items-center justify-center rounded-xl border border-[#E7EAF3] bg-white px-3 text-[12px] font-semibold text-[#071044] transition hover:bg-[#F8F7FF]">
                                View Pass
                            </a>
                            <a href="{{ route('exhibitions.visit', $pass['slug']) }}" class="inline-flex h-9 items-center justify-center rounded-xl bg-[#5B32F6] px-3 text-[12px] font-semibold text-white transition hover:bg-[#4C10D0]">
                                Enter Lobby
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="visitor-flow-empty">
                <p class="text-[14px] font-semibold text-[#071044]">No passes or tickets yet</p>
                <p class="mt-2 text-[13px] text-[#5A6480]">Book an event ticket or register for an exhibition pass to see them here.</p>
                <div class="mt-5 flex flex-wrap justify-center gap-3">
                    <a href="{{ url('/events/listings') }}" class="inline-flex h-10 items-center justify-center rounded-xl border border-[#E7EAF3] px-4 text-[13px] font-semibold text-[#071044] transition hover:bg-[#F8F7FF]">
                        Browse Events
                    </a>
                    <a href="{{ route('exhibitions.index') }}" class="inline-flex h-10 items-center justify-center rounded-xl bg-[#5B32F6] px-4 text-[13px] font-semibold text-white transition hover:bg-[#4C10D0]">
                        Get Exhibition Pass
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

@if ($upcomingEvents->isNotEmpty() || $upcomingExhibitions->isNotEmpty())
    <div id="dashboard-upcoming" class="scroll-mt-24 visitor-flow-card">
        <h3 class="text-[18px] font-bold text-[#071044]">Upcoming For You</h3>
        <div class="mt-5 grid gap-4 md:grid-cols-2">
            @foreach ($upcomingEvents->take(3) as $event)
                <div class="rounded-2xl border border-[#E7EAF3] bg-[#FBFAFF] px-4 py-4">
                    <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-[11px] font-semibold text-blue-700">Event</span>
                    <p class="mt-3 text-[15px] font-bold text-[#071044]">{{ $event->title }}</p>
                    <p class="mt-1 text-[13px] text-[#5A6480]">{{ $event->starts_at?->format('M d, Y') ?? 'Date TBD' }}</p>
                </div>
            @endforeach
            @foreach ($upcomingExhibitions->take(3) as $exhibition)
                <div class="rounded-2xl border border-[#E7EAF3] bg-[#FBFAFF] px-4 py-4">
                    <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-[11px] font-semibold text-indigo-700">Exhibition</span>
                    <p class="mt-3 text-[15px] font-bold text-[#071044]">{{ $exhibition->title ?? $exhibition->name }}</p>
                    <p class="mt-1 text-[13px] text-[#5A6480]">{{ $exhibition->start_date?->format('M d, Y') ?? 'Date TBD' }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endif
