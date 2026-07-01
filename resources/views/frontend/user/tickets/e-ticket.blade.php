@extends('layouts.visitor-portal')

@section('title', 'eproexpo — Event E-Ticket')
@section('shell-class', 'shell--passes')

@section('page-styles')
@include('frontend.user.tickets.partials.ticket-page-styles')
@endsection

@section('portal-content')
@php
    use App\Support\EventTicketQr;
    $eventName = $ticket->companyEvent ? $ticket->companyEvent->title : 'Event';
    if (! $ticket->companyEvent && $ticket->event_slug == 'global-tech-summit-2024') {
        $eventName = 'Global Tech Summit 2024';
    }
    $dateInfo = $ticket->companyEvent ? ($ticket->companyEvent->starts_at?->format('M d, Y') ?? 'Date TBD') : 'May 15 - May 17, 2024';
    $timeInfo = $ticket->companyEvent && $ticket->companyEvent->start_time
        ? \Carbon\Carbon::parse($ticket->companyEvent->start_time)->format('h:i A')
        : '10:00 AM';
    $qrImageUrl = EventTicketQr::imageUrl($ticket, 512);
    $initials = collect(explode(' ', $ticket->attendee_name))->map(fn ($w) => substr($w, 0, 1))->take(2)->implode('');
@endphp
<main class="main">
    @if (session('success'))
        <div style="background:#E9FAF1;border:1px solid #B8EFD4;color:#1D9E75;padding:12px 14px;border-radius:12px;font-size:13px;font-weight:600;margin-bottom:14px;">{{ session('success') }}</div>
    @endif
    @if (session('warning'))
        <div style="background:#FFF8E6;border:1px solid #F5DFA0;color:#9A6700;padding:12px 14px;border-radius:12px;font-size:13px;font-weight:600;margin-bottom:14px;">{{ session('warning') }}</div>
    @endif
    <a href="{{ route('frontend.user.passes') }}" class="back-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M15 18l-6-6 6-6"/></svg>
        Back to My Passes
    </a>

    <div class="welcome-banner">
        <div>
            <h1>Event E-Ticket</h1>
            <p>Your pass is active. Keep this QR ready at entry.</p>
        </div>
    </div>

    <div class="ticket-grid">
        <article class="ticket-card">
            <div class="ticket-card-inner">
                <div class="ticket-hero">
                    <span class="tag">Confirmed Ticket</span>
                    <h1>{{ $eventName }}</h1>
                    <p>Arrive early for smooth badge verification at the entry gate.</p>
                    <div class="ticket-meta">
                        <div class="box"><span>Date</span><strong>{{ $dateInfo }}</strong></div>
                        <div class="box"><span>Time</span><strong>{{ $timeInfo }}</strong></div>
                        <div class="box"><span>Seat</span><strong>General</strong></div>
                    </div>
                </div>
                <div class="ticket-qr">
                    <img src="{{ $qrImageUrl }}" alt="Event ticket QR code">
                    <div class="tid">Ticket ID<strong>{{ $ticket->order_number }}</strong></div>
                    <span class="ready">Ready for check-in</span>
                </div>
            </div>
        </article>

        <aside class="side-actions" style="display:flex; flex-direction:column; gap:14px;">
            <div class="side-card">
                <h2>Attendee</h2>
                <div class="attendee">
                    <div class="av">{{ strtoupper($initials) }}</div>
                    <div>
                        <p>{{ $ticket->attendee_name }}</p>
                        <span>{{ $ticket->attendee_email }}</span>
                    </div>
                </div>
                <div class="detail-row"><span>Entry gate</span><strong>Main Gate</strong></div>
                <div class="detail-row"><span>Ticket type</span><strong>{{ $ticket->ticket_name }} x {{ $ticket->quantity }}</strong></div>
                <div class="detail-row"><span>Status</span><strong style="color:#1D9E75;">Paid</strong></div>
            </div>
            <div class="side-card">
                <h2>Actions</h2>
                <a href="{{ route('frontend.user.tickets.e-ticket', ['id' => $ticket->id, 'download' => 1]) }}" class="action-btn primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
                    Download Pass
                </a>
                @if ($emailConfigured ?? false)
                    <form method="POST" action="{{ route('frontend.user.tickets.email', $ticket->id) }}" class="m-0">
                        @csrf
                        <button type="submit" class="action-btn secondary" style="width:100%;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M4 7l8 6 8-6"/></svg>
                            Email Pass
                        </button>
                    </form>
                @endif
                <a href="{{ route('frontend.user.passes') }}" class="action-btn secondary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                    Back to My Passes
                </a>
            </div>
        </aside>
    </div>
</main>
@endsection

@if (request()->boolean('download'))
@push('scripts')
<script>window.addEventListener('load', () => window.print());</script>
@endpush
@endif
