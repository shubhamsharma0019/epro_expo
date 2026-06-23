@props([
    'meeting',
    'slug',
])

@php
    $meetingCompany = $meeting->company;
    $companyName = $meetingCompany?->company_name ?: $meetingCompany?->name ?: 'Company';
    $boothBooking = $meetingCompany?->boothBookings
        ?->first(fn ($booking) => ($booking->exhibition?->slug ?: $slug) === $slug);
    $companySlug = \Illuminate\Support\Str::slug($boothBooking?->boothProfile?->company_name ?: $companyName);
    $meetingTime = $meeting->companyMeeting?->start_time
        ? $meeting->companyMeeting->start_time->format('h:i A')
        : ($meeting->preferred_time ? \Carbon\Carbon::parse($meeting->preferred_time)->format('h:i A') : 'TBD');
    $meetingTitle = $meeting->meeting_topic ?: $meeting->companyMeeting?->title ?: 'Meeting';
    $zoomJoinUrl = $meeting->companyMeeting?->zoom_join_url ?: $meeting->companyMeeting?->meeting_link;
    $statusLabel = \App\Domain\Visitor\Models\VisitorMeetingBooking::displayStatus($meeting->status);
    $statusClass = match ($meeting->status) {
        'confirmed', 'accepted' => 'bg-[#EEFDF3] text-[#16A34A]',
        'completed' => 'bg-[#EFF6FF] text-[#2563EB]',
        'rejected' => 'bg-red-50 text-red-700',
        default => 'bg-yellow-50 text-yellow-700',
    };
@endphp

<article {{ $attributes->merge(['class' => 'visitor-flow-card flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between']) }}>
    <div class="flex min-w-0 gap-4">
        <div class="grid h-14 w-20 shrink-0 place-items-center rounded-lg bg-[#F4F0FF] text-[14px] font-semibold text-purple">
            {{ $meetingTime }}
        </div>
        <div class="min-w-0">
            <h2 class="text-[19px] font-semibold text-navy">{{ $companyName }}</h2>
            <p class="mt-1 text-[14px] font-medium text-[#5A6480]">{{ $meetingTitle }}</p>
            @if ($meeting->preferred_date)
                <p class="mt-1 text-[12px] font-medium text-[#5A6480]">Preferred: {{ $meeting->preferred_date->format('M d, Y') }}</p>
            @endif
        </div>
    </div>
    <div class="flex flex-wrap items-center gap-3 meeting-card-actions">
        <span class="inline-flex h-10 items-center rounded-md px-4 text-[13px] font-semibold {{ $statusClass }}">
            {{ $statusLabel }}
        </span>

        @if (in_array($meeting->status, ['confirmed', 'accepted', 'completed'], true) && $zoomJoinUrl)
            <a href="{{ $zoomJoinUrl }}" target="_blank" rel="noopener" class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-[#0F9D58] px-4 text-[13px] font-semibold text-white hover:bg-[#0B8043]">
                <i class="fa-solid fa-video"></i> Join Google Meet
            </a>
        @endif

        <a href="{{ route('exhibitions.visitor.companies.show', [$slug, $companySlug]) }}" class="inline-flex h-10 items-center justify-center rounded-md border border-borderColor px-4 text-[13px] font-semibold text-purple">Open Booth</a>
    </div>
</article>
