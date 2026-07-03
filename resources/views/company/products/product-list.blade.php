@extends('layouts.company')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8 flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
        <div>
            <h1 class="company-page-title font-semibold text-navy">Manage Products</h1>
        </div>
        <a href="{{ url('/company/products/create') }}" class="inline-flex h-[52px] items-center justify-center gap-3 rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[15px] font-semibold text-white">Add Product</a>
    </div>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        @include('components.company.company-product-card')
        @include('components.company.company-product-card', ['title' => 'Cloud Ops Console', 'description' => 'Monitor cloud health and deployment pipelines.', 'showUrl' => '/company/products/2', 'editUrl' => '/company/products/2/edit'])
        @include('components.company.company-product-card', ['title' => 'Smart Analytics Kit', 'description' => 'Real-time business metrics for operations teams.', 'showUrl' => '/company/products/3', 'editUrl' => '/company/products/3/edit'])
    </div>
</section>
@endsection
