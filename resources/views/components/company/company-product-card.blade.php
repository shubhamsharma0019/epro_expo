<article class="rounded-xl border border-borderColor bg-white p-6 shadow-sm">
    <div class="mb-5 flex h-[118px] items-center justify-center rounded-lg bg-[#F4F0FF] text-purple">
        <i class="{{ $icon ?? 'fa-solid fa-cube' }} text-[30px]"></i>
    </div>
    <h2 class="text-[20px] font-semibold text-navy">{{ $title ?? 'AI Workflow Studio' }}</h2>
    <p class="mt-3 text-[15px] font-medium leading-7 text-[#34405F]">{{ $description ?? 'Automate approval, support, and reporting workflows.' }}</p>
    <div class="mt-5 flex gap-3">
        <a href="{{ url($showUrl ?? '/company/products/1') }}" class="inline-flex h-[42px] flex-1 items-center justify-center rounded-md border border-purple px-4 text-[14px] font-semibold text-purple">View</a>
        <a href="{{ url($editUrl ?? '/company/products/1/edit') }}" class="inline-flex h-[42px] flex-1 items-center justify-center rounded-md border border-borderColor px-4 text-[14px] font-semibold text-navy">Edit</a>
    </div>
</article>
