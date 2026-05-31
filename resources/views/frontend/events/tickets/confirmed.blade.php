@extends('layouts.frontend')

@section('title', 'Booking Confirmed - Event Registration')

@section('content')
@php
    $eventName = $ticket->companyEvent ? $ticket->companyEvent->title : 'Event';
    if (!$ticket->companyEvent && $ticket->event_slug == 'global-tech-summit-2024') {
        $eventName = 'Global Tech Summit 2024';
    }
    $dateInfo = $ticket->companyEvent
        ? ($ticket->companyEvent->starts_at?->format('M d, Y') ?? 'Date TBD') . ($ticket->companyEvent->ends_at ? ' - ' . $ticket->companyEvent->ends_at->format('M d, Y') : '')
        : 'May 15 - May 17, 2024';
@endphp
<main class="relative flex-1 px-8 pb-14">
            <section class="relative mx-auto max-w-[900px] pt-[48px] text-center">
                <!-- Confetti dots -->
                <div class="pointer-events-none absolute left-0 right-0 top-0 mx-auto h-[160px] max-w-[760px]">
                    <span class="confetti-piece left-[12%] top-[72px] bg-[#F59E0B]"></span>
                    <span class="confetti-piece left-[20%] top-[32px] bg-[#2478FF]"></span>
                    <span class="confetti-piece left-[28%] top-[86px] bg-[#6D35E8]"></span>
                    <span class="confetti-piece left-[36%] top-[26px] bg-[#E83E95]"></span>
                    <span class="confetti-piece left-[45%] top-[7px] bg-[#F59E0B]"></span>
                    <span class="confetti-piece left-[55%] top-[72px] bg-[#4DB6C7]"></span>
                    <span class="confetti-piece left-[62%] top-[4px] bg-[#F1841B]"></span>
                    <span class="confetti-piece left-[70%] top-[36px] bg-[#7AC943]"></span>
                    <span class="confetti-piece left-[78%] top-[72px] bg-[#FF5252]"></span>
                    <span class="confetti-piece left-[88%] top-[60px] bg-[#6738D8]"></span>
                    <span class="confetti-piece left-[94%] top-[96px] bg-[#19A86B]"></span>
                </div>

                <!-- Success icon -->
                <div class="relative mx-auto flex h-[92px] w-[92px] items-center justify-center rounded-full bg-gradient-to-br from-[#16B85E] to-[#0FA968] shadow-[0_16px_35px_rgba(22,184,94,0.22)]">
                    <svg class="h-12 w-12 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.25 12.35L9.65 16.75L18.75 7.65" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <h1 class="mt-9 text-[38px] font-extrabold leading-tight tracking-[-0.035em] text-[#071044]">
                    Booking Confirmed!
                </h1>
                <p class="mt-4 text-[20px] font-medium text-[#202B63]">
                    Your booking has been successfully completed.
                </p>

                <div class="mt-12">
                    <p class="text-[20px] font-medium text-[#071044]">Order Number</p>
                    <p class="mt-4 text-[29px] font-extrabold tracking-[-0.02em] text-[#071044]">
                        {{ $ticket->order_number }}
                    </p>
                </div>

                <p class="mx-auto mt-8 max-w-[430px] text-[20px] font-medium leading-[1.55] text-[#202B63]">
                    A confirmation has been sent to<br>
                    <span class="font-extrabold text-[#071044]">{{ $ticket->attendee_email }}</span>
                </p>

                <!-- Order Summary Card -->
                <div class="mx-auto mt-11 max-w-[748px] rounded-xl border border-[#DDE2F2] bg-white px-8 py-5 text-left shadow-[0_2px_10px_rgba(22,30,84,0.02)]">
                    <h2 class="mb-6 text-[19px] font-extrabold tracking-[-0.015em] text-[#071044]">Order Summary</h2>

                    <div class="space-y-5 text-[18px]">
                        <div class="grid grid-cols-[260px_1fr] items-start gap-4">
                            <p class="font-medium text-[#323A68]">Event</p>
                            <p class="font-semibold text-[#071044]">{{ $eventName }}</p>
                        </div>
                        <div class="grid grid-cols-[260px_1fr] items-start gap-4">
                            <p class="font-medium text-[#323A68]">Date</p>
                            <p class="font-semibold text-[#071044]">{{ $dateInfo }}</p>
                        </div>
                        <div class="grid grid-cols-[260px_1fr] items-start gap-4">
                            <p class="font-medium text-[#323A68]">Pass Type</p>
                            <p class="font-semibold text-[#071044]">{{ $ticket->ticket_name }}</p>
                        </div>
                    </div>

                    <div class="my-5 h-px w-full bg-[#DEE3F3]"></div>

                    <div class="space-y-5 text-[18px]">
                        <div class="grid grid-cols-[260px_1fr] items-center gap-4">
                            <p class="font-extrabold text-[#202B63]">Total Amount</p>
                            <p class="text-right text-[23px] font-extrabold tracking-[-0.02em] text-[#071044]">${{ number_format($ticket->total_amount, 2) }}</p>
                        </div>
                        <div class="grid grid-cols-[260px_1fr] items-center gap-4">
                            <p class="font-extrabold text-[#202B63]">Total Tickets</p>
                            <p class="text-right text-[19px] font-extrabold text-[#071044]">{{ $ticket->quantity }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mx-auto mt-7 grid max-w-[748px] grid-cols-2 gap-6">
                    <a href="{{ url('/user/tickets/' . $ticket->id . '/e-ticket') }}"
                        class="flex h-[66px] items-center justify-center rounded-lg bg-gradient-to-r from-[#5B2EFF] to-[#4310D8] text-[20px] font-extrabold text-white shadow-[0_14px_30px_rgba(91,46,255,0.18)] transition hover:-translate-y-0.5 hover:shadow-[0_18px_36px_rgba(91,46,255,0.25)]">
                        View E-Ticket
                    </a>
                    <a href="{{ url('/user/tickets') }}"
                        class="flex h-[66px] items-center justify-center rounded-lg border border-[#907BFF] bg-white text-[20px] font-extrabold text-[#4320D6] transition hover:bg-[#F7F4FF]">
                        Go to My Bookings
                    </a>
                </div>
            </section>
        </main>
@endsection

@push('scripts')
<script>
// Clear event order data from local storage so user can buy new tickets
localStorage.removeItem("eventOrder");
</script>
@endpush
