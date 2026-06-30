@extends('layouts.frontend')

@section('title', 'Verify Ticket')

@section('content')
<main class="mx-auto w-full max-w-[720px] flex-1 px-4 pb-12 pt-10 md:px-[32px]">
    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[14px] font-medium text-emerald-700">{{ session('success') }}</div>
    @endif
    @if (session('warning'))
        <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-[14px] font-medium text-amber-700">{{ session('warning') }}</div>
    @endif

    @if ($state === 'invalid')
        <div class="rounded-[20px] border border-red-200 bg-red-50 p-8 text-center">
            <h1 class="text-[28px] font-extrabold text-red-700">Invalid Ticket</h1>
            <p class="mt-3 text-[15px] text-red-600">This QR code is not valid or the ticket could not be found.</p>
        </div>
    @elseif ($state === 'not_started')
        <div class="rounded-[20px] border border-blue-200 bg-blue-50 p-8 text-center">
            <h1 class="text-[28px] font-extrabold text-blue-800">Event Not Started</h1>
            <p class="mt-3 text-[15px] text-blue-700">Check-in will open when the event begins.</p>
            @if ($eventWindow)
                <p class="mt-4 text-[15px] font-semibold text-blue-900">Event Dates: {{ $eventWindow }}</p>
            @endif
        </div>
    @elseif ($state === 'expired')
        <div class="rounded-[20px] border border-slate-200 bg-slate-50 p-8 text-center">
            <h1 class="text-[28px] font-extrabold text-slate-800">Event Ended</h1>
            <p class="mt-3 text-[15px] text-slate-600">This ticket is no longer valid because the event has ended.</p>
            @if ($eventWindow)
                <p class="mt-4 text-[15px] font-semibold text-slate-800">Event Dates: {{ $eventWindow }}</p>
            @endif
        </div>
    @elseif ($state === 'cancelled')
        <div class="rounded-[20px] border border-red-200 bg-red-50 p-8 text-center">
            <h1 class="text-[28px] font-extrabold text-red-700">Ticket Cancelled</h1>
            <p class="mt-3 text-[15px] text-red-600">This ticket has been cancelled and cannot be used.</p>
        </div>
    @elseif ($state === 'unpaid')
        <div class="rounded-[20px] border border-amber-200 bg-amber-50 p-8 text-center">
            <h1 class="text-[28px] font-extrabold text-amber-800">Payment Not Confirmed</h1>
            <p class="mt-3 text-[15px] text-amber-700">This ticket cannot be used until payment is confirmed.</p>
        </div>
    @elseif ($state === 'invalid_visitor')
        <div class="rounded-[20px] border border-red-200 bg-red-50 p-8 text-center">
            <h1 class="text-[28px] font-extrabold text-red-700">Visitor Not Verified</h1>
            <p class="mt-3 text-[15px] text-red-600">Visitor details could not be verified for this ticket.</p>
        </div>
    @elseif ($state === 'used_today')
        <div class="rounded-[20px] border border-emerald-200 bg-emerald-50 p-8">
            <h1 class="text-[28px] font-extrabold text-emerald-800">Already Checked In Today</h1>
            <p class="mt-3 text-[15px] text-emerald-700">This visitor has already been checked in for today.</p>
            <div class="mt-6 space-y-3 rounded-xl bg-white p-5 text-left text-[15px] text-[#1F2A6A]">
                <p><span class="font-bold">Visitor Name:</span> {{ $ticket->meta['attendee_name'] ?? $ticket->visitor?->name }}</p>
                <p><span class="font-bold">Checked-in Time:</span> {{ $todayCheckin?->checked_in_at?->format('M d, Y h:i A') ?? $ticket->checked_in_at?->format('M d, Y h:i A') ?? 'N/A' }}</p>
                <p><span class="font-bold">Total Check-ins:</span> {{ $checkinCount ?? 0 }}</p>
                <p><span class="font-bold">Total QR Scans:</span> {{ $scanCount ?? 0 }}</p>
                <p><span class="font-bold">Ticket Number:</span> {{ $ticket->ticket_no }}</p>
                <p><span class="font-bold">Event:</span> {{ $ticket->event?->title }}</p>
            </div>
        </div>
    @else
        <div class="rounded-[20px] border border-[#E8E3F0] bg-white p-8 shadow-[0_8px_30px_rgba(31,42,107,0.06)]">
            <h1 class="text-[28px] font-extrabold text-[#071044]">Verify Ticket</h1>
            <p class="mt-2 text-[15px] text-[#4E567A]">Review ticket details before allowing entry.</p>

            @if ($eventWindow)
                <p class="mt-3 text-[14px] font-medium text-emerald-700">Valid during event: {{ $eventWindow }}</p>
            @endif

            <div class="mt-6 space-y-3 rounded-xl bg-[#F8FAFF] p-5 text-[15px] text-[#1F2A6A]">
                <p><span class="font-bold">Visitor Name:</span> {{ $ticket->meta['attendee_name'] ?? $ticket->visitor?->name }}</p>
                <p><span class="font-bold">Event Name:</span> {{ $ticket->event?->title }}</p>
                <p><span class="font-bold">Ticket Number:</span> {{ $ticket->ticket_no }}</p>
                <p><span class="font-bold">Ticket Type:</span> {{ $ticket->ticket_type }} × {{ $ticket->quantity }}</p>
                <p><span class="font-bold">Payment Status:</span> {{ ucfirst($ticket->payment_status) }}</p>
                <p><span class="font-bold">Status:</span> {{ ucfirst($ticket->status) }}</p>
                <p><span class="font-bold">Previous Check-ins:</span> {{ $checkinCount ?? 0 }}</p>
                <p><span class="font-bold">QR Scans:</span> {{ $scanCount ?? 0 }}</p>
            </div>

            <form method="POST" action="{{ route('verify-ticket.check-in', $ticket->qr_token) }}" class="mt-6">
                @csrf
                <button type="submit"
                    class="inline-flex h-[52px] w-full items-center justify-center rounded-xl bg-[#4318FF] px-5 text-[15px] font-bold text-white shadow-[0_8px_20px_rgba(67,24,255,0.25)] transition hover:bg-[#3412C9]">
                    Mark Check-In
                </button>
            </form>
        </div>
    @endif
</main>
@endsection
