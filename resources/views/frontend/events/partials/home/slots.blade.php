<div id="slots" class="h-full rounded-[10px] border border-[#F0EEF8] bg-white px-7 py-7 shadow-[0_18px_42px_rgba(31,42,106,0.07)]">
    <h2 class="text-[24px] font-extrabold leading-none tracking-[-0.01em] text-[#191D4D]">Ticket Booking &amp; Slots</h2>
    <p class="mt-5 flex items-center gap-2 text-[13px] font-extrabold text-[#59617F]">
        <svg class="h-[14px] w-[14px] shrink-0 text-[#7D829D]" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 18s6-5.18 6-10A6 6 0 1 0 4 8c0 4.82 6 10 6 10Zm0-7a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
        </svg>
        <span>Time Zone: (GMT+05:30) Asia/Kolkata</span>
    </p>

    <h3 class="mt-7 text-[15px] font-extrabold text-[#252A57]">Available Slots</h3>
    <div class="mt-3 overflow-hidden rounded-[10px] border border-[#ECEAF4] bg-white">
        @if (count($slots) > 0)
            @foreach ($slots as $slot)
                <div class="grid grid-cols-[1fr_auto_auto] items-center gap-4 border-b border-[#ECEAF4] px-4 py-3.5 last:border-b-0">
                    <div>
                        <p class="text-[13px] font-extrabold leading-tight text-[#252A57]">{{ $slot['time'] }}</p>
                        <p class="mt-1 text-[12px] font-extrabold text-[#1CA65E]">{{ $slot['seats'] }}</p>
                    </div>
                    <span class="min-w-10 text-right text-[17px] font-extrabold text-[#252A57]">{{ $slot['price'] }}</span>
                    <a href="{{ $slot['href'] }}" class="rounded-[7px] border border-[#E1DDF1] bg-white px-5 py-2.5 text-[12px] font-extrabold text-[#5b2eff] shadow-[0_5px_12px_rgba(31,42,106,0.04)] transition hover:border-[#B9A8F3] hover:bg-[#F8F6FF]">Select</a>
                </div>
            @endforeach
        @else
            <div class="px-5 py-7 text-center">
                <p class="text-[13px] font-extrabold text-[#252A57]">No ticket slots available yet</p>
                <p class="mt-2 text-[12px] font-semibold text-[#59617F]">Published events with dates will appear here.</p>
            </div>
        @endif
    </div>
    <a href="{{ url('/events/listings') }}" class="mt-5 block rounded-[7px] border border-[#E7EAF3] bg-white py-3 text-center text-[13px] font-extrabold text-[#5b2eff] transition hover:border-[#B9A8F3] hover:bg-[#F8F6FF]">View More Slots</a>
</div>
