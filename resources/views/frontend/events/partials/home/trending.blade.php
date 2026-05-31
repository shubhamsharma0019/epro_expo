<section id="trending" class="mt-8 bg-white">
    <div class="mb-5 flex items-start justify-between gap-4">
        <div>
            <h2 class="text-[22px] font-extrabold leading-none text-[#071044]">Trending Events</h2>
            <p class="mt-3 text-[14px] font-semibold text-[#4E567A]">Popular events you don't want to miss</p>
        </div>
        <a href="{{ url('/events/listings') }}" class="mt-1 inline-flex shrink-0 items-center gap-2 text-[13px] font-extrabold text-[#5b2eff]">
            View All Events
            <span aria-hidden="true">-&gt;</span>
        </a>
    </div>
    @if (count($events) > 0)
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
            @foreach ($events as $event)
                @include('frontend.events.partials.home.trending-card', ['event' => $event])
            @endforeach
        </div>
    @else
        <div class="rounded-[10px] border border-dashed border-[#D8DDF0] bg-[#FBFCFF] px-6 py-8 text-center">
            <p class="text-[15px] font-extrabold text-[#071044]">No published events yet</p>
            <p class="mt-2 text-[13px] font-semibold text-[#4E567A]">Published company events will appear here automatically.</p>
        </div>
    @endif
</section>
