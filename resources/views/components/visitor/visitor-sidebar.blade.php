@php
    $completedPass = auth()->check()
        ? \App\Domain\Visitor\Models\Visitor::query()
            ->whereRaw('LOWER(email) = ?', [strtolower(auth()->user()->email)])
            ->where('payment_status', 'completed')
            ->with('exhibition')
            ->latest()
            ->first()
        : null;

    $routeSlug = request()->route('slug');
    $hubSlug = $routeSlug ?? $completedPass?->exhibition?->slug ?? session('activeExhibitionSlug');
    $hasExhibitionPass = $completedPass !== null;
    $showExhibitionLinks = filled($hubSlug) && ($hasExhibitionPass || filled($routeSlug));

    $mainLinks = [
        ['Dashboard', route('frontend.user.dashboard'), 'ph-chart-pie-slice'],
        ['My Passes', route('frontend.user.tickets.index'), 'ph-ticket'],
    ];

    $exhibitionLinks = $showExhibitionLinks ? [
        ['Exhibition Lobby', route('exhibitions.visit', $hubSlug), 'ph-door-open'],
        ['Companies', route('exhibitions.visitor.companies', $hubSlug), 'ph-storefront'],
        ['Sessions', route('exhibitions.visitor.sessions', $hubSlug), 'ph-play-circle'],
        ['My Meetings', route('exhibitions.visitor.meetings', $hubSlug), 'ph-calendar-check'],
    ] : [];

    $accountLinks = [
        ['Profile', route('frontend.user.profile'), 'ph-user'],
    ];

    $isActive = function (string $href): bool {
        $path = parse_url($href, PHP_URL_PATH) ?? $href;
        $current = request()->path();

        if ($path === '/user/dashboard' || str_ends_with($path, '/user/dashboard')) {
            return request()->routeIs('frontend.user.dashboard');
        }

        return $current === ltrim($path, '/') || str_starts_with($current, ltrim($path, '/').'/');
    };
@endphp

<aside id="user-sidebar-aside" class="flex h-full min-h-0 w-full flex-col overflow-hidden bg-[#0b1739] font-sans text-[#a0aabf]">
    <div class="flex shrink-0 items-center justify-between border-b border-white/10 px-5 py-5">
        <x-shared.brand-logo
            href="{{ route('frontend.user.dashboard') }}"
            subtitle="VISITOR PORTAL"
            mark-class="h-10 w-10 rounded-[14px] text-[18px]"
            title-class="text-[20px] text-white"
            subtitle-class="text-[10px] text-[#a0aabf]"
        />
        <button type="button" data-user-sidebar-close data-sidebar-close class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white lg:hidden">
            <i class="ph ph-x text-lg"></i>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-4">
        <ul class="space-y-1">
            @foreach ($mainLinks as [$label, $href, $icon])
                <li>
                    <a href="{{ $href }}" @class([
                        'flex items-center gap-3 rounded-[10px] px-3 py-2.5 transition-colors',
                        'bg-[#3723db] text-white' => $isActive($href),
                        'hover:bg-white/5 hover:text-white' => ! $isActive($href),
                    ])>
                        <i class="{{ $icon }} text-[20px]"></i>
                        <span class="text-[14px] font-medium">{{ $label }}</span>
                    </a>
                </li>
            @endforeach

            @if ($showExhibitionLinks)
                <li class="pt-3">
                    <p class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-[0.14em] text-white/40">Exhibition</p>
                </li>
                @foreach ($exhibitionLinks as [$label, $href, $icon])
                    <li>
                        <a href="{{ $href }}" @class([
                            'flex items-center gap-3 rounded-[10px] px-3 py-2.5 transition-colors',
                            'bg-[#3723db] text-white' => $isActive($href),
                            'hover:bg-white/5 hover:text-white' => ! $isActive($href),
                        ])>
                            <i class="{{ $icon }} text-[20px]"></i>
                            <span class="text-[14px] font-medium">{{ $label }}</span>
                        </a>
                    </li>
                @endforeach
            @endif

            <li class="pt-3">
                <p class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-[0.14em] text-white/40">Account</p>
            </li>
            @foreach ($accountLinks as [$label, $href, $icon])
                <li>
                    <a href="{{ $href }}" @class([
                        'flex items-center gap-3 rounded-[10px] px-3 py-2.5 transition-colors',
                        'bg-[#3723db] text-white' => $isActive($href),
                        'hover:bg-white/5 hover:text-white' => ! $isActive($href),
                    ])>
                        <i class="{{ $icon }} text-[20px]"></i>
                        <span class="text-[14px] font-medium">{{ $label }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="border-t border-white/10 px-3 py-4">
        <ul class="space-y-1">
            <li>
                <a href="{{ url('/') }}" class="flex items-center gap-3 rounded-[10px] px-3 py-2.5 text-[14px] font-medium transition-colors hover:bg-white/5 hover:text-white">
                    <i class="ph ph-globe text-[20px]"></i>
                    Back to Website
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('frontend.user.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-[10px] border-0 bg-transparent px-3 py-2.5 text-left text-[14px] font-medium text-rose-300 transition-colors hover:bg-rose-500/10 hover:text-rose-200">
                        <i class="ph ph-sign-out text-[20px]"></i>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
