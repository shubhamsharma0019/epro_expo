<section id="company-details" class="visitor-flow-card scroll-mt-24">
    <h2 class="text-[20px] font-bold text-[#071044]">About company</h2>
    <p class="mt-3 break-words whitespace-pre-line text-[14px] font-medium leading-7 text-[#5A6480]">{{ $profile?->about_company ?: 'A trusted exhibitor presenting enterprise-ready products for visitor engagement, analytics, automation, and business operations.' }}</p>
</section>

<section id="products" class="visitor-flow-card scroll-mt-24">
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-[20px] font-bold text-[#071044]">Our Products & Services</h2>
        @if ($products->count() > 4)
            <span class="text-[13px] font-bold text-[#5B32F6]">{{ $products->count() }} listed</span>
        @endif
    </div>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @forelse ($products->take(8) as $product)
            <div class="flex flex-col justify-between rounded-[12px] border border-[#E7EAF3] bg-[#FBFAFF] p-4">
                <div>
                    <div class="h-24 overflow-hidden rounded-lg bg-gradient-to-br from-[#F4F0FF] to-white">
                        @if ($product->product_image)
                            <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        @endif
                    </div>
                    <h3 class="mt-4 text-[15px] font-bold text-[#071044]">{{ $product->name }}</h3>
                    <p class="mt-2 line-clamp-3 text-[13px] font-medium leading-5 text-[#5A6480]">{{ $product->short_description ?: 'Product overview, demo, and business use cases.' }}</p>
                </div>
                <button type="button"
                    @if ($isPassActive && $demoVideoUrl)
                        onclick="openVideoModal('{{ $demoVideoUrl }}', '{{ addslashes($product->name) }} Demo')"
                    @endif
                    class="mt-4 h-10 w-full rounded-lg text-[12px] font-bold {{ $isPassActive ? 'cursor-pointer bg-[#F4F0FF] text-[#5b2eff] transition-colors hover:bg-[#EADCFD]' : 'border border-[#EADCFD] bg-[#FBFAFF] text-[#7A648E]' }}">
                    {{ $isPassActive ? 'Learn More' : $lockMessage }}
                </button>
            </div>
        @empty
            <div class="col-span-full py-8 text-center text-[14px] font-semibold text-[#5A6480]">No products published yet.</div>
        @endforelse
    </div>
</section>

<section id="brochures" class="visitor-flow-card scroll-mt-24">
    <h2 class="text-[20px] font-bold text-[#071044]">Brochures & Documents</h2>
    <div class="mt-4 grid gap-4 md:grid-cols-2">
        <div>
            <h3 class="mb-3 text-[14px] font-bold text-[#34405F]">Documents</h3>
            <div class="space-y-3">
                @forelse ($documents as $document)
                    <div class="flex items-center justify-between rounded-lg bg-[#FBFAFF] p-3">
                        <span class="min-w-0 truncate pr-3 text-[13px] font-bold text-[#34405F]">{{ $document->title }}</span>
                        <a href="{{ $isPassActive ? asset('storage/' . $document->file_path) : $ticketUrl }}" target="{{ $isPassActive ? '_blank' : '_self' }}" class="shrink-0 text-[12px] font-bold {{ $isPassActive ? 'text-[#5b2eff]' : 'text-[#7A648E]' }} hover:underline">{{ $isPassActive ? 'Download' : 'Locked' }}</a>
                    </div>
                @empty
                    <p class="py-2 text-center text-[13px] font-medium text-[#5A6480]">No documents uploaded.</p>
                @endforelse
            </div>
        </div>
        <div>
            <h3 class="mb-3 text-[14px] font-bold text-[#34405F]">Catalogues</h3>
            <div class="space-y-3">
                @forelse ($catalogues as $catalogue)
                    <div class="flex items-center justify-between rounded-lg bg-[#FBFAFF] p-3">
                        <span class="min-w-0 truncate pr-3 text-[13px] font-bold text-[#34405F]">{{ $catalogue->title }}</span>
                        <a href="{{ $isPassActive ? asset('storage/' . $catalogue->file_path) : $ticketUrl }}" target="{{ $isPassActive ? '_blank' : '_self' }}" class="shrink-0 text-[12px] font-bold {{ $isPassActive ? 'text-[#5b2eff]' : 'text-[#7A648E]' }} hover:underline">{{ $isPassActive ? 'Open' : 'Locked' }}</a>
                    </div>
                @empty
                    <p class="py-2 text-center text-[13px] font-medium text-[#5A6480]">No catalogues uploaded.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section id="company-video" class="visitor-flow-card scroll-mt-24">
    <h2 class="text-[20px] font-bold text-[#071044]">Company Video</h2>
    @if ($demoVideoUrl)
        <div class="mt-4 overflow-hidden rounded-xl bg-[#071044]">
            @if ($isPassActive)
                <button type="button" onclick="openVideoModal('{{ $demoVideoUrl }}', '{{ addslashes($company) }} Video')" class="flex w-full items-center gap-4 p-5 text-left text-white hover:bg-[#0b1a52]">
                    <span class="grid h-12 w-12 place-items-center rounded-full bg-white/15"><i class="ph ph-play-fill text-xl"></i></span>
                    <span>
                        <span class="block text-[15px] font-bold">Watch company overview</span>
                        <span class="mt-1 block text-[12px] text-white/70">Launch the booth video experience</span>
                    </span>
                </button>
            @else
                <div class="p-5 text-[13px] font-bold text-white/80">{{ $lockMessage }}</div>
            @endif
        </div>
    @else
        <p class="mt-3 text-[13px] font-medium text-[#5A6480]">No company video uploaded yet.</p>
    @endif
</section>

<section id="photo-gallery" class="visitor-flow-card scroll-mt-24 visitor-flow-media">
    <h2 class="text-[20px] font-bold text-[#071044]">Photo Gallery</h2>
    <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($mediaItems as $media)
            @php
                $isVid = ($media->type === 'video' || !empty($media->video_url));
                $fallback = $isVid
                    ? 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=400&q=80'
                    : 'https://images.unsplash.com/photo-1542744094-3a31f103e35f?auto=format&fit=crop&w=400&q=80';
                $mediaThumb = $media->thumbnail
                    ? asset('storage/' . $media->thumbnail)
                    : (($media->type === 'image' && $media->file_path) ? asset('storage/' . $media->file_path) : $fallback);
                $mediaUrl = $media->file_path ? asset('storage/' . $media->file_path) : ($media->video_url ?: '#');
                $isExternalWebpage = false;
                if ($isVid && !empty($media->video_url)) {
                    $url = $media->video_url;
                    if (!str_contains($url, 'youtube.com') && !str_contains($url, 'youtu.be') && !str_contains($url, 'vimeo.com') && !str_ends_with(strtolower($url), '.mp4') && !str_ends_with(strtolower($url), '.webm') && !str_ends_with(strtolower($url), '.ogg')) {
                        $isExternalWebpage = true;
                    }
                }
            @endphp
            @if ($isPassActive)
                @if ($isExternalWebpage)
                    <a href="{{ $mediaUrl }}" target="_blank" class="block rounded-[12px] bg-[#071044] p-4 text-white hover:opacity-90">
                @elseif ($isVid)
                    <button type="button" onclick="openVideoModal('{{ $mediaUrl }}', '{{ addslashes($media->title) }}')" class="block w-full rounded-[12px] bg-[#071044] p-4 text-left text-white hover:opacity-90">
                @else
                    <button type="button" onclick="openImageModal('{{ $mediaUrl }}', '{{ addslashes($media->title) }}')" class="block w-full rounded-[12px] bg-[#071044] p-4 text-left text-white hover:opacity-90">
                @endif
            @else
                <div class="rounded-[12px] bg-[#071044] p-4 text-white">
            @endif
                <div class="relative h-24 overflow-hidden rounded-lg bg-white/10">
                    <img src="{{ $mediaThumb }}" alt="{{ $media->title }}" class="h-full w-full object-cover">
                    @if ($isVid)
                        <div class="absolute inset-0 grid place-items-center bg-black/30">
                            <div class="grid h-8 w-8 place-items-center rounded-full bg-white/80 text-[#071044]"><i class="ph ph-play-fill"></i></div>
                        </div>
                    @endif
                </div>
                <p class="mt-3 truncate text-[13px] font-bold">{{ $media->title }}</p>
            @if ($isPassActive)
                @if ($isExternalWebpage)
                    </a>
                @else
                    </button>
                @endif
            @else
                </div>
            @endif
        @empty
            <div class="col-span-full py-8 text-center text-[14px] font-semibold text-[#5A6480]">No media items uploaded.</div>
        @endforelse
    </div>
</section>

<section class="visitor-flow-card scroll-mt-24">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h2 class="text-[20px] font-bold text-[#071044]">Visitor decision</h2>
            <p class="mt-2 text-[14px] font-medium leading-6 text-[#5A6480]">Save this booth, book a meeting, join sessions, or get a pass to unlock premium access.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            @if ($isPassActive)
                <a href="{{ route('exhibitions.visitor.chat', [$slug, $companySlug]) }}" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#E7EAF3] bg-white px-5 text-[13px] font-bold text-[#071044] hover:bg-[#F8F7FF]">Live Chat</a>
                <a href="#meeting" class="inline-flex h-11 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[13px] font-bold text-white">Book Meeting</a>
            @else
                <a href="{{ $ticketUrl }}" class="inline-flex h-11 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-5 text-[13px] font-bold text-white">Register / Get Pass</a>
            @endif
        </div>
    </div>
</section>
