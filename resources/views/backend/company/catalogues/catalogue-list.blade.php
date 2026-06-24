@extends('layouts.company')

@section('title', 'Catalogues')
@section('page-title', 'Catalogues')

@section('content')
<section class="max-w-[1200px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8 flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
        <div>
            <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">Manage Catalogues</h1>
        </div>
        <a href="{{ url('/company/catalogues/create') }}" class="inline-flex h-[52px] items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[15px] font-semibold text-white">Add Catalogue</a>
    </div>
    <div class="space-y-4">
        @include('components.company.company-catalogue-card', ['title' => 'Product Catalogue 2024.pdf', 'showUrl' => '/company/catalogues/1', 'editUrl' => '/company/catalogues/1/edit'])
        @include('components.company.company-catalogue-card', ['title' => 'Enterprise Solutions Brochure.pdf', 'meta' => '16 pages', 'showUrl' => '/company/catalogues/2', 'editUrl' => '/company/catalogues/2/edit'])
    </div>
</section>
@endsection
