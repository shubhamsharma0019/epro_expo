<article class="rounded-xl border border-borderColor bg-white p-5 shadow-sm">
    <div class="flex items-start justify-between gap-4">
        <div><p class="text-[14px] font-medium text-[#5A6480]">{{ $label ?? 'Metric' }}</p><p class="mt-3 text-[30px] font-semibold leading-none text-navy">{{ $value ?? '0' }}</p><p class="mt-3 text-[13px] font-medium text-[#34405F]">{{ $meta ?? 'Updated today' }}</p></div>
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-[#F4F0FF] text-purple"><i class="{{ $icon ?? 'fa-solid fa-chart-line' }}"></i></span>
    </div>
</article>
