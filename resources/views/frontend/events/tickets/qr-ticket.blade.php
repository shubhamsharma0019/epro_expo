@extends('layouts.frontend')

@section('title', 'QR Ticket - ' . ($ticket->event?->title ?? 'Event'))

@section('content')
@php
    use App\Support\LiveContent;

    $event = $ticket->event;
    $eventName = $event?->title ?? 'Event';
    $dateInfo = $event?->starts_at
        ? $event->starts_at->format('M d, Y') . ($event->ends_at ? ' - ' . $event->ends_at->format('M d, Y') : '')
        : 'Date TBD';
    $timeInfo = $event?->starts_at
        ? $event->starts_at->format('h:i A') . ($event->ends_at ? ' - ' . $event->ends_at->format('h:i A') : '') . ($event->timezone ? ' (' . $event->timezone . ')' : '')
        : 'Time TBD';
    $venueInfo = LiveContent::formatCompanyEventVenue($event);
    $attendeeName = $ticket->meta['attendee_name'] ?? $ticket->visitor?->name ?? 'Attendee';
    $bookingNumber = $ticket->booking?->booking_number ?? $visitorTicket?->order_number ?? 'N/A';
    $scanWindowState = app(\App\Domain\Visitor\Services\EventTicketScanService::class)->eventWindowState($event);
    $scanStatusLabel = match ($scanWindowState) {
        'not_started' => 'Ready for QR scan',
        'expired' => 'Event ended — QR scan no longer valid',
        default => ($remainingCheckIns ?? 0) <= 0
            ? 'All event day check-ins used'
            : (($checkinCount ?? 0) > 0
                ? 'Checked in ' . ($checkinCount ?? 0) . ' of ' . ($eventDayCount ?? 1) . ' event days'
                : 'Valid for check-in during event dates'),
    };
