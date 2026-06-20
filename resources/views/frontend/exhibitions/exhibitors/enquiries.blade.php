@extends('layouts.exhibition')

@section('title', 'EproExpo Exhibitor Enquiries')

@section('content')

@php
    $bookings = collect($bookings ?? []);
    $userFullName = auth()->check()
        ? trim((auth()->user()->first_name ?? '') . ' ' . (auth()->user()->last_name ?? '')) ?: auth()->user()->name
        : '';
    $userEmail = auth()->check() ? auth()->user()->email : '';
@endphp

<section class="max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">Enquiries</h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">Send an enquiry to an exhibitor.</p>
    </div>

    @include('frontend.exhibitions.partials.exhibition-tabs')

    @if (session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-[14px] font-semibold text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-[14px] font-semibold text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('exhibitions.exhibitors.enquiries.send') }}" class="rounded-2xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
        @csrf

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <label>
                <span class="mb-2 block text-[13px] font-semibold text-[#34405F]">Company</span>
                <select name="booth_booking_id" required class="h-[52px] w-full rounded-md border border-borderColor bg-white px-4 text-[15px] font-medium text-navy outline-none focus:border-purple">
                    <option value="">Select company</option>
                    @foreach ($bookings as $booking)
                        @php
                            $companyName = $booking->boothProfile?->company_name ?? $booking->company?->company_name ?? $booking->company?->name ?? 'Company';
                            $exhibitionName = $booking->exhibition?->title;
                        @endphp
                        <option value="{{ $booking->id }}" @selected(old('booth_booking_id') == $booking->id)>
                            {{ $companyName }}{{ $exhibitionName ? ' - ' . $exhibitionName : '' }}
                        </option>
                    @endforeach
                </select>
                @error('booth_booking_id')
                    <span class="mt-1 block text-[12px] font-semibold text-red-600">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span class="mb-2 block text-[13px] font-semibold text-[#34405F]">Subject</span>
                <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Product pricing, demo, catalogue..." class="h-[52px] w-full rounded-md border border-borderColor px-4 text-[15px] font-medium text-navy outline-none focus:border-purple">
                @error('subject')
                    <span class="mt-1 block text-[12px] font-semibold text-red-600">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span class="mb-2 block text-[13px] font-semibold text-[#34405F]">Name</span>
                <input type="text" name="name" value="{{ old('name', $userFullName) }}" required class="h-[52px] w-full rounded-md border border-borderColor px-4 text-[15px] font-medium text-navy outline-none focus:border-purple">
                @error('name')
                    <span class="mt-1 block text-[12px] font-semibold text-red-600">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span class="mb-2 block text-[13px] font-semibold text-[#34405F]">Email</span>
                <input type="email" name="email" value="{{ old('email', $userEmail) }}" required class="h-[52px] w-full rounded-md border border-borderColor px-4 text-[15px] font-medium text-navy outline-none focus:border-purple">
                @error('email')
                    <span class="mt-1 block text-[12px] font-semibold text-red-600">{{ $message }}</span>
                @enderror
            </label>
        </div>

        <label class="mt-5 block">
            <span class="mb-2 block text-[13px] font-semibold text-[#34405F]">Message</span>
            <textarea name="message" rows="6" required placeholder="Write your enquiry..." class="w-full rounded-md border border-borderColor px-4 py-4 text-[15px] font-medium text-navy outline-none focus:border-purple">{{ old('message') }}</textarea>
            @error('message')
                <span class="mt-1 block text-[12px] font-semibold text-red-600">{{ $message }}</span>
            @enderror
        </label>

        <button type="submit" class="mt-5 inline-flex h-[52px] items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-7 text-[16px] font-semibold text-white disabled:cursor-not-allowed disabled:opacity-60" @disabled($bookings->isEmpty())>
            Submit Enquiry
        </button>

        @if ($bookings->isEmpty())
            <p class="mt-4 text-[13px] font-semibold text-[#5A6480]">No live exhibitor booths are available for enquiries yet.</p>
        @endif
    </form>
</section>

@endsection
