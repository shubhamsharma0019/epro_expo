@extends('layouts.company')

@section('title', 'Customize Booth')
@section('page-title', 'Booth Booking')

@section('content')
<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    @include('components.company.company-stepper', ['active' => 'Customize'])

    <div class="mb-8">
        <h1 class="text-[26px] font-semibold leading-tight tracking-[-0.8px] text-navy sm:text-[34px] sm:leading-[42px]">Customize Booth</h1>
    </div>

    @if (session('status'))
        <div class="mb-6 rounded-xl border border-[#dccfff] bg-[#f5f2ff] p-4 text-sm font-semibold text-[#5b2eff]">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <div class="space-y-6">
            <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
                <h2 class="mb-6 text-[24px] font-semibold text-navy">Branding Options</h2>
                <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                    @forelse ($brandingServices as $service)
                        @php $selected = $bookingServices->get($service->id); @endphp
                        <div class="rounded-xl border border-borderColor bg-white p-5 shadow-sm">
                            <div class="mb-5 flex h-[92px] items-center justify-center rounded-md bg-[#F4F0FF] text-purple">
                                <i class="{{ $service->icon ?: 'fa-solid fa-pen-nib' }} text-[26px]"></i>
                            </div>
                            <h3 class="text-[18px] font-semibold text-navy">{{ $service->title }}</h3>
                            <p class="mt-2 text-[15px] font-medium text-[#34405F]">₹{{ number_format((float) $service->price, 0) }}</p>
                            <form method="POST" action="{{ route('company.booth-booking.services.toggle') }}" class="mt-5">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                <input type="hidden" name="return_to" value="customize">
                                <button type="submit" class="inline-flex h-[44px] w-full items-center justify-center rounded-md {{ $selected ? 'bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white' : 'border border-purple text-purple' }} text-[15px] font-semibold">
                                    {{ $selected ? 'Selected' : 'Add' }}
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-[15px] font-medium text-[#34405F]">No branding services available yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
                <h2 class="mb-6 text-[24px] font-semibold text-navy">Furniture & Setup</h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @forelse ($furnitureServices as $service)
                        @php $selected = $bookingServices->get($service->id); @endphp
                        <form method="POST" action="{{ route('company.booth-booking.services.toggle') }}">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <input type="hidden" name="return_to" value="customize">
                            <button type="submit" class="flex w-full cursor-pointer items-center justify-between rounded-lg border border-borderColor bg-white px-5 py-4 text-left text-[16px] font-medium text-navy">
                                <span class="flex items-center gap-4">
                                    <span class="inline-flex h-5 w-5 items-center justify-center rounded border border-[#8FA0C7] {{ $selected ? 'bg-purple text-white' : 'bg-white' }}">
                                        @if ($selected)
                                            <i class="fa-solid fa-check text-[10px]"></i>
                                        @endif
                                    </span>
                                    <span>{{ $service->title }}</span>
                                </span>
                                <span class="font-semibold">₹{{ number_format((float) $service->price, 0) }}</span>
                            </button>
                        </form>
                    @empty
                        <p class="text-[15px] font-medium text-[#34405F]">No furniture services available yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <aside class="rounded-xl border border-borderColor bg-white p-6 shadow-sm xl:self-start">
            <h2 class="mb-6 text-[22px] font-semibold text-navy">Customization Summary</h2>
            <div class="space-y-4 text-[15px] font-medium text-[#34405F]">
                @forelse ($bookingServices as $bookingService)
                    <div class="flex items-center justify-between gap-5">
                        <span>{{ $bookingService->service?->title }}</span>
                        <span class="font-semibold text-navy">₹{{ number_format((float) $bookingService->total, 0) }}</span>
                    </div>
                @empty
                    <p>No customization options selected yet.</p>
                @endforelse
            </div>
            <div class="my-6 border-t border-borderColor"></div>
            <div class="flex items-center justify-between gap-5">
                <span class="text-[16px] font-semibold text-[#34405F]">Sub Total</span>
                <span class="text-[28px] font-semibold leading-none text-navy">₹{{ number_format((float) ($customizationTotal ?? 0), 0) }}</span>
            </div>
            <a href="{{ route('company.booth-booking.summary', request()->only('exhibition')) }}" class="mt-7 inline-flex h-[58px] w-full items-center justify-center gap-4 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-8 text-[18px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]">Continue <i class="fa-solid fa-arrow-right text-[15px]"></i></a>
        </aside>
    </div>
</section>
@endsection
