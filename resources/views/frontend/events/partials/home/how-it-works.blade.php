<div id="how-it-works" class="h-full rounded-[10px] border border-[#F0EEF8] bg-white px-7 py-7 shadow-[0_18px_42px_rgba(31,42,106,0.07)]">
    <h2 class="text-[24px] font-extrabold leading-none tracking-[-0.01em] text-[#191D4D]">How It Works</h2>
    <div class="relative mt-7 space-y-7">
        <span class="absolute bottom-8 left-4 top-4 w-px bg-[#E6E2F4]"></span>
        @foreach ($steps as $index => $step)
            <div class="relative flex gap-4">
                <span class="z-10 grid h-8 w-8 shrink-0 place-items-center rounded-full bg-gradient-to-br from-[#6A35FF] to-[#3F18CC] text-[14px] font-extrabold text-white shadow-[0_7px_16px_rgba(91,46,255,0.28)]">{{ $index + 1 }}</span>
                <div>
                    <h3 class="text-[17px] font-extrabold leading-tight text-[#232752]">{{ $step[0] }}</h3>
                    <p class="mt-2 max-w-md text-[14px] font-semibold leading-[1.55] text-[#555D83]">{{ $step[1] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
