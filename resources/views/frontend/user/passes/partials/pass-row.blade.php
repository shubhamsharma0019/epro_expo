@php
    $category = $pass['category'] ?? 'completed';
    $badgeClass = match ($category) {
        'upcoming' => 'upcoming',
        'live' => 'live',
        default => 'completed',
    };
    $badgeLabel = match ($category) {
        'upcoming' => 'Upcoming',
        'live' => 'Live',
        default => 'Completed',
    };
@endphp
@php
    $emailUrl = $emailUrl ?? null;
@endphp
<div class="pass-row" data-status="{{ $category }}">
    <div class="ic">
        @if ($category === 'live')
            <span class="live-beep" aria-hidden="true"></span>
        @endif
        @if ($isEvent)
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 2v4M16 2v4"/></svg>
        @else
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21V8l9-5 9 5v13"/><path d="M9 21v-7h6v7"/></svg>
        @endif
    </div>
    <div class="body">
        <div class="top-line">
            <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
            <h4>{{ $pass['name'] }}</h4>
        </div>
        <div class="meta-line">
            <span>{{ $pass['date'] ? $pass['date']->format('M d, Y') : 'Date TBD' }}</span>
            @if (($pass['quantity'] ?? 1) > 1)
                <span>Qty {{ $pass['quantity'] }}</span>
            @endif
            @if (! empty($pass['number']))
                <span>{{ $pass['number'] }}</span>
            @endif
        </div>
    </div>
    <div class="right">
        <span class="status-confirmed">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
            {{ ucfirst($pass['status'] ?? 'confirmed') }}
        </span>
        <a href="{{ $downloadUrl }}" class="icon-btn" title="Download ticket">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
        </a>
        @if ($emailUrl)
            <form method="POST" action="{{ $emailUrl }}" class="m-0">
                @csrf
                <button type="submit" class="icon-btn" title="Email ticket">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M4 7l8 6 8-6"/></svg>
                </button>
            </form>
        @endif
    </div>
</div>
