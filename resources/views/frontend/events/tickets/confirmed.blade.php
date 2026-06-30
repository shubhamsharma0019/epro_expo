@extends('layouts.frontend')

@section('title', 'Booking Confirmed - Event Registration')

@section('content')
@php
    use App\Support\EventTicketQr;
    $event = $ticket->companyEvent;
    $eventName = $event?->title ?: 'Event';
    $dateInfo = $event?->starts_at
        ? $event->starts_at->format('M d, Y') . ($event->ends_at ? ' - ' . $event->ends_at->format('M d, Y') : '')
        : 'Date TBD';
    $venueInfo = \App\Support\LiveContent::formatCompanyEventVenue($event);
    $currency = strtoupper($ticket->ticketType?->currency ?: 'INR');
    $currencySymbols = ['INR' => '₹', 'USD' => '$', 'EUR' => '€', 'GBP' => '£'];
    $currencySymbol = $currencySymbols[$currency] ?? ($currency . ' ');
    $formattedTotal = $currencySymbol . number_format((float) $ticket->total_amount, 2);
    $unitPrice = $ticket->ticketType?->price;
    $formattedUnitPrice = $unitPrice !== null
        ? $currencySymbol . number_format((float) $unitPrice, 2)
        : null;
@endphp
<main class="relative flex-1 px-4 pb-14 md:px-8">
            <section class="relative mx-auto max-w-[900px] pt-[48px] text-center">
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

                @include('frontend.events.tickets.partials.event-flow-stepper', ['currentStep' => 4])

                <div class="relative mx-auto mt-8 flex h-[92px] w-[92px] items-center justify-center rounded-full bg-gradient-to-br from-[#16B85E] to-[#0FA968] shadow-[0_16px_35px_rgba(22,184,94,0.22)]">
                    <svg class="h-12 w-12 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.25 12.35L9.65 16.75L18.75 7.65" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <h1 class="mt-9 text-[32px] font-extrabold leading-tight tracking-[-0.035em] text-[#071044] sm:text-[38px]">
                    Payment Confirmed!
                </h1>
                <p class="mt-4 text-[18px] font-medium text-[#202B63] sm:text-[20px]">
                    Your visitor pass booking is complete.
                </p>

                <div class="mt-12">
                    <p class="text-[18px] font-medium text-[#071044] sm:text-[20px]">Order Number</p>
                    <p class="mt-4 text-[24px] font-extrabold tracking-[-0.02em] text-[#071044] sm:text-[29px]">
                        {{ $ticket->order_number }}
                    </p>
                </div>

                @if (session('success'))
                    <p class="mx-auto mt-6 max-w-[520px] rounded-xl bg-emerald-50 px-4 py-3 text-[14px] font-medium text-emerald-700">{{ session('success') }}</p>
                @endif
                @if (session('warning'))
                    <p class="mx-auto mt-6 max-w-[520px] rounded-xl bg-amber-50 px-4 py-3 text-[14px] font-medium text-amber-700">{{ session('warning') }}</p>
                @endif

                <p class="mx-auto mt-8 max-w-[430px] text-[16px] font-medium leading-[1.55] text-[#202B63] sm:text-[20px]">
                    @if ($emailSent)
                        A confirmation with your QR ticket has been sent to<br>
                    @else
                        Your ticket details are ready for<br>
                    @endif
                    <span class="font-extrabold text-[#071044]">{{ $ticket->attendee_email }}</span>
                </p>
                @unless ($emailSent || $emailConfigured)
                    <p class="mx-auto mt-3 max-w-[520px] text-[14px] text-[#64748B]">Your ticket is ready below. Download it or open your QR pass anytime from your dashboard.</p>
                @endunless

                <div class="mx-auto mt-11 max-w-[748px] rounded-xl border border-[#DDE2F2] bg-white px-6 py-5 text-left shadow-[0_2px_10px_rgba(22,30,84,0.02)] sm:px-8">
                    <h2 class="mb-6 text-[19px] font-extrabold tracking-[-0.015em] text-[#071044]">Order Summary</h2>

                    <div class="space-y-5 text-[16px] sm:text-[18px]">
                        <div class="grid grid-cols-1 items-start gap-2 sm:grid-cols-[260px_1fr] sm:gap-4">
                            <p class="font-medium text-[#323A68]">Event</p>
                            <p class="font-semibold text-[#071044]">{{ $eventName }}</p>
                        </div>
                        <div class="grid grid-cols-1 items-start gap-2 sm:grid-cols-[260px_1fr] sm:gap-4">
                            <p class="font-medium text-[#323A68]">Date</p>
                            <p class="font-semibold text-[#071044]">{{ $dateInfo }}</p>
                        </div>
                        <div class="grid grid-cols-1 items-start gap-2 sm:grid-cols-[260px_1fr] sm:gap-4">
                            <p class="font-medium text-[#323A68]">Venue</p>
                            <p class="font-semibold text-[#071044]">{{ $venueInfo }}</p>
                        </div>
                        <div class="grid grid-cols-1 items-start gap-2 sm:grid-cols-[260px_1fr] sm:gap-4">
                            <p class="font-medium text-[#323A68]">Pass Type</p>
                            <p class="font-semibold text-[#071044]">{{ $ticket->ticket_name }}</p>
                        </div>
                        <div class="grid grid-cols-1 items-start gap-2 sm:grid-cols-[260px_1fr] sm:gap-4">
                            <p class="font-medium text-[#323A68]">Attendee</p>
                            <p class="font-semibold text-[#071044]">{{ $ticket->attendee_name ?: auth()->user()?->name }}</p>
                        </div>
                        <div class="grid grid-cols-1 items-start gap-2 sm:grid-cols-[260px_1fr] sm:gap-4">
                            <p class="font-medium text-[#323A68]">Payment Status</p>
                            <p class="font-semibold capitalize text-emerald-700">{{ $ticket->payment_status ?: 'paid' }}</p>
                        </div>
                    </div>

                    <div class="my-5 h-px w-full bg-[#DEE3F3]"></div>

                    <div class="space-y-5 text-[16px] sm:text-[18px]">
                        @if ($formattedUnitPrice)
                            <div class="flex justify-between sm:grid sm:grid-cols-[260px_1fr] sm:items-center sm:gap-4">
                                <p class="font-medium text-[#323A68]">Price per ticket</p>
                                <p class="text-right font-semibold text-[#071044] sm:text-left">{{ $formattedUnitPrice }}</p>
                            </div>
                        @endif
                        <div class="flex justify-between sm:grid sm:grid-cols-[260px_1fr] sm:items-center sm:gap-4">
                            <p class="font-extrabold text-[#202B63]">Total Amount</p>
                            <p class="text-right text-[20px] font-extrabold tracking-[-0.02em] text-[#071044] sm:text-left sm:text-[23px]">{{ $formattedTotal }}</p>
                        </div>
                        <div class="flex justify-between sm:grid sm:grid-cols-[260px_1fr] sm:items-center sm:gap-4">
                            <p class="font-extrabold text-[#202B63]">Total Tickets</p>
                            <p class="text-right text-[17px] font-extrabold text-[#071044] sm:text-left sm:text-[19px]">{{ $ticket->quantity }}</p>
                        </div>
                    </div>
                </div>

                <div class="mx-auto mt-7 grid max-w-[748px] grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6">
                    <a href="{{ ($issuedTicket ?? null) ? route('qr-ticket.show', $issuedTicket) : route('events.tickets.e-ticket', ['order' => $ticket->order_number]) }}"
                        class="flex h-[58px] items-center justify-center rounded-lg bg-gradient-to-r from-[#5B2EFF] to-[#4310D8] text-[16px] font-extrabold text-white shadow-[0_14px_30px_rgba(91,46,255,0.18)] transition hover:-translate-y-0.5 sm:h-[66px] sm:text-[18px]">
                        Get QR Ticket
                    </a>
                    <a href="{{ route('frontend.user.dashboard') }}"
                        class="flex h-[58px] items-center justify-center rounded-lg border border-[#907BFF] bg-white text-[16px] font-extrabold text-[#4320D6] transition hover:bg-[#F7F4FF] sm:h-[66px] sm:text-[18px]">
                        Go to Dashboard
                    </a>
                </div>

                <form method="POST" action="{{ route('events.tickets.send-ticket-email') }}" class="mx-auto mt-4 max-w-[748px]">
                    @csrf
                    <input type="hidden" name="order" value="{{ $ticket->order_number }}">
                    <button type="submit" class="flex h-[52px] w-full items-center justify-center rounded-lg border border-[#DDE2F2] bg-white text-[15px] font-bold text-[#071044] transition hover:bg-[#F8FAFF]">
                        {{ $emailSent ? 'Resend Ticket Email' : 'Send Ticket to Email' }}
                    </button>
                </form>
            </section>
        </main>
@endsection

@push('scripts')
<script>
localStorage.removeItem("eventOrder");
</script>
@endpush
