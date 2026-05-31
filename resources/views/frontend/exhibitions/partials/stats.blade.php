<section class="px-5 py-10 sm:px-8 lg:px-10">
    <div class="mx-auto grid max-w-[1500px] grid-cols-1 gap-4 md:grid-cols-4">
        @foreach ([['120+', 'Exhibitors'], ['18', 'Pavilions'], ['60+', 'Booths'], ['24/7', 'Support']] as [$value, $label])
            <div class="rounded-2xl border border-borderColor bg-white p-6 shadow-sm">
                <p class="text-[30px] font-semibold text-navy">{{ $value }}</p>
                <p class="mt-2 text-[14px] font-medium text-[#5A6480]">{{ $label }}</p>
            </div>
        @endforeach
    </div>
</section>
