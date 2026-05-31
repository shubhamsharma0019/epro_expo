@extends('layouts.company')

@section('title', 'Documents')
@section('page-title', 'Documents')

@section('content')
<section class="max-w-[1200px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8 flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
        <div>
            <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">Manage Documents</h1>
            <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">Upload company profiles, certifications, and datasheets.</p>
        </div>
        <a href="{{ url('/company/documents/create') }}" class="inline-flex h-[52px] items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[15px] font-semibold text-white">Add Document</a>
    </div>
    <div class="space-y-4">
        @include('components.company.company-document-card', ['title' => 'Company Profile.pdf', 'showUrl' => '/company/documents/1', 'editUrl' => '/company/documents/1/edit'])
        @include('components.company.company-document-card', ['title' => 'AI Workflow Datasheet.pdf', 'meta' => 'PDF, 2.4 MB', 'showUrl' => '/company/documents/2', 'editUrl' => '/company/documents/2/edit'])
        @include('components.company.company-document-card', ['title' => 'Security Certification.pdf', 'meta' => 'PDF, 1.1 MB', 'showUrl' => '/company/documents/3', 'editUrl' => '/company/documents/3/edit'])
    </div>
</section>
@endsection
