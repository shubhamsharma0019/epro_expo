<div class="rounded-[18px] bg-white px-7 py-6 shadow-[0_12px_35px_rgba(31,42,106,0.05)]">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-[20px] font-semibold text-[#071044]">Explore by Country</h2>
        <a href="{{ url('/events/listings/search') }}" class="text-[13px] font-semibold text-[#5b2eff]">View All Countries&nbsp; -></a>
    </div>
    <div class="grid gap-7 lg:grid-cols-[255px_minmax(0,1fr)]">
        <div class="space-y-3">
            @foreach ($countries as $country)
                <a href="{{ route('events.listings.index', ['country' => $country['name']]) }}" class="flex items-center justify-between border-b border-[#EEF0F7] pb-2.5 text-[13px] font-semibold text-[#071044]">
                    <span class="flex min-w-0 items-center gap-3">
                        <img src="{{ asset('images/events-home/flags/' . $country['flag']) }}" alt="{{ $country['name'] }}" class="h-[22px] w-8 shrink-0 rounded-[3px] object-cover shadow-sm">
                        <span class="truncate">{{ $country['name'] }}</span>
                    </span>
                    <span class="ml-4 shrink-0 text-[11px] font-medium text-[#4E567A]">{{ $country['count'] }}</span>
                </a>
            @endforeach
        </div>
        <div class="flex min-h-[285px] items-center justify-center">
            <img src="{{ asset('images/events-home/world-map.svg') }}" alt="Event countries map" class="h-auto w-full max-w-[650px] object-contain">
        </div>
    </div>
</div>
