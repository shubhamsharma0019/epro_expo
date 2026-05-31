@extends('layouts.exhibition')

@section('title', 'EproExpo Customize Booth')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">

    <div class="mb-10 flex items-center gap-5 overflow-x-auto pb-1 text-[15px] font-medium text-[#34405F]">
        @foreach ([
            ['Pavilion', '/exhibitions/pavilions/innovation-pavilion'],
            ['Hall', '/exhibitions/halls/hall-1'],
            ['Booth Size', '/exhibitions/booths/sizes'],
            ['Booth Slot', '/exhibitions/booths/slots'],
        ] as [$label, $href])
            <a href="{{ url($href) }}" class="flex shrink-0 items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white">
                    <i class="fa-solid fa-check text-[12px]"></i>
                </span>
                <span>{{ $label }}</span>
            </a>
            <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>
        @endforeach

        <a href="{{ url('/exhibitions/booths/customize') }}" class="flex shrink-0 items-center gap-3 rounded-full bg-[#F4F0FF] px-4 py-2 text-purple">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[14px] font-semibold text-white">5</span>
            <span class="font-semibold">Customize</span>
        </a>
        <i class="fa-solid fa-chevron-right shrink-0 text-[12px] text-[#9AA3B8]"></i>
        <a href="{{ url('/exhibitions/booking/summary') }}" class="flex shrink-0 items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full border border-[#8FA0C7] bg-white text-[14px] font-semibold text-navy">6</span>
            <span>Summary</span>
        </a>
    </div>

    <div class="mb-8">
        <h1 class="text-[32px] font-semibold leading-[40px] tracking-[-0.8px] text-navy">
            Customize Booth
        </h1>
        <p class="mt-4 text-[16px] font-medium leading-7 text-[#34405F]">
            Choose booth branding, furniture, and display options before reviewing your booking.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <div class="space-y-6">
            <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
                <h2 class="mb-6 text-[24px] font-semibold text-navy">Branding Options</h2>
                <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                    @foreach ([
                        ['Logo Fascia', '₹49', 'Selected'],
                        ['Back Wall Print', '₹129', 'Add'],
                        ['Digital Screen', '₹199', 'Add'],
                    ] as [$title, $price, $action])
                        <div class="rounded-xl border border-borderColor bg-white p-5 shadow-sm">
                            <div class="mb-5 flex h-[92px] items-center justify-center rounded-md bg-[#F4F0FF] text-purple">
                                <i class="fa-solid fa-pen-nib text-[26px]"></i>
                            </div>
                            <h3 class="text-[18px] font-semibold text-navy">{{ $title }}</h3>
                            <p class="mt-2 text-[15px] font-medium text-[#34405F]">{{ $price }}</p>
                            <button type="button" class="mt-5 inline-flex h-[44px] w-full items-center justify-center rounded-md {{ $action === 'Selected' ? 'bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white' : 'border border-purple text-purple' }} text-[15px] font-semibold">
                                {{ $action }}
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
                <h2 class="mb-6 text-[24px] font-semibold text-navy">Furniture & Setup</h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @foreach ([
                        ['Reception Counter', '₹79'],
                        ['Meeting Table', '₹59'],
                        ['Two Chairs', '₹39'],
                        ['Brochure Stand', '₹29'],
                    ] as [$item, $price])
                        <label class="flex cursor-pointer items-center justify-between rounded-lg border border-borderColor bg-white px-5 py-4 text-[16px] font-medium text-navy">
                            <span class="flex items-center gap-4">
                                <input type="checkbox" class="h-5 w-5 rounded border-[#8FA0C7] text-purple" @checked($loop->first)>
                                <span>{{ $item }}</span>
                            </span>
                            <span class="font-semibold">{{ $price }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <aside class="rounded-xl border border-borderColor bg-white p-6 shadow-sm xl:self-start">
            <h2 class="mb-6 text-[22px] font-semibold text-navy">Customization Summary</h2>
            <div class="space-y-4 text-[15px] font-medium text-[#34405F]">
                <div class="flex items-center justify-between gap-5">
                    <span>Logo Fascia</span>
                    <span class="font-semibold text-navy">₹49</span>
                </div>
                <div class="flex items-center justify-between gap-5">
                    <span>Reception Counter</span>
                    <span class="font-semibold text-navy">₹79</span>
                </div>
            </div>
            <div class="my-6 border-t border-borderColor"></div>
            <div class="flex items-center justify-between gap-5">
                <span class="text-[16px] font-semibold text-[#34405F]">Sub Total</span>
                <span class="text-[28px] font-semibold leading-none text-navy">₹128</span>
            </div>
            <a href="{{ url('/exhibitions/booking/summary') }}" class="mt-7 inline-flex h-[58px] w-full items-center justify-center gap-4 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-8 text-[18px] font-semibold text-white shadow-[0_10px_20px_rgba(91,46,255,0.18)]">
                Continue
                <i class="fa-solid fa-arrow-right text-[15px]"></i>
            </a>
        </aside>
    </div>

</section>

@endsection
