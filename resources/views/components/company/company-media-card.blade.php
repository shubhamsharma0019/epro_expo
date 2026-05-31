<article class="overflow-hidden rounded-xl border border-borderColor bg-white shadow-sm">
    <div class="flex h-[150px] items-center justify-center bg-[#F4F0FF] text-purple">
        <i class="{{ $icon ?? 'fa-regular fa-image' }} text-[30px]"></i>
    </div>
    <div class="p-5">
        <h2 class="text-[18px] font-semibold text-navy">{{ $title ?? 'Booth Hero Image' }}</h2>
        <p class="mt-2 text-[14px] font-medium text-[#5A6480]">{{ $meta ?? 'Image asset' }}</p>
        <div class="mt-5 flex gap-3">
            <a href="{{ url($showUrl ?? '#') }}" class="inline-flex h-[42px] flex-1 items-center justify-center rounded-md border border-purple px-4 text-[14px] font-semibold text-purple">View</a>
            <a href="{{ url($editUrl ?? '#') }}" class="inline-flex h-[42px] flex-1 items-center justify-center rounded-md border border-borderColor px-4 text-[14px] font-semibold text-navy">Edit</a>
        </div>
    </div>
</article>
