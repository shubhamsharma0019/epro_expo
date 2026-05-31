@extends('layouts.exhibition')

@section('title', 'EproExpo Add Services')

@section('content')

<section class="max-w-[1500px] px-4 py-6 sm:px-8 lg:px-10 lg:py-10">

    <div class="rounded-xl border border-borderColor bg-white px-4 py-6 shadow-sm sm:px-8 sm:py-7">
        <h1 class="mb-4 text-[26px] font-semibold leading-tight text-navy sm:mb-6 sm:text-[34px] sm:leading-[42px]">
            Add Services (Optional)
        </h1>

        <p class="mb-6 text-[16px] leading-7 text-[#34405F] sm:mb-8 sm:text-[22px] sm:leading-8">
            Enhance your presence with premium services.
        </p>

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-5 py-4 text-[15px] font-semibold text-red-700">
                {{ $errors->first() }}
            </div>
        @endif
        @if (session('status'))
            <div class="mb-6 rounded-lg border border-[#DCD3FF] bg-[#FBFAFF] px-5 py-4 text-[15px] font-semibold text-purple">
                {{ session('status') }}
            </div>
        @endif

        @php
            $featured = $services->first();
            $otherServices = $services->slice(1);
        @endphp

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <div class="overflow-hidden rounded-xl border border-borderColor bg-white shadow-sm">
                @if ($featured)
                    @php($featuredSelected = in_array($featured->id, $selectedServiceIds, true))
                    <div class="flex flex-col gap-4 border-b border-borderColor bg-[#FBFCFF] px-4 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-10 sm:py-8">
                        <form method="POST" action="{{ route('exhibitions.booking.services.toggle') }}" class="min-w-0 flex-1">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $featured->id }}">
                            <button type="submit" class="flex min-w-0 items-center gap-4 text-left text-[18px] font-semibold text-navy sm:gap-5 sm:text-[25px]">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded border-2 border-[#8FA0C7] bg-white text-black">
                                    @if ($featuredSelected)
                                        <i class="fa-solid fa-check text-[13px]"></i>
                                    @endif
                                </span>
                                <span class="min-w-0 break-words">{{ $featured->title }}</span>
                            </button>
                        </form>
                        <span class="shrink-0 text-[20px] font-semibold text-navy sm:text-[25px]">${{ number_format((float) $featured->price) }}</span>
                    </div>
                @endif

                <div class="space-y-5 px-4 py-5 sm:space-y-8 sm:px-10 sm:py-8">
                    @forelse ($otherServices as $service)
                        @php($selected = in_array($service->id, $selectedServiceIds, true))
                        <div class="flex flex-col gap-3 rounded-lg px-0 py-2 text-[18px] text-navy sm:flex-row sm:items-center sm:justify-between sm:gap-5 sm:px-3 sm:text-[22px]">
                            <form method="POST" action="{{ route('exhibitions.booking.services.toggle') }}" class="min-w-0 flex-1">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                <button type="submit" class="flex min-w-0 items-center gap-4 text-left sm:gap-6">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded border-2 border-[#8FA0C7] bg-white text-black">
                                        @if ($selected)
                                            <i class="fa-solid fa-check text-[13px]"></i>
                                        @endif
                                    </span>
                                    <span class="min-w-0 break-words">{{ $service->title }}</span>
                                </button>
                            </form>

                            <span class="shrink-0 font-semibold">${{ number_format((float) $service->price) }}</span>
                        </div>
                    @empty
                        <p class="text-[16px] font-semibold text-[#5A6480]">No services available.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-xl border border-borderColor bg-white p-4 shadow-sm sm:p-8">
                <h2 class="mb-5 text-[21px] font-semibold text-navy sm:mb-8 sm:text-[25px]">Service Details</h2>

                <div class="rounded-xl border border-borderColor bg-white p-4 sm:p-8">
                    <div class="flex gap-4 sm:gap-6">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                            <i class="{{ $detailService?->icon ?: 'fa-regular fa-star' }} text-[15px]"></i>
                        </span>

                        <div>
                            <h3 class="text-[20px] font-semibold text-navy sm:text-[25px]">{{ $detailService?->title ?? 'Featured Listing' }}</h3>
                            <p class="mt-4 max-w-[480px] text-[16px] leading-7 text-[#5A6480] sm:mt-5 sm:text-[21px] sm:leading-8">
                                {{ $detailService?->description ?? 'Highlight your company at the top of exhibitor list and get more visibility.' }}
                            </p>

                            <div class="mt-8 space-y-4 text-[15px] font-semibold text-[#34405F]">
                                <div class="flex items-center justify-between gap-5">
                                    <span>Selected Services</span>
                                    <span class="text-navy">{{ $selectedServicesCount }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-5">
                                    <span>Services Amount</span>
                                    <span class="text-navy">${{ number_format($servicesAmount) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 rounded-xl border border-borderColor bg-white px-4 py-5 shadow-sm sm:px-8">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-[20px] font-semibold text-navy sm:text-[24px]">Selected Services ({{ $selectedServicesCount }})</h2>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @forelse ($selectedServices as $service)
                            <span class="rounded-md border border-[#DCD3FF] bg-[#FBFAFF] px-3 py-2 text-[13px] font-semibold text-navy">
                                {{ $service->title }} - ${{ number_format((float) $service->price) }}
                            </span>
                        @empty
                            <span class="text-[14px] font-semibold text-[#5A6480]">No services selected</span>
                        @endforelse
                    </div>
                </div>

                <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                    <span class="text-[26px] font-semibold leading-none text-navy sm:text-[30px]">${{ number_format($servicesAmount) }}</span>
                    <a href="{{ url('/exhibitions/booking/review') }}"
                        class="inline-flex h-[56px] w-full items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[16px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)] sm:h-[66px] sm:w-auto sm:min-w-[330px] sm:gap-5 sm:px-8 sm:text-[21px]">
                        Continue to Review
                        <i class="fa-solid fa-arrow-right text-[17px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
