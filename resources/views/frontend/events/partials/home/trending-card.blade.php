@php
    $eventSlug = $event['slug'] ?? \Illuminate\Support\Str::slug($event['title']);
    $fallbackEventImage = asset('images/events-home/trending/global-tech-summit.svg');
    $eventImage = $event['imageUrl'] ?? ($assetBase . '/' . ($event['image'] ?? 'trending/global-tech-summit.svg'));
@endphp

<article class="overflow-hidden rounded-[9px] border border-[#E8EAF3] bg-white shadow-[0_8px_18px_rgba(31,42,106,0.06)]">
    <a href="{{ url('/events/listings/' . $eventSlug) }}" class="relative block aspect-[16/9] overflow-hidden bg-[#071044]">
        <img src="{{ $eventImage }}" alt="{{ $event['title'] }}" class="block h-full w-full object-cover" onerror="this.onerror=null;this.src='{{ $fallbackEventImage }}';">
        <span class="absolute left-2.5 top-2.5 inline-flex items-center gap-1 rounded-[5px] px-2.5 py-1 text-[10px] font-extrabold leading-none shadow-[0_8px_16px_rgba(7,16,68,0.18)] {{ $event['badgeClass'] }}">
            <span class="h-1.5 w-1.5 rounded-full bg-current opacity-80"></span>
            {{ $event['badge'] }}
        </span>
    </a>
    <div class="px-4 pb-4 pt-5">
        <h3 class="truncate text-[15px] font-extrabold leading-snug text-[#071044]">{{ $event['title'] }}</h3>
        <div class="mt-4 flex items-center justify-between gap-2 text-[11px] font-bold text-[#6F7692]">
            <span class="flex min-w-0 items-center gap-1.5 truncate">
                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true"><rect x="2.5" y="3.5" width="11" height="10" rx="2" stroke="currentColor" stroke-width="1.4"/><path d="M5 2v3M11 2v3M3 6.5h10" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                {{ $event['date'] }}
            </span>
            <span class="flex shrink-0 items-center gap-1.5">
                <svg class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M8 14s4.5-4.1 4.5-8A4.5 4.5 0 0 0 3.5 6c0 3.9 4.5 8 4.5 8Z" stroke="currentColor" stroke-width="1.4"/><circle cx="8" cy="6" r="1.6" stroke="currentColor" stroke-width="1.4"/></svg>
                {{ $event['country'] }}
            </span>
        </div>
        <p class="mt-3 flex items-center gap-1.5 truncate text-[11px] font-bold text-[#6F7692]">
            <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true"><circle cx="8" cy="8" r="5.5" stroke="currentColor" stroke-width="1.4"/><path d="M2.8 8h10.4M8 2.5c1.6 1.5 2.4 3.3 2.4 5.5S9.6 12 8 13.5C6.4 12 5.6 10.2 5.6 8S6.4 4 8 2.5Z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
            {{ $event['type'] }}
        </p>
        <div class="mt-5 grid gap-3">
            <span class="truncate text-[18px] font-extrabold text-[#071044]">{{ $event['price'] }}</span>
            <a href="{{ url('/events/listings/' . $eventSlug) }}" class="inline-flex h-9 w-full items-center justify-center rounded-[7px] bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[12px] font-extrabold text-white shadow-[0_8px_14px_rgba(91,46,255,0.22)]">View Event</a>
        </div>
    </div>
</article>
