<aside class="space-y-5 xl:sticky xl:top-24">
    @if ($primaryRepresentative)
        <div class="booth-stat-card">
            <h2 class="text-[16px] font-bold text-[#071044]">Booth Representatives</h2>
            <div class="mt-4 flex items-start gap-3">
                <div class="grid h-12 w-12 shrink-0 place-items-center overflow-hidden rounded-full bg-[#F4F0FF] text-[14px] font-bold text-[#5B32F6]">
                    @if ($primaryRepresentative->photo)
                        <img src="{{ asset('storage/' . $primaryRepresentative->photo) }}" alt="{{ $primaryRepresentative->name }}" class="h-full w-full object-cover">
                    @else
                        {{ substr($primaryRepresentative->name, 0, 1) }}
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-[14px] font-bold text-[#071044]">{{ $primaryRepresentative->name }}</p>
                    <p class="truncate text-[12px] font-medium text-[#5A6480]">{{ $primaryRepresentative->designation ?: 'Business Manager' }}</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <a href="{{ route('exhibitions.visitor.chat', [$slug, $companySlug]) }}" class="grid h-8 w-8 place-items-center rounded-lg bg-[#F4F0FF] text-[#5B32F6]" title="Chat"><i class="ph ph-chat-circle"></i></a>
                        @if ($profile?->email ?: $primaryRepresentative->email)
                            <a href="mailto:{{ $profile?->email ?: $primaryRepresentative->email }}" class="grid h-8 w-8 place-items-center rounded-lg bg-[#F4F0FF] text-[#5B32F6]" title="Email"><i class="ph ph-envelope"></i></a>
                        @endif
                        @if ($profile?->website)
                            <a href="{{ $profile->website }}" target="_blank" rel="noopener" class="grid h-8 w-8 place-items-center rounded-lg bg-[#F4F0FF] text-[#5B32F6]" title="Website"><i class="ph ph-globe"></i></a>
                        @endif
                        @if ($profile?->phone ?: $primaryRepresentative->phone)
                            <a href="tel:{{ $profile?->phone ?: $primaryRepresentative->phone }}" class="grid h-8 w-8 place-items-center rounded-lg bg-[#F4F0FF] text-[#5B32F6]" title="Phone"><i class="ph ph-phone"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div id="visitor-reporting" class="booth-stat-card scroll-mt-24">
        <div class="mb-4 flex items-center justify-between gap-3">
            <h2 class="text-[16px] font-bold text-[#071044]">Visitor Reporting</h2>
            @if ($slug)
                <a href="{{ route('exhibitions.visitor.dashboard', $slug) }}" class="text-[12px] font-bold text-[#5B32F6] hover:underline">View All</a>
            @endif
        </div>
        <div class="grid grid-cols-2 gap-3">
            @foreach ([['Total Visitors', number_format($boothViewsCount), 'ph ph-users'], ['Products', number_format($products->count()), 'ph ph-package'], ['Brochures', number_format($documents->count() + $catalogues->count()), 'ph ph-file-text'], ['Sessions', number_format($sessions->count()), 'ph ph-presentation-chart']] as [$label, $value, $icon])
                <div class="rounded-lg bg-[#FBFAFF] p-3">
                    <div class="mb-2 flex items-center gap-2 text-[#5B32F6]"><i class="{{ $icon }}"></i><span class="text-[11px] font-bold uppercase tracking-wide text-[#5A6480]">{{ $label }}</span></div>
                    <p class="text-[18px] font-bold text-[#071044]">{{ $value }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div id="business-leads" class="booth-stat-card scroll-mt-24">
        <div class="mb-4 flex items-center justify-between gap-3">
            <h2 class="text-[16px] font-bold text-[#071044]">Business Leads</h2>
            @if ($isPassActive)
                <a href="{{ route('exhibitions.visitor.meetings', $slug) }}" class="text-[12px] font-bold text-[#5B32F6] hover:underline">View All</a>
            @endif
        </div>
        <div class="grid grid-cols-2 gap-3">
            @foreach ([['My Meetings', number_format($myMeetingsCount), 'ph ph-calendar-check'], ['Confirmed', number_format($confirmedMeetings), 'ph ph-check-circle'], ['Pending', number_format($pendingMeetings), 'ph ph-clock'], ['Team Contacts', number_format($teamMembers->count()), 'ph ph-users-three']] as [$label, $value, $icon])
                <div class="rounded-lg bg-[#FBFAFF] p-3">
                    <div class="mb-2 flex items-center gap-2 text-[#5B32F6]"><i class="{{ $icon }}"></i><span class="text-[11px] font-bold uppercase tracking-wide text-[#5A6480]">{{ $label }}</span></div>
                    <p class="text-[18px] font-bold text-[#071044]">{{ $value }}</p>
                </div>
            @endforeach
        </div>
    </div>

    @if ($isPassActive && $visitorMeetings->isNotEmpty())
        <div id="my-meetings" class="visitor-flow-card scroll-mt-24">
            <h2 class="text-[18px] font-bold text-[#071044]">Your meetings with {{ $company }}</h2>
            <div class="mt-4 space-y-3">
                @foreach ($visitorMeetings as $visitorMeeting)
                    @php
                        $vmTopic = $visitorMeeting->meeting_topic ?: $visitorMeeting->companyMeeting?->title ?: 'Meeting';
                        $vmTime = $visitorMeeting->companyMeeting?->start_time
                            ? $visitorMeeting->companyMeeting->start_time->format('M d, h:i A')
                            : ($visitorMeeting->preferred_date ? $visitorMeeting->preferred_date->format('M d, Y') . ($visitorMeeting->preferred_time ? ' · ' . \Carbon\Carbon::parse($visitorMeeting->preferred_time)->format('h:i A') : '') : 'Time TBD');
                        $vmJoinUrl = $visitorMeeting->companyMeeting?->meeting_link ?: $visitorMeeting->companyMeeting?->zoom_join_url;
                        $vmReady = $vmJoinUrl && in_array($visitorMeeting->status, ['confirmed', 'accepted', 'rescheduled'], true);
                        $vmStatusLabel = \App\Domain\Visitor\Models\VisitorMeetingBooking::displayStatus($visitorMeeting->status);
                    @endphp
                    <div class="rounded-lg border border-[#E7EAF3] bg-[#FBFAFF] p-3">
                        <p class="text-[14px] font-bold text-[#071044]">{{ $vmTopic }}</p>
                        <p class="mt-1 text-[12px] font-medium text-[#5A6480]">{{ $vmTime }}</p>
                        <span class="mt-2 inline-flex rounded-md px-2 py-0.5 text-[11px] font-semibold {{ $vmReady ? 'bg-[#EEFDF3] text-[#16A34A]' : 'bg-yellow-50 text-yellow-700' }}">{{ $vmStatusLabel }}</span>
                        <div class="mt-3">
                            @if ($vmReady)
                                <a href="{{ $vmJoinUrl }}" target="_blank" rel="noopener" class="inline-flex h-9 items-center justify-center rounded-lg bg-[#0F9D58] px-3 text-[12px] font-bold text-white">Join Meet</a>
                            @else
                                <form method="POST" action="{{ route('exhibitions.visitor.meetings.join', [$slug, $companySlug, $visitorMeeting->id]) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex h-9 items-center justify-center rounded-lg bg-[#5b2eff] px-3 text-[12px] font-bold text-white">Request to Join</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div id="sessions" class="visitor-flow-card scroll-mt-24">
        <h2 class="text-[18px] font-bold text-[#071044]">Conference / Webinars</h2>
        <div class="mt-4 space-y-3">
            @forelse ($sessions->take(4) as $session)
                <div class="rounded-lg bg-[#FBFAFF] p-3">
                    <p class="text-[12px] font-bold text-[#5b2eff]">{{ optional($session->session_date)->format('M d') }} | {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('h:i A') : '' }}</p>
                    <p class="mt-1 text-[13px] font-medium text-[#34405F]">{{ $session->title }}</p>
                    <span class="mt-2 inline-block text-[12px] font-bold {{ $isPassActive ? 'text-[#5b2eff]' : 'text-[#7A648E]' }}">{{ $isPassActive ? 'Join Session' : 'Pass Required' }}</span>
                </div>
            @empty
                <p class="py-2 text-center text-[13px] font-medium text-[#5A6480]">No sessions scheduled.</p>
            @endforelse
        </div>
    </div>

    @if ($teamMembers->count() > 1)
        <div class="visitor-flow-card">
            <h2 class="text-[18px] font-bold text-[#071044]">Team</h2>
            <div class="mt-4 space-y-3">
                @foreach ($teamMembers->skip(1)->take(3) as $member)
                    <div class="flex items-center gap-3 rounded-lg bg-[#FBFAFF] p-3">
                        <div class="grid h-10 w-10 shrink-0 place-items-center overflow-hidden rounded-lg bg-[#F4F0FF] text-[13px] font-bold text-[#5b2eff]">
                            @if ($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="h-full w-full object-cover">
                            @else
                                {{ substr($member->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-[13px] font-bold text-[#34405F]">{{ $member->name }}</p>
                            <p class="truncate text-[12px] font-medium text-[#5A6480]">{{ $member->designation }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <form id="enquiry" action="{{ route('exhibitions.visitor.enquiry.send', [$slug, $companySlug]) }}" method="POST" class="visitor-flow-card scroll-mt-24">
        @csrf
        <h2 class="text-[18px] font-bold text-[#071044]">Send enquiry</h2>
        @unless ($isPassActive)
            <p class="mt-3 rounded-lg border border-[#EADCFD] bg-[#FBFAFF] p-3 text-[13px] font-bold text-[#5b2eff]">{{ $lockMessage }}</p>
        @endunless
        <input type="text" name="name" value="{{ $userFullName }}" placeholder="Your name" class="mt-4 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
        <input type="email" name="email" value="{{ $userEmail }}" placeholder="Your email" class="mt-3 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
        <input type="text" name="subject" placeholder="Subject" class="mt-3 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
        <textarea name="message" placeholder="Your message" class="mt-3 min-h-[90px] w-full rounded-lg border border-[#E7EAF3] p-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}></textarea>
        <button type="submit" class="mt-4 h-11 w-full rounded-lg text-[14px] font-bold {{ $isPassActive ? 'bg-[#5b2eff] text-white hover:bg-[#4310d8]' : 'bg-[#F4F0FF] text-[#5b2eff]' }}" {{ $isPassActive ? '' : 'disabled' }}>
            {{ $isPassActive ? 'Send Enquiry' : 'Register / Get Pass' }}
        </button>
    </form>

    <form id="meeting" action="{{ route('exhibitions.visitor.meetings.book', [$slug, $companySlug]) }}" method="POST" class="visitor-flow-card scroll-mt-24">
        @csrf
        <h2 class="text-[18px] font-bold text-[#071044]">Request meeting</h2>
        @unless ($isPassActive)
            <p class="mt-3 rounded-lg border border-[#EADCFD] bg-[#FBFAFF] p-3 text-[13px] font-bold text-[#5b2eff]">{{ $lockMessage }}</p>
        @endunless
        <input type="text" name="meeting_topic" placeholder="Meeting topic" class="mt-4 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
        <input type="text" name="visitor_name" value="{{ $userFullName }}" placeholder="Your name" class="mt-3 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
        <input type="email" name="visitor_email" value="{{ $userEmail }}" placeholder="Email" class="mt-3 h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
        <select name="meeting_type" class="mt-3 h-11 w-full rounded-lg border border-[#E7EAF3] bg-white px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? 'required' : 'disabled' }}>
            @php
                $meetingAvailability = $meetingAvailability ?? $booking?->boothMeetingAvailability;
                $allowOneToOne = $meetingAvailability?->allow_one_to_one ?? true;
                $allowOneToMany = $meetingAvailability?->allow_one_to_many ?? false;
            @endphp
            @if ($allowOneToOne)
                <option value="one-to-one" @selected(old('meeting_type', 'one-to-one') === 'one-to-one')>One-to-One</option>
            @endif
            @if ($allowOneToMany)
                <option value="one-to-many" @selected(old('meeting_type') === 'one-to-many')>One-to-Many</option>
            @endif
            @if (! $allowOneToOne && ! $allowOneToMany)
                <option value="one-to-one">One-to-One</option>
            @endif
        </select>
        @if ($meetingSlots->isNotEmpty())
            <select name="booth_meeting_slot_id" class="mt-3 h-11 w-full rounded-lg border border-[#E7EAF3] bg-white px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? '' : 'disabled' }}>
                <option value="">Use preferred date/time below</option>
                @foreach ($meetingSlots as $slot)
                    <option value="{{ $slot->id }}">
                        {{ $slot->date ? $slot->date->format('M d') : '' }} |
                        {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} -
                        {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                    </option>
                @endforeach
            </select>
        @endif
        <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
            <input type="date" name="preferred_date" class="h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? '' : 'disabled' }}>
            <input type="time" name="preferred_time" class="h-11 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? '' : 'disabled' }}>
        </div>
        <textarea name="message" placeholder="Description / agenda" class="mt-3 min-h-[100px] w-full rounded-lg border border-[#E7EAF3] p-4 text-[14px] outline-none focus:border-[#5b2eff]" {{ $isPassActive ? '' : 'disabled' }}></textarea>
        <button type="submit" class="mt-4 h-11 w-full rounded-lg text-[14px] font-bold {{ $isPassActive ? 'bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-white' : 'bg-[#F4F0FF] text-[#5b2eff]' }}" {{ $isPassActive ? '' : 'disabled' }}>{{ $isPassActive ? 'Send Meeting Request' : 'Register / Get Pass' }}</button>
    </form>

    @if ($nextBooths->isNotEmpty())
        <div class="visitor-flow-card">
            <h2 class="text-[18px] font-bold text-[#071044]">Next booths</h2>
            <div class="mt-4 space-y-3">
                @foreach ($nextBooths as $nb)
                    <a href="{{ route('exhibitions.visitor.companies.show', [$slug, $nb['slug']]) }}" class="flex items-center justify-between rounded-lg bg-[#FBFAFF] p-3 text-[13px] font-bold text-[#34405F] hover:bg-[#F4F0FF] hover:text-[#5b2eff]">
                        <span>{{ $nb['name'] }}</span>
                        <span>Open</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</aside>
