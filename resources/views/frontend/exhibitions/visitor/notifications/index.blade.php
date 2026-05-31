@extends('layouts.frontend')

@section('title', 'Notifications - EproExpo')

@section('content')
<section class="max-w-[1100px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="mb-7 rounded-xl border border-borderColor bg-white p-6 shadow-sm lg:p-8">
        <p class="text-[13px] font-semibold uppercase tracking-[0.12em] text-purple">Visitor updates</p>
        <h1 class="mt-3 text-[32px] font-semibold tracking-[-0.8px] text-navy sm:text-[40px]">Notifications</h1>
        <p class="mt-3 max-w-[760px] text-[16px] font-medium leading-7 text-[#5A6480]">Meeting reminders, session alerts, exhibitor replies and saved booth updates.</p>
    </div>

    <div class="space-y-4">
        @foreach ([['Meeting confirmed', 'TechNova Solutions accepted your 10:30 AM meeting request.', '2 min ago'], ['Session starting soon', 'AI in Exhibitions Webinar starts at 03:00 PM.', '20 min ago'], ['Brochure available', 'GreenLoop Energy added a new product catalogue.', '1 hr ago'], ['Chat reply', 'CloudBridge replied to your booth chat.', '2 hrs ago']] as [$title, $copy, $time])
            <article class="rounded-xl border border-borderColor bg-white p-5 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-[18px] font-semibold text-navy">{{ $title }}</h2>
                        <p class="mt-2 text-[14px] font-medium leading-6 text-[#5A6480]">{{ $copy }}</p>
                    </div>
                    <span class="shrink-0 text-[13px] font-semibold text-purple">{{ $time }}</span>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endsection
