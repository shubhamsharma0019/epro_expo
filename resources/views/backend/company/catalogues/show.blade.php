@extends('layouts.company')

@section('title', 'Catalogue Details')
@section('page-title', 'Catalogues')

@section('content')
<section class="max-w-[900px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="rounded-xl border border-borderColor bg-white p-8 shadow-sm">
        <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-md bg-[#F4F0FF] text-purple"><i class="fa-regular fa-folder-open text-[26px]"></i></div>
        <h1 class="text-[32px] font-semibold text-navy">Product Catalogue 2024.pdf</h1>
        <p class="mt-3 text-[15px] font-medium text-[#5A6480]">24 pages, updated today</p>
        <a href="{{ url('/company/catalogues/1/edit') }}" class="mt-8 inline-flex h-[50px] items-center justify-center rounded-md border border-purple px-6 text-[15px] font-semibold text-purple">Edit Catalogue</a>
    </div>
</section>
@endsection
