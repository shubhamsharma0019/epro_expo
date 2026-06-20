@extends('layouts.company')

@section('title', 'Meeting Details')
@section('page-title', 'Meeting Details')

@section('content')
<section class="max-w-[900px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    @if (session('status'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
        <div class="flex items-center justify-between mb-4">
            <span class="rounded-md px-3 py-1.5 text-[13px] font-semibold 
                {{ $meeting->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : ($meeting->status === 'confirmed' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700') }}">
                {{ ucfirst($meeting->status) }}
            </span>
            <a href="{{ route('company.meetings.index') }}" class="text-sm font-semibold text-purple hover:underline">
                Back to Meetings
            </a>
        </div>
        
        <h1 class="mt-5 text-[32px] font-semibold text-navy">
            {{ $meeting->companyMeeting ? $meeting->companyMeeting->title : 'Meeting Appointment' }}
        </h1>
        
        <div class="mt-7 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="rounded-lg border border-borderColor p-5">
                <p class="text-[14px] font-medium text-[#5A6480]">Attendee</p>
                <p class="mt-2 text-[17px] font-semibold text-navy">{{ $meeting->visitor_name }}</p>
                <p class="text-[13px] text-gray-500">{{ $meeting->visitor_email }}</p>
            </div>
            <div class="rounded-lg border border-borderColor p-5">
                <p class="text-[14px] font-medium text-[#5A6480]">Time Slot</p>
                <p class="mt-2 text-[17px] font-semibold text-navy">
                    {{ $meeting->companyMeeting ? \Carbon\Carbon::parse($meeting->companyMeeting->start_time)->format('M d, Y, h:i A') : 'N/A' }}
                </p>
            </div>
            <div class="rounded-lg border border-borderColor p-5">
                <p class="text-[14px] font-medium text-[#5A6480]">Attendee Message</p>
                <p class="mt-2 text-[17px] font-semibold text-navy">{{ $meeting->message ?: '--' }}</p>
            </div>
            <div class="rounded-lg border border-borderColor p-5">
                <p class="text-[14px] font-medium text-[#5A6480]">Description</p>
                <p class="mt-2 text-[17px] font-semibold text-navy">
                    {{ $meeting->companyMeeting ? $meeting->companyMeeting->description : '--' }}
                </p>
            </div>
        </div>
        
        @if ($meeting->status === 'confirmed' && $meeting->companyMeeting && ($meeting->companyMeeting->meeting_link || $meeting->companyMeeting->zoom_meeting_id))
            <div class="mt-7 rounded-lg border border-[#D1D5DB] bg-[#F9FAFB] p-6 space-y-3">
                <h3 class="text-[16px] font-semibold text-navy">
                    <i class="fa-solid fa-video text-[#2D8CFF] mr-2"></i> Zoom Meeting Details
                </h3>
                @if ($meeting->companyMeeting->meeting_link)
                    <a href="{{ $meeting->companyMeeting->meeting_link }}" target="_blank" class="block text-[15px] font-medium text-[#2D8CFF] hover:underline break-all">
                        {{ $meeting->companyMeeting->meeting_link }}
                    </a>
                @endif
                @if ($meeting->companyMeeting->zoom_meeting_id)
                    <p class="text-[14px] text-[#34405F]"><span class="font-semibold">Meeting ID:</span> {{ $meeting->companyMeeting->zoom_meeting_id }}</p>
                @endif
                @if ($meeting->companyMeeting->zoom_passcode)
                    <p class="text-[14px] text-[#34405F]"><span class="font-semibold">Passcode:</span> {{ $meeting->companyMeeting->zoom_passcode }}</p>
                @endif
                @if ($meeting->companyMeeting->meeting_date)
                    <p class="text-[14px] text-[#34405F]"><span class="font-semibold">Date:</span> {{ $meeting->companyMeeting->meeting_date->format('M d, Y') }}@if ($meeting->companyMeeting->meeting_time) at {{ \Carbon\Carbon::parse($meeting->companyMeeting->meeting_time)->format('h:i A') }}@endif</p>
                @endif
                @if ($meeting->companyMeeting->meeting_agenda)
                    <p class="text-[14px] text-[#34405F]"><span class="font-semibold">Agenda:</span> {{ $meeting->companyMeeting->meeting_agenda }}</p>
                @endif
            </div>
        @endif

        @if (in_array($meeting->status, ['pending', 'confirmed', 'accepted', 'rescheduled'], true))
            <div class="mt-7 rounded-lg border border-borderColor p-6">
                <h3 class="text-[16px] font-semibold text-navy mb-4">Zoom meeting setup (optional)</h3>
                <form method="POST" action="{{ route('company.meetings.zoom.update', $meeting->id) }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @csrf
                    <div class="md:col-span-2">
                        <label class="text-[13px] font-semibold text-[#5A6480]">Meeting link</label>
                        <input type="url" name="meeting_link" value="{{ old('meeting_link', $meeting->companyMeeting?->meeting_link) }}" class="mt-1 h-11 w-full rounded-md border border-borderColor px-3 text-[14px]" placeholder="https://zoom.us/j/...">
                    </div>
                    <div>
                        <label class="text-[13px] font-semibold text-[#5A6480]">Meeting ID</label>
                        <input type="text" name="zoom_meeting_id" value="{{ old('zoom_meeting_id', $meeting->companyMeeting?->zoom_meeting_id) }}" class="mt-1 h-11 w-full rounded-md border border-borderColor px-3 text-[14px]">
                    </div>
                    <div>
                        <label class="text-[13px] font-semibold text-[#5A6480]">Passcode</label>
                        <input type="text" name="zoom_passcode" value="{{ old('zoom_passcode', $meeting->companyMeeting?->zoom_passcode) }}" class="mt-1 h-11 w-full rounded-md border border-borderColor px-3 text-[14px]">
                    </div>
                    <div>
                        <label class="text-[13px] font-semibold text-[#5A6480]">Date</label>
                        <input type="date" name="meeting_date" value="{{ old('meeting_date', optional($meeting->companyMeeting?->meeting_date)->format('Y-m-d')) }}" class="mt-1 h-11 w-full rounded-md border border-borderColor px-3 text-[14px]">
                    </div>
                    <div>
                        <label class="text-[13px] font-semibold text-[#5A6480]">Time</label>
                        <input type="time" name="meeting_time" value="{{ old('meeting_time', $meeting->companyMeeting?->meeting_time ? \Carbon\Carbon::parse($meeting->companyMeeting->meeting_time)->format('H:i') : '') }}" class="mt-1 h-11 w-full rounded-md border border-borderColor px-3 text-[14px]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-[13px] font-semibold text-[#5A6480]">Agenda</label>
                        <textarea name="meeting_agenda" rows="3" class="mt-1 w-full rounded-md border border-borderColor px-3 py-2 text-[14px]">{{ old('meeting_agenda', $meeting->companyMeeting?->meeting_agenda) }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <button type="submit" class="inline-flex h-[44px] items-center justify-center rounded-md border border-purple px-5 text-[14px] font-semibold text-purple hover:bg-[#F4F2FF]">Save meeting details</button>
                    </div>
                </form>
            </div>
        @endif

        @if (in_array($meeting->status, ['pending', 'confirmed', 'accepted', 'rescheduled'], true))
            <div class="mt-7 rounded-lg border border-borderColor p-6">
                <h3 class="text-[16px] font-semibold text-navy mb-4">Manage Schedule & Actions</h3>
                
                @if(session('error'))
                    <div class="mb-4 rounded-md bg-red-50 p-4 text-sm font-medium text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex flex-wrap gap-3 mb-6">
                    @if ($meeting->status === 'pending')
                        <form method="POST" action="{{ route('company.meetings.status.update', $meeting->id) }}" class="inline-block">
                            @csrf
                            <input type="hidden" name="status" value="confirmed">
                            <input type="hidden" name="meeting_link" value="{{ $meeting->companyMeeting?->meeting_link }}">
                            <input type="hidden" name="zoom_meeting_id" value="{{ $meeting->companyMeeting?->zoom_meeting_id }}">
                            <input type="hidden" name="zoom_passcode" value="{{ $meeting->companyMeeting?->zoom_passcode }}">
                            <input type="hidden" name="meeting_date" value="{{ optional($meeting->companyMeeting?->meeting_date)->format('Y-m-d') }}">
                            <input type="hidden" name="meeting_time" value="{{ $meeting->companyMeeting?->meeting_time ? \Carbon\Carbon::parse($meeting->companyMeeting->meeting_time)->format('H:i') : '' }}">
                            <input type="hidden" name="meeting_agenda" value="{{ $meeting->companyMeeting?->meeting_agenda }}">
                            <button type="submit" class="inline-flex h-11 items-center justify-center rounded-md bg-[#16A34A] px-5 text-[14px] font-semibold text-white hover:bg-green-700">
                                Confirm Meeting
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('company.meetings.status.update', $meeting->id) }}" class="inline-block">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="inline-flex h-11 items-center justify-center rounded-md border border-red-200 px-5 text-[14px] font-semibold text-red-600 hover:bg-red-50">
                                Reject Request
                            </button>
                        </form>
                    @endif

                    @if (in_array($meeting->status, ['confirmed', 'accepted', 'rescheduled', 'pending'], true))
                        <button type="button" onclick="document.getElementById('reschedule-form').classList.toggle('hidden')" class="inline-flex h-11 items-center justify-center rounded-md border border-purple px-5 text-[14px] font-semibold text-purple hover:bg-[#F4F2FF]">
                            Reschedule...
                        </button>
                    @endif

                    @if (in_array($meeting->status, ['confirmed', 'accepted', 'rescheduled'], true))
                        <form method="POST" action="{{ route('company.meetings.status.update', $meeting->id) }}" class="inline-block">
                            @csrf
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="inline-flex h-11 items-center justify-center rounded-md bg-[#2563EB] px-5 text-[14px] font-semibold text-white hover:bg-blue-700">
                                Mark as Completed
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('company.meetings.status.update', $meeting->id) }}" class="inline-block">
                            @csrf
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="inline-flex h-11 items-center justify-center rounded-md border border-gray-300 px-5 text-[14px] font-semibold text-gray-700 hover:bg-gray-50">
                                Cancel Meeting
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Reschedule Form (Hidden by default) -->
                <div id="reschedule-form" class="{{ session('error') ? '' : 'hidden' }} border-t border-gray-100 pt-6">
                    <h4 class="text-[15px] font-bold text-navy mb-4">Select New Date & Time Slot</h4>
                    <form method="POST" action="{{ route('company.meetings.status.update', $meeting->id) }}" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @csrf
                        <input type="hidden" name="status" value="rescheduled">
                        <div>
                            <label class="text-[13px] font-semibold text-[#5A6480]">Preferred Date</label>
                            <input type="date" name="meeting_date" required value="{{ old('meeting_date', optional($meeting->companyMeeting?->meeting_date)->format('Y-m-d')) }}" class="mt-1 h-11 w-full rounded-md border border-borderColor px-3 text-[14px]">
                        </div>
                        <div>
                            <label class="text-[13px] font-semibold text-[#5A6480]">Preferred Time</label>
                            <input type="time" name="meeting_time" required value="{{ old('meeting_time', $meeting->companyMeeting?->meeting_time ? \Carbon\Carbon::parse($meeting->companyMeeting->meeting_time)->format('H:i') : '') }}" class="mt-1 h-11 w-full rounded-md border border-borderColor px-3 text-[14px]">
                        </div>
                        <div class="sm:col-span-2">
                            <button type="submit" class="inline-flex h-11 items-center justify-center rounded-md bg-purple px-5 text-[14px] font-semibold text-white hover:bg-opacity-90">
                                Submit Reschedule Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
