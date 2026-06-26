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

    $availableSlotCount = $meetingSlots->where('status', 'available')->count();
@endphp

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="mx-auto w-full max-w-[1200px]">
        <p class="mb-6 text-[14px] leading-relaxed text-[#6B7280]">Set when visitors can book meetings with your team. Preferences saved here also apply to your booth meeting setup.</p>

        @if (session('status'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-bold">Please fix the highlighted availability details.</p>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="meetingAvailabilityForm" method="POST" action="{{ route('company.booth-setup.meetings.update', $booking) }}" class="space-y-6">
            @csrf

            <section class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="mb-1 text-[16px] font-bold text-[#1E1B4B]">Schedule</h2>
                <p class="mb-5 text-[13px] text-[#6B7280]">Choose the date range, working hours, and active days for meeting slots.</p>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <label for="available_start_date" class="mb-2 block text-[13px] font-medium text-[#4B5563]">Start Date</label>
                        <input id="available_start_date" name="available_start_date" type="date" value="{{ $startDate }}" class="block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#1E1B4B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>
                    <div>
                        <label for="available_end_date" class="mb-2 block text-[13px] font-medium text-[#4B5563]">End Date</label>
                        <input id="available_end_date" name="available_end_date" type="date" value="{{ $endDate }}" class="block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#1E1B4B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>
                    <div>
                        <label for="daily_start_time" class="mb-2 block text-[13px] font-medium text-[#4B5563]">Daily Start</label>
                        <input id="daily_start_time" name="daily_start_time" type="time" value="{{ $dailyStartTime }}" class="block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#1E1B4B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>
                    <div>
                        <label for="daily_end_time" class="mb-2 block text-[13px] font-medium text-[#4B5563]">Daily End</label>
                        <input id="daily_end_time" name="daily_end_time" type="time" value="{{ $dailyEndTime }}" class="block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#1E1B4B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>
                </div>

                <div class="mt-5">
                    <label class="mb-3 block text-[13px] font-medium text-[#4B5563]">Available Days</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($weekdays as $day)
                            @php $checked = in_array($day, $selectedWeekdays, true); @endphp
                            <label data-weekday-row class="inline-flex cursor-pointer items-center rounded-full border px-3 py-2 text-[13px] font-semibold transition {{ $checked ? 'border-[#4C1D95] bg-[#F5F3FF] text-[#4C1D95]' : 'border-gray-200 bg-white text-[#4B5563] hover:border-[#C4B5FD]' }}">
                                <input data-weekday-input type="checkbox" name="available_weekdays[]" value="{{ $day }}" @checked($checked) class="sr-only">
                                <span data-weekday-name>{{ substr($day, 0, 3) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </section>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-5">
                <section class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6 xl:col-span-3">
                    <h2 class="mb-1 text-[16px] font-bold text-[#1E1B4B]">Meeting Settings</h2>
                    <p class="mb-5 text-[13px] text-[#6B7280]">Configure channels, slot rules, capacity, and meeting formats.</p>

                    <div class="mb-5">
                        <label class="mb-2 block text-[13px] font-medium text-[#4B5563]">Meeting Channels</label>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach ($meetingTypeOptions as $value => $type)
                                @php $checked = in_array($value, $selectedMeetingTypes, true); @endphp
                                <label data-meeting-type-row class="flex cursor-pointer items-center justify-center rounded-lg border py-2.5 text-[13px] font-bold {{ $checked ? 'border-[#4C1D95] bg-[#F5F3FF] text-[#4C1D95]' : 'border-gray-200 bg-white text-gray-500' }}">
                                    <input data-meeting-type-input type="checkbox" name="meeting_types[]" value="{{ $value }}" @checked($checked) class="sr-only">
                                    <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $type['icon'] }}"></path></svg>
                                    {{ $type['label'] }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="slot_duration" class="mb-2 block text-[13px] font-medium text-[#4B5563]">Slot Duration</label>
                            <select id="slot_duration" name="slot_duration" class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] text-[#1E1B4B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                                @foreach ([15, 30, 45, 60, 90, 120] as $minutes)
                                    <option value="{{ $minutes }}" @selected($slotDuration === $minutes)>{{ $minutes }} min</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="buffer_time" class="mb-2 block text-[13px] font-medium text-[#4B5563]">Buffer Time</label>
                            <select id="buffer_time" name="buffer_time" class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] text-[#1E1B4B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                                @foreach ([0, 5, 10, 15, 30, 45, 60] as $minutes)
                                    <option value="{{ $minutes }}" @selected($bufferTime === $minutes)>{{ $minutes }} min</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="max_capacity" class="mb-2 block text-[13px] font-medium text-[#4B5563]">Max Capacity</label>
                            <input id="max_capacity" name="max_capacity" type="number" min="1" value="{{ old('max_capacity', $availability?->max_capacity ?? 1) }}" class="block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#1E1B4B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        </div>
                        <div>
                            <label for="timezone" class="mb-2 block text-[13px] font-medium text-[#4B5563]">Timezone</label>
                            <select id="timezone" name="timezone" class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] text-[#1E1B4B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                                @foreach (['Asia/Kolkata', 'UTC', 'Asia/Dubai', 'Europe/London', 'America/New_York'] as $tz)
                                    <option value="{{ $tz }}" @selected($timezone === $tz)>{{ $tz }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="assigned_team_member_id" class="mb-2 block text-[13px] font-medium text-[#4B5563]">Assigned Team Member</label>
                        <select id="assigned_team_member_id" name="assigned_team_member_id" class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] text-[#1E1B4B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                            <option value="">Any available member</option>
                            @foreach ($teamMembers as $member)
                                <option value="{{ $member->id }}" @selected((string) $assignedTeamMemberId === (string) $member->id)>{{ $member->name }}{{ $member->designation ? ' - '.$member->designation : '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-[13px] font-medium text-[#4B5563]">Meeting Formats</label>
                        <div class="flex flex-wrap gap-3">
                            <label class="inline-flex cursor-pointer items-center rounded-lg border border-gray-200 px-3 py-2 text-[13px] font-medium text-[#4B5563]">
                                <input type="checkbox" name="allow_one_to_one" value="1" {{ old('allow_one_to_one', $availability?->allow_one_to_one ?? 1) ? 'checked' : '' }} class="mr-2 rounded border-gray-300 text-[#4C1D95] focus:ring-[#4C1D95]">
                                One-to-One
                            </label>
                            <label class="inline-flex cursor-pointer items-center rounded-lg border border-gray-200 px-3 py-2 text-[13px] font-medium text-[#4B5563]">
                                <input type="checkbox" name="allow_one_to_many" value="1" {{ old('allow_one_to_many', $availability?->allow_one_to_many ?? 0) ? 'checked' : '' }} class="mr-2 rounded border-gray-300 text-[#4C1D95] focus:ring-[#4C1D95]">
                                One-to-Many
                            </label>
                            <label class="inline-flex cursor-pointer items-center rounded-lg border border-gray-200 px-3 py-2 text-[13px] font-medium text-[#4B5563]">
                                <input type="checkbox" name="allow_conference" value="1" {{ old('allow_conference', $availability?->allow_conference ?? 0) ? 'checked' : '' }} class="mr-2 rounded border-gray-300 text-[#4C1D95] focus:ring-[#4C1D95]">
                                Conference
                            </label>
                        </div>
                    </div>
                </section>

                <section class="flex flex-col rounded-xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6 xl:col-span-2">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <div>
                            <h2 class="text-[16px] font-bold text-[#1E1B4B]">Slot Preview</h2>
                            <p class="mt-1 text-[12px] text-[#6B7280]">Live preview based on your current settings.</p>
                        </div>
                        <span id="previewSlotBadge" class="shrink-0 rounded-full bg-[#F5F3FF] px-3 py-1 text-[11px] font-bold text-[#4C1D95]">{{ $availableSlotCount }} slots</span>
                    </div>

                    <div id="slotsPreview" class="min-h-[280px] flex-1 space-y-4 overflow-y-auto pr-1"></div>
                </section>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ route('company.booth-setup.sessions.index', $booking) }}" class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-6 py-3 text-[14px] font-bold text-[#1E1B4B] transition-colors hover:bg-gray-50">
                    Continue to Sessions
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#4C1D95] px-8 py-3 text-[14px] font-bold text-white transition-colors hover:bg-[#3b1774]">
                    Save Availability
                </button>
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
        slotsPreview: document.getElementById('slotsPreview'),
        previewSlotBadge: document.getElementById('previewSlotBadge'),
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

    const cloneDate = (date) => new Date(date.getFullYear(), date.getMonth(), date.getDate());
    const addDays = (date, days) => {
        const next = cloneDate(date);
        next.setDate(next.getDate() + days);
        return next;
    };
    const formatDate = (date) => date.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
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
            row.classList.toggle('border-[#4C1D95]', input.checked);
            row.classList.toggle('bg-[#F5F3FF]', input.checked);
            row.classList.toggle('text-[#4C1D95]', input.checked);
            row.classList.toggle('border-gray-200', !input.checked);
            row.classList.toggle('bg-white', !input.checked);
            row.classList.toggle('text-[#4B5563]', !input.checked);
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

    const renderPreview = (slots) => {
        refs.previewSlotBadge.textContent = `${slots.length} slots`;

        if (!slots.length) {
            refs.slotsPreview.innerHTML = `
                <div class="flex h-full min-h-[280px] flex-col items-center justify-center rounded-xl border border-dashed border-gray-200 bg-[#F8FAFC] px-6 text-center">
                    <svg class="mb-3 h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-[14px] font-bold text-[#1E1B4B]">No slots to preview</p>
                    <p class="mt-1 text-[13px] text-[#6B7280]">Adjust dates, days, channels, or time range.</p>
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

        refs.slotsPreview.innerHTML = Object.entries(grouped).slice(0, 4).map(([label, daySlots]) => `
            <div>
                <div class="mb-2 flex items-center justify-between">
                    <h4 class="text-[12px] font-bold text-[#1E1B4B]">${label}</h4>
                    <span class="text-[11px] text-gray-400">${daySlots.length} slots</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    ${daySlots.slice(0, 6).map((slot) => `
                        <div class="rounded-lg border border-gray-100 bg-[#F8FAFC] px-3 py-2">
                            <p class="text-[12px] font-bold text-[#1E1B4B]">${formatTime(slot.start)}</p>
                            <p class="text-[11px] text-[#6B7280]">${typeLabels[slot.type] || slot.type}</p>
                        </div>
                    `).join('')}
                </div>
            </div>
        `).join('');
    };

    const refresh = () => {
        setActiveClasses();
        renderPreview(buildSlots());
    };

    form.querySelectorAll('input, select').forEach((input) => {
        input.addEventListener('change', refresh);
        input.addEventListener('input', refresh);
    });

    refresh();
});
</script>
@endpush
