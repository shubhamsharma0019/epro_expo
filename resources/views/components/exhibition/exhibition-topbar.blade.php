@php
    $activeSlug = request()->route('slug')
        ?? session('activeExhibitionSlug')
        ?? \App\Domain\Visitor\Models\Visitor::where('email', auth()->user()?->email)
            ->where('payment_status', 'completed')
            ->with('exhibition')
            ->latest()
            ->first()?->exhibition?->slug;

    $exhibition = $activeSlug
        ? \App\Domain\Event\Models\Exhibition::where('slug', $activeSlug)->first()
        : null;

    $pageTitle = trim($__env->yieldContent('page-title'));
    if ($pageTitle === '') {
        $pageTitle = $exhibition->title ?? $exhibition->name ?? 'Exhibition';
    }
@endphp

<header class="sticky top-0 z-30 flex min-h-[72px] items-center justify-between border-b border-gray-100 bg-white px-4 sm:px-8">
    <div class="flex min-w-0 flex-1 items-center gap-3">
        <button
            type="button"
            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-gray-200 text-[#0B132C] lg:hidden"
            data-sidebar-open
            data-user-sidebar-open
            aria-label="Open sidebar"
        >
            <i class="ph ph-list text-xl"></i>
        </button>
        <div class="visitor-topbar-title min-w-0">
            <h1 class="truncate text-[17px] font-bold text-[#0B132C] sm:text-[18px]">{{ $pageTitle }}</h1>
        </div>
    </div>

    @auth
        <div class="relative shrink-0" id="exhTopbarDropdownContainer">
            <button type="button" id="exhTopbarDropdownBtn" class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-gray-200 px-2 py-1.5 transition hover:bg-gray-50 focus:outline-none sm:gap-3 sm:px-2.5">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#3723db] text-[14px] font-semibold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </span>
                <span class="hidden text-left sm:block">
                    <span class="block max-w-[120px] truncate text-[13px] font-bold leading-none text-[#0B132C]">{{ auth()->user()->name }}</span>
                    <span class="block pt-1 text-[11px] font-medium leading-none text-gray-500">Visitor</span>
                </span>
                <i class="ph ph-caret-down hidden text-gray-400 sm:block"></i>
            </button>

            <div id="exhTopbarDropdownMenu" class="absolute right-0 z-50 mt-2.5 hidden w-48 origin-top-right rounded-xl border border-gray-100 bg-white py-1.5 shadow-lg">
                <a href="{{ route('frontend.user.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50">
                    <i class="ph ph-chart-pie-slice text-[16px] text-gray-500"></i>
                    Dashboard
                </a>
                <a href="{{ route('frontend.user.passes') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50">
                    <i class="ph ph-ticket text-[16px] text-gray-500"></i>
                    My Passes
                </a>
                <hr class="my-1 border-gray-100">
                <form method="POST" action="{{ route('frontend.user.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 border-0 bg-transparent px-4 py-2.5 text-left text-[13px] font-semibold text-red-600 hover:bg-red-50">
                        <i class="ph ph-sign-out text-[16px] text-red-500"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const btn = document.getElementById('exhTopbarDropdownBtn');
                const menu = document.getElementById('exhTopbarDropdownMenu');
                if (btn && menu) {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        menu.classList.toggle('hidden');
                    });
                    document.addEventListener('click', (e) => {
                        if (!btn.contains(e.target) && !menu.contains(e.target)) {
                            menu.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
    @endauth
</header>
