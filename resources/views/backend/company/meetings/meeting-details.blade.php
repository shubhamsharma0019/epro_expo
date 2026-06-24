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

    @if (session('error'))
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 px-5 py-4 text-sm text-blue-800">
        <p class="font-semibold">Google Meet meetings</p>
        <p class="mt-1">When you confirm, a real Google Meet link is created automatically. Both company and visitor can join using the same link.</p>
        @if (empty($googleMeetConfigured))
            <p class="mt-2 text-[13px] font-medium text-amber-800">Google API is not configured yet — you can paste a <code class="text-[12px]">meet.google.com</code> link manually below.</p>
        @endif
    </div>

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
        
        @if (in_array($meeting->status, ['confirmed', 'accepted', 'rescheduled'], true) && $meeting->companyMeeting && ($meeting->companyMeeting->meeting_link || $meeting->companyMeeting->zoom_meeting_id || $meeting->companyMeeting->zoom_join_url))
            <div class="mt-7 rounded-lg border border-[#D1D5DB] bg-[#F9FAFB] p-6 space-y-3">
                <h3 class="text-[16px] font-semibold text-navy">
                    <i class="fa-solid fa-video text-[#0F9D58] mr-2"></i> Google Meet
                </h3>
                @php
                    $joinUrl = $meeting->companyMeeting->zoom_join_url ?: $meeting->companyMeeting->meeting_link;
                @endphp
                @if ($joinUrl)
                    <a href="{{ $joinUrl }}" target="_blank" rel="noopener" class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-[#0F9D58] px-4 text-[13px] font-semibold text-white hover:bg-[#0B8043]">
                        <i class="fa-solid fa-video"></i> Join Google Meet
                    </a>
                @endif
                @if ($meeting->companyMeeting->zoom_start_url && $meeting->companyMeeting->zoom_start_url !== $joinUrl)
                    <a href="{{ $meeting->companyMeeting->zoom_start_url }}" target="_blank" rel="noopener" class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-[#2D8CFF] px-4 text-[13px] font-semibold text-[#2D8CFF] hover:bg-blue-50">
                        <i class="fa-solid fa-play"></i> Host Link (Zoom)
                    </a>
                @endif
                @if ($joinUrl)
                    <div>
                        <p class="text-[13px] font-semibold text-[#5A6480] mb-1">Share this link with visitor</p>
                        <a href="{{ $joinUrl }}" target="_blank" rel="noopener" class="block text-[15px] font-medium text-[#0F9D58] hover:underline break-all">
                            {{ $joinUrl }}
                        </a>
                    </div>
                @endif
                @if ($meeting->companyMeeting->zoom_meeting_id && str_contains($meeting->companyMeeting->zoom_meeting_id, '-'))
                    <p class="text-[14px] text-[#34405F]"><span class="font-semibold">Meet code:</span> {{ $meeting->companyMeeting->zoom_meeting_id }}</p>
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
                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    <h3 class="text-[16px] font-semibold text-navy">Google Meet setup</h3>
                    @if ($meeting->companyMeeting && ! empty($googleMeetConfigured))
                        <form method="POST" action="{{ route('company.meetings.zoom.create', $meeting->id) }}" class="inline-block">
                            @csrf
                            <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-[#0F9D58] px-4 text-[13px] font-semibold text-white hover:bg-[#0B8043]">
                                <i class="fa-solid fa-rotate-right"></i> {{ ($meeting->companyMeeting->zoom_join_url || $meeting->companyMeeting->meeting_link) ? 'Regenerate Google Meet Link' : 'Create Google Meet Link' }}
                            </button>
                        </form>
                    @endif
                </div>
                <p class="mb-4 text-[13px] text-[#5A6480]">Link not working? Try <strong>Regenerate</strong> first, or paste a new link from <strong>meet.google.com</strong>.</p>
                @if ($meeting->companyMeeting && ($meeting->companyMeeting->meeting_link || $meeting->companyMeeting->zoom_join_url))
                    <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                        If Meet shows &quot;Invalid video call name&quot;, delete the old link, paste a new one, then click <strong>Save meeting details</strong>.
                    </div>
                @endif
                <form method="POST" action="{{ route('company.meetings.zoom.update', $meeting->id) }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @csrf
                    <div class="md:col-span-2">
                        <label class="text-[13px] font-semibold text-[#5A6480]">Google Meet link</label>
                        <input type="url" name="meeting_link" value="{{ old('meeting_link', $meeting->companyMeeting?->zoom_join_url ?: $meeting->companyMeeting?->meeting_link) }}" class="mt-1 h-11 w-full rounded-md border border-borderColor px-3 text-[14px]" placeholder="https://meet.google.com/abc-defg-hij">
                        <p class="mt-1 text-[12px] text-[#5A6480]">New link: open meet.google.com → New meeting → copy link → paste here</p>
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

                <div class="flex flex-wrap gap-3 mb-6">
                    @if ($meeting->status === 'pending')
                        <form method="POST" action="{{ route('company.meetings.status.update', $meeting->id) }}" class="inline-block">
                            @csrf
                            <input type="hidden" name="status" value="confirmed">
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
