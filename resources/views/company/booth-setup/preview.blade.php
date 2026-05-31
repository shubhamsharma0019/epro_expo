@extends('layouts.company')

@section('title', 'Preview Booth | eproexpo')
@section('page-title', 'Preview Booth')

@section('content')
@php
    $profile = $booking->boothProfile;
    $branding = $booking->boothBranding;
    $company = $booking->company;

    $companyName = $profile?->company_name ?: $company?->company_name ?: $company?->name ?: 'Company booth';
    $companyInitials = collect(explode(' ', $companyName))->filter()->take(2)->map(fn ($word) => strtoupper(substr($word, 0, 1)))->implode('') ?: 'CB';
    $boothTitle = $branding?->welcome_heading ?: $profile?->booth_title ?: $profile?->tagline ?: 'Welcome to our booth';
    $about = $profile?->about_company ?: $profile?->welcome_text ?: 'Add your company profile details to show visitors a complete booth overview.';
    $hallName = $booking->hall?->title ?: $booking->hall?->name ?: 'Hall not assigned';
    $boothNumber = $booking->booth?->booth_number ?: $booking->booth?->number ?: 'N/A';
    $industry = $profile?->industry ?: $company?->industry ?: 'Exhibitor';
    $statusLabel = match ($booking->booth_setup_status ?? 'setup_in_progress') {
        'ready_to_publish' => 'Ready',
        'pending_review', 'submitted_for_review' => 'In Review',
        'published', 'approved', 'live' => 'Live',
        default => 'Draft',
    };

    $bannerUrl = $branding?->booth_banner
        ? asset('storage/' . $branding->booth_banner)
        : ($profile?->booth_banner ? asset('storage/' . $profile->booth_banner) : asset('assets/exhibition/images/booth_banner.png'));
    $logoUrl = $profile?->company_logo ? asset('storage/' . $profile->company_logo) : null;
    $brandColor = $branding?->primary_color ?: $profile?->brand_color ?: '#4C1D95';
    $ctaText = $branding?->cta_button_text ?: $profile?->cta_text ?: 'Contact Team';
    $ctaLink = $branding?->cta_button_link ?: $profile?->cta_link ?: $profile?->website;

    $products = collect($products ?? []);
    $documents = collect($documents ?? []);
    $catalogues = collect($catalogues ?? []);
    $mediaItems = collect($mediaItems ?? []);
    $teamMembers = collect($teamMembers ?? []);
    $sessions = collect($sessions ?? []);
    $availableMeetingSlots = collect($availableMeetingSlots ?? []);
    $files = $documents->concat($catalogues);
    $activeTab = request('tab', 'overview');
    $validTabs = ['overview', 'products', 'documents', 'catalogues', 'media', 'team', 'sessions'];
    $activeTab = in_array($activeTab, $validTabs, true) ? $activeTab : 'overview';
    $tabs = [
        'overview' => ['label' => 'Overview', 'count' => null],
        'products' => ['label' => 'Products', 'count' => $products->count()],
        'documents' => ['label' => 'Documents', 'count' => $documents->count()],
        'catalogues' => ['label' => 'Catalogues', 'count' => $catalogues->count()],
        'media' => ['label' => 'Media', 'count' => $mediaItems->count()],
        'team' => ['label' => 'Team', 'count' => $teamMembers->count()],
        'sessions' => ['label' => 'Sessions', 'count' => $sessions->count()],
    ];

    $formatSize = fn ($bytes) => $bytes ? number_format($bytes / 1024 / 1024, 1) . ' MB' : '-';
    $publicSlug = $booking->exhibition?->slug;
    $companySlug = \Illuminate\Support\Str::slug($companyName);
    $visitorPreviewUrl = $publicSlug && $companySlug ? route('exhibitions.visitor.companies.show', [$publicSlug, $companySlug]) : null;
@endphp

