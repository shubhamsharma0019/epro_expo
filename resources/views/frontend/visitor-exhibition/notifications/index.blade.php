@extends('layouts.exhibition')

@section('title', 'Notifications - EproExpo')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')

<section class="visitor-flow-page mx-auto w-full max-w-[1100px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="visitor-flow-hero mb-7">
        <p class="text-[13px] font-semibold uppercase tracking-[0.12em] text-purple">Visitor updates</p>
        <h1>Notifications</h1>
        <p>Meeting reminders, session alerts, exhibitor updates and saved booth activity from the live exhibition database.</p>
    </div>

    <div class="space-y-4">
        @forelse (($notifications ?? collect()) as $notification)
            <article class="visitor-flow-card">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-[18px] font-semibold text-navy">{{ $notification['title'] }}</h2>
                        <p class="mt-2 text-[14px] font-medium leading-6 text-[#5A6480]">{{ $notification['copy'] }}</p>
                    </div>
                    <span class="shrink-0 text-[13px] font-semibold text-purple">{{ $notification['time'] }}</span>
                </div>
            </article>
        @empty
            <div class="visitor-flow-empty">
                <p class="text-[16px] font-semibold text-navy">No notifications yet</p>
                <p class="mt-2 text-[14px] text-[#5A6480]">Announcements and meeting updates will appear here when available.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
