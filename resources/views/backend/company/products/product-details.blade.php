@extends('layouts.company')

@section('title', 'Product Details')
@section('page-title', 'Products')

@section('content')
<section class="max-w-[1000px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-6 flex h-[160px] items-center justify-center rounded-lg bg-[#F4F0FF] text-purple"><i class="fa-solid fa-cube text-[42px]"></i></div>
        <h1 class="text-[34px] font-semibold text-navy">AI Workflow Studio</h1>
        <p class="mt-4 text-[16px] font-medium leading-7 text-[#34405F]">Automate approval, support, and reporting workflows.</p>
        <a href="{{ url('/company/products/1/edit') }}" class="mt-8 inline-flex h-[50px] items-center justify-center rounded-md border border-purple px-6 text-[15px] font-semibold text-purple">Edit Product</a>
    </div>
</section>
@endsection
