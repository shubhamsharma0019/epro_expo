<section class="mt-8 rounded-[18px] bg-white px-7 py-6 shadow-[0_12px_35px_rgba(31,42,106,0.05)]">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-[20px] font-semibold text-[#071044]">Browse Events by Category</h2>
        <a href="{{ url('/events/listings/categories') }}" class="text-[13px] font-semibold text-[#5b2eff]">View All Categories&nbsp; -></a>
    </div>
    <div class="grid grid-cols-2 gap-5 md:grid-cols-4 xl:grid-cols-8">
        @foreach ($categories as $category)
            <a href="{{ route('events.listings.index', ['category' => $category['value'] ?? $category['name']]) }}" class="flex h-[136px] flex-col items-center justify-center rounded-[12px] border border-[#EEF0F7] bg-white px-4 text-center shadow-[0_8px_18px_rgba(31,42,106,0.04)] transition hover:border-[#cfc6ff]">
                <img src="{{ asset('images/events-home/categories/' . $category['icon']) }}" alt="{{ $category['name'] }}" class="h-12 w-12 object-contain">
                <h3 class="mt-3 text-[14px] font-semibold text-[#071044]">{{ $category['name'] }}</h3>
                <p class="mt-1 text-[12px] font-medium text-[#4E567A]">{{ $category['count'] }}</p>
            </a>
        @endforeach
    </div>
</section>
