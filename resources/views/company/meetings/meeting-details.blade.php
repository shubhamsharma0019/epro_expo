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

    <div class="mb-6 rounded-xl border border-[#EADCFD] bg-[#FBFAFF] px-5 py-4 text-sm text-[#34405F]">
        <p class="font-semibold text-navy">Meeting setup — 3 simple steps</p>
        <ol class="mt-2 list-decimal space-y-1 pl-5">
            <li>Paste your <strong>Google Meet link</strong>, set <strong>date & time</strong>, and click <strong>Save meeting details</strong>.</li>
            <li>The visitor is notified automatically and the meeting is marked <strong>Confirmed</strong> when a link is saved.</li>
            <li>After the call, click <strong>Mark as Completed</strong> (or <strong>Cancel Meeting</strong> if needed).</li>
        </ol>
        @if ($meeting->status === 'pending')
            <p class="mt-2 text-[13px] font-medium text-amber-800">This request is still pending — save a Meet link below to confirm it for the visitor.</p>
        @endif
    </div>

    <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 px-5 py-4 text-sm text-blue-800">
        <p class="font-semibold">Google Meet meetings</p>
        <p class="mt-1">Host and visitor join the <strong>same Google Meet link</strong>. Save the link, then use <strong>Join as Host</strong> before the visitor joins.</p>
        @if (empty($googleMeetConfigured))
            <p class="mt-2 text-[13px] font-medium text-amber-800">Google API is not configured yet — you can paste a <code class="text-[12px]">meet.google.com</code> link manually below.</p>
        @endif
        @if (! empty($meetJoinUrl))
            <div class="mt-3 rounded-lg border border-blue-300 bg-white px-4 py-3 text-[13px] text-[#1E3A5F]">
                <p class="font-semibold">Testing on the same laptop?</p>
                <ol class="mt-2 list-decimal space-y-1 pl-5">
                    <li>Save <strong>one</strong> Meet link first (do not click Regenerate repeatedly).</li>
                    <li>Company → <strong>Join as Host</strong> in a normal Chrome window.</li>
                    <li>Visitor → log in with <strong>Incognito / a separate browser</strong> and click <strong>Join Meet</strong>.</li>
                    <li>Both users will join the same room: <code class="break-all text-[12px]">{{ $meetJoinUrl }}</code></li>
                    <li>If both sides use the same Google account, choose <strong>Join as guest</strong> on the visitor side so two separate participants appear.</li>
                </ol>
            </div>
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

        @if (in_array($meeting->status, ['confirmed', 'accepted', 'rescheduled'], true))
            <div class="mt-6 rounded-xl border border-[#BBF7D0] bg-[#F0FDF4] p-5">
                @if (! empty($meetJoinUrl))
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-[15px] font-bold text-[#166534]">Ready to join</p>
                            <p class="mt-1 text-[13px] text-[#15803D]">Host and visitor use the same Google Meet room. Join here first as host.</p>
                            <p class="mt-2 text-[12px] font-mono text-[#166534] break-all">{{ $meetJoinUrl }}</p>
                        </div>
                        <form method="POST" action="{{ route('company.meetings.join', $meeting->id) }}">
                            @csrf
                            <button type="submit" class="inline-flex h-12 items-center justify-center gap-2 rounded-lg bg-[#0F9D58] px-6 text-[14px] font-bold text-white hover:bg-[#0B8043] whitespace-nowrap">
                                <i class="fa-solid fa-video"></i> Join as Host
                            </button>
                        </form>
                    </div>
                @else
                    <p class="text-[14px] font-semibold text-amber-900">Meeting is confirmed but no Google Meet link is saved yet.</p>
                    <p class="mt-1 text-[13px] text-amber-800">Paste your <code>meet.google.com</code> link below and click <strong>Save meeting details</strong>.</p>
                @endif
            </div>
        @endif
        
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
        
        @if ($meeting->companyMeeting && ! empty($meetJoinUrl))
            <div class="mt-7 rounded-lg border border-[#D1D5DB] bg-[#F9FAFB] p-6 space-y-3">
                <h3 class="text-[16px] font-semibold text-navy">
                    <i class="fa-solid fa-video text-[#0F9D58] mr-2"></i> Google Meet
                </h3>
                @php
                    $joinUrl = $meetJoinUrl;
                    $isGoogleMeet = str_contains($joinUrl, 'meet.google.com');
                    $meetCode = null;
                    if ($isGoogleMeet && preg_match('~meet\.google\.com/([a-z0-9-]+)~i', $joinUrl, $meetMatches)) {
                        $meetCode = $meetMatches[1];
                    }
                @endphp
                <form method="POST" action="{{ route('company.meetings.join', $meeting->id) }}">
                    @csrf
                    <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-md bg-[#0F9D58] px-5 text-[14px] font-semibold text-white hover:bg-[#0B8043]">
                        <i class="fa-solid fa-video"></i> Join as Host
                    </button>
                </form>
                <p class="text-[13px] text-[#5A6480]">Same link is sent to the visitor — both join one meeting room.</p>
                <div>
                    <p class="text-[13px] font-semibold text-[#5A6480] mb-1">Meeting link (shared with visitor)</p>
                    <a href="{{ $joinUrl }}" target="_blank" rel="noopener" class="block text-[15px] font-medium text-[#0F9D58] hover:underline break-all">
                        {{ $joinUrl }}
                    </a>
                </div>
                @if ($meetCode)
                    <p class="text-[14px] text-[#34405F]"><span class="font-semibold">Meet code:</span> {{ $meetCode }}</p>
                @elseif ($meeting->companyMeeting->zoom_meeting_id && ! $isGoogleMeet)
                    <p class="text-[14px] text-[#34405F]"><span class="font-semibold">Meeting ID:</span> {{ $meeting->companyMeeting->zoom_meeting_id }}</p>
                @endif
                @if ($meeting->companyMeeting->host_email || $meeting->companyMeeting->attendee_email)
                    <div class="rounded-md border border-[#E5E7EB] bg-white px-4 py-3 text-[13px] text-[#34405F]">
                        @if ($meeting->companyMeeting->host_email)
                            <p><span class="font-semibold">Host:</span> {{ $meeting->companyMeeting->host_email }}</p>
                        @endif
                        @if ($meeting->companyMeeting->attendee_email)
                            <p class="{{ $meeting->companyMeeting->host_email ? 'mt-1' : '' }}"><span class="font-semibold">Visitor:</span> {{ $meeting->companyMeeting->attendee_email }}</p>
                        @endif
                    </div>
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
                        @if (! empty($meetJoinUrl))
                            <form method="POST" action="{{ route('company.meetings.join', $meeting->id) }}" class="inline-block">
                                @csrf
                                <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-md bg-[#0F9D58] px-5 text-[14px] font-semibold text-white hover:bg-[#0B8043]">
                                    <i class="fa-solid fa-video"></i> Join as Host
                                </button>
                            </form>
                        @endif
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
