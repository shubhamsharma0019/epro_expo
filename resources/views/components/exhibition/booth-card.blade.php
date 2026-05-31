@props([
    'title' => 'Premium Booth',
    'size' => '6m x 6m',
    'area' => '36 sq m',
    'price' => '&#8377;85,000',
    'description' => 'Best for product demos, brand showcases, meeting pods, and premium visitor interaction.',
    'features' => ['Prime location', 'Brand wall', 'Meeting desk', 'Power included'],
    'badge' => 'Recommended',
    'href' => '#',
])

<a href="{{ $href }}"
   class="group block min-w-0 rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">

    <div class="flex min-w-0 items-start justify-between gap-4">
        <div class="min-w-0">
            <div class="inline-flex rounded-full bg-[#F4F0FF] px-3 py-1.5 text-[12px] font-semibold text-[#5b2eff]">
                {{ $badge }}
            </div>

            <h3 class="mt-4 text-[21px] font-semibold tracking-[-0.02em] text-[#071044]">
                {{ $title }}
            </h3>

            <p class="mt-2 text-[15px] leading-6 text-[#5A6480]">
                {{ $description }}
            </p>
        </div>

        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#F4F0FF] text-[20px] text-[#5b2eff] transition group-hover:bg-[#5b2eff] group-hover:text-white">
            &#9671;
        </div>
    </div>

    <div class="mt-6 grid grid-cols-3 gap-3">
        <div class="rounded-2xl border border-[#E7EAF3] bg-[#F7F8FC] p-3">
            <p class="text-[13px] font-medium text-[#5A6480]">Size</p>
            <p class="mt-1 truncate text-[15px] font-semibold text-[#071044]">{{ $size }}</p>
        </div>

        <div class="rounded-2xl border border-[#E7EAF3] bg-[#F7F8FC] p-3">
            <p class="text-[13px] font-medium text-[#5A6480]">Area</p>
            <p class="mt-1 truncate text-[15px] font-semibold text-[#071044]">{{ $area }}</p>
        </div>

        <div class="rounded-2xl border border-[#E7EAF3] bg-[#F7F8FC] p-3">
            <p class="text-[13px] font-medium text-[#5A6480]">Price</p>
            <p class="mt-1 truncate text-[15px] font-semibold text-[#071044]">{{ $price }}</p>
        </div>
    </div>

    <div class="mt-6 space-y-3">
        @foreach ($features as $feature)
            <div class="flex items-center gap-3 text-[14px] font-medium text-[#34405F]">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#F4F0FF] text-[12px] text-[#5b2eff]">
                    &#10003;
                </span>
                <span class="min-w-0 truncate">{{ $feature }}</span>
            </div>
        @endforeach
    </div>

    <div class="mt-6 flex h-12 items-center justify-center rounded-xl bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-4 text-[14px] font-semibold text-white shadow-sm">
        Select Booth Size
    </div>
</a>
