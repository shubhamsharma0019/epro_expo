@php
    $topbarTitle = trim($__env->yieldContent('page-title', $__env->yieldContent('title', 'Dashboard')));
    $topbarTitle = preg_replace('/\s*\|\s*eproexpo$/i', '', $topbarTitle);
    $topbarTitle = str_replace('EproExpo ', '', $topbarTitle);

    $quickLinks = [
        ['Exhibitions', '/company/exhibitions', 'fa-solid fa-globe'],
        ['Book Booths', '/company/exhibitions', 'fa-regular fa-clipboard'],
        ['My Bookings', '/company/bookings', 'fa-regular fa-bookmark'],
    ];
    $topbarCompany = session('company_id') ? \App\Domain\Company\Models\Company::find(session('company_id')) : null;
    $topbarName = $topbarCompany?->contact_person_name
        ?? $topbarCompany?->owner_name
        ?? $topbarCompany?->company_name
        ?? $topbarCompany?->name
        ?? 'Company';
    $topbarIndustry = $topbarCompany?->industry ?: 'Exhibitor';
    $topbarInitials = collect(explode(' ', trim((string) $topbarName)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->implode('') ?: 'C';
    $topbarLogo = $topbarCompany?->logo ?: $topbarCompany?->boothProfiles()->latest()->first()?->company_logo;
    $topbarLogoUrl = $topbarLogo
        ? (str_starts_with($topbarLogo, 'http') ? $topbarLogo : asset(str_starts_with($topbarLogo, 'storage/') ? $topbarLogo : 'storage/' . ltrim($topbarLogo, '/')))
        : null;
@endphp

<header class="sticky top-0 z-30 border-b border-[#E7EAF3] bg-white/96 backdrop-blur-xl">
    <div class="flex min-h-[76px] items-center gap-4 px-5 py-3 sm:px-8 lg:px-8">
        <button type="button" data-company-sidebar-open class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md border border-borderColor text-navy lg:hidden">
            <i class="fa-solid fa-bars text-[18px]"></i>
        </button>

        <div class="min-w-0 shrink-0 lg:w-[220px]">
            <p class="hidden text-[11px] font-medium uppercase tracking-[0.14em] text-[#8A94AD] sm:block">Company</p>
            <h1 class="truncate text-[20px] font-semibold leading-7 text-[#071044] sm:text-[22px]">{{ $topbarTitle ?: 'Dashboard' }}</h1>
        </div>

        <div class="hidden shrink-0 items-center gap-2 rounded-full border border-[#E7EAF3] bg-[#F8FAFF] p-1 lg:flex">
            @foreach ($quickLinks as [$label, $href, $icon])
                <a href="{{ url($href) }}" class="inline-flex h-9 items-center gap-2 rounded-full px-4 text-[13px] font-medium transition {{ request()->is(trim(parse_url($href, PHP_URL_PATH), '/') . '*') ? 'bg-white text-[#5b2eff] shadow-sm' : 'text-[#34405F] hover:bg-white hover:text-[#5b2eff] hover:shadow-sm' }}">
                    <i class="{{ $icon }} text-[12px]"></i>
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="hidden min-w-0 flex-1 md:block">
            <label class="relative block max-w-[620px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[14px] text-[#7A849D]"></i>
                <input type="search" placeholder="Search bookings, leads, products..." class="h-12 w-full rounded-full border border-[#E2E7F3] bg-[#F7F9FE] pl-11 pr-20 text-[14px] font-medium text-[#071044] outline-none transition placeholder:text-[#8A94AD] focus:border-[#5b2eff] focus:bg-white focus:ring-4 focus:ring-[#5b2eff]/10">
                <span class="pointer-events-none absolute right-3 top-1/2 hidden -translate-y-1/2 rounded-full border border-[#E7EAF3] bg-white px-2.5 py-1 text-[11px] font-medium text-[#8A94AD] sm:inline-flex">Ctrl K</span>
            </label>
        </div>

        <div class="ml-auto flex shrink-0 items-center gap-2 sm:gap-3">
            <a href="{{ url('/company/enquiries') }}" class="hidden h-11 items-center justify-center gap-2 rounded-full border border-[#E7EAF3] bg-white px-4 text-[13px] font-medium text-[#071044] shadow-sm transition hover:border-[#5b2eff] hover:text-[#5b2eff] md:inline-flex">
                <i class="fa-solid fa-users text-[12px]"></i>
                Leads
            </a>
            <button type="button" class="relative flex h-11 w-11 items-center justify-center rounded-full border border-[#E7EAF3] bg-white text-[#071044] shadow-sm transition hover:border-[#5b2eff] hover:text-[#5b2eff]">
                <i class="fa-regular fa-bell text-[18px]"></i>
                <span class="absolute right-2.5 top-2.5 h-2 w-2 rounded-full bg-[#246BFF] ring-2 ring-white"></span>
            </button>
            <a href="{{ url('/company/profile') }}" class="flex h-12 items-center gap-3 rounded-full border border-[#E7EAF3] bg-white py-1 pl-1 pr-2 shadow-sm transition hover:border-[#5b2eff] sm:pr-4">
                <span id="company-topbar-avatar" class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-[#5b2eff] to-[#246BFF] text-[14px] font-medium text-white">
                    @if ($topbarLogoUrl)
                        <img src="{{ $topbarLogoUrl }}" alt="{{ $topbarName }}" class="h-full w-full object-cover" onerror="this.remove(); this.parentElement.textContent='{{ $topbarInitials }}';">
                    @else
                        {{ $topbarInitials }}
                    @endif
                </span>
                <span class="hidden max-w-[150px] min-w-0 sm:block">
                    <span class="block truncate text-[14px] font-medium leading-5 text-[#071044]">{{ $topbarName }}</span>
                    <span class="block truncate text-[12px] font-medium leading-4 text-[#7A849D]">{{ $topbarIndustry }}</span>
                </span>
                <i class="fa-solid fa-chevron-down hidden text-[10px] text-[#8A94AD] sm:block"></i>
            </a>
        </div>
    </div>

    <div class="flex gap-2 overflow-x-auto border-t border-[#F0F2F8] px-5 py-2 sm:px-8 lg:hidden">
        @foreach ($quickLinks as [$label, $href, $icon])
            <a href="{{ url($href) }}" class="inline-flex h-9 shrink-0 items-center gap-2 rounded-full bg-[#F8FAFF] px-4 text-[13px] font-medium text-[#34405F]">
                <i class="{{ $icon }} text-[12px]"></i>
                {{ $label }}
            </a>
        @endforeach
    </div>
</header>
