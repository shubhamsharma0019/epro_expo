<section class="max-w-[900px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">{{ $mode }} Product</h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">Product information will appear on your booth profile.</p>
    </div>
    <form class="rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
        <div class="grid grid-cols-1 gap-5">
            <input type="text" value="{{ $mode === 'Edit' ? 'AI Workflow Studio' : '' }}" placeholder="Product name" class="h-[52px] rounded-md border border-borderColor px-4 text-[15px] font-medium outline-none focus:border-purple">
            <textarea rows="5" placeholder="Product description" class="rounded-md border border-borderColor px-4 py-3 text-[15px] font-medium outline-none focus:border-purple">{{ $mode === 'Edit' ? 'Automate approval, support, and reporting workflows.' : '' }}</textarea>
            <input type="text" placeholder="Category" class="h-[52px] rounded-md border border-borderColor px-4 text-[15px] font-medium outline-none focus:border-purple">
        </div>
        <button type="button" class="mt-6 inline-flex h-[52px] items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-7 text-[15px] font-semibold text-white">Save Product</button>
    </form>
</section>
