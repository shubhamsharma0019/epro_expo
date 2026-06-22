@php
    $activeNav = $activeNav ?? null;
    $navLinkClass = fn (string $key) => ($activeNav === $key ? 'text-[#5726E8]' : 'text-[#071044]') . ' hover:text-[#5726E8]';
@endphp
<header class="sticky top-0 z-50 border-b border-[#EEF0F7] bg-white/90 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1440px] items-center justify-between px-4 py-4 sm:px-6 lg:px-8 lg:py-5">
        <x-shared.brand-logo href="{{ route('home') }}" mark-class="h-11 w-11 rounded-[16px] text-[20px] sm:h-[54px] sm:w-[54px] sm:rounded-[18px] sm:text-[24px]" title-class="text-[24px] text-[#071044] sm:text-[30px]" subtitle-class="text-[10px] text-[#8A94AD] sm:text-[12px]" />

        <nav class="hidden items-center gap-10 text-[14px] font-semibold lg:flex">
            <a class="{{ $navLinkClass('events') }}" href="{{ route('events.home') }}">Explore Events</a>
            <a class="{{ $navLinkClass('exhibitions') }}" href="{{ route('exhibitions.index') }}">Exhibitions</a>
            <a class="{{ $navLinkClass('features') }}" href="{{ route('frontend.features') }}">Features</a>
            <a class="{{ $navLinkClass('pricing') }}" href="{{ route('frontend.pricing') }}">Pricing</a>
            <a class="{{ $navLinkClass('about') }}" href="{{ route('frontend.about') }}">About Us</a>
        </nav>

        <div class="hidden items-center gap-4 lg:flex">
            <a href="{{ route('events.home') }}" class="rounded-lg bg-gradient-to-r from-[#6D28D9] to-[#4B16D8] px-6 py-3 text-[14px] font-bold text-white shadow-[0_12px_24px_rgba(91,46,255,0.26)]">Get Started</a>
        </div>

        <button id="eventHomeMenuBtn" class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-[#E0E4EF] lg:hidden" aria-label="Open menu">
            <span class="text-2xl">&#9776;</span>
        </button>
    </div>

    <div id="eventHomeMobileMenu" class="hidden border-t border-[#EEF0F7] bg-white px-4 py-5 sm:px-6 lg:hidden">
        <div class="flex flex-col gap-4 text-[15px] font-semibold">
            <a class="{{ $navLinkClass('events') }}" href="{{ route('events.home') }}">Explore Events</a>
            <a class="{{ $navLinkClass('exhibitions') }}" href="{{ route('exhibitions.index') }}">Exhibitions</a>
            <a class="{{ $navLinkClass('features') }}" href="{{ route('frontend.features') }}">Features</a>
            <a class="{{ $navLinkClass('pricing') }}" href="{{ route('frontend.pricing') }}">Pricing</a>
            <a class="{{ $navLinkClass('about') }}" href="{{ route('frontend.about') }}">About Us</a>
            <div class="grid grid-cols-1 gap-3 pt-2">
                <a href="{{ route('events.home') }}" class="rounded-lg bg-[#5726E8] px-5 py-3 text-center font-bold text-white">Get Started</a>
            </div>
        </div>
    </div>
</header>

<script>
    (() => {
        const menuButton = document.getElementById('eventHomeMenuBtn');
        const mobileMenu = document.getElementById('eventHomeMobileMenu');

        menuButton?.addEventListener('click', () => {
            mobileMenu?.classList.toggle('hidden');
        });

        mobileMenu?.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
        });
    })();
</script>
