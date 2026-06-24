@extends('layouts.company')

@section('title', 'Company Settings')
@section('page-title', 'Settings')

@section('content')
<section class="max-w-[1100px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-8">
        <h1 class="text-[34px] font-semibold leading-[42px] tracking-[-0.8px] text-navy">Settings</h1>
        <p class="mt-3 text-[16px] font-medium leading-7 text-[#34405F]">Manage notification preferences and account access.</p>
    </div>

    <div class="space-y-5">
        @foreach ([['Email Notifications', 'Receive booking, enquiry, and meeting updates.'], ['Lead Alerts', 'Notify your team when a visitor sends an enquiry.'], ['Meeting Reminders', 'Send reminders before scheduled buyer meetings.']] as [$title, $description])
            <div class="flex flex-col gap-4 rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-[19px] font-semibold text-navy">{{ $title }}</h2>
                    <p class="mt-2 text-[15px] font-medium text-[#5A6480]">{{ $description }}</p>
                </div>
                <button type="button" class="h-8 w-14 rounded-full bg-[#5b2eff] p-1"><span class="block h-6 w-6 translate-x-6 rounded-full bg-white"></span></button>
            </div>
        @endforeach
    </div>
</section>
@endsection
