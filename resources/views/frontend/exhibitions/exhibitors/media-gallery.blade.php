@extends('layouts.exhibition')

@section('title', 'EproExpo Media Gallery')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">Media Gallery</h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">Photos and demo media from the exhibitor booth.</p>
    </div>

    @include('frontend.exhibitions.partials.exhibition-tabs')

    <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
        @foreach (range(1, 6) as $item)
            <div class="h-[220px] rounded-2xl border border-borderColor bg-white p-3 shadow-sm">
                <div class="flex h-full items-center justify-center rounded-xl bg-[#F4F0FF] text-purple">
                    <i class="fa-regular fa-image text-[30px]"></i>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection
