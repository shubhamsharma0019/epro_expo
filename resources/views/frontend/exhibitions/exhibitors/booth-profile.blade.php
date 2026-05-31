@extends('layouts.exhibition')

@section('title', 'EproExpo Booth Microsite')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8 overflow-hidden rounded-2xl border border-borderColor bg-white shadow-sm">
        <div class="bg-gradient-to-r from-[#071044] via-[#17206A] to-[#5b2eff] px-6 py-10 text-white sm:px-8">
            <p class="text-[15px] font-medium text-white/75">Exhibitor Booth Microsite</p>
            <h1 class="mt-3 text-[36px] font-semibold leading-[44px] tracking-[-0.8px]">TechNova Solutions</h1>
            <p class="mt-4 max-w-3xl text-[16px] font-medium leading-7 text-white/80">
                AI automation, cloud transformation, and connected product demos at Innovation Pavilion.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-6 sm:p-8 xl:grid-cols-[minmax(0,1fr)_340px]">
            <div>
                @include('frontend.exhibitions.partials.exhibition-tabs')

                <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm">
                    <h2 class="mb-5 text-[24px] font-semibold text-navy">Company Overview</h2>
                    <p class="text-[16px] font-medium leading-8 text-[#34405F]">
                        TechNova Solutions helps teams automate operations using practical AI workflows, secure cloud infrastructure, and analytics dashboards.
                    </p>
                    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                        @foreach ([['12+', 'Products'], ['40+', 'Team Members'], ['18', 'Live Demos']] as [$value, $label])
                            <div class="rounded-xl border border-borderColor bg-[#FBFCFF] p-5">
                                <p class="text-[28px] font-semibold text-navy">{{ $value }}</p>
                                <p class="mt-1 text-[14px] font-medium text-[#5A6480]">{{ $label }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside class="rounded-xl border border-borderColor bg-white p-6 shadow-sm xl:self-start">
                <h2 class="mb-5 text-[22px] font-semibold text-navy">Booth Information</h2>
                <div class="space-y-4 text-[15px] font-medium text-[#34405F]">
                    <p><i class="fa-solid fa-location-dot mr-3 text-purple"></i>Hall 1 - Booth 12A</p>
                    <p><i class="fa-regular fa-calendar-days mr-3 text-purple"></i>May 16 - May 19, 2024</p>
                    <p><i class="fa-solid fa-globe mr-3 text-purple"></i>www.technova.example</p>
                </div>
                <a href="{{ url('/exhibitions/exhibitors/meetings') }}" class="mt-7 inline-flex h-[52px] w-full items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[16px] font-semibold text-white">
                    Schedule Meeting
                </a>
            </aside>
        </div>
    </div>
</section>

@endsection
