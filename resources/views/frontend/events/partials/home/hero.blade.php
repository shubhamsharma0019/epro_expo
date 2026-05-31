<section class="relative overflow-visible lg:min-h-[535px]">
    <div class="absolute right-0 top-0 z-0 hidden h-[520px] w-[780px] lg:block">
        @include('frontend.events.partials.home.hero-carousel')
    </div>

    <div class="relative z-10 max-w-[960px]">
        <h1 class="max-w-[610px] text-[36px] font-semibold leading-[1.08] text-[#071044] min-[420px]:text-[42px] sm:text-[56px] sm:leading-[1.03]">
            Discover <span class="text-[#5b2eff]">Events.</span><br>
            Book <span class="text-[#5b2eff]">Tickets.</span> Join Live.
        </h1>
        <p class="mt-5 max-w-[560px] text-[15px] font-medium leading-[1.65] text-[#071044] sm:mt-7 sm:text-[18px]">
            Explore thousands of events across categories and countries. Book your tickets and get access to live sessions as per available slots.
        </p>

        <div class="mt-7 rounded-[14px] border border-[#E7EAF3] bg-white p-4 shadow-[0_16px_38px_rgba(31,42,106,0.08)] sm:p-5 lg:mt-9 lg:w-[960px]">
            <div class="flex w-full overflow-hidden rounded-t-[10px] border border-b-0 border-[#E7EAF3] bg-white sm:w-max">
                <button class="flex-1 border-b-2 border-[#5b2eff] px-4 py-3 text-[13px] font-semibold text-[#5b2eff] sm:flex-none sm:px-8 sm:text-[14px]">Events</button>
                <a href="{{ route('exhibitions.index') }}" class="flex-1 px-4 py-3 text-center text-[13px] font-semibold text-[#071044] sm:flex-none sm:px-8 sm:text-[14px]">Virtual Exhibitions</a>
            </div>
            @include('frontend.events.partials.home.search-form')
        </div>
    </div>

    <div class="mt-8 lg:hidden">
        @include('frontend.events.partials.home.hero-carousel')
    </div>
</section>
