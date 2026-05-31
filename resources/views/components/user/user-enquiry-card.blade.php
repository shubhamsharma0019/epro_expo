<a href="{{ url($href ?? '/user/enquiries/1') }}" class="block rounded-xl border border-borderColor bg-white p-5 shadow-sm hover:border-purple">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div><h2 class="text-[19px] font-semibold text-navy">{{ $title ?? 'Product pricing request' }}</h2><p class="mt-2 text-[15px] font-medium text-[#34405F]">{{ $meta ?? 'Sent to TechNova Solutions' }}</p></div>
        <span class="w-fit rounded-md bg-[#F4F0FF] px-3 py-1.5 text-[13px] font-semibold text-purple">{{ $status ?? 'Open' }}</span>
    </div>
</a>
