@extends('layouts.frontend')

@section('title', 'Events Dashboard')

@section('content')
<main class="px-[44px] pt-8 pb-10">
    <div class="mb-6 flex items-end justify-between gap-4">
        <div>
            <h1 class="text-[22px] font-extrabold tracking-[-0.02em] text-[#212D6B]">Events Dashboard</h1>
            <p class="mt-2 text-[14px] text-[#4E567A]">Manage your event bookings, tickets, agenda, and networking.</p>
        </div>
        <a href="{{ url('/events/listings') }}" class="rounded-xl bg-[#4318FF] px-6 py-3 text-[14px] font-bold text-white shadow-[0_8px_20px_rgba(67,24,255,0.25)]">Browse Events</a>
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
        @foreach ([['Upcoming Events','4'], ['Active Tickets','2'], ['Meetings','6']] as [$label, $value])
            <div class="rounded-2xl border border-[#E8E3F0] bg-white p-6 shadow-[0_1px_2px_rgba(27,36,87,0.02)]">
                <p class="text-[14px] font-medium text-[#4E567A]">{{ $label }}</p>
                <p class="mt-4 text-[30px] font-semibold text-[#1F2A6A]">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-7 rounded-2xl border border-[#E8E3F0] bg-white p-7 shadow-[0_1px_2px_rgba(27,36,87,0.02)]">
        <h2 class="text-[18px] font-bold text-[#1F2A6A]">Continue Event Flow</h2>
        <div class="mt-5 flex flex-wrap gap-3">
            @foreach ([['Listings','/events/listings'],['Agenda','/events/agenda/schedule'],['Networking','/events/networking/attendees'],['Live','/events/live/livestream'],['Profile','/events/profile']] as [$label, $href])
                <a href="{{ url($href) }}" class="rounded-xl border border-[#B9A8F3] px-5 py-2.5 text-[14px] font-bold text-[#5B35D5] hover:bg-[#F4F0FF]">{{ $label }}</a>
            @endforeach
        </div>
    </div>
</main>
@endsection