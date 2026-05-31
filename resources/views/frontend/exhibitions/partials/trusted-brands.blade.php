<section class="px-5 py-10 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1500px]">
        <p class="mb-5 text-[15px] font-semibold text-[#5A6480]">Trusted by exhibitors and event teams</p>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            @foreach (['TechNova', 'CloudAxis', 'MediCore', 'EduSpark'] as $brand)
                <div class="rounded-xl border border-borderColor bg-white p-5 text-center text-[16px] font-semibold text-navy shadow-sm">{{ $brand }}</div>
            @endforeach
        </div>
    </div>
</section>
