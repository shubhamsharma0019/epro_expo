@extends('layouts.user')

@section('title', 'Visitor Dashboard - EproExpo')
@section('page-title', 'Dashboard')

@section('content')
@php
    $userName = $user->name ?? 'Visitor';
@endphp

<section class="space-y-6 px-5 py-6 sm:px-8">
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

    <div class="rounded-3xl bg-[#0B132C] px-6 py-7 text-white">
        <p class="text-[12px] font-semibold uppercase tracking-[0.18em] text-white/60">{{ now()->format('M d, Y') }}</p>
        <h2 class="mt-3 text-[30px] font-bold">Welcome back, {{ $userName }}</h2>
        <p class="mt-2 max-w-2xl text-[14px] text-white/70">
            Your event tickets, exhibition passes, and activity agenda are ready in one place.
        </p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($statCards as $card)
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <p class="text-[12px] font-semibold uppercase tracking-[0.14em] text-gray-400">{{ $card['label'] }}</p>
                <p class="mt-3 text-[28px] font-bold text-[#0B132C]">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.3fr_0.7fr]">
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-[18px] font-bold text-[#0B132C]">My Passes & Tickets</h3>
                    <p class="mt-1 text-[13px] text-gray-500">Event tickets and exhibition passes linked to your account.</p>
                </div>
                <a href="{{ route('frontend.user.tickets.index') }}" class="text-[13px] font-semibold text-[#3723db]">View all</a>
            </div>

            <div class="mt-5 space-y-4">
                @forelse ($passes->take(6) as $pass)
                    @php
                        $isEvent = $pass['type'] === 'event';
                        $statusClass = $pass['status'] === 'confirmed'
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'bg-gray-100 text-gray-600';
                    @endphp
                    <div class="rounded-2xl border border-gray-100 px-4 py-4">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex rounded-full px-3 py-1 text-[11px] font-semibold {{ $isEvent ? 'bg-blue-50 text-blue-700' : 'bg-indigo-50 text-indigo-700' }}">
                                        {{ $pass['pass_type'] }}
                                    </span>
                                    <span class="inline-flex rounded-full bg-[#F8F9FC] px-3 py-1 text-[11px] font-semibold text-gray-500">
                                        {{ ucfirst($pass['category']) }}
                                    </span>
                                </div>
                                <p class="mt-3 text-[15px] font-bold text-[#0B132C]">{{ $pass['name'] }}</p>
                                <p class="mt-1 text-[13px] text-gray-500">
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
                                    class="inline-flex h-9 items-center justify-center rounded-xl border border-gray-200 px-3 text-[12px] font-semibold text-[#0B132C] transition hover:bg-gray-50"
                                >
                                    View QR
                                </button>
                                @if ($isEvent)
                                    <a href="{{ route('frontend.user.tickets.e-ticket', ['id' => $pass['id'], 'download' => 1]) }}" class="inline-flex h-9 items-center justify-center rounded-xl bg-[#3723db] px-3 text-[12px] font-semibold text-white transition hover:bg-[#2b1bb8]">
                                        Download
                                    </a>
                                @elseif (! empty($pass['slug']))
                                    <a href="{{ route('frontend.user.tickets.exhibition.show', $pass['id']) }}" class="inline-flex h-9 items-center justify-center rounded-xl border border-gray-200 px-3 text-[12px] font-semibold text-[#0B132C] transition hover:bg-gray-50">
                                        View Pass
                                    </a>
                                    <a href="{{ route('exhibitions.visit', $pass['slug']) }}" class="inline-flex h-9 items-center justify-center rounded-xl bg-[#3723db] px-3 text-[12px] font-semibold text-white transition hover:bg-[#2b1bb8]">
                                        Enter Lobby
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-gray-200 px-4 py-10 text-center">
                        <p class="text-[14px] font-semibold text-[#0B132C]">No passes or tickets yet</p>
                        <p class="mt-2 text-[13px] text-gray-500">Book an event ticket or register for an exhibition pass to see them here.</p>
                        <div class="mt-5 flex flex-wrap justify-center gap-3">
                            <a href="{{ url('/events/listings') }}" class="inline-flex h-10 items-center justify-center rounded-xl border border-gray-200 px-4 text-[13px] font-semibold text-[#0B132C] transition hover:bg-gray-50">
                                Browse Events
                            </a>
                            <a href="{{ route('exhibitions.index') }}" class="inline-flex h-10 items-center justify-center rounded-xl bg-[#3723db] px-4 text-[13px] font-semibold text-white transition hover:bg-[#2b1bb8]">
                                Get Exhibition Pass
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="text-[18px] font-bold text-[#0B132C]">Quick Actions</h3>
                <div class="mt-5 grid gap-3">
                    @foreach ($quickActions as $action)
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
                <h3 class="text-[18px] font-bold text-[#0B132C]">Recent Activities</h3>
                <div class="mt-5 space-y-3">
                    @forelse ($recentActivities->take(5) as $act)
                        <div class="rounded-2xl bg-[#F8F9FC] px-4 py-3">
                            <p class="text-[14px] font-semibold text-[#0B132C]">{{ $act['title'] }}</p>
                            <p class="mt-1 text-[13px] text-gray-500">{{ $act['desc'] }}</p>
                            <p class="mt-2 text-[12px] text-gray-400">{{ $act['time']->diffForHumans() }}</p>
                        </div>
                    @empty
                        <div class="rounded-2xl bg-[#F8F9FC] px-4 py-6 text-center text-[13px] text-gray-500">
                            No recent activity found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @if ($upcomingEvents->isNotEmpty() || $upcomingExhibitions->isNotEmpty())
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="text-[18px] font-bold text-[#0B132C]">Upcoming For You</h3>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                @foreach ($upcomingEvents->take(3) as $event)
                    <div class="rounded-2xl border border-gray-100 bg-[#F8F9FC] px-4 py-4">
                        <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-[11px] font-semibold text-blue-700">Event</span>
                        <p class="mt-3 text-[15px] font-bold text-[#0B132C]">{{ $event->title }}</p>
                        <p class="mt-1 text-[13px] text-gray-500">{{ $event->starts_at?->format('M d, Y') ?? 'Date TBD' }}</p>
                    </div>
                @endforeach
                @foreach ($upcomingExhibitions->take(3) as $exhibition)
                    <div class="rounded-2xl border border-gray-100 bg-[#F8F9FC] px-4 py-4">
                        <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-[11px] font-semibold text-indigo-700">Exhibition</span>
                        <p class="mt-3 text-[15px] font-bold text-[#0B132C]">{{ $exhibition->title ?? $exhibition->name }}</p>
                        <p class="mt-1 text-[13px] text-gray-500">{{ $exhibition->start_date?->format('M d, Y') ?? 'Date TBD' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>

<div id="qr-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#071044]/60 p-4 backdrop-blur-sm">
    <div id="qr-modal-card" class="relative w-full max-w-sm scale-95 rounded-3xl border border-gray-100 bg-white p-6 shadow-2xl transition-all duration-300">
        <button type="button" onclick="closeQrModal()" class="absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition hover:bg-gray-200">
            <i class="ph ph-x"></i>
        </button>

        <div class="mt-2 text-center">
            <span id="modal-ticket-type" class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-indigo-600">Ticket Pass</span>
            <h3 id="modal-title" class="mt-3 truncate text-xl font-bold text-[#0B132C]">Event Title</h3>
            <p id="modal-email" class="mt-1 text-xs text-gray-400">user@example.com</p>

            <div class="mt-6 inline-flex flex-col items-center justify-center rounded-2xl border border-indigo-50 bg-[#FBFAFF] p-4 shadow-inner">
                <img src="" alt="QR Pass" id="modal-qr-img" class="h-44 w-44 rounded-xl bg-white shadow-sm" />
                <p id="modal-ticket-id" class="mt-3 font-mono text-xs font-bold tracking-wider text-[#0B132C]">ORDER_NUMBER</p>
            </div>

            <p class="mt-4 text-xs leading-relaxed text-gray-500">Present this QR code at the registration desk for verification.</p>
        </div>
    </div>
</div>

<script>
    function openQrModal(id, title, type, email) {
        document.getElementById('modal-ticket-id').innerText = id;
        document.getElementById('modal-title').innerText = title;
        document.getElementById('modal-ticket-type').innerText = type;
        document.getElementById('modal-email').innerText = email;

        document.getElementById('modal-qr-img').src =
            'https://api.qrserver.com/v1/create-qr-code/?size=200x200&margin=10&data=' +
            encodeURIComponent(id + '|' + title + '|' + email);

        const modal = document.getElementById('qr-modal');
        const card = document.getElementById('qr-modal-card');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);
    }

    function closeQrModal() {
        const modal = document.getElementById('qr-modal');
        const card = document.getElementById('qr-modal-card');

        card.classList.remove('scale-100');
        card.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 150);
    }
</script>
@endsection
