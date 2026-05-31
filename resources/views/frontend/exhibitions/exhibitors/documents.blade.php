@extends('layouts.exhibition')

@section('title', 'EproExpo Exhibitor Documents')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">Documents</h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">Download company documents, datasheets, and certifications.</p>
    </div>

    @include('frontend.exhibitions.partials.exhibition-tabs')

    <div class="space-y-4">
        @foreach (['Company Profile.pdf', 'AI Workflow Datasheet.pdf', 'Security Certification.pdf'] as $document)
            <div class="flex flex-col gap-4 rounded-xl border border-borderColor bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 items-center justify-center rounded-md bg-[#F4F0FF] text-purple"><i class="fa-regular fa-file-lines"></i></span>
                    <span class="text-[17px] font-semibold text-navy">{{ $document }}</span>
                </div>
                <button type="button" class="inline-flex h-[44px] items-center justify-center gap-3 rounded-md border border-purple px-5 text-[15px] font-semibold text-purple">
                    Download <i class="fa-solid fa-download text-[13px]"></i>
                </button>
            </div>
        @endforeach
    </div>
</section>

@endsection
