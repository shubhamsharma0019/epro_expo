@extends('layouts.visitor-portal')

@section('title', 'eproexpo — Exhibition Pass')
@section('shell-class', 'shell--passes')

@section('page-styles')
@include('frontend.user.tickets.partials.ticket-page-styles')
@endsection

@section('portal-content')
@php
    $exhibitionName = $pass->exhibition->title ?? $pass->exhibition->name ?? 'Exhibition';
    $dateInfo = $pass->exhibition?->start_date?->format('M d, Y') ?? 'Date TBD';
    $qrData = urlencode($pass->booking_id . '|' . $exhibitionName . '|' . $pass->email);
    $initials = collect(explode(' ', $pass->name ?? 'V'))->map(fn ($w) => substr($w, 0, 1))->take(2)->implode('');
    $hallsUrl = filled($pass->exhibition?->slug) && $pass->payment_status === 'completed'
        ? route('frontend.user.exhibitions.halls', $pass->exhibition->slug)
        : null;
@endphp
<main class="main">
    <a href="{{ route('frontend.user.passes') }}" class="back-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M15 18l-6-6 6-6"/></svg>
        Back to My Passes
    </a>

    <div class="welcome-banner">
        <div>
            <h1>Exhibition Pass</h1>
            <p>Present this pass at the exhibition entry desk.</p>
        </div>
        <div class="pill"><span class="dot"></span>{{ $pass->booking_id }}</div>
    </div>

    <div class="ticket-grid">
        <article class="ticket-card">
            <div class="ticket-card-inner">
                <div class="ticket-hero">
                    <span class="tag">Exhibition Pass</span>
                    <h1>{{ $exhibitionName }}</h1>
                    <p>Your visitor pass is confirmed for exhibition entry.</p>
                    <div class="ticket-meta">
                        <div class="box"><span>Date</span><strong>{{ $dateInfo }}</strong></div>
                        <div class="box"><span>Pass ID</span><strong>{{ $pass->booking_id }}</strong></div>
                        <div class="box"><span>Status</span><strong>Confirmed</strong></div>
                    </div>
                </div>
                <div class="ticket-qr">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ $qrData }}" alt="Exhibition pass QR code">
                    <div class="tid">Booking ID<strong>{{ $pass->booking_id }}</strong></div>
                    <span class="ready">Ready for entry</span>
                </div>
            </div>
        </article>

        <aside class="side-actions" style="display:flex; flex-direction:column; gap:14px;">
            <div class="side-card">
                <h2>Visitor</h2>
                <div class="attendee">
                    <div class="av">{{ strtoupper($initials) }}</div>
                    <div>
                        <p>{{ $pass->name }}</p>
                        <span>{{ $pass->email }}</span>
                    </div>
                </div>
            </div>
            <div class="side-card">
                <h2>Actions</h2>
                @if ($hallsUrl)
                    <a href="{{ $hallsUrl }}" class="action-btn primary">Explore Halls</a>
                @endif
                <button type="button" class="action-btn {{ $hallsUrl ? 'secondary' : 'primary' }}" onclick="window.print()">Download Pass</button>
                <a href="{{ route('frontend.user.passes') }}" class="action-btn secondary">Back to My Passes</a>
            </div>
        </aside>
    </div>
</main>
@endsection
