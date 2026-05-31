<header class="sticky top-0 z-50 border-b border-[#E7EAF3] bg-white/95 backdrop-blur lg:hidden">
    <div class="flex h-[76px] items-center justify-between px-5 sm:px-8">
        <a href="{{ url('/exhibitions/dashboard') }}" class="flex min-w-0 items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#5b2eff] via-[#C135FF] to-[#246BFF] shadow-sm">
                <span class="text-[16px] font-semibold text-white">e</span>
            </div>

            <div class="min-w-0 leading-none">
                <div class="text-[22px] font-semibold tracking-[-0.03em]">
                    <span class="text-[#071044]">epro</span><span class="text-[#246BFF]">expo</span>
                </div>
                <p class="mt-1 text-[11px] font-medium text-[#5A6480]">Visitor Dashboard</p>
            </div>
        </a>

        <button type="button" data-exhibition-mobile-button class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-[#E7EAF3] bg-white text-[#071044] shadow-sm" aria-label="Open menu">
            <i class="fa-solid fa-bars text-[18px]"></i>
        </button>
    </div>

    <div data-exhibition-mobile-menu class="hidden border-t border-[#E7EAF3] bg-white">
        <div class="flex gap-2 overflow-x-auto px-5 py-4 sm:px-8">
            <a href="{{ url('/exhibitions/dashboard') }}" class="shrink-0 rounded-full bg-[#F4F0FF] px-4 py-2 text-[14px] font-medium text-[#5b2eff]">Dashboard</a>
            <a href="{{ url('/exhibitions') }}" class="shrink-0 rounded-full px-4 py-2 text-[14px] font-medium text-[#34405F]">Browse</a>
            <a href="{{ url('/exhibitions/innovation-expo/companies') }}" class="shrink-0 rounded-full px-4 py-2 text-[14px] font-medium text-[#34405F]">Companies</a>
            <a href="{{ url('/exhibitions/halls') }}" class="shrink-0 rounded-full px-4 py-2 text-[14px] font-medium text-[#34405F]">Halls</a>
            <a href="{{ url('/exhibitions/innovation-expo/tickets/select') }}" class="shrink-0 rounded-full px-4 py-2 text-[14px] font-medium text-[#34405F]">Get Pass</a>
            <a href="{{ url('/exhibitions/innovation-expo/my-passes') }}" class="shrink-0 rounded-full px-4 py-2 text-[14px] font-medium text-[#34405F]">My Passes</a>
        </div>
    </div>
</header>

@push('scripts')
<script>
    const exhibitionMobileButton = document.querySelector('[data-exhibition-mobile-button]');
    const exhibitionMobileMenu = document.querySelector('[data-exhibition-mobile-menu]');

    if (exhibitionMobileButton && exhibitionMobileMenu) {
        exhibitionMobileButton.addEventListener('click', () => {
            exhibitionMobileMenu.classList.toggle('hidden');
        });
    }
</script>
@endpush
