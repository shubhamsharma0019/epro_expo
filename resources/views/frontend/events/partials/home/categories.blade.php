<section class="mt-8 rounded-[18px] bg-white px-4 py-5 shadow-[0_12px_35px_rgba(31,42,106,0.05)] sm:px-7 sm:py-6">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-[18px] font-semibold text-[#071044] sm:text-[20px]">Browse Events by Category</h2>
        <a href="{{ url('/events/listings/categories') }}" class="text-[13px] font-semibold text-[#5b2eff]">View All Categories&nbsp; -></a>
    </div>
    <div class="grid grid-cols-2 gap-3 sm:gap-5 md:grid-cols-4 xl:grid-cols-8">
        @forelse ($categories as $category)
            <a href="{{ route('events.listings.index', ['category' => $category['value'] ?? $category['name']]) }}" class="flex h-[120px] flex-col items-center justify-center rounded-[12px] border border-[#EEF0F7] bg-white px-3 py-4 text-center shadow-[0_8px_18px_rgba(31,42,106,0.04)] transition hover:border-[#cfc6ff] sm:h-[136px] sm:px-4">
                <img src="{{ asset('images/events-home/categories/' . $category['icon']) }}" alt="{{ $category['name'] }}" class="h-10 w-10 object-contain sm:h-12 sm:w-12">
                <h3 class="mt-2 text-[12px] font-semibold text-[#071044] sm:mt-3 sm:text-[14px]">{{ $category['name'] }}</h3>
                <p class="mt-1 text-[12px] font-medium text-[#4E567A]">{{ $category['count'] }}</p>
            </a>
        @empty
            <div class="col-span-full rounded-[10px] border border-dashed border-[#D8DDF0] bg-[#FBFCFF] px-6 py-8 text-center">
                <p class="text-[15px] font-extrabold text-[#071044]">No categories yet</p>
                <p class="mt-2 text-[13px] font-semibold text-[#4E567A]">Published events will populate categories automatically.</p>
            </div>
        @endforelse
    </div>
</section>
