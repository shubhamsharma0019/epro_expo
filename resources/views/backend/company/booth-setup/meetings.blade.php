@extends('layouts.company')

@section('title', 'Setup Meeting Availability | eproexpo')
@section('page-title', 'Setup Meeting Availability')

@php
    $defaultStart = $availability?->available_start_date ?? $booking->exhibition?->start_date ?? now();
    $defaultEnd = $availability?->available_end_date ?? $booking->exhibition?->end_date ?? $defaultStart;
    $startDate = old('available_start_date', \Carbon\Carbon::parse($defaultStart)->format('Y-m-d'));
    $endDate = old('available_end_date', \Carbon\Carbon::parse($defaultEnd)->format('Y-m-d'));

    $selectedWeekdays = old('available_weekdays', $availability?->available_weekdays ?? ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']);
    $selectedWeekdays = is_array($selectedWeekdays) ? $selectedWeekdays : [];

    $selectedMeetingTypes = old('meeting_types', $availability?->meeting_types ?? ['video']);
    $selectedMeetingTypes = is_array($selectedMeetingTypes) ? $selectedMeetingTypes : [];

    $dailyStartTime = old('daily_start_time', $availability?->daily_start_time ? \Carbon\Carbon::parse($availability->daily_start_time)->format('H:i') : '09:00');
    $dailyEndTime = old('daily_end_time', $availability?->daily_end_time ? \Carbon\Carbon::parse($availability->daily_end_time)->format('H:i') : '18:00');
    $slotDuration = (int) old('slot_duration', $availability?->slot_duration ?? 30);
    $bufferTime = (int) old('buffer_time', $availability?->buffer_time ?? 10);
    $assignedTeamMemberId = old('assigned_team_member_id', $availability?->assigned_team_member_id);
    $timezone = old('timezone', $availability?->timezone ?? 'Asia/Kolkata');

    $weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    $meetingTypeOptions = [
        'video' => ['label' => 'Video', 'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
        'audio' => ['label' => 'Audio', 'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 15.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
        'chat' => ['label' => 'Chat', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
    ];

    $rangeStart = \Carbon\Carbon::parse($startDate);
    $rangeEnd = \Carbon\Carbon::parse($endDate);
    $rangeDays = $rangeStart->lte($rangeEnd) ? (int) $rangeStart->diffInDays($rangeEnd) + 1 : 0;
    $slotGroups = $meetingSlots->groupBy(fn ($slot) => \Carbon\Carbon::parse($slot->date)->format('M d, Y'))->take(5);
    $availableSlotCount = $meetingSlots->where('status', 'available')->count();
    $totalMinutes = $availableSlotCount * max($slotDuration, 0);
    $assignedMember = $teamMembers->firstWhere('id', (int) $assignedTeamMemberId);
@endphp

@section('content')
<div class="p-8">
    <div class="w-full max-w-[1400px] mx-auto border border-gray-100 rounded-2xl p-8 bg-white shadow-sm">
        <div class="mb-8">
            <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight">Setup Meeting Availability</h1>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-bold">Please fix the highlighted availability details.</p>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="meetingAvailabilityForm" method="POST" action="{{ route('company.booth-setup.meetings.update', $booking) }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
                <div class="md:col-span-5 border border-gray-100 rounded-xl p-6 bg-white shadow-sm">
                    <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Select Dates</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label for="available_start_date" class="block text-[#4B5563] text-[13px] font-medium mb-2">Start Date</label>
                            <input id="available_start_date" name="available_start_date" type="date" value="{{ $startDate }}" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        </div>
                        <div>
                            <label for="available_end_date" class="block text-[#4B5563] text-[13px] font-medium mb-2">End Date</label>
                            <input id="available_end_date" name="available_end_date" type="date" value="{{ $endDate }}" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        </div>
                    </div>

                    <div class="rounded-xl bg-[#F8FAFC] border border-gray-100 p-4">
                        <div class="flex items-center justify-between mb-4">
                            <span id="calendarRangeLabel" class="text-[#1E1B4B] font-bold text-[14px]">{{ $rangeStart->format('M d, Y') }} - {{ $rangeEnd->format('M d, Y') }}</span>
                            <span id="calendarDaysLabel" class="text-[#6B7280] text-[12px] font-semibold">{{ $rangeDays }} days</span>
                        </div>
                        <div id="availabilityCalendarGrid" class="grid grid-cols-7 gap-2 text-center">
                            @foreach ($weekdays as $day)
                                <div class="text-[11px] text-gray-400 font-bold">{{ substr($day, 0, 2) }}</div>
                            @endforeach

                            @foreach (\Carbon\CarbonPeriod::create($rangeStart->copy()->startOfWeek(\Carbon\Carbon::SUNDAY), $rangeEnd->copy()->endOfWeek(\Carbon\Carbon::SATURDAY)) as $calendarDay)
                                @php
                                    $inRange = $calendarDay->betweenIncluded($rangeStart, $rangeEnd);
                                    $isAvailableDay = in_array($calendarDay->format('l'), $selectedWeekdays, true);
                                @endphp
                                <div class="h-9 flex items-center justify-center rounded-lg text-[13px] font-semibold {{ $inRange && $isAvailableDay ? 'bg-[#4C1D95] text-white' : ($inRange ? 'bg-white text-[#1E1B4B] border border-gray-100' : 'text-gray-300') }}">
                                    {{ $calendarDay->day }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="md:col-span-7 border border-gray-100 rounded-xl p-6 bg-white shadow-sm">
                    <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Available Days</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($weekdays as $day)
                            @php $checked = in_array($day, $selectedWeekdays, true); @endphp
                            <label data-weekday-row class="grid grid-cols-[minmax(0,1fr)_auto] items-center gap-4 rounded-lg border {{ $checked ? 'border-[#4C1D95] bg-[#F5F3FF]' : 'border-gray-100 bg-white' }} px-4 py-3 cursor-pointer">
                                <span class="flex min-w-0 items-center">
                                    <input data-weekday-input type="checkbox" name="available_weekdays[]" value="{{ $day }}" @checked($checked) class="h-4 w-4 rounded border-gray-300 text-[#4C1D95] focus:ring-[#4C1D95]">
                                    <span data-weekday-name class="ml-3 truncate text-[14px] font-semibold {{ $checked ? 'text-[#1E1B4B]' : 'text-[#4B5563]' }}">{{ $day }}</span>
                                </span>
                                <span data-day-time class="text-[12px] text-[#6B7280] whitespace-nowrap">{{ \Carbon\Carbon::createFromFormat('H:i', $dailyStartTime)->format('h:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i', $dailyEndTime)->format('h:i A') }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <div class="md:col-span-4 border border-gray-100 rounded-xl p-6 bg-white shadow-sm">
                    <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Meeting Settings</h3>

                    <div class="mb-5">
                        <label class="block text-[#4B5563] text-[13px] font-medium mb-2">Meeting Type</label>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach ($meetingTypeOptions as $value => $type)
                                @php $checked = in_array($value, $selectedMeetingTypes, true); @endphp
                                <label data-meeting-type-row class="flex items-center justify-center border {{ $checked ? 'border-[#4C1D95] bg-[#F5F3FF] text-[#4C1D95]' : 'border-gray-200 bg-white text-gray-500' }} rounded-lg py-2 text-[13px] font-bold cursor-pointer">
                                    <input data-meeting-type-input type="checkbox" name="meeting_types[]" value="{{ $value }}" @checked($checked) class="sr-only">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $type['icon'] }}"></path></svg>
                                    {{ $type['label'] }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label for="daily_start_time" class="block text-[#4B5563] text-[13px] font-medium mb-2">Daily Start Time</label>
                            <input id="daily_start_time" name="daily_start_time" type="time" value="{{ $dailyStartTime }}" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        </div>
                        <div>
                            <label for="daily_end_time" class="block text-[#4B5563] text-[13px] font-medium mb-2">Daily End Time</label>
                            <input id="daily_end_time" name="daily_end_time" type="time" value="{{ $dailyEndTime }}" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="slot_duration" class="block text-[#4B5563] text-[13px] font-medium mb-2">Slot Duration</label>
                        <select id="slot_duration" name="slot_duration" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white">
                            @foreach ([15, 30, 45, 60, 90, 120] as $minutes)
                                <option value="{{ $minutes }}" @selected($slotDuration === $minutes)>{{ $minutes }} Minutes</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="buffer_time" class="block text-[#4B5563] text-[13px] font-medium mb-2">Buffer Time</label>
                        <select id="buffer_time" name="buffer_time" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white">
                            @foreach ([0, 5, 10, 15, 30, 45, 60] as $minutes)
                                <option value="{{ $minutes }}" @selected($bufferTime === $minutes)>{{ $minutes }} Minutes</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="assigned_team_member_id" class="block text-[#4B5563] text-[13px] font-medium mb-2">Assign to Team Member</label>
                        <select id="assigned_team_member_id" name="assigned_team_member_id" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white">
                            <option value="">Any Available Member</option>
                            @foreach ($teamMembers as $member)
                                <option value="{{ $member->id }}" @selected((string) $assignedTeamMemberId === (string) $member->id)>{{ $member->name }}{{ $member->designation ? ' - '.$member->designation : '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="max_capacity" class="block text-[#4B5563] text-[13px] font-medium mb-2">Max Capacity per Slot</label>
                        <input id="max_capacity" name="max_capacity" type="number" min="1" value="{{ old('max_capacity', $availability?->max_capacity ?? 1) }}" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>

                    <div class="mb-5">
                        <label class="block text-[#4B5563] text-[13px] font-medium mb-2">Availability Mode</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center text-[13px] font-medium text-[#4B5563] cursor-pointer">
                                <input type="checkbox" name="allow_one_to_one" value="1" {{ old('allow_one_to_one', $availability?->allow_one_to_one ?? 1) ? 'checked' : '' }} class="mr-2 rounded border-gray-300 text-[#4C1D95] focus:ring-[#4C1D95]">
                                One-to-One
                            </label>
                            <label class="flex items-center text-[13px] font-medium text-[#4B5563] cursor-pointer">
                                <input type="checkbox" name="allow_one_to_many" value="1" {{ old('allow_one_to_many', $availability?->allow_one_to_many ?? 0) ? 'checked' : '' }} class="mr-2 rounded border-gray-300 text-[#4C1D95] focus:ring-[#4C1D95]">
                                One-to-Many (Group)
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="timezone" class="block text-[#4B5563] text-[13px] font-medium mb-2">Timezone</label>
                        <select id="timezone" name="timezone" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg text-[#1E1B4B] text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B] bg-white">
                            @foreach (['Asia/Kolkata', 'UTC', 'Asia/Dubai', 'Europe/London', 'America/New_York'] as $tz)
                                <option value="{{ $tz }}" @selected($timezone === $tz)>{{ $tz }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="md:col-span-4 border border-gray-100 rounded-xl p-6 bg-white shadow-sm">
                    <div class="flex items-start justify-between gap-4 mb-6">
                        <h3 class="text-[#1E1B4B] font-bold text-[15px]">Time Slots Preview</h3>
                        <span id="previewSlotBadge" class="rounded-full bg-[#F5F3FF] px-3 py-1 text-[11px] font-bold text-[#4C1D95]">{{ $availableSlotCount }} slots</span>
                    </div>

                    <div id="slotsPreview" class="space-y-4 max-h-[430px] overflow-y-auto pr-1"></div>
                </div>

                <div class="md:col-span-4 border border-gray-100 rounded-xl p-6 bg-white shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="text-[#1E1B4B] font-bold text-[15px] mb-6">Selected Summary</h3>

                        <div class="space-y-4">
                            <div class="flex justify-between items-start border-b border-gray-50 pb-4">
                                <span class="text-[#6B7280] text-[13px]">Dates</span>
                                <div class="text-right">
                                    <p id="summaryDates" class="text-[#4B5563] text-[13px] mb-1">{{ $rangeStart->format('M d') }} - {{ $rangeEnd->format('M d, Y') }}</p>
                                    <p id="summaryDays" class="text-gray-400 text-[12px]">{{ $rangeDays }} Days</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-start border-b border-gray-50 pb-4">
                                <span class="text-[#6B7280] text-[13px]">Available Days</span>
                                <span id="summaryWeekdays" class="text-[#4B5563] text-[13px] text-right">{{ implode(', ', $selectedWeekdays) ?: 'Not selected' }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                                <span class="text-[#6B7280] text-[13px]">Estimated Slots</span>
                                <span id="summarySlots" class="text-[#4B5563] text-[13px]">{{ $availableSlotCount }} Slots</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                                <span class="text-[#6B7280] text-[13px]">Slot Duration</span>
                                <span id="summaryDuration" class="text-[#4B5563] text-[13px]">{{ $slotDuration }} Minutes</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                                <span class="text-[#6B7280] text-[13px]">Max Capacity</span>
                                <span id="summaryMaxCapacity" class="text-[#4B5563] text-[13px]">{{ $availability?->max_capacity ?? 1 }} Attendees</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                                <span class="text-[#6B7280] text-[13px]">Availability Modes</span>
                                <span id="summaryModes" class="text-[#4B5563] text-[13px]">{{ ($availability?->allow_one_to_one ?? true) ? 'One-to-One' : '' }} {{ ($availability?->allow_one_to_many ?? false) ? 'One-to-Many' : '' }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                                <span class="text-[#6B7280] text-[13px]">Buffer Time</span>
                                <span id="summaryBuffer" class="text-[#4B5563] text-[13px]">{{ $bufferTime }} Minutes</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                                <span class="text-[#6B7280] text-[13px]">Total Availability</span>
                                <span id="summaryTotalTime" class="text-[#4B5563] text-[13px]">{{ intdiv($totalMinutes, 60) }}h {{ $totalMinutes % 60 }}m</span>
                            </div>
                            <div class="flex justify-between items-start pb-4">
                                <span class="text-[#6B7280] text-[13px] flex-shrink-0 mr-4">Assigned To</span>
                                <span id="summaryAssigned" class="text-[#4B5563] text-[13px] text-right">{{ $assignedMember?->name ?? 'Any Available Member' }} ({{ $timezone }})</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        <button type="submit" class="w-full bg-[#4C1D95] text-white py-3 rounded-lg font-bold text-[14px] hover:bg-[#3b1774] transition-colors">
                            Save Availability
                        </button>
                        <a href="{{ route('company.booth-setup.sessions.index', $booking) }}" class="w-full inline-flex justify-center items-center px-6 py-3 border border-gray-200 rounded-lg text-[#1E1B4B] font-bold text-[14px] hover:bg-gray-50 transition-colors">
                            Continue to Sessions
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('meetingAvailabilityForm');
    if (!form) {
        return;
    }

    const weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const typeLabels = { video: 'Video', audio: 'Audio', chat: 'Chat' };
    const refs = {
        start: document.getElementById('available_start_date'),
        end: document.getElementById('available_end_date'),
        dailyStart: document.getElementById('daily_start_time'),
        dailyEnd: document.getElementById('daily_end_time'),
        duration: document.getElementById('slot_duration'),
        buffer: document.getElementById('buffer_time'),
        assigned: document.getElementById('assigned_team_member_id'),
        timezone: document.getElementById('timezone'),
        calendarGrid: document.getElementById('availabilityCalendarGrid'),
        calendarRange: document.getElementById('calendarRangeLabel'),
        calendarDays: document.getElementById('calendarDaysLabel'),
        slotsPreview: document.getElementById('slotsPreview'),
        previewSlotBadge: document.getElementById('previewSlotBadge'),
        summaryDates: document.getElementById('summaryDates'),
        summaryDays: document.getElementById('summaryDays'),
        summaryWeekdays: document.getElementById('summaryWeekdays'),
        summarySlots: document.getElementById('summarySlots'),
        summaryDuration: document.getElementById('summaryDuration'),
        summaryBuffer: document.getElementById('summaryBuffer'),
        summaryTotalTime: document.getElementById('summaryTotalTime'),
        summaryAssigned: document.getElementById('summaryAssigned'),
        maxCapacity: document.getElementById('max_capacity'),
        allowOneToOne: document.querySelector('input[name="allow_one_to_one"]'),
        allowOneToMany: document.querySelector('input[name="allow_one_to_many"]'),
        summaryMaxCapacity: document.getElementById('summaryMaxCapacity'),
        summaryModes: document.getElementById('summaryModes'),
    };

    const parseDate = (value) => {
        if (!value) {
            return null;
        }
        const parts = value.split('-').map(Number);
        if (parts.length !== 3 || parts.some(Number.isNaN)) {
            return null;
        }
        return new Date(parts[0], parts[1] - 1, parts[2]);
    };

    const dateKey = (date) => [date.getFullYear(), String(date.getMonth() + 1).padStart(2, '0'), String(date.getDate()).padStart(2, '0')].join('-');
    const cloneDate = (date) => new Date(date.getFullYear(), date.getMonth(), date.getDate());
    const addDays = (date, days) => {
        const next = cloneDate(date);
        next.setDate(next.getDate() + days);
        return next;
    };
    const formatDate = (date, withYear = true) => date.toLocaleDateString('en-US', {
        month: 'short',
        day: '2-digit',
        ...(withYear ? { year: 'numeric' } : {}),
    });
    const formatTime = (minutes) => {
        const normalized = ((minutes % 1440) + 1440) % 1440;
        const hours = Math.floor(normalized / 60);
        const mins = normalized % 60;
        const suffix = hours >= 12 ? 'PM' : 'AM';
        const hour12 = hours % 12 || 12;
        return `${String(hour12).padStart(2, '0')}:${String(mins).padStart(2, '0')} ${suffix}`;
    };
    const timeToMinutes = (value) => {
        const [hours, minutes] = (value || '').split(':').map(Number);
        if (Number.isNaN(hours) || Number.isNaN(minutes)) {
            return null;
        }
        return hours * 60 + minutes;
    };
    const selectedWeekdays = () => [...form.querySelectorAll('[data-weekday-input]:checked')].map((input) => input.value);
    const selectedTypes = () => [...form.querySelectorAll('[data-meeting-type-input]:checked')].map((input) => input.value);

    const buildSlots = () => {
        const start = parseDate(refs.start.value);
        const end = parseDate(refs.end.value);
        const dayNames = selectedWeekdays();
        const types = selectedTypes();
        const startMinutes = timeToMinutes(refs.dailyStart.value);
        const endMinutes = timeToMinutes(refs.dailyEnd.value);
        const duration = Math.max(1, Number.parseInt(refs.duration.value, 10) || 0);
        const buffer = Math.max(0, Number.parseInt(refs.buffer.value, 10) || 0);
        const slots = [];

        if (!start || !end || start > end || !dayNames.length || !types.length || startMinutes === null || endMinutes === null || startMinutes >= endMinutes) {
            return slots;
        }

        for (let date = cloneDate(start); date <= end; date = addDays(date, 1)) {
            const weekday = weekdays[date.getDay()];
            if (!dayNames.includes(weekday)) {
                continue;
            }

            for (let cursor = startMinutes; cursor + duration <= endMinutes; cursor += duration + buffer) {
                types.forEach((type) => {
                    slots.push({
                        date: cloneDate(date),
                        start: cursor,
                        end: cursor + duration,
                        type,
                    });
                });
            }
        }

        return slots;
    };

    const setActiveClasses = () => {
        form.querySelectorAll('[data-weekday-row]').forEach((row) => {
            const input = row.querySelector('[data-weekday-input]');
            const name = row.querySelector('[data-weekday-name]');
            row.classList.toggle('border-[#4C1D95]', input.checked);
            row.classList.toggle('bg-[#F5F3FF]', input.checked);
            row.classList.toggle('border-gray-100', !input.checked);
            row.classList.toggle('bg-white', !input.checked);
            name.classList.toggle('text-[#1E1B4B]', input.checked);
            name.classList.toggle('text-[#4B5563]', !input.checked);
        });

        form.querySelectorAll('[data-meeting-type-row]').forEach((row) => {
            const input = row.querySelector('[data-meeting-type-input]');
            row.classList.toggle('border-[#4C1D95]', input.checked);
            row.classList.toggle('bg-[#F5F3FF]', input.checked);
            row.classList.toggle('text-[#4C1D95]', input.checked);
            row.classList.toggle('border-gray-200', !input.checked);
            row.classList.toggle('bg-white', !input.checked);
            row.classList.toggle('text-gray-500', !input.checked);
        });
    };

    const renderCalendar = () => {
        const start = parseDate(refs.start.value);
        const end = parseDate(refs.end.value);
        const activeDays = selectedWeekdays();

        refs.calendarGrid.innerHTML = weekdays.map((day) => `<div class="text-[11px] text-gray-400 font-bold">${day.slice(0, 2)}</div>`).join('');

        if (!start || !end || start > end) {
            refs.calendarRange.textContent = 'Select valid dates';
            refs.calendarDays.textContent = '0 days';
            return;
        }

        refs.calendarRange.textContent = `${formatDate(start)} - ${formatDate(end)}`;
        const rangeDays = Math.round((end - start) / 86400000) + 1;
        refs.calendarDays.textContent = `${rangeDays} days`;

        const calendarStart = addDays(start, -start.getDay());
        const calendarEnd = addDays(end, 6 - end.getDay());
        const maxCells = 70;
        let cellCount = 0;

        for (let date = calendarStart; date <= calendarEnd && cellCount < maxCells; date = addDays(date, 1)) {
            const inRange = date >= start && date <= end;
            const active = inRange && activeDays.includes(weekdays[date.getDay()]);
            const className = active
                ? 'bg-[#4C1D95] text-white'
                : (inRange ? 'bg-white text-[#1E1B4B] border border-gray-100' : 'text-gray-300');
            refs.calendarGrid.insertAdjacentHTML('beforeend', `<div class="h-9 flex items-center justify-center rounded-lg text-[13px] font-semibold ${className}" data-date="${dateKey(date)}">${date.getDate()}</div>`);
            cellCount += 1;
        }
    };

    const renderPreview = (slots) => {
        refs.previewSlotBadge.textContent = `${slots.length} slots`;

        if (!slots.length) {
            refs.slotsPreview.innerHTML = `
                <div class="h-[320px] rounded-xl border border-dashed border-gray-200 bg-[#F8FAFC] flex flex-col items-center justify-center text-center px-6">
                    <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-[#1E1B4B] text-[14px] font-bold">No slots available</p>
                    <p class="text-[#6B7280] text-[13px] mt-1">Select dates, days, meeting type, and valid time range.</p>
                </div>
            `;
            return;
        }

        const grouped = slots.reduce((carry, slot) => {
            const label = formatDate(slot.date);
            carry[label] = carry[label] || [];
            carry[label].push(slot);
            return carry;
        }, {});

        refs.slotsPreview.innerHTML = Object.entries(grouped).slice(0, 5).map(([label, daySlots]) => `
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-[#1E1B4B] font-bold text-[12px]">${label}</h4>
                    <span class="text-gray-400 text-[11px]">${daySlots.length} slots</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    ${daySlots.slice(0, 8).map((slot) => `
                        <div class="rounded-lg border border-gray-100 bg-[#F8FAFC] px-3 py-2">
                            <p class="text-[#1E1B4B] text-[12px] font-bold">${formatTime(slot.start)}</p>
                            <p class="text-[#6B7280] text-[11px]">${typeLabels[slot.type] || slot.type} - Available</p>
                        </div>
                    `).join('')}
                </div>
            </div>
        `).join('');
    };

    const renderSummary = (slots) => {
        const start = parseDate(refs.start.value);
        const end = parseDate(refs.end.value);
        const dayNames = selectedWeekdays();
        const duration = Number.parseInt(refs.duration.value, 10) || 0;
        const buffer = Number.parseInt(refs.buffer.value, 10) || 0;
        const totalMinutes = slots.length * duration;
        const assignedOption = refs.assigned.options[refs.assigned.selectedIndex];

        if (start && end && start <= end) {
            const rangeDays = Math.round((end - start) / 86400000) + 1;
            refs.summaryDates.textContent = `${formatDate(start, false)} - ${formatDate(end)}`;
            refs.summaryDays.textContent = `${rangeDays} Days`;
        } else {
            refs.summaryDates.textContent = 'Invalid date range';
            refs.summaryDays.textContent = '0 Days';
        }

        refs.summaryWeekdays.textContent = dayNames.length ? dayNames.join(', ') : 'Not selected';
        refs.summarySlots.textContent = `${slots.length} Slots`;
        refs.summaryDuration.textContent = `${duration} Minutes`;
        refs.summaryBuffer.textContent = `${buffer} Minutes`;
        refs.summaryTotalTime.textContent = `${Math.floor(totalMinutes / 60)}h ${totalMinutes % 60}m`;
        refs.summaryAssigned.textContent = `${assignedOption?.text || 'Any Available Member'} (${refs.timezone.value || 'Asia/Kolkata'})`;
        if (refs.summaryMaxCapacity) {
            refs.summaryMaxCapacity.textContent = `${refs.maxCapacity.value || 1} Attendees`;
        }
        if (refs.summaryModes) {
            const modes = [];
            if (refs.allowOneToOne && refs.allowOneToOne.checked) modes.push('One-to-One');
            if (refs.allowOneToMany && refs.allowOneToMany.checked) modes.push('One-to-Many');
            refs.summaryModes.textContent = modes.length ? modes.join(' / ') : 'None';
        }
        form.querySelectorAll('[data-day-time]').forEach((item) => {
            const startMinutes = timeToMinutes(refs.dailyStart.value);
            const endMinutes = timeToMinutes(refs.dailyEnd.value);
            item.textContent = startMinutes !== null && endMinutes !== null ? `${formatTime(startMinutes)} - ${formatTime(endMinutes)}` : 'Invalid time';
        });
    };

    const refresh = () => {
        setActiveClasses();
        renderCalendar();
        const slots = buildSlots();
        renderPreview(slots);
        renderSummary(slots);
    };

    form.querySelectorAll('input, select').forEach((input) => {
        input.addEventListener('change', refresh);
        input.addEventListener('input', refresh);
    });

    refresh();
});
</script>
@endpush
