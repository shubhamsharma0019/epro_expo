<article class="rounded-xl border border-borderColor bg-white p-5 shadow-sm sm:p-6">
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_300px] xl:items-center">
        <div class="min-w-0">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="text-[21px] font-semibold text-navy">{{ $title ?? 'Innovation Pavilion Booth' }}</h2>
                    <p class="mt-2 text-[14px] font-medium text-[#5A6480]">{{ $code ?? 'EXPO2024-INV-12A-001' }}</p>
                </div>
                <span class="w-fit rounded-md bg-[#EAF9F0] px-3 py-1.5 text-[13px] font-semibold text-[#16A34A]">{{ $status ?? 'Confirmed' }}</span>
            </div>

            <div class="grid gap-3 text-[15px] font-medium text-[#34405F] sm:grid-cols-2">
                <p class="flex items-center gap-3"><i class="fa-regular fa-building w-4 text-purple"></i>{{ $hall ?? 'Hall 1 - Tech & Innovation' }}</p>
                <p class="flex items-center gap-3"><i class="fa-solid fa-shop w-4 text-purple"></i>{{ $booth ?? 'Booth 12A (10m x 3m)' }}</p>
                <p class="flex items-center gap-3"><i class="fa-regular fa-calendar-days w-4 text-purple"></i>{{ $date ?? 'May 16 - May 19, 2024' }}</p>
                <p class="flex items-center gap-3"><i class="fa-solid fa-wallet w-4 text-purple"></i>{{ $amount ?? '₹657.80' }}</p>
            </div>
        </div>

        <div class="flex flex-col gap-3 border-t border-borderColor pt-5 xl:border-l xl:border-t-0 xl:pl-7 xl:pt-0">
            <a href="{{ url($detailsUrl ?? '/company/bookings/EXPO2024-INV-12A-001') }}" class="inline-flex h-[48px] items-center justify-center gap-3 rounded-md border border-purple px-5 text-[15px] font-semibold text-purple">
                View Details <i class="fa-solid fa-chevron-right text-[12px]"></i>
            </a>
            <a href="{{ url('/company/profile') }}" class="inline-flex h-[48px] items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[15px] font-semibold text-white">
                Booth Profile <i class="fa-solid fa-store text-[13px]"></i>
            </a>
        </div>
    </div>
</article>
