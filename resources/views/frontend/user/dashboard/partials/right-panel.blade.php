<aside class="space-y-5 xl:sticky xl:top-24">
    <div id="dashboard-actions" class="booth-stat-card scroll-mt-24">
        <h2 class="text-[16px] font-bold text-[#071044]">Quick Actions</h2>
        <div class="mt-4 grid gap-3">
            @foreach ($quickActions as $action)
                <a href="{{ $action['href'] }}" class="inline-flex items-center justify-between rounded-xl border border-[#E7EAF3] bg-[#FBFAFF] px-4 py-3 transition hover:bg-[#F8F7FF]">
                    <span class="flex items-center gap-3">
                        <i class="{{ $action['icon'] }} text-lg text-[#5B32F6]"></i>
                        <span class="text-[14px] font-semibold text-[#071044]">{{ $action['label'] }}</span>
                    </span>
                    <i class="ph ph-arrow-right text-[#5A6480]"></i>
                </a>
            @endforeach
        </div>
    </div>

    <div id="dashboard-activity" class="booth-stat-card scroll-mt-24">
        <div class="mb-4 flex items-center justify-between gap-3">
            <h2 class="text-[16px] font-bold text-[#071044]">Recent Activities</h2>
        </div>
        <div class="space-y-3">
            @forelse ($recentActivities->take(5) as $act)
                <div class="rounded-xl bg-[#FBFAFF] px-4 py-3">
                    <p class="text-[14px] font-semibold text-[#071044]">{{ $act['title'] }}</p>
                    <p class="mt-1 text-[13px] text-[#5A6480]">{{ $act['desc'] }}</p>
                    <p class="mt-2 text-[12px] text-[#94A3B8]">{{ $act['time']->diffForHumans() }}</p>
                </div>
            @empty
                <div class="rounded-xl bg-[#FBFAFF] px-4 py-6 text-center text-[13px] text-[#5A6480]">
                    No recent activity found.
                </div>
            @endforelse
        </div>
    </div>

    <div class="booth-stat-card">
        <h2 class="text-[16px] font-bold text-[#071044]">Visitor Summary</h2>
        <div class="mt-4 grid grid-cols-2 gap-3">
            @foreach ([['Event Tickets', $eventTickets->count(), 'ph ph-ticket'], ['Exhibition Passes', $exhibitionPasses->count(), 'ph ph-qr-code'], ['Pending Meetings', $pendingMeetingsCount, 'ph ph-calendar-check'], ['Total Passes', $totalTicketsCount, 'ph ph-stack']] as [$label, $value, $icon])
                <div class="rounded-lg bg-[#FBFAFF] p-3">
                    <div class="mb-2 flex items-center gap-2 text-[#5B32F6]">
                        <i class="{{ $icon }}"></i>
                        <span class="text-[11px] font-bold uppercase tracking-wide text-[#5A6480]">{{ $label }}</span>
                    </div>
                    <p class="text-[18px] font-bold text-[#071044]">{{ number_format($value) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</aside>
