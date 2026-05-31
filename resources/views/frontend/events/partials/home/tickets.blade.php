<section id="tickets" class="mt-8 grid gap-6 xl:grid-cols-[0.95fr_1fr]">
    <div class="rounded-[8px] border border-[#F0EEF8] bg-white px-5 py-5 shadow-[0_12px_28px_rgba(31,42,106,0.055)]">
        <div class="mb-5 flex items-center justify-between gap-5">
            <h2 class="text-[20px] font-extrabold leading-none tracking-[-0.01em] text-[#191D4D]">Your Tickets</h2>
            <a href="{{ url('/events/profile/my-tickets') }}" class="inline-flex items-center gap-2 text-[12px] font-extrabold text-[#5b2eff]">
                <span>View All Tickets</span>
                <span aria-hidden="true">-&gt;</span>
            </a>
        </div>
        <div class="overflow-hidden rounded-[10px] border border-[#F0EEF8] bg-white">
            @if (count($tickets) > 0)
                @foreach ($tickets as $ticket)
                    @include('frontend.events.partials.home.ticket-row', ['ticket' => $ticket])
                @endforeach
            @else
                <div class="px-5 py-8 text-center">
                    <p class="text-[14px] font-extrabold text-[#071044]">No event tickets yet</p>
                    <a href="{{ url('/events/listings') }}" class="mt-3 inline-flex rounded-[7px] bg-[#5b2eff] px-5 py-2.5 text-[12px] font-extrabold text-white">Browse Events</a>
                </div>
            @endif
        </div>
    </div>

    @include('frontend.events.partials.home.sample-ticket')
</section>
