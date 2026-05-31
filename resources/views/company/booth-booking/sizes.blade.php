@extends('layouts.company-flow')

@section('title', 'EproExpo Booth Size Options')

@section('content')
@php
    $selectedSizeId = $selectedSize?->id;
@endphp

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[32px] font-semibold leading-[40px] tracking-[-0.8px] text-navy">
            Choose Booth Size
        </h1>

        <p class="mt-4 text-[16px] font-medium leading-7 text-[#34405F]">
            Select the booth size that fit your requirements.
            @if ($hall)
                <span class="block text-[14px] text-[#5A6480]">{{ $hall->title }} · {{ optional($hall->pavilion)->title }}</span>
            @endif
        </p>
    </div>

    <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-5">
        @forelse ($boothSizes as $size)
            @php
                $isSelected = $selectedSizeId === $size->id;
                $area = (float) $size->area;
                $cols = $area >= 81 ? 5 : ($area >= 18 ? 4 : 3);
                $rows = $area >= 81 ? 5 : ($area >= 36 ? 4 : ($area >= 18 ? 3 : 2));
                $cells = $cols * $rows;
                $shapeClass = $area >= 81
                    ? 'mt-7 h-[110px] w-[110px]'
                    : ($area >= 36 ? 'mt-8 h-[96px] w-[96px]' : 'mt-10 h-[66px] w-[96px]');
                $priceClass = $area >= 81 ? 'mt-7' : ($area >= 36 ? 'mt-8' : 'mt-10');
            @endphp

            <form method="POST" action="{{ route('company.booth-booking.sizes.select') }}">
                @csrf
                <input type="hidden" name="hall_id" value="{{ $hall?->id }}">
                <input type="hidden" name="size_id" value="{{ $size->id }}">
            <button type="submit" class="relative block min-h-[260px] w-full rounded-xl border {{ $isSelected ? 'border-purple' : 'border-borderColor' }} bg-white p-6 text-center shadow-sm no-underline transition hover:border-purple">
                @if ($isSelected)
                    <span class="absolute right-3 top-3 flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                        <i class="fa-solid fa-check text-[13px]"></i>
                    </span>
                @endif

                <h2 class="text-[20px] font-semibold text-navy">{{ $size->title }}</h2>
                <p class="mt-3 text-[17px] font-medium text-[#34405F]">({{ number_format((float) $size->area, 0) }} sq.m)</p>

                <div class="mx-auto {{ $shapeClass }} grid overflow-hidden bg-gradient-to-br {{ $isSelected ? 'from-[#2e05d7] to-[#4f20ff]' : 'from-[#b38cff] to-[#8a55ef]' }}"
                    style="grid-template-columns: repeat({{ $cols }}, minmax(0, 1fr)); grid-template-rows: repeat({{ $rows }}, minmax(0, 1fr));">
                    @for ($i = 0; $i < $cells; $i++)
                        <span class="border border-white/30"></span>
                    @endfor
                </div>

                <p class="{{ $priceClass }} text-[26px] font-semibold leading-none text-navy">₹{{ number_format((float) $size->price) }}</p>
            </button>
            </form>
        @empty
            <div class="rounded-xl border border-borderColor bg-white p-10 text-center shadow-sm sm:col-span-2 xl:col-span-5">
                <h2 class="text-[20px] font-semibold text-navy">No booth sizes available</h2>
                <p class="mt-2 text-[15px] font-medium text-[#5A6480]">Add active booth sizes in the database to continue.</p>
            </div>
        @endforelse
    </div>

    <div class="mb-4 rounded-xl border border-borderColor bg-white px-6 py-6 shadow-sm">
        <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-[20px] font-semibold text-navy">Custom Size</h2>
                <p class="mt-2 text-[16px] font-medium text-[#34405F]">Tailored to your needs</p>
            </div>

            <form method="POST" action="{{ route('company.booth-booking.sizes.custom') }}">
                @csrf
                <input type="hidden" name="hall_id" value="{{ $hall?->id }}">
            <button type="submit" class="inline-flex h-[52px] min-w-[150px] items-center justify-center rounded-md border border-[#B9A7FF] px-7 text-[16px] font-semibold text-purple">
                Contact Us
            </button>
            </form>
        </div>
    </div>

    <div class="rounded-xl border border-borderColor bg-white px-6 py-7 shadow-sm">
        <h2 class="mb-8 text-[20px] font-semibold text-navy">
            Booth Includes
        </h2>

        <div class="grid grid-cols-1 gap-7 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ([['fa-solid fa-briefcase', 'Basic Setup'], ['fa-regular fa-lightbulb', '2 Spot Lights'], ['fa-regular fa-square', '1 Power Socket'], ['fa-solid fa-table-cells', 'Basic Carpet'], ['fa-solid fa-broom', 'Daily Cleaning']] as [$icon, $label])
                <div class="text-center">
                    <i class="{{ $icon }} mb-4 text-[30px] text-purple"></i>
                    <p class="text-[15px] font-medium text-[#34405F]">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-7 flex justify-end">
        <form method="POST" action="{{ route('company.booth-booking.sizes.continue') }}">
            @csrf
            <input type="hidden" name="hall_id" value="{{ $hall?->id }}">
            <input type="hidden" name="size_id" value="{{ $selectedSizeId }}">
        <button type="submit"
            class="inline-flex h-[58px] min-w-[250px] items-center justify-center gap-4 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-8 text-[18px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)] disabled:cursor-not-allowed disabled:opacity-60"
            @disabled(! $hall || ! $selectedSize)>
            Continue
            <i class="fa-solid fa-arrow-right text-[15px]"></i>
        </button>
        </form>
    </div>

</section>

@endsection
