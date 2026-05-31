@php
    $activeSlug = request()->route('slug') ?? 'global-tech-expo-2026';

    $topLinks = [
        ['Browse', route('exhibitions.index'), request()->routeIs('exhibitions.index') || request()->routeIs('exhibitions.browse') || request()->routeIs('exhibitions.show')],
        ['Companies', route('exhibitions.visitor.companies', $activeSlug), request()->routeIs('exhibitions.visitor.companies*')],
        ['Halls & Map', route('exhibitions.visitor.floor-map', $activeSlug), request()->routeIs('exhibitions.visitor.floor-map') || request()->routeIs('exhibitions.halls.*') || request()->routeIs('exhibitions.visitor-halls.*')],
        ['Sessions', route('exhibitions.visitor.sessions', $activeSlug), request()->routeIs('exhibitions.visitor.sessions')],
    ];
@endphp

<header class="sticky top-0 z-30 border-b border-borderColor bg-white/95 px-5 py-3 shadow-sm backdrop-blur sm:px-8 lg:px-8">
    <div class="flex min-h-[60px] items-center justify-between gap-4">
        <div class="flex min-w-0 items-center gap-3">
            <button type="button" data-sidebar-open class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-borderColor text-navy lg:hidden">
                <i class="fa-solid fa-bars text-[16px]"></i>
            </button>

            <nav class="hidden min-w-0 items-center gap-1 rounded-xl bg-[#FBFAFF] p-1 lg:flex">
                @foreach ($topLinks as [$label, $href, $active])
                    <a href="{{ $href }}" class="inline-flex h-10 items-center rounded-lg px-4 text-[13px] font-semibold transition {{ $active ? 'bg-white text-purple shadow-sm' : 'text-navy hover:text-purple' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>

            <div class="min-w-0 lg:hidden">
                <p class="truncate text-[15px] font-semibold text-navy">Visitor Exhibition</p>
                <p class="truncate text-[12px] font-medium text-[#5A6480]">Companies, halls, pass and sessions</p>
            </div>
        </div>

        <div class="flex shrink-0 items-center gap-2 sm:gap-3">
            <a href="{{ route('exhibitions.tickets.select', $activeSlug) }}" class="hidden h-10 items-center rounded-lg bg-[#5b2eff] px-4 text-[13px] font-bold text-white shadow-[0_8px_18px_rgba(91,46,255,0.18)] sm:inline-flex">
                Get Pass
            </a>

            <a href="{{ route('exhibitions.visitor.notifications', $activeSlug) }}" class="grid h-10 w-10 place-items-center rounded-lg border border-borderColor text-navy hover:bg-[#F8F7FF] hover:text-purple" title="Notifications">
                <i class="fa-regular fa-bell text-[17px]"></i>
            </a>

            <div class="flex h-10 items-center gap-2 rounded-full border border-borderColor bg-white pl-1 pr-3">
                <img src="https://i.pravatar.cc/100" class="h-8 w-8 rounded-full object-cover" alt="John Doe">
                <span class="hidden max-w-[96px] truncate text-[13px] font-semibold text-navy sm:block">John Doe</span>
                <i class="fa-solid fa-chevron-down text-[10px] text-[#5A6480]"></i>
            </div>
        </div>
    </div>
</header>
