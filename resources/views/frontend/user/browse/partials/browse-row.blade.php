@php
    $category = $item['category'] ?? 'completed';
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
    $isEvent = ($item['type'] ?? 'exhibition') === 'event';
    $hasTicket = (bool) ($item['has_ticket'] ?? false);
    if ($isEvent) {
        $actionUrl = $hasTicket ? ($item['ticket_url'] ?? route('frontend.user.passes')) : ($item['book_url'] ?? '#');
        $actionLabel = $hasTicket ? 'View Ticket' : 'Get Ticket';
    } else {
        $actionUrl = $item['explore_url'] ?? ($item['book_url'] ?? '#');
        $actionLabel = 'Explore';
    }
@endphp
<div class="browse-row" data-status="{{ $category }}">
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
            <h4>{{ $item['name'] }}</h4>
        </div>
        <div class="meta-line">
            <span>{{ $item['date_label'] }}</span>
            <span>{{ $item['location'] }}</span>
        </div>
    </div>
    <div class="right">
        <a href="{{ $actionUrl }}" class="explore-btn">
            {{ $actionLabel }}
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
    </div>
</div>
