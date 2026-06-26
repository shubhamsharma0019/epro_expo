@extends('layouts.company')

@section('title', 'Media Details')
@section('page-title', 'Media Gallery')

@section('content')
<section class="max-w-[900px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="rounded-xl border border-borderColor bg-white p-8 shadow-sm">
        <div class="mb-6 flex h-[240px] items-center justify-center rounded-lg bg-[#F4F0FF] text-purple"><i class="fa-regular fa-image text-[42px]"></i></div>
        <h1 class="text-[32px] font-semibold text-navy">Booth Hero Image</h1>
        <p class="mt-3 text-[15px] font-medium text-[#5A6480]">Image asset, updated today</p>
        <a href="{{ url('/company/media/1/edit') }}" class="mt-8 inline-flex h-[50px] items-center justify-center rounded-md border border-purple px-6 text-[15px] font-semibold text-purple">Edit Media</a>
    </div>
</section>
@endsection
