<section class="px-5 py-10 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1500px]">
        <h2 class="mb-6 text-[30px] font-semibold text-navy">Features</h2>
        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            @foreach ([['Pavilion discovery', 'Compare categories and choose the right pavilion.'], ['Interactive halls', 'Review halls, floor plans, and booth availability.'], ['Booking management', 'Track invoices, services, and confirmed bookings.']] as [$title, $copy])
                <div class="rounded-2xl border border-borderColor bg-white p-6 shadow-sm">
                    <h3 class="text-[20px] font-semibold text-navy">{{ $title }}</h3>
                    <p class="mt-3 text-[15px] font-medium leading-7 text-[#34405F]">{{ $copy }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
