@extends('layouts.exhibition')

@section('title', 'EproExpo Exhibitor Meetings')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">Meetings</h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">Book or manage meetings with this exhibitor.</p>
    </div>

    @include('frontend.exhibitions.partials.exhibition-tabs')

    <div class="rounded-2xl border border-borderColor bg-white p-6 shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            @foreach (['May 16, 11:00 AM', 'May 17, 02:00 PM', 'May 18, 04:30 PM'] as $slot)
                <button type="button" class="rounded-xl border border-borderColor px-5 py-4 text-left text-[16px] font-semibold text-navy hover:border-purple hover:text-purple">
                    {{ $slot }}
                </button>
            @endforeach
        </div>
        <a href="{{ url('/exhibitions/exhibitors/enquiries') }}" class="mt-7 inline-flex h-[52px] items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-7 text-[16px] font-semibold text-white">
            Send Enquiry
        </a>
    </div>
</section>

@endsection
