@extends('layouts.user')

@section('title', 'Event E-Ticket')
@section('page-title', 'Event E-Ticket')

@section('content')
@php
    use App\Support\EventTicketQr;
    $eventName = $ticket->companyEvent ? $ticket->companyEvent->title : 'Event';
    if (!$ticket->companyEvent && $ticket->event_slug == 'global-tech-summit-2024') {
        $eventName = 'Global Tech Summit 2024';
    }
    $dateInfo = $ticket->companyEvent ? ($ticket->companyEvent->starts_at?->format('M d, Y') ?? 'Date TBD') : 'May 15 - May 17, 2024';
    $timeInfo = $ticket->companyEvent && $ticket->companyEvent->start_time ? \Carbon\Carbon::parse($ticket->companyEvent->start_time)->format('h:i A') : '10:00 AM';
    $qrImageUrl = EventTicketQr::imageUrl($ticket, 512);
    $initials = collect(explode(' ', $ticket->attendee_name))->map(fn($w) => substr($w, 0, 1))->take(2)->implode('');
@endphp
<section class="space-y-6 px-4 py-6 sm:px-8">
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <article class="overflow-hidden rounded-[30px] border border-[#E7EAF3] bg-white shadow-[0_22px_60px_rgba(7,16,68,0.08)]">
            <div class="grid lg:grid-cols-[1fr_260px]">
                <div class="bg-gradient-to-br from-[#071044] via-[#1A2A78] to-[#5b2eff] p-8 text-white sm:p-10">
                    <span class="inline-flex rounded-full bg-white/12 px-4 py-2 text-[12px] font-medium uppercase tracking-[0.12em] text-white/80">Confirmed Ticket</span>
                    <h1 class="mt-8 max-w-[560px] text-[32px] font-medium leading-tight sm:text-[42px]">{{ $eventName }}</h1>
                    <p class="mt-4 max-w-[520px] text-[15px] leading-7 text-white/74">Your pass is active. Keep this QR ready at entry and arrive early for smooth badge verification.</p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/14 bg-white/10 p-4">
                            <p class="text-[12px] text-white/60">Date</p>
                            <p class="mt-2 text-[15px] font-medium">{{ $dateInfo }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/14 bg-white/10 p-4">
                            <p class="text-[12px] text-white/60">Time</p>
                            <p class="mt-2 text-[15px] font-medium">{{ $timeInfo }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/14 bg-white/10 p-4">
                            <p class="text-[12px] text-white/60">Seat</p>
                            <p class="mt-2 text-[15px] font-medium">General</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center justify-center border-t border-dashed border-[#D8DDF0] bg-[#F8FAFF] p-8 text-center lg:border-l lg:border-t-0">
                    <x-shared.qr-ticket-card
                        src="{{ $qrImageUrl }}"
                        alt="Event ticket QR code"
                        size-class="h-[220px] w-[220px]"
                        card-class="px-5 pb-6 pt-5"
                    />
                    <p class="mt-5 text-[12px] font-medium uppercase tracking-[0.16em] text-[#5A6480]">Ticket ID</p>
                    <p class="mt-2 text-[17px] font-medium text-[#071044]">{{ $ticket->order_number }}</p>
                    <div class="mt-6 inline-flex rounded-full bg-emerald-50 px-4 py-2 text-[13px] font-medium text-emerald-700">Ready for check-in</div>
                </div>
            </div>
        </article>

        <aside class="space-y-5">
            <div class="rounded-[26px] border border-[#E7EAF3] bg-white p-6 shadow-[0_16px_42px_rgba(7,16,68,0.06)]">
                <h2 class="text-[18px] font-medium text-[#071044]">Attendee</h2>
                <div class="mt-5 flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F4F0FF] text-[18px] font-medium text-[#5b2eff]">{{ strtoupper($initials) }}</div>
                    <div class="min-w-0">
                        <p class="truncate text-[15px] font-medium text-[#071044]">{{ $ticket->attendee_name }}</p>
                        <p class="truncate text-[13px] text-[#5A6480]">{{ $ticket->attendee_email }}</p>
                    </div>
                </div>
                <div class="mt-6 space-y-3 text-[14px] text-[#34405F]">
                    <p class="ticket-detail-row flex justify-between gap-4"><span>Entry gate</span><strong class="font-medium text-[#071044]">Main Gate</strong></p>
                    <p class="ticket-detail-row flex justify-between gap-4"><span>Ticket type</span><strong class="font-medium text-[#071044]">{{ $ticket->ticket_name }} x {{ $ticket->quantity }}</strong></p>
                    <p class="ticket-detail-row flex justify-between gap-4"><span>Status</span><strong class="font-medium text-emerald-700">Paid</strong></p>
                </div>
            </div>

            <div class="rounded-[26px] border border-[#E7EAF3] bg-white p-6 shadow-[0_16px_42px_rgba(7,16,68,0.06)]">
                <h2 class="text-[18px] font-medium text-[#071044]">Actions</h2>
                <div class="mt-5 grid gap-3">
                    <button onclick="window.print()" class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[14px] font-medium text-white shadow-[0_14px_30px_rgba(91,46,255,0.25)]">
                        <i class="fa-solid fa-download"></i> Download Pass
                    </button>
                    <a href="{{ url('/user/tickets') }}" class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl border border-[#E7EAF3] bg-white px-5 text-[14px] font-medium text-[#071044]">
                        <i class="fa-solid fa-arrow-left"></i> Back to Tickets
                    </a>
                </div>
            </div>
        </aside>
    </div>
</section>

@if (request()->boolean('download'))
    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
@endif
@endsection
