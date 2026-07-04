<header class="sticky top-0 z-50 border-b border-[#EEF0F7] bg-white/90 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1440px] items-center justify-between px-4 py-4 sm:px-6 lg:px-8 lg:py-5">
        <x-shared.frontend-brand-logo />

        <nav class="hidden items-center gap-10 text-[14px] font-semibold text-[#071044] lg:flex">
            <a class="hover:text-[#5726E8]" href="{{ route('events.home') }}">Explore Events</a>
            <a class="hover:text-[#5726E8]" href="{{ route('exhibitions.index') }}">Exhibitions</a>
            <a class="hover:text-[#5726E8]" href="{{ route('home') }}#features">Features</a>
            <a class="hover:text-[#5726E8]" href="{{ route('home') }}#pricing">Pricing</a>
            <a class="hover:text-[#5726E8]" href="{{ route('home') }}#about">About Us</a>
        </nav>

        <div class="hidden items-center gap-4 lg:flex">
            <x-frontend.get-started-menu menu-id="sharedGetStarted" />
        </div>

        <button type="button" data-mobile-menu-button class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-[#E0E4EF] text-[#071044] lg:hidden" aria-label="Open menu">
            <span class="text-2xl">&#9776;</span>
        </button>
    </div>

    <div data-mobile-menu class="hidden border-t border-[#EEF0F7] bg-white px-4 py-5 sm:px-6 lg:hidden">
        <div class="flex flex-col gap-4 text-[15px] font-semibold text-[#071044]">
            <a href="{{ route('events.home') }}">Explore Events</a>
            <a href="{{ route('exhibitions.index') }}">Exhibitions</a>
            <a href="{{ route('home') }}#features">Features</a>
            <a href="{{ route('home') }}#pricing">Pricing</a>
            <a href="{{ route('home') }}#about">About Us</a>
            <x-frontend.get-started-menu variant="mobile" />
        </div>
    </div>
</header>

@push('scripts')
<script>
    const mobileMenuButton = document.querySelector('[data-mobile-menu-button]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
</script>
@endpush