@endphp
<main class="mx-auto w-full max-w-[1440px] flex-1 px-4 pb-12 pt-6 sm:px-6 lg:px-8">
    @if ($visitorTicket)
        <a href="{{ route('events.tickets.confirmed', ['order' => $visitorTicket->order_number]) }}"
            class="mb-4 inline-flex items-center gap-3 text-[15px] font-medium text-[#182064] transition hover:text-[#3B19E6]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Back to Confirmation
        </a>
    @endif

    @include('frontend.events.tickets.partials.event-flow-stepper', ['currentStep' => 4])

    <div class="mb-6 mt-6">
        <h1 class="text-[28px] font-extrabold leading-tight tracking-[-0.035em] text-[#071044] sm:text-[32px]">Get QR Ticket</h1>
        <p class="mt-2 text-[16px] font-medium text-[#1E2A67] sm:text-[18px]">View, download, or email your event visitor pass.</p>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[14px] font-medium text-emerald-700">{{ session('success') }}</div>
    @endif
    @php
        $warningMessage = session('warning');
        $emailFailureMessage = \App\Support\EventTicketMail::visitorSendFailureMessage($ticketRecipientEmail ?? null);
    @endphp
    @if ($warningMessage && $warningMessage !== $emailFailureMessage)
        <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-[14px] font-medium text-amber-700">
            {{ $warningMessage }}
        </div>
    @endif
    @if (($emailSent ?? false) && ($ticketRecipientEmail ?? null))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[14px] font-medium text-emerald-700">
            Ticket emailed to {{ $ticketRecipientEmail }}.
        </div>

    @endif

    <div id="ticketCard" class="overflow-hidden rounded-[16px] border border-[#3B47C8] bg-white shadow-[0_8px_30px_rgba(31,42,107,0.08)]">
        <div class="grid min-h-[292px] grid-cols-1 md:grid-cols-[1fr_330px]">
            <div class="relative overflow-hidden bg-[#06154B] px-6 py-8 text-white md:px-[43px] md:py-[48px]">
                <div class="absolute inset-0 opacity-70" style="background: radial-gradient(circle at 76% 0%, rgba(75,46,255,.35), transparent 38%), radial-gradient(circle at 12% 88%, rgba(26,62,166,.65), transparent 42%), linear-gradient(135deg, #071044 0%, #06195c 56%, #061044 100%);"></div>
                <div class="relative z-10">
                    <span class="inline-flex rounded-full bg-white/12 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.12em]">Visitor Pass</span>
                    <h2 class="mt-5 text-[26px] font-extrabold leading-tight tracking-[-0.035em] sm:text-[30px]">{{ $eventName }}</h2>
                    <div class="mt-8 space-y-4 text-[16px] font-semibold sm:text-[18px]">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/></svg>
                            <span>{{ $dateInfo }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                            <span>{{ $timeInfo }}</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-4.438 7-11a7 7 0 1 0-14 0c0 6.562 7 11 7 11Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"/></svg>
                            <span>{{ $venueInfo }}</span>
                        </div>
                    </div>
                    <div class="mt-8 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-xl border border-white/14 bg-white/10 p-4">
                            <p class="text-[12px] text-white/60">Visitor Name</p>
                            <p class="mt-1 text-[15px] font-bold">{{ $attendeeName }}</p>
                        </div>
                        <div class="rounded-xl border border-white/14 bg-white/10 p-4">
                            <p class="text-[12px] text-white/60">Ticket Type</p>
                            <p class="mt-1 text-[15px] font-bold">{{ $ticket->ticket_type }} × {{ $ticket->quantity }}</p>
                        </div>
                        <div class="rounded-xl border border-white/14 bg-white/10 p-4">
                            <p class="text-[12px] text-white/60">Ticket Number</p>
                            <p class="mt-1 text-[15px] font-bold">{{ $ticket->ticket_no }}</p>
                        </div>
                        <div class="rounded-xl border border-white/14 bg-white/10 p-4">
                            <p class="text-[12px] text-white/60">Payment Status</p>
                            <p class="mt-1 text-[15px] font-bold">{{ ucfirst($ticket->payment_status) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center justify-center border-t border-dashed border-[#D8DDF0] bg-[#F8FAFF] p-8 text-center md:border-l md:border-t-0">
                @include('frontend.events.tickets.partials.qr-code', ['ticket' => $ticket, 'displaySize' => 220])
                <p class="mt-5 text-[12px] font-bold uppercase tracking-[0.16em] text-[#5A6480]">Booking Code</p>
                <p class="mt-2 text-[17px] font-bold text-[#071044]">{{ $bookingNumber }}</p>
                <div class="mt-5 inline-flex rounded-full bg-emerald-50 px-4 py-2 text-[13px] font-semibold text-emerald-700">
                    {{ $scanStatusLabel }}
                </div>
                @if (($eventDayCount ?? 1) > 1)
                    <p class="mt-3 text-[12px] font-medium text-[#5A6480]">
                        {{ $checkinCount ?? 0 }} of {{ $eventDayCount }} event day check-ins used
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <a href="{{ route('frontend.user.dashboard') }}"
            class="inline-flex h-[52px] items-center justify-center rounded-xl bg-[#4318FF] px-5 text-[15px] font-bold text-white shadow-[0_8px_20px_rgba(67,24,255,0.25)] transition hover:bg-[#3412C9] sm:col-span-1">
            Continue to Dashboard
        </a>
        <button type="button" onclick="window.print()"
            class="inline-flex h-[52px] items-center justify-center rounded-xl border border-[#907BFF] bg-white px-5 text-[15px] font-bold text-[#4320D6] transition hover:bg-[#F7F4FF]">
            Download Ticket
        </button>
        <form method="POST" action="{{ route('qr-ticket.send-email', $ticket) }}">
            @csrf
            <button type="submit"
                @disabled(! ($ticketRecipientEmail ?? null))
                class="inline-flex h-[52px] w-full items-center justify-center gap-2 rounded-xl border border-[#907BFF] bg-white px-5 text-[15px] font-bold text-[#4320D6] transition hover:bg-[#F7F4FF] disabled:cursor-not-allowed disabled:opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                {{ ($emailSent ?? false) ? 'Resend Email' : 'Send Email' }}
            </button>
        </form>
    </div>
</main>
@endsection

@if (request()->boolean('download'))
    @push('scripts')
    <script>window.addEventListener('load', function () { window.print(); });</script>
    @endpush
@endif
