<article class="rounded-xl border border-borderColor bg-white p-5 shadow-sm sm:p-6">
    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
        <div class="min-w-0">
            <h2 class="text-[20px] font-semibold text-navy">{{ $title ?? 'Global Tech Summit 2024' }}</h2>
            <p class="mt-2 text-[15px] font-medium text-[#34405F]">{{ $meta ?? 'General Pass x 2 | May 15 - May 17, 2024' }}</p>
            <p class="mt-2 text-[13px] font-semibold text-[#16A34A]">{{ $status ?? 'Confirmed' }}</p>
        </div>
        <a href="{{ url($href ?? '/user/tickets/1') }}" class="inline-flex h-[46px] items-center justify-center rounded-md border border-purple px-5 text-[15px] font-semibold text-purple">View Details</a>
    </div>
</article>
