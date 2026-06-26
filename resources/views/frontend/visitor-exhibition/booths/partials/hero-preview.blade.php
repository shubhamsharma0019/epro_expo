<div id="booth-home" class="booth-preview-stage relative overflow-hidden shadow-[0_18px_44px_rgba(7,16,68,0.12)]" @if($bannerUrl) style="background-image: linear-gradient(rgba(7,16,68,0.55), rgba(7,16,68,0.72)), url('{{ $bannerUrl }}');" @endif>
    <div class="relative flex h-full min-h-[320px] flex-col justify-between p-4 sm:min-h-[420px] sm:p-6">
        <div class="max-w-2xl text-white">
            <p class="text-[11px] font-bold uppercase tracking-[0.14em] text-white/70">Virtual Booth Preview</p>
            <h2 class="mt-2 text-[24px] font-bold leading-tight sm:text-[32px]">{{ $welcomeHeading }}</h2>
            @if ($welcomeTagline)
                <p class="mt-2 max-w-xl text-[14px] font-medium leading-6 text-white/80">{{ $welcomeTagline }}</p>
            @endif
        </div>

        <div class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <div class="booth-preview-hotspot">
                <p class="text-[11px] font-bold uppercase tracking-wide text-[#5A6480]">Company Video</p>
                @if ($demoVideoUrl && $isPassActive)
                    <button type="button" onclick="openVideoModal('{{ $demoVideoUrl }}', '{{ addslashes($company) }} Video')" class="mt-2 inline-flex h-9 items-center gap-2 rounded-lg bg-[#5B32F6] px-3 text-[12px] font-bold text-white">
                        <i class="ph ph-play-fill"></i> Play Video
                    </button>
                @else
                    <a href="{{ $isPassActive ? '#company-video' : $ticketUrl }}" class="mt-2 inline-flex h-9 items-center gap-2 rounded-lg border border-[#EADCFD] bg-[#FBFAFF] px-3 text-[12px] font-bold text-[#5B32F6]">
                        {{ $isPassActive ? 'View Gallery' : 'Pass Required' }}
                    </a>
                @endif
            </div>

            <div class="booth-preview-hotspot">
                <p class="text-[11px] font-bold uppercase tracking-wide text-[#5A6480]">Download Brochure</p>
                @if ($firstBrochure && $isPassActive)
                    <a href="{{ asset('storage/' . $firstBrochure->file_path) }}" target="_blank" class="mt-2 inline-flex h-9 items-center gap-2 rounded-lg bg-[#2563EB] px-3 text-[12px] font-bold text-white">
                        <i class="ph ph-download-simple"></i> Download
                    </a>
                @else
                    <a href="{{ $isPassActive ? '#brochures' : $ticketUrl }}" class="mt-2 inline-flex h-9 items-center gap-2 rounded-lg border border-[#E7EAF3] px-3 text-[12px] font-bold text-[#34405F]">
                        {{ $isPassActive ? 'View Brochures' : 'Locked' }}
                    </a>
                @endif
            </div>

            <div class="booth-preview-hotspot">
                <p class="text-[11px] font-bold uppercase tracking-wide text-[#5A6480]">Live Session</p>
                <a href="{{ $isPassActive ? '#meeting' : $ticketUrl }}" class="mt-2 inline-flex h-9 items-center gap-2 rounded-lg bg-[#0F9D58] px-3 text-[12px] font-bold text-white">
                    <i class="ph ph-calendar-check"></i> Request Meeting
                </a>
            </div>

            <div class="booth-preview-hotspot">
                <p class="text-[11px] font-bold uppercase tracking-wide text-[#5A6480]">Conference</p>
                @if ($nextSession)
                    <p class="mt-1 truncate text-[12px] font-semibold text-[#071044]">{{ $nextSession->title }}</p>
                    <a href="#sessions" class="mt-2 inline-flex h-9 items-center gap-2 rounded-lg bg-[#F59E0B] px-3 text-[12px] font-bold text-white">
                        Join Session
                    </a>
                @else
                    <a href="#sessions" class="mt-2 inline-flex h-9 items-center gap-2 rounded-lg border border-[#E7EAF3] px-3 text-[12px] font-bold text-[#34405F]">
                        View Sessions
                    </a>
                @endif
            </div>
        </div>

        <div class="mt-5 flex flex-col gap-4 rounded-xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <div class="grid h-14 w-14 shrink-0 place-items-center overflow-hidden rounded-xl bg-white text-[20px] font-bold text-[#5B32F6]">
                    @if ($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $company }}" class="h-full w-full object-cover">
                    @else
                        {{ substr($company, 0, 1) }}
                    @endif
                </div>
                <div>
                    <p class="text-[14px] font-bold text-white">{{ $company }}</p>
                    <p class="text-[12px] font-medium text-white/75">{{ $hallName }} · {{ $boothLabel }}</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach ([[$products->count(), 'Products'], [$teamMembers->count(), 'Team'], [$sessions->count(), 'Sessions'], [$documents->count() + $catalogues->count(), 'Files']] as [$count, $label])
                    <span class="rounded-lg bg-white/15 px-3 py-1.5 text-[11px] font-bold text-white">{{ $count }}+ {{ $label }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>
