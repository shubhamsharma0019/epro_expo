@extends('layouts.company')

@section('title', 'Company Profile')
@section('page-title', 'Company Profile')

@section('content')
@php
    $companyInitials = collect(explode(' ', $company->company_name ?? $company->name ?? 'Company'))
        ->filter()
        ->take(2)
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->implode('');
    $logoUrl = $company->logo ? asset($company->logo) : null;
@endphp

<section class="mx-auto w-full max-w-[1500px] px-4 py-6 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-[28px] font-bold leading-tight text-gray-900 sm:text-[34px]">Manage Company Profile</h1>
        <p class="mt-2 text-[15px] font-medium leading-7 text-gray-500">Keep your exhibitor profile, booth microsite, and contact details up to date.</p>
    </div>

    @if (session('status'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('company.profile.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-6 xl:grid-cols-[320px_minmax(0,1fr)]">
        @csrf

        <aside class="rounded-2xl border border-gray-100 bg-white p-6 text-center shadow-sm xl:self-start">
            <label class="group mx-auto flex h-28 w-28 cursor-pointer items-center justify-center overflow-hidden rounded-full bg-[#F4F0FF] text-[32px] font-bold text-[#3D1B9B] ring-1 ring-[#E7EAF3] transition hover:ring-[#3D1B9B]">
                @if ($logoUrl)
                    <img id="company-main-logo-preview" src="{{ $logoUrl }}" alt="{{ $company->company_name ?? 'Company logo' }}" class="h-full w-full object-cover">
                @else
                    <img id="company-main-logo-preview" src="" alt="Company logo preview" class="hidden h-full w-full object-cover">
                    <span id="company-main-logo-initials">{{ $companyInitials ?: 'C' }}</span>
                @endif
                <input id="company-main-logo-input" type="file" name="logo" class="hidden" accept="image/*">
            </label>
            <h2 class="mt-5 text-[22px] font-bold text-gray-900">{{ $company->company_name ?? $company->name ?? 'Company' }}</h2>
            <p class="mt-2 text-[14px] font-medium text-gray-500">{{ $company->industry ?? 'Industry not added' }}</p>
            <p class="mt-5 text-[12px] font-semibold text-gray-400">PNG, JPG or SVG. Max 5MB.</p>
        </aside>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6 lg:p-8">
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                <label class="block">
                    <span class="text-[14px] font-bold text-gray-700">Company Name <span class="text-red-500">*</span></span>
                    <input type="text" name="company_name" value="{{ old('company_name', $company->company_name ?? $company->name) }}" class="mt-2 h-[50px] w-full rounded-lg border border-gray-200 px-4 text-[15px] font-medium text-gray-900 outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                </label>
                <label class="block">
                    <span class="text-[14px] font-bold text-gray-700">Contact Person <span class="text-red-500">*</span></span>
                    <input type="text" name="contact_person_name" value="{{ old('contact_person_name', $company->contact_person_name ?? $company->owner_name) }}" class="mt-2 h-[50px] w-full rounded-lg border border-gray-200 px-4 text-[15px] font-medium text-gray-900 outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                </label>
                <label class="block">
                    <span class="text-[14px] font-bold text-gray-700">Email <span class="text-red-500">*</span></span>
                    <input type="email" name="email" value="{{ old('email', $company->email) }}" class="mt-2 h-[50px] w-full rounded-lg border border-gray-200 px-4 text-[15px] font-medium text-gray-900 outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                </label>
                <label class="block">
                    <span class="text-[14px] font-bold text-gray-700">Phone</span>
                    <input type="tel" name="phone" value="{{ old('phone', $company->phone) }}" class="mt-2 h-[50px] w-full rounded-lg border border-gray-200 px-4 text-[15px] font-medium text-gray-900 outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                </label>
                <label class="block">
                    <span class="text-[14px] font-bold text-gray-700">Website</span>
                    <input type="url" name="website" value="{{ old('website', $company->website) }}" class="mt-2 h-[50px] w-full rounded-lg border border-gray-200 px-4 text-[15px] font-medium text-gray-900 outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                </label>
                <label class="block">
                    <span class="text-[14px] font-bold text-gray-700">Industry</span>
                    <input type="text" name="industry" value="{{ old('industry', $company->industry) }}" class="mt-2 h-[50px] w-full rounded-lg border border-gray-200 px-4 text-[15px] font-medium text-gray-900 outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                </label>
                <label class="block">
                    <span class="text-[14px] font-bold text-gray-700">City</span>
                    <input type="text" name="city" value="{{ old('city', $company->city) }}" class="mt-2 h-[50px] w-full rounded-lg border border-gray-200 px-4 text-[15px] font-medium text-gray-900 outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                </label>
                <label class="block">
                    <span class="text-[14px] font-bold text-gray-700">Country</span>
                    <input type="text" name="country" value="{{ old('country', $company->country) }}" class="mt-2 h-[50px] w-full rounded-lg border border-gray-200 px-4 text-[15px] font-medium text-gray-900 outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                </label>
            </div>

            <label class="mt-5 block">
                <span class="text-[14px] font-bold text-gray-700">Address</span>
                <textarea name="address" rows="3" class="mt-2 w-full rounded-lg border border-gray-200 px-4 py-3 text-[15px] font-medium leading-7 text-gray-900 outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">{{ old('address', $company->address) }}</textarea>
            </label>

            <label class="mt-5 block">
                <span class="text-[14px] font-bold text-gray-700">Company Bio</span>
                <textarea name="about" rows="5" class="mt-2 w-full rounded-lg border border-gray-200 px-4 py-3 text-[15px] font-medium leading-7 text-gray-900 outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">{{ old('about', $company->about) }}</textarea>
            </label>

            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('company.dashboard') }}" class="inline-flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-6 py-3 text-[15px] font-bold text-gray-900 transition hover:border-[#3D1B9B] hover:text-[#3D1B9B] sm:w-auto">Cancel</a>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-[#3D1B9B] px-8 py-3 text-[15px] font-bold text-white shadow-md transition hover:bg-[#31167D] sm:w-auto">Save Profile</button>
            </div>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
    (() => {
        const input = document.getElementById('company-main-logo-input');
        const preview = document.getElementById('company-main-logo-preview');
        const initials = document.getElementById('company-main-logo-initials');

        input?.addEventListener('change', () => {
            const file = input.files?.[0];
            if (!file || !preview) {
                return;
            }

            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            initials?.classList.add('hidden');
        });
    })();
</script>
@endpush
