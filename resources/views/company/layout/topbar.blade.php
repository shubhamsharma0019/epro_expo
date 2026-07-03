@php
    $topbarTitle = trim($__env->yieldContent('page-title', $__env->yieldContent('title', 'Dashboard')));
    $topbarTitle = preg_replace('/\s*\|\s*eproexpo$/i', '', $topbarTitle);
    $topbarTitle = str_replace('EproExpo ', '', $topbarTitle);
    for ($i = 0; $i < 3; $i++) {
        $decodedTitle = html_entity_decode($topbarTitle, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if ($decodedTitle === $topbarTitle) {
            break;
        }
        $topbarTitle = $decodedTitle;
    }
    $topbarCompany = $currentCompany ?? (session('company_id')
        ? \App\Domain\Company\Models\Company::find(session('company_id'))
        : null);
    $topbarCompanyName = $topbarCompany?->company_name
        ?? $topbarCompany?->name
        ?? 'Company';
    $topbarContactName = $topbarCompany?->contact_person_name
        ?? $topbarCompany?->owner_name
        ?? $topbarCompanyName;
    $topbarLogo = $topbarCompany?->logo ?: $topbarCompany?->boothProfiles()->latest()->first()?->company_logo;
    $topbarLogoUrl = null;
    if ($topbarLogo) {
        $topbarLogoUrl = str_starts_with($topbarLogo, 'http')
            ? $topbarLogo
            : asset(str_starts_with($topbarLogo, 'storage/') ? $topbarLogo : 'storage/' . ltrim($topbarLogo, '/'));
    }
    $topbarInitial = collect(explode(' ', trim((string) $topbarContactName)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->implode('') ?: 'C';

    $topbarNotificationCount = $topbarCompany
        ? app(\App\Domain\Company\Services\CompanyNotificationService::class)->unreadCount($topbarCompany)
        : 0;
@endphp

<header class="z-40 flex h-[80px] shrink-0 items-center justify-between border-b border-gray-100 bg-white px-4 sm:px-6 lg:px-8">
    <div class="flex min-w-0 items-center gap-4">
        <button type="button" data-company-sidebar-open class="grid h-10 w-10 shrink-0 place-items-center rounded-xl text-gray-500 transition-colors hover:bg-gray-50 hover:text-gray-900 lg:hidden">
            <i class="ph ph-list text-2xl"></i>
        </button>
        <h1 class="company-page-title truncate text-xl font-bold text-gray-900 sm:text-2xl">{{ $topbarTitle ?: 'Dashboard' }}</h1>
    </div>

    <div class="flex shrink-0 items-center gap-3 sm:gap-6">

        <a href="{{ route('company.notifications') }}" id="company-notification-bell" class="relative text-gray-500 transition-colors hover:text-gray-900">
            <i class="ph ph-bell text-2xl"></i>
            <span
                id="company-notification-badge"
                class="absolute -right-1 -top-1 flex h-4 min-w-4 items-center justify-center rounded-full border-2 border-white bg-red-500 px-1 text-[9px] font-bold leading-none text-white {{ $topbarNotificationCount > 0 ? '' : 'hidden' }}"
                data-unread-count="{{ $topbarNotificationCount }}"
            >{{ $topbarNotificationCount > 99 ? '99+' : $topbarNotificationCount }}</span>
        </a>
        <a href="{{ url('/company/profile') }}" class="flex min-w-0 items-center text-gray-900 no-underline">
            <span id="company-topbar-avatar" class="flex h-9 w-9 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#F4F0FF] text-sm font-bold text-[#3b18ff]">
                @if ($topbarLogoUrl)
                    <img src="{{ $topbarLogoUrl }}" alt="{{ $topbarContactName }}" class="h-full w-full object-cover" onerror="this.remove(); this.parentElement.textContent='{{ $topbarInitial }}';">
                @else
                    {{ $topbarInitial }}
                @endif
            </span>
            <span class="company-topbar-profile-text ml-3 hidden min-w-0 md:inline">
                <span class="block max-w-[150px] truncate text-sm font-semibold">{{ $topbarContactName }}</span>
            </span>
            <i class="ph ph-caret-down ml-2 hidden text-gray-500 sm:block"></i>
        </a>
    </div>
</header>

