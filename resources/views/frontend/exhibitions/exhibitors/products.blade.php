@extends('layouts.exhibition')

@section('title', 'EproExpo Exhibitor Products')

@section('content')

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">Products</h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">Browse products showcased by TechNova Solutions.</p>
    </div>

    @include('frontend.exhibitions.partials.exhibition-tabs')

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        @foreach ([
            ['AI Workflow Studio', 'Automate approval, support, and reporting workflows.'],
            ['Cloud Ops Console', 'Monitor cloud health and deployment pipelines.'],
            ['Smart Analytics Kit', 'Real-time business metrics for operations teams.'],
        ] as [$title, $description])
            <article class="rounded-2xl border border-borderColor bg-white p-6 shadow-sm">
                <div class="mb-5 flex h-[120px] items-center justify-center rounded-lg bg-[#F4F0FF] text-purple">
                    <i class="fa-solid fa-cube text-[30px]"></i>
                </div>
                <h2 class="text-[20px] font-semibold text-navy">{{ $title }}</h2>
                <p class="mt-3 text-[15px] font-medium leading-7 text-[#34405F]">{{ $description }}</p>
            </article>
        @endforeach
    </div>
</section>

@endsection
