@extends('layouts.user')

@section('title', 'User Settings')
@section('page-title', 'Settings')

@section('content')
<main class="px-5 py-6 sm:px-8 lg:px-8">
    <section class="rounded-[26px] border border-[#E7EAF3] bg-white p-6 shadow-[0_18px_50px_rgba(7,16,68,0.08)] sm:p-8">
        <span class="inline-flex rounded-full bg-[#F4F0FF] px-4 py-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#5b2eff]">Preferences</span>
        <h1 class="mt-5 text-[34px] font-semibold tracking-[-0.04em] text-[#071044]">Notification settings.</h1>
        <p class="mt-3 max-w-[700px] text-[15px] font-medium leading-7 text-[#5A6480]">Choose what updates you want to receive across tickets, enquiries, visits, and meetings.</p>
    </section>

    <section class="mt-6 grid gap-4">
        @foreach ([['Ticket Updates', 'Receive event and exhibition ticket notifications.', true], ['Enquiry Replies', 'Get notified when exhibitors reply.', true], ['Meeting Reminders', 'Reminders for upcoming booth meetings.', true], ['Marketing Updates', 'Occasional event recommendations and new exhibition alerts.', false]] as [$title, $copy, $active])
            <div class="flex flex-col gap-4 rounded-[22px] border border-[#E7EAF3] bg-white p-5 shadow-[0_12px_34px_rgba(7,16,68,0.06)] sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-[18px] font-semibold text-[#071044]">{{ $title }}</h2>
                    <p class="mt-2 text-[14px] font-medium text-[#5A6480]">{{ $copy }}</p>
                </div>
                <button type="button" class="h-8 w-14 rounded-full {{ $active ? 'bg-[#5b2eff]' : 'bg-[#D7DCE8]' }} p-1"><span class="block h-6 w-6 rounded-full bg-white transition {{ $active ? 'translate-x-6' : '' }}"></span></button>
            </div>
        @endforeach
    </section>
</main>
@endsection
