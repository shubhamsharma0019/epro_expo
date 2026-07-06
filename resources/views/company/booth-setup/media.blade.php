@extends('layouts.company')

@section('title', 'Media Gallery | eproexpo')
@section('page-title', 'Media Gallery')

@section('content')
@php
    $editingMedia = $mediaItem ?? null;
    $action = $editingMedia
        ? route('company.booth-setup.media.update', [$booking, $editingMedia])
        : route('company.booth-setup.media.store', $booking);
    $mediaCounts = $mediaCounts ?? \App\Domain\Booth\Models\BoothMedia::countByType(collect($mediaItems ?? []));
    $activeTab = request('tab', 'all');
@endphp

<section class="px-4 py-6 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-[1400px] bg-white">
        <h1 class="mb-8 text-[28px] font-bold tracking-tight text-[#1E1B4B]">Media Gallery</h1>

        @if (session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
        @endif

        <div class="mb-8 border-b border-gray-200 overflow-x-auto">
            <nav class="flex min-w-max space-x-8" id="media-tabs">
                <button type="button" data-filter="all" class="media-tab-btn border-b-2 px-1 py-3 text-[15px] focus:outline-none cursor-pointer transition-all {{ $activeTab === 'all' ? 'border-[#3D1B9B] font-bold text-[#3D1B9B]' : 'border-transparent font-medium text-gray-500 hover:text-[#3D1B9B]' }}">All Media ({{ $mediaCounts['all'] }})</button>
                <button type="button" data-filter="image" class="media-tab-btn border-b-2 px-1 py-3 text-[15px] focus:outline-none cursor-pointer transition-all {{ $activeTab === 'image' ? 'border-[#3D1B9B] font-bold text-[#3D1B9B]' : 'border-transparent font-medium text-gray-500 hover:text-[#3D1B9B]' }}">Images ({{ $mediaCounts['image'] }})</button>
                <button type="button" data-filter="video" class="media-tab-btn border-b-2 px-1 py-3 text-[15px] focus:outline-none cursor-pointer transition-all {{ $activeTab === 'video' ? 'border-[#3D1B9B] font-bold text-[#3D1B9B]' : 'border-transparent font-medium text-gray-500 hover:text-[#3D1B9B]' }}">Videos ({{ $mediaCounts['video'] }})</button>
                <button type="button" data-filter="document" class="media-tab-btn border-b-2 px-1 py-3 text-[15px] focus:outline-none cursor-pointer transition-all {{ $activeTab === 'document' ? 'border-[#3D1B9B] font-bold text-[#3D1B9B]' : 'border-transparent font-medium text-gray-500 hover:text-[#3D1B9B]' }}">Documents ({{ $mediaCounts['document'] }})</button>
                <button type="button" data-filter="360" class="media-tab-btn border-b-2 px-1 py-3 text-[15px] focus:outline-none cursor-pointer transition-all {{ $activeTab === '360' ? 'border-[#3D1B9B] font-bold text-[#3D1B9B]' : 'border-transparent font-medium text-gray-500 hover:text-[#3D1B9B]' }}">360 ({{ $mediaCounts['360'] }})</button>
            </nav>
        </div>

        <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mb-10 grid grid-cols-1 gap-6 lg:grid-cols-12">
            @csrf
            @if ($editingMedia)
                @method('PUT')
            @endif

            <label id="media-dropzone" class="flex min-h-[240px] cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-[#8B5CF6] bg-white p-8 text-center transition-colors lg:col-span-8">
                <span class="mb-4 text-[#3D1B9B]">
                    <svg class="h-14 w-14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                </span>
                <span class="mb-2 text-[16px] font-bold text-[#1E1B4B]">Drag & drop files here or <span class="text-[#3D1B9B]">click to upload</span></span>
                <span id="media-file-name" class="mb-6 text-[13px] text-[#6B7280]">Supports: JPG, PNG, WEBP, MP4, MOV, PDF up to 40MB</span>
                <span class="rounded-lg border border-[#3D1B9B] bg-white px-6 py-2.5 text-[14px] font-semibold text-[#3D1B9B] transition-colors hover:bg-purple-50">Choose Files</span>
                <input id="media-file-input" type="file" name="{{ $editingMedia ? 'file' : 'files[]' }}" class="hidden" accept="image/*,video/*,.pdf" @if (! $editingMedia) multiple @endif>
            </label>

            <div class="flex flex-col gap-4 lg:col-span-4">
                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <h3 class="mb-4 text-[15px] font-bold text-[#1E1B4B]">Storage Usage</h3>
                    <div class="mb-2 flex items-end justify-between">
                        <p class="text-[14px]"><span class="font-bold text-[#1E1B4B]">{{ $storageUsagePercent ?? 0 }}%</span> <span class="text-gray-500">used</span></p>
                        <span class="text-[14px] font-bold text-[#1E1B4B]">{{ $storageUsagePercent ?? 0 }}%</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-[#F3F4F6]"><div class="h-2 rounded-full bg-[#3D1B9B]" style="width: {{ $storageUsagePercent ?? 0 }}%"></div></div>
                </div>
                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <h3 class="mb-3 text-[15px] font-bold text-[#1E1B4B]">Media Details</h3>
                    <div class="space-y-3">
                        <input id="media-title-input" name="title" value="{{ old('title', $editingMedia?->title) }}" placeholder="Media title (optional for files)" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                        <select name="type" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                            @foreach (['image' => 'Image', 'video' => 'Video', 'document' => 'Document', '360' => '360'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('type', $editingMedia?->type ?? 'image') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <input name="video_url" value="{{ old('video_url', $editingMedia?->video_url) }}" placeholder="Video URL (optional)" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                        <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $editingMedia?->sort_order ?? 0) }}" placeholder="Sort order" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                        <select name="status" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                            <option value="active" @selected(old('status', $editingMedia?->status ?? 'active') === 'active')>Active</option>
                            <option value="inactive" @selected(old('status', $editingMedia?->status) === 'inactive')>Inactive</option>
                        </select>
                        <textarea name="description" rows="2" placeholder="Description" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">{{ old('description', $editingMedia?->description) }}</textarea>
                        <div class="flex justify-end gap-3">
                            @if ($editingMedia)
                                <a href="{{ route('company.booth-setup.media.index', $booking) }}" class="rounded-lg border border-gray-200 px-5 py-2.5 text-[14px] font-semibold text-[#3D1B9B] hover:bg-purple-50">Cancel</a>
                            @endif
                            <button class="rounded-lg bg-[#3D1B9B] px-5 py-2.5 text-[14px] font-bold text-white hover:bg-[#31167D]">{{ $editingMedia ? 'Update Media' : 'Save Media' }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="mb-6 flex flex-col items-center justify-between gap-4 md:flex-row">
            <h2 class="text-[18px] font-bold text-[#1E1B4B]">Recent Media</h2>
        </div>

        <div id="media-grid" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse ($mediaItems as $item)
                @php
                    $resolvedType = $item->resolvedType();
                    $mediaUrl = $item->mediaUrl();
                    $thumbUrl = $item->thumbnailUrl();
                    $isHidden = $activeTab !== 'all' && $activeTab !== $resolvedType;
                @endphp
                <div class="media-card group flex flex-col overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm {{ $isHidden ? 'hidden' : '' }}" data-media-type="{{ $resolvedType }}">
                    <a href="{{ $mediaUrl ?: '#' }}" target="_blank" class="relative h-40 w-full overflow-hidden bg-[#0F172A]">
                        @if ($resolvedType === 'video')
                            <div class="flex h-full w-full items-center justify-center bg-[#111827] text-white">
                                <i class="ph ph-play-circle text-[42px]"></i>
                            </div>
                        @elseif ($resolvedType === 'document')
                            <div class="flex h-full w-full items-center justify-center bg-[#F8FAFC] text-[#3D1B9B]">
                                <i class="ph ph-file-pdf text-[42px]"></i>
                            </div>
                        @else
                            <img src="{{ $thumbUrl }}" alt="{{ $item->title }}" class="h-full w-full object-cover">
                        @endif
                        <span class="absolute left-2 top-2 rounded bg-[#4C1D95] px-2.5 py-1 text-[10px] font-bold text-white">{{ ucfirst($resolvedType) }}</span>
                    </a>
                    <div class="p-4">
                        <h4 class="mb-1 truncate text-[14px] font-bold text-[#1E1B4B]">{{ $item->title }}</h4>
                        <p class="mb-3 text-[12px] text-gray-500">{{ optional($item->created_at)->format('M d, Y') }} {{ $item->file_size ? '• ' . number_format($item->file_size / 1024 / 1024, 1) . ' MB' : '' }}</p>
                        <div class="flex items-center justify-between">
                            <p class="text-[12px] font-medium text-gray-500">Views: {{ number_format($item->views ?? 0) }}</p>
                            <div class="flex gap-2">
                                <a href="{{ route('company.booth-setup.media.edit', [$booking, $item]) }}" class="text-gray-400 hover:text-[#3D1B9B]"><i class="ph ph-pencil-simple"></i></a>
                                <form method="POST" action="{{ route('company.booth-setup.media.destroy', [$booking, $item]) }}" onsubmit="return confirm('Delete this media item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-500"><i class="ph ph-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-xl border border-gray-100 bg-white p-8 text-center text-[14px] text-[#6B7280]">No media uploaded yet.</div>
            @endforelse

            <div id="media-filter-empty" class="hidden col-span-full rounded-xl border border-gray-100 bg-white p-8 text-center text-[14px] text-[#6B7280]">
                No media of this type uploaded yet.
            </div>
        </div>

        <div class="mt-10 flex justify-end border-t border-gray-100 pt-8">
            <a href="{{ route('company.booth-setup.team-members.index', $booking) }}" class="inline-flex rounded-lg bg-[#3D1B9B] px-8 py-3 text-[15px] font-bold text-white shadow-md transition-colors hover:bg-[#31167D]">
                Save & Continue <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const mediaInput = document.getElementById('media-file-input');
    const mediaDropzone = document.getElementById('media-dropzone');
    const mediaFileName = document.getElementById('media-file-name');

    function updateMediaFileName(files) {
        const selected = Array.from(files || []);
        if (!selected.length || !mediaFileName) return;

        mediaFileName.textContent = selected.length === 1
            ? selected[0].name
            : `${selected.length} files selected`;

        const titleInput = document.getElementById('media-title-input');
        if (titleInput && !titleInput.value.trim() && selected.length === 1) {
            titleInput.value = selected[0].name.replace(/\.[^/.]+$/, '').replace(/[-_]+/g, ' ');
        }
    }

    mediaInput?.addEventListener('change', (event) => {
        updateMediaFileName(event.target.files);
    });

    ['dragenter', 'dragover'].forEach((eventName) => {
        mediaDropzone?.addEventListener(eventName, (event) => {
            event.preventDefault();
            mediaDropzone.classList.add('bg-purple-50', 'border-[#3D1B9B]');
        });
    });

    ['dragleave', 'drop'].forEach((eventName) => {
        mediaDropzone?.addEventListener(eventName, (event) => {
            event.preventDefault();
            mediaDropzone.classList.remove('bg-purple-50', 'border-[#3D1B9B]');
        });
    });

    mediaDropzone?.addEventListener('drop', (event) => {
        if (!mediaInput || !event.dataTransfer?.files?.length) return;

        mediaInput.files = event.dataTransfer.files;
        updateMediaFileName(mediaInput.files);
    });

    // Dynamic Tab Filtering
    (() => {
        const tabs = document.querySelectorAll('.media-tab-btn');
        const cards = document.querySelectorAll('.media-card');
        const emptyState = document.getElementById('media-filter-empty');

        const applyFilter = (filter) => {
            tabs.forEach((tab) => {
                const isActive = tab.dataset.filter === filter;
                tab.classList.toggle('border-[#3D1B9B]', isActive);
                tab.classList.toggle('font-bold', isActive);
                tab.classList.toggle('text-[#3D1B9B]', isActive);
                tab.classList.toggle('border-transparent', !isActive);
                tab.classList.toggle('font-medium', !isActive);
                tab.classList.toggle('text-gray-500', !isActive);
            });

            let visibleCount = 0;
            cards.forEach((card) => {
                const shouldShow = filter === 'all' || card.dataset.mediaType === filter;
                card.classList.toggle('hidden', !shouldShow);
                if (shouldShow) {
                    visibleCount++;
                }
            });

            if (emptyState) {
                emptyState.classList.toggle('hidden', visibleCount > 0 || cards.length === 0);
            }

            const url = new URL(window.location.href);
            if (filter === 'all') {
                url.searchParams.delete('tab');
            } else {
                url.searchParams.set('tab', filter);
            }
            window.history.replaceState({}, '', url);
        };

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => applyFilter(tab.dataset.filter || 'all'));
        });

        applyFilter(@json($activeTab));
    })();
</script>
@endpush
