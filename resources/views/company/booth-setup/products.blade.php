@extends('layouts.company')

@section('title', 'Products | eproexpo')
@section('page-title', 'Products')

@section('content')
@php
    $editingProduct = $product ?? null;
    $showProductForm = $showProductForm ?? false;
    $productAction = $editingProduct
        ? route('company.booth-setup.products.update', [$booking, $editingProduct])
        : route('company.booth-setup.products.store', $booking);
    $productImageUrl = \App\Support\MediaUrl::url($editingProduct?->product_image, 'assets/exhibition/images/booth_banner.png');
@endphp

<section class="px-4 py-6 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-[1400px] rounded-2xl border border-gray-100 bg-white p-8 shadow-sm">
        <h1 class="mb-8 text-[28px] font-bold tracking-tight text-[#1E1B4B]">Products</h1>

        @if (session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
        @endif

        <form method="GET" action="{{ route('company.booth-setup.products.index', $booking) }}" class="mb-8 flex flex-col items-center justify-between gap-4 md:flex-row">
            <div class="flex w-full flex-1 flex-col gap-4 md:w-auto md:flex-row">
                <div class="relative w-full md:w-[320px]">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full rounded-lg border border-gray-200 py-2.5 pl-10 pr-3 text-[14px] text-gray-900 outline-none focus:border-[#3D1B9B] focus:ring-[#3D1B9B]" placeholder="Search products...">
                </div>

                <div class="relative w-full md:w-[260px]">
                    <select name="category" onchange="this.form.submit()" class="block w-full cursor-pointer appearance-none rounded-lg border border-gray-200 bg-white py-2.5 pl-4 pr-10 text-[14px] font-medium text-[#1E1B4B] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        <option value="">All Categories</option>
                        @foreach ($categories ?? [] as $category)
                            <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <div class="flex w-full flex-col gap-3 md:w-auto md:flex-row">
                @if (request('search') || request('category'))
                    <a href="{{ route('company.booth-setup.products.index', $booking) }}" class="flex items-center justify-center rounded-lg border border-gray-200 px-5 py-2.5 text-[14px] font-bold text-[#3D1B9B] transition-colors hover:bg-purple-50">Clear</a>
                @endif
                <button type="submit" class="flex items-center justify-center rounded-lg border border-gray-200 px-5 py-2.5 text-[14px] font-bold text-[#3D1B9B] transition-colors hover:bg-purple-50">Search</button>
                <a href="{{ route('company.booth-setup.products.create', $booking) }}" class="flex items-center justify-center rounded-lg bg-[#3D1B9B] px-6 py-2.5 text-[14px] font-bold text-white transition-colors hover:bg-[#31167D]">
                    Add Product <span class="ml-2 text-lg leading-none">+</span>
                </a>
            </div>
        </form>

        @if ($showProductForm)
            <form method="POST" action="{{ $productAction }}" enctype="multipart/form-data" class="mb-8 rounded-xl border border-gray-100 bg-[#FAFAFA] p-6">
                @csrf
                @if ($editingProduct)
                    @method('PUT')
                @endif

                <div class="mb-5 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-[18px] font-bold text-[#1E1B4B]">{{ $editingProduct ? 'Edit Product' : 'Add Product' }}</h2>
                        <p class="mt-1 text-[13px] text-[#6B7280]">Saved products will appear in your booth profile.</p>
                    </div>
                    <a href="{{ route('company.booth-setup.products.index', $booking) }}" class="text-[13px] font-bold text-[#3D1B9B] hover:underline">Close</a>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                    <div class="lg:col-span-4">
                        <label class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Product Image</label>
                        <label class="flex h-[190px] cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-[#8B5CF6] bg-white p-4 hover:bg-purple-50">
                            <img id="product-image-preview" src="{{ $productImageUrl }}" class="mb-3 h-20 w-28 rounded-lg object-cover" alt="Product preview">
                            <span class="text-center text-[13px] font-medium text-[#3D1B9B]">Click to upload PNG or JPG</span>
                            <input id="product-image-input" type="file" name="product_image" class="hidden" accept="image/*">
                        </label>
                    </div>

                    <div class="grid grid-cols-1 gap-5 lg:col-span-8 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Product Name <span class="text-red-500">*</span></span>
                            <input type="text" name="name" value="{{ old('name', $editingProduct?->name) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#111827] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Category</span>
                            <input type="text" name="category" value="{{ old('category', $editingProduct?->category) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#111827] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Status <span class="text-red-500">*</span></span>
                            <select name="status" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] text-[#111827] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                                <option value="draft" @selected(old('status', $editingProduct?->status ?? 'published') === 'draft')>Draft</option>
                                <option value="published" @selected(old('status', $editingProduct?->status ?? 'published') === 'published')>Published</option>
                            </select>
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Sort Order</span>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $editingProduct?->sort_order ?? 0) }}" min="0" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#111827] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        </label>
                        <label class="block md:col-span-2">
                            <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Short Description</span>
                            <textarea name="short_description" rows="2" class="w-full rounded-lg border border-gray-200 px-4 py-3 text-[14px] text-[#6B7280] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">{{ old('short_description', $editingProduct?->short_description) }}</textarea>
                        </label>
                        <label class="block md:col-span-2">
                            <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Detailed Description</span>
                            <textarea name="detailed_description" rows="4" class="w-full rounded-lg border border-gray-200 px-4 py-3 text-[14px] text-[#6B7280] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">{{ old('detailed_description', $editingProduct?->detailed_description) }}</textarea>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-[#3D1B9B] px-8 py-3 text-[15px] font-bold text-white shadow-md transition-colors hover:bg-[#31167D] sm:w-auto">
                        {{ $editingProduct ? 'Update Product' : 'Save Product' }}
                    </button>
                </div>
            </form>
        @endif

        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white">
            @forelse ($products as $item)
                @php
                    $imageUrl = \App\Support\MediaUrl::url($item->product_image, 'assets/exhibition/images/booth_banner.png');
                    $statusClasses = $item->status === 'published'
                        ? 'bg-emerald-50 border-emerald-200 text-[#10B981]'
                        : 'bg-amber-50 border-amber-200 text-amber-700';
                @endphp
                <div class="grid grid-cols-1 items-center gap-6 border-b border-gray-100 p-6 last:border-b-0 md:grid-cols-12">
                    <a href="{{ route('company.booth-setup.products.edit', [$booking, $item]) }}" class="flex items-center space-x-5 md:col-span-6">
                        <img src="{{ $imageUrl }}" class="h-20 w-28 flex-shrink-0 rounded-lg border border-gray-100 object-cover" alt="{{ $item->name }}">
                        <div>
                            <h4 class="mb-1 text-[15px] font-bold text-[#1E1B4B]">{{ $item->name }}</h4>
                            <p class="pr-4 text-[13px] leading-relaxed text-[#6B7280]">{{ $item->short_description ?: 'No short description added.' }}</p>
                        </div>
                    </a>
                    <div class="md:col-span-2">
                        <p class="mb-1 text-[13px] text-[#6B7280]">Category</p>
                        <p class="text-[14px] font-semibold text-[#3D1B9B]">{{ $item->category ?: 'Uncategorized' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="mb-1 text-[13px] text-[#6B7280]">Status</p>
                        <span class="inline-flex rounded-md border px-3 py-1 text-[12px] font-semibold {{ $statusClasses }}">{{ ucfirst($item->status) }}</span>
                    </div>
                    <div class="md:col-span-1">
                        <p class="mb-1 text-[13px] text-[#6B7280]">Views</p>
                        <p class="text-[16px] font-bold text-[#1E1B4B]">{{ number_format($item->views ?? 0) }}</p>
                    </div>
                    <div class="flex justify-end gap-2 md:col-span-1">
                        <a href="{{ route('company.booth-setup.products.edit', [$booking, $item]) }}" class="rounded-full p-2 text-[#3D1B9B] transition-colors hover:bg-purple-50" title="Edit product">
                            <i class="ph ph-pencil-simple text-xl"></i>
                        </a>
                        <form method="POST" action="{{ route('company.booth-setup.products.destroy', [$booking, $item]) }}" onsubmit="return confirm('Delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full p-2 text-red-500 transition-colors hover:bg-red-50" title="Delete product">
                                <i class="ph ph-trash text-xl"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <h3 class="text-[18px] font-bold text-[#1E1B4B]">No products added yet</h3>
                    <p class="mt-2 text-[14px] text-[#6B7280]">Use Add Product to create your first booth product.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 flex flex-col gap-4 pt-4 md:flex-row md:items-center md:justify-between">
            <p class="text-[14px] text-[#6B7280]">
                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
            </p>
            <div class="flex items-center justify-end">
                {{ $products->links() }}
            </div>
        </div>

        <div class="mt-10 flex justify-end border-t border-gray-100 pt-8">
            <a href="{{ route('company.booth-setup.documents.index', $booking) }}" class="inline-flex items-center rounded-lg bg-[#3D1B9B] px-8 py-3 text-[15px] font-bold text-white shadow-md transition-colors hover:bg-[#31167D]">
                Save & Continue
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    (() => {
        const input = document.getElementById('product-image-input');
        const preview = document.getElementById('product-image-preview');

        input?.addEventListener('change', () => {
            const file = input.files?.[0];
            if (!file || !preview) {
                return;
            }

            preview.src = URL.createObjectURL(file);
        });
    })();
</script>
@endpush

