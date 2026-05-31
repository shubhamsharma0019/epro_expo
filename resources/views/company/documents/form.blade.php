<section class="max-w-[900px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">{{ $mode }} Document</h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">Attach documents for visitors and booth reviewers.</p>
    </div>
    <form class="rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
        <input type="text" value="{{ $mode === 'Edit' ? 'Company Profile.pdf' : '' }}" placeholder="Document title" class="h-[52px] w-full rounded-md border border-borderColor px-4 text-[15px] font-medium outline-none focus:border-purple">
        <div class="mt-5 rounded-xl border border-dashed border-borderColor bg-[#F8F9FD] p-8 text-center text-[15px] font-medium text-[#5A6480]">Upload file</div>
        <button type="button" class="mt-6 inline-flex h-[52px] items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-7 text-[15px] font-semibold text-white">Save Document</button>
    </form>
</section>
