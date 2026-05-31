@extends('layouts.exhibition')

@section('title', 'EproExpo Catalogues')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">Catalogues</h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">View product catalogues and solution brochures.</p>
    </div>

    @include('frontend.exhibitions.partials.exhibition-tabs')

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        @foreach (['Enterprise AI Catalogue', 'Cloud Modernization Catalogue'] as $catalogue)
            <article class="rounded-2xl border border-borderColor bg-white p-6 shadow-sm">
                <div class="mb-5 h-[160px] rounded-lg bg-gradient-to-r from-[#071044] to-[#5b2eff]"></div>
                <h2 class="text-[21px] font-semibold text-navy">{{ $catalogue }}</h2>
                <button type="button" class="mt-5 inline-flex h-[48px] items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[15px] font-semibold text-white">
                    Open Catalogue
                </button>
            </article>
        @endforeach
    </div>
</section>

@endsection
