@extends('layouts.company')

@section('title', 'Upload Catalogues | eproexpo')
@section('page-title', 'Upload Catalogues')

@section('content')
@php
    $editingCatalogue = $catalogue ?? null;
    $action = $editingCatalogue
        ? route('company.booth-setup.catalogues.update', [$booking, $editingCatalogue])
        : route('company.booth-setup.catalogues.store', $booking);
    $coverUrl = $editingCatalogue?->cover_image ? asset('storage/' . $editingCatalogue->cover_image) : asset('assets/exhibition/images/booth_banner.png');
@endphp

<section class="px-4 py-6 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-[1400px] rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6 lg:p-8">
        <h1 class="mb-6 text-[22px] font-bold tracking-tight text-[#1E1B4B] sm:text-[28px] lg:mb-8">Upload Catalogues</h1>

        @if (session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mb-10">
            @csrf
            @if ($editingCatalogue)
                @method('PUT')
            @endif
            <label class="mb-5 flex w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-[#8B5CF6] bg-white px-4 py-8 text-center sm:py-12">
                <span class="mb-4 text-[#3D1B9B]">
                    <svg class="h-12 w-12 sm:h-16 sm:w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L8 8m4-4 4 4M6 20h12a2 2 0 0 0 2-2v-3m-16 3v-3a2 2 0 0 1 2-2h2"></path></svg>
                </span>
                <span class="mb-2 text-[15px] font-bold text-[#1E1B4B] sm:text-[16px]">Upload catalogue PDF/file</span>
                <span id="catalogue-file-name" class="mb-6 text-[12px] text-[#6B7280] sm:text-[13px]">PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX (Max. 20MB)</span>
                <span class="rounded-lg border border-[#3D1B9B] px-6 py-2.5 text-[14px] font-semibold text-[#3D1B9B] transition-colors hover:bg-purple-50">Browse Files</span>
                <input id="catalogue-file-input" type="file" name="file" class="hidden" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx">
            </label>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
                <label>
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Catalogue Title</span>
                    <input name="title" value="{{ old('title', $editingCatalogue?->title) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                </label>
                <label>
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Category</span>
                    <input name="category" value="{{ old('category', $editingCatalogue?->category) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                </label>
                <label>
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Pages</span>
                    <input type="number" min="1" name="pages" value="{{ old('pages', $editingCatalogue?->pages) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                </label>
                <label>
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Visibility</span>
                    <select name="visibility" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                        <option value="public" @selected(old('visibility', $editingCatalogue?->visibility ?? 'public') === 'public')>Public</option>
                        <option value="private" @selected(old('visibility', $editingCatalogue?->visibility) === 'private')>Private</option>
                    </select>
                </label>
                <label>
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Status</span>
                    <select name="status" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                        <option value="active" @selected(old('status', $editingCatalogue?->status ?? 'active') === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $editingCatalogue?->status) === 'inactive')>Inactive</option>
                    </select>
                </label>
                <label class="xl:col-span-3">
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Cover Image</span>
                    <div class="flex min-w-0 items-center gap-4">
                        <img id="catalogue-cover-preview" src="{{ $coverUrl }}" class="h-12 w-16 flex-shrink-0 rounded-md border border-gray-200 object-cover" alt="Cover preview">
                        <input id="catalogue-cover-input" type="file" name="cover_image" class="min-w-0 w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]" accept="image/*">
                    </div>
                </label>
                <label class="md:col-span-2 xl:col-span-4">
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Short Description</span>
                    <textarea name="description" rows="2" class="w-full rounded-lg border border-gray-200 px-4 py-3 text-[14px] outline-none focus:border-[#3D1B9B]">{{ old('description', $editingCatalogue?->description) }}</textarea>
                </label>
            </div>
            <div class="mt-5 flex justify-end gap-3">
                @if ($editingCatalogue)
                    <a href="{{ route('company.booth-setup.catalogues.index', $booking) }}" class="rounded-lg border border-gray-200 px-6 py-2.5 text-[14px] font-semibold text-[#3D1B9B] hover:bg-purple-50">Cancel</a>
                @endif
                <button type="submit" class="rounded-lg bg-[#3D1B9B] px-6 py-2.5 text-[14px] font-bold text-white hover:bg-[#31167D]">{{ $editingCatalogue ? 'Update Catalogue' : 'Upload Catalogue' }}</button>
            </div>
        </form>

        <div class="mb-6 overflow-x-auto rounded-xl border border-gray-100 bg-white">
            <div class="min-w-0">
                <div class="border-b border-gray-100 p-4 sm:p-6">
                    <h3 class="text-[16px] font-bold text-[#1E1B4B] lg:mb-6">Uploaded Catalogues</h3>
                    <div class="hidden grid-cols-12 items-center gap-4 lg:grid">
                        <div class="col-span-4 text-[14px] font-bold text-[#1E1B4B]">Catalogue</div>
                        <div class="col-span-2 text-[14px] font-bold text-[#1E1B4B]">Category</div>
                        <div class="col-span-1 text-center text-[14px] font-bold text-[#1E1B4B]">Pages</div>
                        <div class="col-span-2 text-center text-[14px] font-bold text-[#1E1B4B]">Size</div>
                        <div class="col-span-2 text-center text-[14px] font-bold text-[#1E1B4B]">Visibility</div>
                        <div class="col-span-1 text-center text-[14px] font-bold text-[#1E1B4B]">Actions</div>
                    </div>
                </div>
                @forelse ($catalogues as $item)
                    <div class="flex flex-col gap-3 border-b border-gray-100 p-4 last:border-b-0 lg:grid lg:grid-cols-12 lg:items-center lg:gap-4 lg:p-6">
                        <div class="flex min-w-0 items-center lg:col-span-4">
                            <div class="mr-4 h-14 w-14 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 bg-gray-100">
                                <img src="{{ $item->cover_image ? asset('storage/' . $item->cover_image) : asset('assets/exhibition/images/booth_banner.png') }}" alt="{{ $item->title }}" class="h-full w-full object-cover">
                            </div>
                            <span class="truncate pr-4 text-[14px] font-bold text-[#1E1B4B]">{{ $item->title }}</span>
                        </div>
                        <div class="text-[14px] text-[#6B7280] lg:col-span-2">
                            <span class="mr-2 font-semibold text-[#1E1B4B] lg:hidden">Category:</span>{{ $item->category ?: '-' }}
                        </div>
                        <div class="text-[14px] text-[#6B7280] lg:col-span-1 lg:text-center">
                            <span class="mr-2 font-semibold text-[#1E1B4B] lg:hidden">Pages:</span>{{ $item->pages ?: '-' }}
                        </div>
                        <div class="text-[14px] text-[#6B7280] lg:col-span-2 lg:text-center">
                            <span class="mr-2 font-semibold text-[#1E1B4B] lg:hidden">Size:</span>{{ $item->file_size ? number_format($item->file_size / 1024 / 1024, 1) . ' MB' : '-' }}
                        </div>
                        <div class="flex items-center lg:col-span-2 lg:justify-center">
                            <span class="mr-2 text-[14px] font-semibold text-[#1E1B4B] lg:hidden">Visibility:</span>
                            <span class="inline-flex rounded-md border px-3 py-1 text-[12px] font-semibold {{ $item->visibility === 'public' ? 'border-emerald-200 bg-emerald-50 text-[#10B981]' : 'border-[#DDD6FE] bg-[#F5F3FF] text-[#6D28D9]' }}">{{ ucfirst($item->visibility) }}</span>
                        </div>
                        <div class="flex gap-2 lg:col-span-1 lg:justify-center">
                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="flex h-8 w-8 items-center justify-center rounded border border-gray-200 text-gray-500 hover:bg-gray-50"><i class="ph ph-download-simple"></i></a>
                            <a href="{{ route('company.booth-setup.catalogues.edit', [$booking, $item]) }}" class="flex h-8 w-8 items-center justify-center rounded border border-gray-200 text-gray-500 hover:bg-gray-50"><i class="ph ph-pencil-simple"></i></a>
                            <form method="POST" action="{{ route('company.booth-setup.catalogues.destroy', [$booking, $item]) }}" onsubmit="return confirm('Delete this catalogue?');">
                                @csrf
                                @method('DELETE')
                                <button class="flex h-8 w-8 items-center justify-center rounded border border-gray-200 text-red-500 hover:bg-red-50"><i class="ph ph-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-[14px] text-[#6B7280]">No catalogues uploaded yet.</div>
                @endforelse
            </div>
        </div>

        <p class="mt-4 text-[14px] text-[#6B7280]">Showing {{ $catalogues->count() }} catalogue{{ $catalogues->count() === 1 ? '' : 's' }}</p>

        <div class="mt-10 flex justify-end border-t border-gray-100 pt-8">
            <a href="{{ route('company.booth-setup.media.index', $booking) }}" class="inline-flex rounded-lg bg-[#3D1B9B] px-8 py-3 text-[15px] font-bold text-white shadow-md transition-colors hover:bg-[#31167D]">
                Save & Continue <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('catalogue-file-input')?.addEventListener('change', (event) => {
        const file = event.target.files?.[0];
        if (file) {
            document.getElementById('catalogue-file-name').textContent = file.name;
        }
    });

    document.getElementById('catalogue-cover-input')?.addEventListener('change', (event) => {
        const file = event.target.files?.[0];
        const preview = document.getElementById('catalogue-cover-preview');
        if (file && preview) {
            preview.src = URL.createObjectURL(file);
        }
    });
</script>
@endpush
