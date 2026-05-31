@extends('layouts.exhibition')

@section('title', 'EproExpo Booth Size Options')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">

    <div class="mb-10 flex items-center gap-5 overflow-x-auto pb-1 text-[15px] font-medium text-[#34405F]">
        <a href="{{ url('/exhibitions/pavilions/innovation-pavilion') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[14px] font-semibold text-white">1</span>
            <span>Pavilion</span>
        </a>

        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>

        <a href="{{ url('/exhibitions/halls/hall-1') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[14px] font-semibold text-white">2</span>
            <span>Hall</span>
        </a>

        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>

        <a href="{{ url('/exhibitions/booths/sizes') }}" class="flex shrink-0 items-center gap-3 rounded-full bg-[#F4F0FF] px-4 py-2 text-purple">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[14px] font-semibold text-white">3</span>
            <span class="font-semibold">Booth Size</span>
        </a>

        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>

        <a href="{{ url('/exhibitions/booths/slots') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-full border border-[#8FA0C7] bg-white text-[14px] font-semibold text-navy">4</span>
            <span>Services</span>
        </a>

        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>

        <a href="{{ url('/exhibitions/booking/review') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-full border border-[#8FA0C7] bg-white text-[14px] font-semibold text-navy">5</span>
            <span>Review</span>
        </a>
    </div>

    <div class="mb-8">
        <h1 class="text-[32px] font-semibold leading-[40px] tracking-[-0.8px] text-navy">
            Choose Booth Size
        </h1>

        <p class="mt-4 text-[16px] font-medium leading-7 text-[#34405F]">
            Select the booth size that fit your requirements.
        </p>
    </div>

    <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-5" id="size-options">
        <button type="button" data-size="3x3" class="size-btn relative min-h-[260px] rounded-xl border border-purple bg-white p-6 text-center shadow-sm">
            <span class="check-icon absolute right-3 top-3 flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                <i class="fa-solid fa-check text-[13px]"></i>
            </span>

            <h2 class="text-[20px] font-semibold text-navy">3m x 3m</h2>
            <p class="mt-3 text-[17px] font-medium text-[#34405F]">(9 sq.m)</p>

            <div class="mx-auto mt-10 grid h-[66px] w-[78px] grid-cols-3 grid-rows-2 overflow-hidden bg-gradient-to-br from-[#2e05d7] to-[#4f20ff]">
                @for ($i = 0; $i < 6; $i++)
                    <span class="border border-white/30"></span>
                @endfor
            </div>

            <p class="mt-10 text-[26px] font-semibold leading-none text-navy">₹499</p>
        </button>

        <button type="button" data-size="3x4" class="size-btn relative min-h-[260px] rounded-xl border border-borderColor bg-white p-6 text-center shadow-sm">
            <span class="check-icon absolute right-3 top-3 hidden h-7 w-7 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                <i class="fa-solid fa-check text-[13px]"></i>
            </span>
            <h2 class="text-[20px] font-semibold text-navy">3m x 4m</h2>
            <p class="mt-3 text-[17px] font-medium text-[#34405F]">(12 sq.m)</p>

            <div class="mx-auto mt-10 grid h-[66px] w-[86px] grid-cols-3 grid-rows-2 overflow-hidden bg-gradient-to-br from-[#b38cff] to-[#8a55ef]">
                @for ($i = 0; $i < 6; $i++)
                    <span class="border border-white/30"></span>
                @endfor
            </div>

            <p class="mt-10 text-[26px] font-semibold leading-none text-navy">₹899</p>
        </button>

        <button type="button" data-size="6x3" class="size-btn relative min-h-[260px] rounded-xl border border-borderColor bg-white p-6 text-center shadow-sm">
            <span class="check-icon absolute right-3 top-3 hidden h-7 w-7 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                <i class="fa-solid fa-check text-[13px]"></i>
            </span>
            <h2 class="text-[20px] font-semibold text-navy">6m x 3m</h2>
            <p class="mt-3 text-[17px] font-medium text-[#34405F]">(18 sq.m)</p>

            <div class="mx-auto mt-10 grid h-[66px] w-[96px] grid-cols-4 grid-rows-3 overflow-hidden bg-gradient-to-br from-[#b38cff] to-[#8a55ef]">
                @for ($i = 0; $i < 12; $i++)
                    <span class="border border-white/30"></span>
                @endfor
            </div>

            <p class="mt-10 text-[26px] font-semibold leading-none text-navy">₹1,499</p>
        </button>

        <button type="button" data-size="6x6" class="size-btn relative min-h-[260px] rounded-xl border border-borderColor bg-white p-6 text-center shadow-sm">
            <span class="check-icon absolute right-3 top-3 hidden h-7 w-7 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                <i class="fa-solid fa-check text-[13px]"></i>
            </span>
            <h2 class="text-[20px] font-semibold text-navy">6m x 6m</h2>
            <p class="mt-3 text-[17px] font-medium text-[#34405F]">(36 sq.m)</p>

            <div class="mx-auto mt-8 grid h-[96px] w-[96px] grid-cols-4 grid-rows-4 overflow-hidden bg-gradient-to-br from-[#b38cff] to-[#8a55ef]">
                @for ($i = 0; $i < 16; $i++)
                    <span class="border border-white/30"></span>
                @endfor
            </div>

            <p class="mt-8 text-[26px] font-semibold leading-none text-navy">₹1,999</p>
        </button>

        <button type="button" data-size="9x9" class="size-btn relative min-h-[260px] rounded-xl border border-borderColor bg-white p-6 text-center shadow-sm">
            <span class="check-icon absolute right-3 top-3 hidden h-7 w-7 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                <i class="fa-solid fa-check text-[13px]"></i>
            </span>
            <h2 class="text-[20px] font-semibold text-navy">9m x 9m</h2>
            <p class="mt-3 text-[17px] font-medium text-[#34405F]">(81 sq.m)</p>

            <div class="mx-auto mt-7 grid h-[110px] w-[110px] grid-cols-5 grid-rows-5 overflow-hidden bg-gradient-to-br from-[#b38cff] to-[#8a55ef]">
                @for ($i = 0; $i < 25; $i++)
                    <span class="border border-white/30"></span>
                @endfor
            </div>

            <p class="mt-7 text-[26px] font-semibold leading-none text-navy">₹2,499</p>
        </button>
    </div>

    <div class="mb-4 rounded-xl border border-borderColor bg-white px-6 py-6 shadow-sm">
        <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-[20px] font-semibold text-navy">Custom Size</h2>
                <p class="mt-2 text-[16px] font-medium text-[#34405F]">Tailored to your needs</p>
            </div>

            <button type="button" class="inline-flex h-[52px] min-w-[150px] items-center justify-center rounded-md border border-[#B9A7FF] px-7 text-[16px] font-semibold text-purple">
                Contact Us
            </button>
        </div>
    </div>

    <div class="rounded-xl border border-borderColor bg-white px-6 py-7 shadow-sm">
        <h2 class="mb-8 text-[20px] font-semibold text-navy">
            Booth Includes
        </h2>

        <div class="grid grid-cols-1 gap-7 sm:grid-cols-2 lg:grid-cols-5">
            <div class="text-center">
                <i class="fa-solid fa-briefcase mb-4 text-[30px] text-purple"></i>
                <p class="text-[15px] font-medium text-[#34405F]">Basic Setup</p>
            </div>

            <div class="text-center">
                <i class="fa-regular fa-lightbulb mb-4 text-[34px] text-purple"></i>
                <p class="text-[15px] font-medium text-[#34405F]">2 Spot Lights</p>
            </div>

            <div class="text-center">
                <i class="fa-regular fa-square mb-4 text-[32px] text-purple"></i>
                <p class="text-[15px] font-medium text-[#34405F]">1 Power Socket</p>
            </div>

            <div class="text-center">
                <i class="fa-solid fa-table-cells mb-4 text-[32px] text-purple"></i>
                <p class="text-[15px] font-medium text-[#34405F]">Basic Carpet</p>
            </div>

            <div class="text-center">
                <i class="fa-solid fa-broom mb-4 text-[32px] text-purple"></i>
                <p class="text-[15px] font-medium text-[#34405F]">Daily Cleaning</p>
            </div>
        </div>
    </div>

    <div class="mt-7 flex justify-end">
        <a id="continue-btn" href="{{ url('/exhibitions/booths/slots?size=3x3') }}"
            class="inline-flex h-[58px] min-w-[250px] items-center justify-center gap-4 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-8 text-[18px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]">
            Continue
            <i class="fa-solid fa-arrow-right text-[15px]"></i>
        </a>
    </div>

</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sizeBtns = document.querySelectorAll('.size-btn');
        const continueBtn = document.getElementById('continue-btn');
        
        sizeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active classes from all
                sizeBtns.forEach(b => {
                    b.classList.remove('border-purple');
                    b.classList.add('border-borderColor');
                    const icon = b.querySelector('.check-icon');
                    if (icon) {
                        icon.classList.add('hidden');
                        icon.classList.remove('flex');
                    }
                });

                // Add active classes to clicked
                btn.classList.add('border-purple');
                btn.classList.remove('border-borderColor');
                const icon = btn.querySelector('.check-icon');
                if (icon) {
                    icon.classList.remove('hidden');
                    icon.classList.add('flex');
                }

                // Update URL
                const size = btn.getAttribute('data-size');
                continueBtn.href = "{{ url('/exhibitions/booths/slots') }}?size=" + size;
            });
        });
    });
</script>
@endpush

@endsection
