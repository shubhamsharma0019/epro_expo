@extends('layouts.exhibition')

@section('title', 'EproExpo Exhibitor Enquiries')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">Enquiries</h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">Send an enquiry to TechNova Solutions.</p>
    </div>

    @include('frontend.exhibitions.partials.exhibition-tabs')

    <div class="rounded-2xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <input type="text" value="John Doe" class="h-[52px] rounded-md border border-borderColor px-4 text-[15px] font-medium text-navy outline-none">
            <input type="email" value="john.doe@example.com" class="h-[52px] rounded-md border border-borderColor px-4 text-[15px] font-medium text-navy outline-none">
        </div>
        <textarea rows="6" placeholder="Write your enquiry..." class="mt-5 w-full rounded-md border border-borderColor px-4 py-4 text-[15px] font-medium text-navy outline-none"></textarea>
        <button type="button" class="mt-5 inline-flex h-[52px] items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-7 text-[16px] font-semibold text-white">
            Submit Enquiry
        </button>
    </div>
</section>

@endsection
