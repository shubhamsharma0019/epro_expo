@props([
    'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=900&q=80',
    'title' => 'Technology Pavilion',
    'category' => 'Innovation & AI',
    'description' => 'Explore leading companies, product showcases, smart solutions, and interactive booths inside this pavilion.',
    'halls' => '04 Halls',
    'booths' => '128 Booths',
    'companies' => '86 Companies',
    'status' => 'Open',
    'href' => '#',
])

<a href="{{ $href }}"
   class="group block min-w-0 overflow-hidden rounded-2xl border border-[#E7EAF3] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">

    {{-- Image --}}
    <div class="relative h-[210px] overflow-hidden bg-[#F7F8FC]">
        <img
            src="{{ $image }}"
            alt="{{ $title }}"
            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
        >

        <div class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1.5 text-[12px] font-semibold text-[#5b2eff] shadow-sm">
            {{ $category }}
        </div>

        <div class="absolute right-4 top-4 rounded-full bg-[#F4F0FF] px-3 py-1.5 text-[12px] font-semibold text-[#5b2eff] shadow-sm">
            {{ $status }}
        </div>
    </div>

    {{-- Content --}}
    <div class="min-w-0 p-6">
        <div class="flex min-w-0 items-start justify-between gap-4">
            <div class="min-w-0">
                <h3 class="truncate text-[21px] font-semibold tracking-[-0.02em] text-[#071044]">
                    {{ $title }}
                </h3>

                <p class="mt-2 line-clamp-2 text-[15px] leading-6 text-[#5A6480]">
                    {{ $description }}
                </p>
            </div>

            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#F4F0FF] text-[18px] text-[#5b2eff] transition group-hover:bg-[#5b2eff] group-hover:text-white">
                &rarr;
            </div>
        </div>

        {{-- Stats --}}
        <div class="mt-6 grid grid-cols-3 gap-3">
            <div class="rounded-2xl border border-[#E7EAF3] bg-[#F7F8FC] p-3">
                <p class="text-[13px] font-medium text-[#5A6480]">Halls</p>
                <p class="mt-1 text-[15px] font-semibold text-[#071044]">{{ $halls }}</p>
            </div>

            <div class="rounded-2xl border border-[#E7EAF3] bg-[#F7F8FC] p-3">
                <p class="text-[13px] font-medium text-[#5A6480]">Booths</p>
                <p class="mt-1 text-[15px] font-semibold text-[#071044]">{{ $booths }}</p>
            </div>

            <div class="rounded-2xl border border-[#E7EAF3] bg-[#F7F8FC] p-3">
                <p class="text-[13px] font-medium text-[#5A6480]">Brands</p>
                <p class="mt-1 text-[15px] font-semibold text-[#071044]">{{ $companies }}</p>
            </div>
        </div>
    </div>
</a>