<section class="px-4 py-6 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-[1280px] overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-gray-100 p-5 lg:flex-row lg:items-center lg:justify-between lg:p-6">
            <div class="flex min-w-0 items-center">
                <div class="mr-3 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#F5F3FF] text-[#6D28D9]">
                    <i class="ph ph-storefront text-[20px]"></i>
                </div>
                <div class="min-w-0">
                    <h2 class="truncate text-[20px] font-bold text-[#1E1B4B]">{{ $companyName }}</h2>
                    <p class="mt-1 text-[13px] font-medium text-[#6B7280]">{{ $hallName }} / Booth {{ $boothNumber }}</p>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                @if ($visitorPreviewUrl)
                    <a href="{{ $visitorPreviewUrl }}" target="_blank" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#4C1D95] px-5 text-[14px] font-bold text-[#4C1D95] transition-colors hover:bg-[#F5F3FF]">
                        <i class="ph ph-eye mr-2"></i>
                        Preview in Visitor
                    </a>
                @endif
                <form method="POST" action="{{ route('company.booth-setup.preview.mark-ready', $booking) }}">
                    @csrf
                    <input type="hidden" name="next" value="publish">
                    <button type="submit" class="inline-flex h-11 w-full items-center justify-center rounded-lg bg-[#4C1D95] px-5 text-[14px] font-bold text-white transition-colors hover:bg-[#3b1774]">
                        Save & Continue
                        <i class="ph ph-arrow-right ml-2"></i>
                    </button>
                </form>
            </div>
        </div>

        @if (session('status'))
            <div class="mx-5 mt-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 lg:mx-6">
                {{ session('status') }}
            </div>
        @endif

        <div class="relative h-[220px] w-full overflow-hidden bg-[#111827] sm:h-[300px]">
            <img src="{{ $bannerUrl }}" alt="{{ $companyName }} booth banner" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-black/10 to-transparent"></div>
            <div class="absolute bottom-5 left-5 right-5 text-white lg:bottom-7 lg:left-7">
                <p class="mb-2 inline-flex rounded-full bg-white/15 px-3 py-1 text-[12px] font-bold backdrop-blur">{{ $industry }}</p>
                <h1 class="max-w-[760px] text-[26px] font-black leading-8 sm:text-[34px] sm:leading-10">{{ $boothTitle }}</h1>
            </div>
        </div>

        <div class="relative border-b border-gray-100 px-5 pb-6 lg:px-8">
            <div class="flex flex-col gap-5 pt-6 sm:flex-row sm:items-start sm:justify-between">
                <div class="flex min-w-0 flex-col gap-4 sm:flex-row sm:items-start">
                    <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-gray-100 bg-white p-3 shadow-md sm:-mt-16 sm:h-32 sm:w-32">
                        @if ($logoUrl)
                            <img src="{{ $logoUrl }}" alt="{{ $companyName }} logo" class="h-full w-full object-contain">
                        @else
                            <span class="text-[26px] font-black tracking-tight text-[#1E1B4B]">{{ $companyInitials }}</span>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-[24px] font-bold text-[#1E1B4B]">{{ $companyName }}</h2>
                        <p class="mt-1 text-[14px] font-medium text-[#6B7280]">{{ $profile?->tagline ?: $industry }}</p>
                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span class="rounded-full bg-[#F5F3FF] px-3 py-1 text-[12px] font-bold text-[#6D28D9]">{{ $hallName }}</span>
                            <span class="rounded-full bg-[#EEF2FF] px-3 py-1 text-[12px] font-bold text-[#4338CA]">Booth {{ $boothNumber }}</span>
                            <span class="inline-flex items-center rounded-full bg-[#ECFDF5] px-3 py-1 text-[12px] font-bold text-[#059669]">
                                <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-[#059669]"></span>
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('company.booth-setup.preview', ['booking' => $booking, 'tab' => 'sessions']) }}" class="inline-flex h-10 items-center rounded-lg px-4 text-[13px] font-bold text-white transition-colors" style="background-color: {{ $brandColor }}">
                        <i class="ph ph-calendar-check mr-2"></i>
                        {{ $availableMeetingSlots->isNotEmpty() ? 'Book Meeting' : 'Meetings TBA' }}
                    </a>
                    <a href="{{ route('company.booth-setup.preview', ['booking' => $booking, 'tab' => 'team']) }}" class="inline-flex h-10 items-center rounded-lg border border-gray-200 px-4 text-[13px] font-bold text-[#4C1D95] hover:bg-purple-50 transition-colors">
                        <i class="ph ph-chat-circle mr-2"></i>
                        Live Chat
                    </a>
                    @if ($files->isNotEmpty())
                        <a href="{{ asset('storage/' . ($files->first()->file_path ?? '')) }}" target="_blank" class="inline-flex h-10 items-center rounded-lg border border-gray-200 px-4 text-[13px] font-bold text-[#4C1D95] hover:bg-purple-50 transition-colors">
                            <i class="ph ph-download-simple mr-2"></i>
                            Download Brochure
                        </a>
                    @endif
                    @if ($ctaLink)
                        <a href="{{ $ctaLink }}" target="_blank" class="inline-flex h-10 items-center rounded-lg border border-gray-200 px-4 text-[13px] font-bold text-[#4C1D95] hover:bg-purple-50 transition-colors">
                            <i class="ph ph-arrow-square-out mr-2"></i>
                            {{ $ctaText }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="overflow-x-auto border-b border-gray-100 px-5 lg:px-8">
            <nav class="flex min-w-max gap-7">
                @foreach ($tabs as $key => $tab)
                    <a href="{{ route('company.booth-setup.preview', ['booking' => $booking, 'tab' => $key]) }}" class="{{ $activeTab === $key ? 'border-[#4C1D95] text-[#4C1D95]' : 'border-transparent text-gray-500 hover:text-[#4C1D95]' }} border-b-2 py-4 text-[14px] font-bold transition-colors">
                        {{ $tab['label'] }} @if (! is_null($tab['count'])) ({{ $tab['count'] }}) @endif
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="p-5 lg:p-8">
            @if ($activeTab === 'overview')
            <p class="mb-8 max-w-5xl text-[14px] leading-7 text-[#4B5563] break-words whitespace-pre-line">{{ $about }}</p>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
                <div class="rounded-xl border border-gray-100 p-5 xl:col-span-7">
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <h3 class="text-[15px] font-bold text-[#1E1B4B]">Featured Products</h3>
                        <span class="text-[12px] font-bold text-[#6B7280]">{{ $products->count() }} published</span>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        @forelse ($products->take(3) as $product)
                            @php $productImage = $product->product_image ? asset('storage/' . $product->product_image) : $bannerUrl; @endphp
                            <article class="overflow-hidden rounded-lg border border-gray-100">
                                <img src="{{ $productImage }}" alt="{{ $product->name }}" class="h-[110px] w-full object-cover">
                                <div class="p-3">
                                    <h4 class="truncate text-[13px] font-bold text-[#1E1B4B]">{{ $product->name }}</h4>
                                    <p class="mt-1 line-clamp-2 text-[11px] leading-4 text-[#6B7280]">{{ $product->short_description ?: $product->category ?: 'Product details coming soon.' }}</p>
                                </div>
                            </article>
                        @empty
                            <p class="col-span-full rounded-lg bg-gray-50 p-6 text-center text-[13px] font-medium text-[#6B7280]">No published products yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-xl border border-gray-100 p-5 xl:col-span-5">
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <h3 class="text-[15px] font-bold text-[#1E1B4B]">Top Files</h3>
                        <span class="text-[12px] font-bold text-[#6B7280]">{{ $files->count() }} public</span>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse ($files->take(4) as $file)
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="flex items-center justify-between gap-4 py-3">
                                <div class="flex min-w-0 items-center">
                                    <i class="ph ph-file-text mr-3 text-[22px] text-[#8B5CF6]"></i>
                                    <span class="truncate text-[13px] font-bold text-[#1E1B4B]">{{ $file->title }}</span>
                                </div>
                                <span class="shrink-0 text-[12px] text-[#6B7280]">{{ $formatSize($file->file_size) }}</span>
                            </a>
                        @empty
                            <p class="rounded-lg bg-gray-50 p-6 text-center text-[13px] font-medium text-[#6B7280]">No public documents or catalogues yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-xl border border-gray-100 p-5 xl:col-span-3">
                    <h3 class="mb-5 text-[15px] font-bold text-[#1E1B4B]">Team Highlights</h3>
                    @if ($teamMembers->isNotEmpty())
                        <div class="mb-5 flex justify-center -space-x-4 py-3">
                            @foreach ($teamMembers->take(5) as $member)
                                <img class="relative h-14 w-14 rounded-full border-2 border-white object-cover" src="{{ $member->photo ? asset('storage/' . $member->photo) : asset('assets/exhibition/images/avatar.png') }}" alt="{{ $member->name }}">
                            @endforeach
                        </div>
                        <p class="text-center text-[13px] font-bold text-[#1E1B4B]">{{ $teamMembers->count() }} active member{{ $teamMembers->count() === 1 ? '' : 's' }}</p>
                    @else
                        <p class="rounded-lg bg-gray-50 p-6 text-center text-[13px] font-medium text-[#6B7280]">No active team members yet.</p>
                    @endif
                </div>

                <div class="rounded-xl border border-gray-100 p-5 xl:col-span-4">
                    <h3 class="mb-5 text-[15px] font-bold text-[#1E1B4B]">Upcoming Sessions</h3>
                    <div class="space-y-5">
                        @forelse ($sessions->take(3) as $session)
                            <div class="flex items-start">
                                <div class="mr-4 mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded bg-[#EFF6FF] text-[#2563EB]">
                                    <i class="ph ph-calendar"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[12px] text-[#6B7280]">{{ $session->session_date?->format('M d, Y') }} {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('h:i A') : '' }}</p>
                                    <h4 class="mt-1 line-clamp-2 text-[13px] font-bold leading-5 text-[#1E1B4B]">{{ $session->title }}</h4>
                                </div>
                            </div>
                        @empty
                            <p class="rounded-lg bg-gray-50 p-6 text-center text-[13px] font-medium text-[#6B7280]">No live or upcoming sessions yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-xl border border-gray-100 p-5 xl:col-span-5">
                    <h3 class="mb-5 text-[15px] font-bold text-[#1E1B4B]">Media Preview</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @forelse ($mediaItems->take(4) as $media)
                            @php
                                $mediaThumb = $media->thumbnail
                                    ? asset('storage/' . $media->thumbnail)
                                    : ($media->type === 'image' && $media->file_path ? asset('storage/' . $media->file_path) : $bannerUrl);
                                $mediaUrl = $media->file_path ? asset('storage/' . $media->file_path) : ($media->video_url ?: '#');
                            @endphp
                            <a href="{{ $mediaUrl }}" target="_blank" class="relative overflow-hidden rounded-lg border border-gray-100 bg-[#111827]">
                                <img src="{{ $mediaThumb }}" alt="{{ $media->title }}" class="h-24 w-full object-cover">
                                <span class="absolute left-2 top-2 rounded bg-black/55 px-2 py-1 text-[10px] font-bold text-white">{{ ucfirst($media->type) }}</span>
                            </a>
                        @empty
                            <p class="col-span-full rounded-lg bg-gray-50 p-6 text-center text-[13px] font-medium text-[#6B7280]">No active media yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            @elseif ($activeTab === 'products')
                <div class="mb-5 flex items-center justify-between gap-4">
                    <h3 class="text-[18px] font-bold text-[#1E1B4B]">Products</h3>
                    <a href="{{ route('company.booth-setup.products.index', $booking) }}" class="text-[13px] font-bold text-[#4C1D95] hover:underline">Manage Products</a>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @forelse ($products as $product)
                        @php $productImage = $product->product_image ? asset('storage/' . $product->product_image) : $bannerUrl; @endphp
                        <article class="overflow-hidden rounded-xl border border-gray-100">
                            <img src="{{ $productImage }}" alt="{{ $product->name }}" class="h-40 w-full object-cover">
                            <div class="p-4">
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <h4 class="truncate text-[15px] font-bold text-[#1E1B4B]">{{ $product->name }}</h4>
                                    <span class="shrink-0 rounded-full bg-[#F5F3FF] px-2.5 py-1 text-[10px] font-bold text-[#6D28D9]">{{ ucfirst($product->status ?? 'draft') }}</span>
                                </div>
                                <p class="line-clamp-2 text-[13px] leading-5 text-[#6B7280]">{{ $product->short_description ?: $product->category ?: 'Product details coming soon.' }}</p>
                            </div>
                        </article>
                    @empty
                        <p class="col-span-full rounded-lg bg-gray-50 p-8 text-center text-[14px] font-medium text-[#6B7280]">No products saved yet.</p>
                    @endforelse
                </div>
            @elseif ($activeTab === 'documents')
                <div class="mb-5 flex items-center justify-between gap-4">
                    <h3 class="text-[18px] font-bold text-[#1E1B4B]">Documents</h3>
                    <a href="{{ route('company.booth-setup.documents.index', $booking) }}" class="text-[13px] font-bold text-[#4C1D95] hover:underline">Manage Documents</a>
                </div>
                <div class="divide-y divide-gray-100 rounded-xl border border-gray-100">
                    @forelse ($documents as $document)
                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="flex flex-col gap-2 p-4 sm:flex-row sm:items-center sm:justify-between">
                            <span class="font-bold text-[#1E1B4B]"><i class="ph ph-file-text mr-2 text-[#8B5CF6]"></i>{{ $document->title }}</span>
                            <span class="text-[12px] font-semibold text-[#6B7280]">{{ ucfirst($document->visibility ?? 'public') }} / {{ ucfirst($document->status ?? 'active') }} / {{ $formatSize($document->file_size) }}</span>
                        </a>
                    @empty
                        <p class="p-8 text-center text-[14px] font-medium text-[#6B7280]">No documents saved yet.</p>
                    @endforelse
                </div>
            @elseif ($activeTab === 'catalogues')
                <div class="mb-5 flex items-center justify-between gap-4">
                    <h3 class="text-[18px] font-bold text-[#1E1B4B]">Catalogues</h3>
                    <a href="{{ route('company.booth-setup.catalogues.index', $booking) }}" class="text-[13px] font-bold text-[#4C1D95] hover:underline">Manage Catalogues</a>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @forelse ($catalogues as $catalogue)
                        @php $cover = $catalogue->cover_image ? asset('storage/' . $catalogue->cover_image) : $bannerUrl; @endphp
                        <a href="{{ asset('storage/' . $catalogue->file_path) }}" target="_blank" class="overflow-hidden rounded-xl border border-gray-100">
                            <img src="{{ $cover }}" alt="{{ $catalogue->title }}" class="h-36 w-full object-cover">
                            <div class="p-4">
                                <h4 class="truncate text-[15px] font-bold text-[#1E1B4B]">{{ $catalogue->title }}</h4>
                                <p class="mt-1 text-[12px] font-semibold text-[#6B7280]">{{ ucfirst($catalogue->visibility ?? 'public') }} / {{ ucfirst($catalogue->status ?? 'active') }} / {{ $formatSize($catalogue->file_size) }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="col-span-full rounded-lg bg-gray-50 p-8 text-center text-[14px] font-medium text-[#6B7280]">No catalogues saved yet.</p>
                    @endforelse
                </div>
            @elseif ($activeTab === 'media')
                <div class="mb-5 flex items-center justify-between gap-4">
                    <h3 class="text-[18px] font-bold text-[#1E1B4B]">Media</h3>
                    <a href="{{ route('company.booth-setup.media.index', $booking) }}" class="text-[13px] font-bold text-[#4C1D95] hover:underline">Manage Media</a>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @forelse ($mediaItems as $media)
                        @php
                            $mediaThumb = $media->thumbnail ? asset('storage/' . $media->thumbnail) : ($media->type === 'image' && $media->file_path ? asset('storage/' . $media->file_path) : $bannerUrl);
                            $mediaUrl = $media->file_path ? asset('storage/' . $media->file_path) : ($media->video_url ?: '#');
                        @endphp
                        <a href="{{ $mediaUrl }}" target="_blank" class="relative overflow-hidden rounded-xl border border-gray-100 bg-[#111827]">
                            <img src="{{ $mediaThumb }}" alt="{{ $media->title }}" class="h-40 w-full object-cover">
                            <span class="absolute left-3 top-3 rounded bg-black/60 px-2.5 py-1 text-[10px] font-bold text-white">{{ ucfirst($media->type) }}</span>
                            <div class="bg-white p-3"><p class="truncate text-[13px] font-bold text-[#1E1B4B]">{{ $media->title }}</p></div>
                        </a>
                    @empty
                        <p class="col-span-full rounded-lg bg-gray-50 p-8 text-center text-[14px] font-medium text-[#6B7280]">No media saved yet.</p>
                    @endforelse
                </div>
            @elseif ($activeTab === 'team')
                <div class="mb-5 flex items-center justify-between gap-4">
                    <h3 class="text-[18px] font-bold text-[#1E1B4B]">Team</h3>
                    <a href="{{ route('company.booth-setup.team-members.index', $booking) }}" class="text-[13px] font-bold text-[#4C1D95] hover:underline">Manage Team</a>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @forelse ($teamMembers as $member)
                        <article class="flex items-center gap-4 rounded-xl border border-gray-100 p-4">
                            <img src="{{ $member->photo ? asset('storage/' . $member->photo) : asset('assets/exhibition/images/avatar.png') }}" alt="{{ $member->name }}" class="h-14 w-14 rounded-full object-cover">
                            <div class="min-w-0">
                                <h4 class="truncate text-[15px] font-bold text-[#1E1B4B]">{{ $member->name }}</h4>
                                <p class="truncate text-[13px] text-[#6B7280]">{{ $member->designation }}</p>
                            </div>
                        </article>
                    @empty
                        <p class="col-span-full rounded-lg bg-gray-50 p-8 text-center text-[14px] font-medium text-[#6B7280]">No team members saved yet.</p>
                    @endforelse
                </div>
            @elseif ($activeTab === 'sessions')
                <div class="mb-5 flex items-center justify-between gap-4">
                    <h3 class="text-[18px] font-bold text-[#1E1B4B]">Sessions</h3>
                    <a href="{{ route('company.booth-setup.sessions.index', $booking) }}" class="text-[13px] font-bold text-[#4C1D95] hover:underline">Manage Sessions</a>
                </div>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                    @forelse ($sessions as $session)
                        <article class="rounded-xl border border-gray-100 p-5">
                            <div class="mb-3 flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-[#F5F3FF] px-3 py-1 text-[11px] font-bold text-[#6D28D9]">{{ ucfirst(str_replace('_', ' ', $session->type ?? 'session')) }}</span>
                                <span class="rounded-full bg-[#EEF2FF] px-3 py-1 text-[11px] font-bold text-[#4338CA]">{{ ucfirst($session->status ?? 'upcoming') }}</span>
                            </div>
                            <h4 class="text-[16px] font-bold text-[#1E1B4B]">{{ $session->title }}</h4>
                            <p class="mt-2 text-[13px] text-[#6B7280]">{{ $session->session_date?->format('M d, Y') }} {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('h:i A') : '' }}</p>
                        </article>
                    @empty
                        <p class="col-span-full rounded-lg bg-gray-50 p-8 text-center text-[14px] font-medium text-[#6B7280]">No sessions saved yet.</p>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
