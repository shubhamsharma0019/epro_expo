@extends('layouts.company')

@section('title', 'Upload Documents | eproexpo')
@section('page-title', 'Upload Documents')

@section('content')
@php
    $editingDocument = $document ?? null;
    $action = $editingDocument
        ? route('company.booth-setup.documents.update', [$booking, $editingDocument])
        : route('company.booth-setup.documents.store', $booking);
@endphp

<section class="px-4 py-6 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-[1400px] rounded-2xl border border-gray-100 bg-white p-8 shadow-sm">
        <h1 class="mb-2 text-[28px] font-bold tracking-tight text-[#1E1B4B]">Upload Documents</h1>
        <p class="mb-8 text-[15px] text-[#6B7280]">Upload important documents to share with attendees.</p>

        @if (session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mb-10">
            @csrf
            @if ($editingDocument)
                @method('PUT')
            @endif

            <label class="mb-5 flex w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-[#8B5CF6] bg-white py-12 text-center">
                <span class="mb-4 text-[#3D1B9B]">
                    <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                </span>
                <span class="mb-2 text-[16px] font-bold text-[#1E1B4B]">Drag & drop files here or <span class="text-[#3D1B9B]">click to browse</span></span>
                <span id="document-file-name" class="mb-6 text-[13px] text-[#6B7280]">PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, JPG, PNG (Max. 20MB)</span>
                <span class="rounded-lg border border-[#3D1B9B] px-6 py-2.5 text-[14px] font-semibold text-[#3D1B9B] transition-colors hover:bg-purple-50">Browse Files</span>
                <input id="document-file-input" type="file" name="file" class="hidden" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png,.webp">
            </label>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
                <label>
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Document Title</span>
                    <input name="title" value="{{ old('title', $editingDocument?->title) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                </label>
                <label>
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Type</span>
                    <select name="document_type" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                        @foreach (['Brochure', 'Certificate', 'Catalogue', 'Datasheet', 'Other'] as $type)
                            <option value="{{ $type }}" @selected(old('document_type', $editingDocument?->document_type) === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </label>
                <label>
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Visibility</span>
                    <select name="visibility" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                        <option value="public" @selected(old('visibility', $editingDocument?->visibility ?? 'public') === 'public')>Public</option>
                        <option value="private" @selected(old('visibility', $editingDocument?->visibility) === 'private')>Private</option>
                    </select>
                </label>
                <label>
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Status</span>
                    <select name="status" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]">
                        <option value="active" @selected(old('status', $editingDocument?->status ?? 'active') === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $editingDocument?->status) === 'inactive')>Inactive</option>
                    </select>
                </label>
                <label class="md:col-span-2 xl:col-span-4">
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Description</span>
                    <textarea name="description" rows="2" class="w-full rounded-lg border border-gray-200 px-4 py-3 text-[14px] outline-none focus:border-[#3D1B9B]">{{ old('description', $editingDocument?->description) }}</textarea>
                </label>
            </div>
            <div class="mt-5 flex justify-end gap-3">
                @if ($editingDocument)
                    <a href="{{ route('company.booth-setup.documents.index', $booking) }}" class="rounded-lg border border-gray-200 px-6 py-2.5 text-[14px] font-semibold text-[#3D1B9B] hover:bg-purple-50">Cancel</a>
                @endif
                <button type="submit" class="rounded-lg bg-[#3D1B9B] px-6 py-2.5 text-[14px] font-bold text-white hover:bg-[#31167D]">{{ $editingDocument ? 'Update Document' : 'Upload Document' }}</button>
            </div>
        </form>

        <div class="mb-6 overflow-hidden rounded-xl border border-gray-100 bg-white">
            <div class="grid min-w-[900px] grid-cols-12 items-center gap-4 border-b border-gray-100 bg-white p-5">
                <div class="col-span-4"><span class="text-[14px] font-bold text-[#1E1B4B]">Uploaded Documents</span></div>
                <div class="col-span-2"><span class="text-[14px] font-bold text-[#1E1B4B]">Type</span></div>
                <div class="col-span-2"><span class="text-[14px] font-bold text-[#1E1B4B]">Visibility</span></div>
                <div class="col-span-2"><span class="text-[14px] font-bold text-[#1E1B4B]">Size</span></div>
                <div class="col-span-1 text-center"><span class="text-[14px] font-bold text-[#1E1B4B]">Downloads</span></div>
                <div class="col-span-1 text-center"><span class="text-[14px] font-bold text-[#1E1B4B]">Actions</span></div>
            </div>
            <div class="overflow-x-auto">
                @forelse ($documents as $item)
                    <div class="grid min-w-[900px] grid-cols-12 items-center gap-4 border-b border-gray-100 p-5 last:border-b-0">
                        <div class="col-span-4 flex min-w-0 items-center">
                            <svg class="mr-3 h-6 w-6 flex-shrink-0 text-[#8B5CF6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            <span class="truncate pr-4 text-[14px] font-medium text-[#4B5563]">{{ $item->title }}</span>
                        </div>
                        <div class="col-span-2 text-[14px] text-[#4B5563]">{{ $item->document_type ?? strtoupper($item->file_type ?? 'file') }}</div>
                        <div class="col-span-2">
                            <span class="inline-flex rounded-md border px-3 py-1 text-[12px] font-semibold {{ $item->visibility === 'public' ? 'border-emerald-200 bg-emerald-50 text-[#10B981]' : 'border-[#DDD6FE] bg-[#F5F3FF] text-[#6D28D9]' }}">{{ ucfirst($item->visibility) }}</span>
                        </div>
                        <div class="col-span-2 text-[14px] text-[#4B5563]">{{ $item->file_size ? number_format($item->file_size / 1024 / 1024, 1) . ' MB' : '-' }}</div>
                        <div class="col-span-1 text-center text-[14px] text-[#4B5563]">{{ number_format($item->downloads ?? 0) }}</div>
                        <div class="col-span-1 flex justify-center gap-2">
                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="flex h-8 w-8 items-center justify-center rounded border border-gray-200 text-gray-500 hover:bg-gray-50" title="View/download"><i class="ph ph-download-simple"></i></a>
                            <a href="{{ route('company.booth-setup.documents.edit', [$booking, $item]) }}" class="flex h-8 w-8 items-center justify-center rounded border border-gray-200 text-gray-500 hover:bg-gray-50" title="Edit"><i class="ph ph-pencil-simple"></i></a>
                            <form method="POST" action="{{ route('company.booth-setup.documents.destroy', [$booking, $item]) }}" onsubmit="return confirm('Delete this document?');">
                                @csrf
                                @method('DELETE')
                                <button class="flex h-8 w-8 items-center justify-center rounded border border-gray-200 text-red-500 hover:bg-red-50" title="Delete"><i class="ph ph-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-[14px] text-[#6B7280]">No documents uploaded yet.</div>
                @endforelse
            </div>
        </div>

        <p class="mt-4 text-[14px] text-[#6B7280]">Showing {{ $documents->count() }} document{{ $documents->count() === 1 ? '' : 's' }}</p>

        <div class="mt-10 flex justify-end border-t border-gray-100 pt-8">
            <a href="{{ route('company.booth-setup.catalogues.index', $booking) }}" class="inline-flex rounded-lg bg-[#3D1B9B] px-8 py-3 text-[15px] font-bold text-white shadow-md transition-colors hover:bg-[#31167D]">
                Save & Continue <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('document-file-input')?.addEventListener('change', (event) => {
        const file = event.target.files?.[0];
        if (file) {
            document.getElementById('document-file-name').textContent = file.name;
        }
    });
</script>
@endpush
