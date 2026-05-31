<article class="flex flex-col gap-4 rounded-xl border border-borderColor bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
    <div class="flex min-w-0 items-center gap-4">
        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-md bg-[#F4F0FF] text-purple"><i class="{{ $icon ?? 'fa-regular fa-file-lines' }}"></i></span>
        <div class="min-w-0">
            <h2 class="truncate text-[17px] font-semibold text-navy">{{ $title ?? 'Company Profile.pdf' }}</h2>
            <p class="mt-1 text-[13px] font-medium text-[#5A6480]">{{ $meta ?? 'Updated today' }}</p>
        </div>
    </div>
    <div class="flex gap-3">
        <a href="{{ url($showUrl ?? '#') }}" class="inline-flex h-[44px] items-center justify-center rounded-md border border-purple px-5 text-[15px] font-semibold text-purple">View</a>
        <a href="{{ url($editUrl ?? '#') }}" class="inline-flex h-[44px] items-center justify-center rounded-md border border-borderColor px-5 text-[15px] font-semibold text-navy">Edit</a>
    </div>
</article>
