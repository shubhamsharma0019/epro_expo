<div class="rounded-xl border border-dashed border-borderColor bg-white px-6 py-12 text-center shadow-sm">
    <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-full bg-[#F4F0FF] text-purple">
        <i class="{{ $icon ?? 'fa-regular fa-folder-open' }} text-[22px]"></i>
    </div>
    <h2 class="text-[20px] font-semibold text-navy">{{ $title ?? 'Nothing here yet' }}</h2>
    <p class="mx-auto mt-3 max-w-[520px] text-[15px] font-medium leading-7 text-[#5A6480]">{{ $message ?? 'Create your first item to start managing this section.' }}</p>
</div>
