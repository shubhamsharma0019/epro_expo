<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">

    <div class="mb-10 flex items-center gap-5 overflow-x-auto pb-1 text-[15px] font-medium text-[#34405F]">
        <a href="{{ url('/exhibitions/pavilions/innovation-pavilion') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                <i class="fa-solid fa-check text-[12px]"></i>
            </span>
            <span>Pavilion</span>
        </a>
        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>
        <a href="{{ url('/exhibitions/halls/hall-1') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                <i class="fa-solid fa-check text-[12px]"></i>
            </span>
            <span>Hall</span>
        </a>
        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>
        <a href="{{ url('/exhibitions/booths/sizes') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                <i class="fa-solid fa-check text-[12px]"></i>
            </span>
            <span>Booth Size</span>
        </a>
        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>
        <a href="{{ url('/exhibitions/booths/slots') }}" class="flex shrink-0 items-center gap-3 rounded-full bg-[#F4F0FF] px-4 py-2 text-purple">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[14px] font-semibold text-white">4</span>
            <span class="font-semibold">Services</span>
        </a>
        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>
        <a href="{{ url('/exhibitions/booking/review') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full border border-[#8FA0C7] bg-white text-[14px] font-semibold text-navy">5</span>
            <span>Review</span>
        </a>
    </div>

    <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-[32px] font-semibold leading-[40px] tracking-[-0.8px] text-navy">
                Hall 1 &ndash; Tech &amp; Innovation
            </h1>
            <p class="mt-4 text-[16px] font-medium leading-7 text-[#34405F]">
                Booth layout plan. Click on any booth to view details and availability.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" class="flex h-[48px] w-[48px] items-center justify-center rounded-md border border-borderColor text-[18px] font-semibold text-navy">+</button>
            <button type="button" class="flex h-[48px] w-[48px] items-center justify-center rounded-md border border-borderColor text-[22px] font-semibold text-navy">&minus;</button>
            <button type="button" class="flex h-[48px] w-[48px] items-center justify-center rounded-md border border-borderColor text-navy">
                <i class="fa-solid fa-expand text-[16px]"></i>
            </button>
        </div>
    </div>

    @include('frontend.exhibitions.booths.partials.floor-diagram', ['hideDetailsPanel' => false])

</section>
