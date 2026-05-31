<section class="px-5 py-10 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1500px] rounded-2xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
        <h2 class="mb-6 text-[30px] font-semibold text-navy">Booking Steps</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
            @foreach (['Pavilion', 'Hall', 'Booth', 'Services', 'Payment'] as $step)
                <div class="rounded-xl border border-borderColor p-5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#F4F0FF] text-[14px] font-semibold text-purple">{{ $loop->iteration }}</span>
                    <p class="mt-4 text-[16px] font-semibold text-navy">{{ $step }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
