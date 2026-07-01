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
    $exploreUrl = $pass['explore_url'] ?? null;
@endphp
<div class="pass-row" data-status="{{ $category }}">
    <div class="ic">
        @if ($category === 'live')
            <span class="live-beep" aria-hidden="true"></span>
        @endif
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21V8l9-5 9 5v13"/><path d="M9 21v-7h6v7"/></svg>
    </div>
    <div class="body">
        <div class="top-line">
            <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
            <h4>{{ $pass['name'] }}</h4>
        </div>
        <div class="meta-line">
            <span>{{ $pass['date'] ? $pass['date']->format('M d, Y') : 'Date TBD' }}</span>
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
        @if ($exploreUrl)
            <a href="{{ $exploreUrl }}" class="explore-btn">
                Explore
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        @endif
    </div>
</div>
