@php
    $eventFlowCompany = $currentCompany ?? ($companyEvent->company ?? null);
    $eventFlowCompanyName = $eventFlowCompany?->company_name ?? $eventFlowCompany?->name ?? 'Company';
    $eventFlowContactName = $eventFlowCompany?->contact_person_name ?? $eventFlowCompany?->owner_name ?? $eventFlowCompanyName;
    $eventFlowInitials = collect(preg_split('/\s+/', trim($eventFlowContactName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->join('') ?: 'C';
@endphp

<header class="flex min-w-0 items-center justify-between gap-4 border-b border-gray-100 bg-white px-4 py-4 sm:px-8 lg:px-10 lg:py-6">
    <div class="flex min-w-0 flex-1 items-center">
        <button type="button" data-company-event-sidebar-open class="grid h-10 w-10 shrink-0 place-items-center rounded-xl text-[#1C1364] transition-colors hover:bg-[#F8F9FA] lg:hidden" aria-label="Open event menu">
            <i class="ph ph-list text-2xl"></i>
        </button>
    </div>

    <div class="flex min-w-0 shrink-0 items-center justify-end">
        <div class="flex min-w-0 items-center gap-3">
            <div class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-[#F4F1FF] text-xs font-bold text-[#5B32F6] md:h-10 md:w-10 md:text-sm">{{ $eventFlowInitials }}</div>
            <div class="hidden min-w-0 sm:block">
                <h4 class="truncate text-xs font-semibold text-[#1C1364] md:text-sm">{{ $eventFlowContactName }}</h4>
                <p class="truncate text-[10px] text-[#6B7280] md:text-xs">{{ $eventFlowCompanyName }}</p>
            </div>
            <i class="ph ph-caret-down shrink-0 text-base text-[#1C1364]"></i>
        </div>
    </div>
</header>
