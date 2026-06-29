@extends('layouts.frontend')

@section('title', 'Visitor Registration - ' . ($title ?? 'Event'))

@section('content')
<main class="mx-auto w-full max-w-[1200px] flex-1 px-4 pb-12 pt-6 md:px-[44px]">
    <div class="mb-8 flex flex-wrap items-center gap-2 text-[14px] text-[#6A708F]">
        <a href="{{ url('/events') }}" class="hover:text-[#5B35D5] transition">Home</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('events.listings.index') }}" class="hover:text-[#5B35D5] transition">Events</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('events.listings.show', $slug) }}" class="hover:text-[#5B35D5] transition">{{ $title }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="font-medium text-[#1F2A6A]">Get Visitor Pass</span>
    </div>

    @include('frontend.events.tickets.partials.event-flow-stepper', ['currentStep' => 1])

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
        <div class="lg:col-span-8">
            <div class="rounded-[20px] border border-[#E8E3F0] bg-white p-6 shadow-[0_4px_20px_rgba(31,42,107,0.03)] sm:p-8">
                <div class="mb-8">
                    <p class="text-[12px] font-bold uppercase tracking-[0.16em] text-[#5B35D5]">Visitor Registration</p>
                    <h1 class="mt-2 text-[26px] font-bold tracking-[-0.02em] text-[#1F2A6A] sm:text-[30px]">Your Information</h1>
                    <p class="mt-2 text-[15px] leading-7 text-[#4E567A]">Enter your details to continue with visitor pass booking for this event.</p>
                </div>

                @if ($errors->has('csrf'))
                    <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-[14px] font-medium text-amber-800">
                        {{ $errors->first('csrf') }}
                    </div>
                @endif

                @if ($errors->any() && ! $errors->has('csrf'))
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[14px] font-medium text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[14px] font-medium text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('events.tickets.visitor-details.store') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="event" value="{{ $slug }}">

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <label class="block md:col-span-2">
                            <span class="text-[13px] font-bold text-[#1F2A6A]">Full Name <span class="text-[#E03137]">*</span></span>
                            <input type="text" name="name" value="{{ $prefill['name'] }}" required
                                class="mt-2 w-full rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3.5 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white">
                        </label>

                        <label class="block">
                            <span class="text-[13px] font-bold text-[#1F2A6A]">Email <span class="text-[#E03137]">*</span></span>
                            <input type="email" name="email" value="{{ $prefill['email'] }}" required
                                class="mt-2 w-full rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3.5 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white">
                        </label>

                        <label class="block">
                            <span class="text-[13px] font-bold text-[#1F2A6A]">Password <span class="text-[#E03137]">*</span></span>
                            <input type="password" name="password" required minlength="8"
                                class="mt-2 w-full rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3.5 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white">
                            <span class="mt-1 block text-[12px] text-[#6A708F]">Minimum 8 characters. Use your existing password if you already have an account.</span>
                        </label>

                        <label class="block">
                            <span class="text-[13px] font-bold text-[#1F2A6A]">Phone Number <span class="text-[#E03137]">*</span></span>
                            <input type="tel" name="phone" value="{{ $prefill['phone'] }}" required
                                class="mt-2 w-full rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3.5 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white">
                        </label>

                        <label class="block">
                            <span class="text-[13px] font-bold text-[#1F2A6A]">Gender <span class="text-[#E03137]">*</span></span>
                            <select name="gender" required
                                class="mt-2 w-full rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3.5 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white">
                                <option value="" disabled {{ $prefill['gender'] ? '' : 'selected' }}>Select gender</option>
                                @foreach (['male' => 'Male', 'female' => 'Female', 'other' => 'Other', 'prefer_not_to_say' => 'Prefer not to say'] as $value => $label)
                                    <option value="{{ $value }}" @selected($prefill['gender'] === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block md:col-span-2">
                            <span class="text-[13px] font-bold text-[#1F2A6A]">City <span class="text-[#E03137]">*</span></span>
                            <input type="text" name="city" value="{{ $prefill['city'] }}" required
                                class="mt-2 w-full rounded-xl border border-[#E8E3F0] bg-[#FAFAFC] px-4 py-3.5 text-[14px] text-[#1F2A6A] outline-none transition focus:border-[#5B35D5] focus:bg-white">
                        </label>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-[#E8E3F0] pt-8 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('events.listings.show', $slug) }}"
                            class="inline-flex items-center justify-center rounded-xl border border-[#B9A8F3] px-8 py-3.5 text-[15px] font-bold text-[#5B35D5] transition hover:bg-[#F4F0FF]">
                            Back
                        </a>
                        <button type="submit"
                            class="rounded-xl bg-[#4318FF] px-10 py-3.5 text-[15px] font-bold text-white shadow-[0_8px_20px_rgba(67,24,255,0.25)] transition hover:bg-[#3412C9]">
                            Continue to Ticket Selection
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-4">
            <div class="sticky top-8 rounded-[20px] border border-[#E8E3F0] bg-[#FAFAFC] p-6 sm:p-8">
                <img src="{{ $bannerImage }}" alt="{{ $title }}" class="mb-5 h-[140px] w-full rounded-2xl object-cover bg-[#E8E3F0]">
                <h3 class="text-[18px] font-bold text-[#1F2A6A]">{{ $title }}</h3>
                <div class="mt-4 space-y-3 text-[14px] text-[#4E567A]">
                    <p class="flex items-start gap-2"><span class="font-bold text-[#1F2A6A]">Date:</span> {{ $dateStr }}</p>
                    <p class="flex items-start gap-2"><span class="font-bold text-[#1F2A6A]">Venue:</span> {{ $location }}</p>
                    <p class="flex items-start gap-2"><span class="font-bold text-[#1F2A6A]">From:</span> {{ $priceLabel }}</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
