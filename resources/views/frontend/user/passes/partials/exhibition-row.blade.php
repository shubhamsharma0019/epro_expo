@php
    $category = $exhibition['category'] ?? 'completed';
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
    $hasPass = str_contains($exhibition['explore_url'] ?? '', '/user/exhibitions/');
    $actionLabel = $hasPass ? 'Explore' : 'Get Pass';
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
            <h4>{{ $exhibition['name'] }}</h4>
        </div>
        <div class="meta-line">
            <span>{{ $exhibition['date_label'] }}</span>
            <span>{{ $exhibition['location'] }}</span>
        </div>
    </div>
    <div class="right">
        <a href="{{ $exhibition['explore_url'] }}" class="explore-btn">
            {{ $actionLabel }}
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
    </div>
</div>
