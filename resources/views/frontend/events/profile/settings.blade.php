@extends('layouts.frontend')

@section('title', 'Settings')

@section('content')
<main class="px-[44px] pt-8 pb-10">
    <div class="mb-6">
        <h1 class="text-[22px] font-extrabold tracking-[-0.02em] text-[#212D6B]">Settings</h1>
        <p class="mt-2 text-[14px] text-[#4E567A]">Update preferences and account settings.</p>
    </div>
    <div class="rounded-2xl border border-[#E8E3F0] bg-white p-7 shadow-[0_1px_2px_rgba(27,36,87,0.02)]">
        <div class="grid gap-4 md:grid-cols-2">
            <x-frontend.agenda-card title="Opening Keynote" time="09:00 AM" />
            <x-frontend.agenda-card title="Networking Session" time="02:00 PM" />
        </div>
        <a href="{{ url('/events/dashboard') }}" class="mt-7 inline-flex rounded-xl bg-[#4318FF] px-7 py-3 text-[15px] font-bold text-white shadow-[0_8px_20px_rgba(67,24,255,0.25)]">Events Dashboard</a>
    </div>
</main>
@endsection