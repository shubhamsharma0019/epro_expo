@extends('layouts.company')

@section('title', 'Media Gallery')
@section('page-title', 'Media Gallery')

@section('content')
<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8 flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
        <div>
            <h1 class="company-page-title font-semibold text-navy">Manage Media Gallery</h1>
            <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">Add images and videos for your booth profile.</p>
        </div>
        <a href="{{ url('/company/media/create') }}" class="inline-flex h-[52px] items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[15px] font-semibold text-white">Add Media</a>
    </div>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        @include('components.company.company-media-card', ['title' => 'Booth Hero Image', 'showUrl' => '/company/media/1', 'editUrl' => '/company/media/1/edit'])
        @include('components.company.company-media-card', ['title' => 'Product Demo Video', 'icon' => 'fa-regular fa-circle-play', 'meta' => 'Video asset', 'showUrl' => '/company/media/2', 'editUrl' => '/company/media/2/edit'])
        @include('components.company.company-media-card', ['title' => 'Team Photo', 'showUrl' => '/company/media/3', 'editUrl' => '/company/media/3/edit'])
    </div>
</section>
@endsection
