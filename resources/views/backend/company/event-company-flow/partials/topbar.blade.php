@php
    $eventFlowCompany = $currentCompany
        ?? ($companyEvent->company ?? null)
        ?? (session('company_id') ? \App\Domain\Company\Models\Company::find(session('company_id')) : null);
    $eventFlowCompanyName = $eventFlowCompany?->company_name ?? $eventFlowCompany?->name ?? 'Company';
    $eventFlowContactName = $eventFlowCompany?->contact_person_name ?? $eventFlowCompany?->owner_name ?? $eventFlowCompanyName;
    $eventFlowInitials = collect(preg_split('/\s+/', trim((string) $eventFlowContactName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->join('') ?: 'C';

    $eventFlowLogo = $eventFlowCompany?->logo ?: $eventFlowCompany?->boothProfiles()->latest()->first()?->company_logo;
    $eventFlowLogoUrl = null;
    if ($eventFlowLogo) {
        $eventFlowLogoUrl = str_starts_with($eventFlowLogo, 'http')
            ? $eventFlowLogo
            : asset(str_starts_with($eventFlowLogo, 'storage/') ? $eventFlowLogo : 'storage/' . ltrim($eventFlowLogo, '/'));
    }

    $eventFlowNotificationCount = ($stats['enquiries_count'] ?? $eventFlowCompany?->enquiries()->count() ?? 0)
        + ($stats['meetings_count'] ?? $eventFlowCompany?->visitorMeetingBookings()->count() ?? 0);
@endphp

<header class="z-40 flex h-[72px] shrink-0 min-w-0 items-center justify-between gap-4 border-b border-gray-100 bg-white px-4 sm:px-6 lg:hidden">
    <div class="flex min-w-0 flex-1 items-center gap-3 sm:gap-4">
        <button type="button" data-company-event-sidebar-open class="grid h-10 w-10 shrink-0 place-items-center rounded-xl text-[#1C1364] transition-colors hover:bg-[#F8F9FA] lg:hidden" aria-label="Open event menu">
            <i class="ph ph-list text-2xl"></i>
        </button>
        <a href="{{ route('company.event-company-flow.dashboard') }}" class="flex min-w-0 items-center gap-2">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center bg-gradient-to-br from-[#071044] to-[#5b2eff] font-bold leading-none text-white rounded-[11px] shadow-sm text-[18px]">
                e
            </span>
            <span class="hidden sm:block min-w-0 leading-none">
                <span class="block truncate font-extrabold tracking-[-0.035em] text-[20px] text-[#071044]">
                    epro<span class="text-[#246BFF]">expo</span>
                </span>
                <span class="mt-0.5 block truncate font-extrabold uppercase tracking-[0.16em] text-[9px] text-[#8A94AD]">
                    EVENT SUITE
                </span>
            </span>
        </a>
    </div>

    <div class="min-w-0 shrink-0 flex items-center gap-2 sm:gap-3">
        <div class="hidden sm:flex flex-col text-right">
            <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Logged in as</span>
            <span class="text-sm font-bold text-[#1C1364] truncate max-w-[150px]">{{ $eventFlowCompanyName }}</span>
        </div>
        <div class="hidden min-[480px]:flex sm:hidden flex-col text-right">
            <span class="text-[11px] font-bold text-[#1C1364] truncate max-w-[110px]">{{ $eventFlowCompanyName }}</span>
        </div>
        
        <a href="{{ route('company.notifications', ['flow' => 'event']) }}" class="relative grid h-9 w-9 place-items-center rounded-xl text-gray-500 transition-colors hover:bg-[#F8F9FA] hover:text-[#1C1364]">
            <i class="ph ph-bell text-2xl"></i>
            @if ($eventFlowNotificationCount > 0)
                <span class="absolute right-0.5 top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full border-2 border-white bg-red-500 px-1 text-[9px] font-bold leading-none text-white">{{ $eventFlowNotificationCount }}</span>
            @endif
        </a>

        <a href="{{ route('company.profile', ['flow' => 'event']) }}" class="flex min-w-0 items-center text-gray-900 no-underline">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#F4F1FF] text-sm font-bold text-[#5B32F6] border border-gray-100">
                @if ($eventFlowLogoUrl)
                    <img src="{{ $eventFlowLogoUrl }}" alt="{{ $eventFlowContactName }}" class="h-full w-full object-cover" onerror="this.remove(); this.parentElement.textContent='{{ $eventFlowInitials }}';">
                @else
                    {{ $eventFlowInitials }}
                @endif
            </span>
        </a>
    </div>
</header>
