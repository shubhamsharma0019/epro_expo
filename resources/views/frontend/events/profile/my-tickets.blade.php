@extends('layouts.frontend')

@section('title', 'My Tickets')

@section('content')
@php
    $tickets = [
        [
            'title' => 'Global Tech Summit 2024',
            'type' => 'General Pass',
            'status' => 'Confirmed',
            'date' => 'May 15 - May 17, 2024',
            'time' => '09:00 AM - 06:00 PM',
            'venue' => 'Jio World Convention Centre, Mumbai',
            'booking' => 'EVT-240515-000123',
            'seat' => 'A-12',
            'price' => '₹102.00',
            'image' => 'images/events-home/trending/global-tech-summit.svg',
        ],
        [
            'title' => 'Digital Marketing Summit',
            'type' => 'VIP Pass',
            'status' => 'Upcoming',
            'date' => 'Jun 02, 2024',
            'time' => '02:00 PM - 05:30 PM',
            'venue' => 'Jio World Convention Centre, Mumbai',
            'booking' => 'EVT-240602-000457',
            'seat' => 'VIP B-08',
            'price' => '₹49.00',
            'image' => 'images/events-home/trending/digital-marketing-summit.svg',
        ],
    ];
@endphp

<main class="bg-[#FBFCFF] px-5 py-8 sm:px-8 lg:px-11">
    <section class="mx-auto max-w-[1440px]">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <span class="inline-flex rounded-full bg-[#F4F0FF] px-4 py-2 text-[12px] font-bold uppercase tracking-[0.14em] text-[#5b2eff]">Event Tickets</span>
                <h1 class="mt-5 text-[34px] font-extrabold tracking-[-0.035em] text-[#071044]">My Tickets</h1>
                <p class="mt-3 max-w-[680px] text-[16px] font-medium leading-7 text-[#4E567A]">
                    Access confirmed tickets, entry QR codes, booking details, and upcoming event sessions from one place.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ url('/events/listings') }}" class="inline-flex h-12 items-center justify-center rounded-xl border border-[#E0E4EF] bg-white px-5 text-[14px] font-bold text-[#071044] hover:bg-[#F8F7FF]">
                    Browse Events
                </a>
                <a href="{{ url('/events/tickets/e-ticket') }}" class="inline-flex h-12 items-center justify-center rounded-xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[14px] font-bold text-white shadow-[0_14px_30px_rgba(91,46,255,0.22)]">
                    Open E-Ticket
                </a>
            </div>
        </div>

        <div class="mt-8 grid gap-6 xl:grid-cols-[minmax(0,1fr)_390px]">
            <div class="grid gap-5">
                @foreach ($tickets as $ticket)
                    <article class="overflow-hidden rounded-[26px] border border-[#E7EAF3] bg-white shadow-[0_18px_44px_rgba(7,16,68,0.07)]">
                        <div class="grid gap-0 lg:grid-cols-[260px_1fr_230px]">
                            <div class="relative min-h-[210px] bg-[#071044]">
                                <img src="{{ asset($ticket['image']) }}" alt="{{ $ticket['title'] }}" class="absolute inset-0 h-full w-full object-cover opacity-90">
                                <div class="absolute inset-0 bg-gradient-to-br from-[#071044]/65 to-[#5b2eff]/25"></div>
                            </div>

                            <div class="min-w-0 p-6 sm:p-7">
                                <div class="flex min-w-0 flex-wrap items-center gap-2 sm:gap-3">
                                    <span class="inline-flex h-8 shrink-0 items-center rounded-full bg-[#EEF2FF] px-3.5 text-[12px] font-bold text-[#1E2A67]">{{ $ticket['status'] }}</span>
                                    <span class="inline-flex h-8 shrink-0 items-center rounded-full bg-[#F4F0FF] px-3.5 text-[12px] font-bold text-[#5b2eff]">{{ $ticket['type'] }}</span>
                                    <span class="inline-flex h-8 shrink-0 items-center rounded-full bg-[#ECFDF5] px-3.5 text-[12px] font-bold text-[#047857]">Paid</span>
                                </div>
                                <h2 class="mt-4 text-[24px] font-extrabold tracking-[-0.025em] text-[#071044]">{{ $ticket['title'] }}</h2>
                                <div class="mt-5 grid gap-3 text-[14px] font-medium text-[#4E567A] sm:grid-cols-2">
                                    <p><span class="block text-[12px] font-bold uppercase tracking-[0.1em] text-[#8A94AD]">Date</span>{{ $ticket['date'] }}</p>
                                    <p><span class="block text-[12px] font-bold uppercase tracking-[0.1em] text-[#8A94AD]">Time</span>{{ $ticket['time'] }}</p>
                                    <p class="sm:col-span-2"><span class="block text-[12px] font-bold uppercase tracking-[0.1em] text-[#8A94AD]">Venue</span>{{ $ticket['venue'] }}</p>
                                </div>
                                <div class="mt-6 flex flex-wrap gap-3">
                                    <a href="{{ url('/events/tickets/e-ticket') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#071044] px-5 text-[13px] font-bold text-white">View Ticket</a>
                                    <a href="{{ url('/events/listings/global-tech-summit-2024') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-[#E7EAF3] bg-white px-5 text-[13px] font-bold text-[#071044] hover:bg-[#F4F0FF]">Event Details</a>
                                </div>
                            </div>

                            <div class="flex flex-col items-center justify-center border-t border-dashed border-[#D9DDF4] bg-[#F8FAFF] p-6 text-center lg:border-l lg:border-t-0">
                                <x-shared.qr-ticket-card
                                    src="https://api.qrserver.com/v1/create-qr-code/?size=170x170&margin=10&data={{ urlencode($ticket['booking'] . '|' . $ticket['title']) }}"
                                    alt="{{ $ticket['title'] }} QR code"
                                    size-class="h-[132px] w-[132px]"
                                    card-class="rounded-[24px] px-4 pb-5 pt-4"
                                />
                                <p class="mt-4 text-[11px] font-bold uppercase tracking-[0.16em] text-[#8A94AD]">Booking ID</p>
                                <p class="mt-2 text-[15px] font-extrabold text-[#071044]">{{ $ticket['booking'] }}</p>
                                <div class="mt-4 grid w-full grid-cols-2 gap-2 text-left">
                                    <div class="rounded-xl bg-white p-3">
                                        <p class="text-[11px] font-bold text-[#8A94AD]">Seat</p>
                                        <p class="mt-1 text-[13px] font-bold text-[#071044]">{{ $ticket['seat'] }}</p>
                                    </div>
                                    <div class="rounded-xl bg-white p-3">
                                        <p class="text-[11px] font-bold text-[#8A94AD]">Paid</p>
                                        <p class="mt-1 text-[13px] font-bold text-[#071044]">{{ $ticket['price'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <aside class="space-y-5">
                <div class="rounded-[26px] border border-[#E7EAF3] bg-white p-6 shadow-[0_18px_44px_rgba(7,16,68,0.07)]">
                    <h2 class="text-[20px] font-extrabold text-[#071044]">Ticket Summary</h2>
                    <div class="mt-5 grid gap-3">
                        @foreach ([['Confirmed', '1'], ['Upcoming', '1'], ['Total Tickets', '4'], ['Amount Paid', '₹151.00']] as [$label, $value])
                            <div class="flex items-center justify-between rounded-2xl bg-[#FBFCFF] p-4">
                                <span class="text-[14px] font-medium text-[#4E567A]">{{ $label }}</span>
                                <strong class="text-[15px] text-[#071044]">{{ $value }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-[26px] border border-[#E7EAF3] bg-white p-6 shadow-[0_18px_44px_rgba(7,16,68,0.07)]">
                    <h2 class="text-[20px] font-extrabold text-[#071044]">Today Agenda</h2>
                    <div class="mt-5 space-y-3">
                        @foreach ([['09:00 AM', 'Opening Keynote', 'Main Stage'], ['02:00 PM', 'Networking Session', 'Main Stage'], ['04:30 PM', 'Product Demos', 'Innovation Hall']] as [$time, $title, $place])
                            <div class="rounded-2xl border border-[#E7EAF3] bg-white p-4">
                                <p class="text-[13px] font-extrabold text-[#5b2eff]">{{ $time }}</p>
                                <p class="mt-2 text-[15px] font-bold text-[#071044]">{{ $title }}</p>
                                <p class="mt-1 text-[13px] font-medium text-[#5A6480]">{{ $place }}</p>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ url('/events/profile/notifications') }}" class="mt-5 inline-flex h-11 w-full items-center justify-center rounded-xl border border-[#E7EAF3] text-[13px] font-bold text-[#071044] hover:bg-[#F4F0FF]">
                        Notification Settings
                    </a>
                </div>
            </aside>
        </div>
    </section>
</main>
@endsection
