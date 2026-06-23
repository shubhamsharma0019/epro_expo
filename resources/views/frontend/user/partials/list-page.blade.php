@extends('layouts.user')

@section('title', $title)
@section('page-title', $title)

@section('content')
@php
    $variant = $variant ?? 'cards';
    $items = $items ?? [];
@endphp

<section class="space-y-6 px-4 py-6 sm:px-8">
    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <p class="text-[12px] font-semibold uppercase tracking-[0.14em] text-gray-400">{{ $eyebrow ?? 'Visitor' }}</p>
        <h1 class="mt-2 text-[26px] font-bold text-[#0B132C] sm:text-[30px]">{{ $title }}</h1>
        <p class="mt-2 max-w-2xl text-[14px] text-gray-500">{{ $description }}</p>
        <p class="mt-4 text-[13px] font-semibold text-[#3723db]">{{ count($items) }} {{ count($items) === 1 ? 'record' : 'records' }}</p>
    </div>

    @if ($variant === 'ticket')
        <div class="grid gap-4 xl:grid-cols-2">
            @forelse ($items as $item)
                @php
                    [$name, $meta, $status, $href] = array_pad($item, 4, '');
                @endphp
                <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <h2 class="text-[18px] font-bold text-[#0B132C]">{{ $name }}</h2>
                    <p class="mt-2 text-[14px] text-gray-500">{{ $meta }}</p>
                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-[12px] font-semibold text-emerald-700">{{ $status }}</span>
                        <a href="{{ $href }}" class="text-[13px] font-semibold text-[#3723db]">View details</a>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-gray-200 bg-white px-6 py-12 text-center">
                    <p class="text-[15px] font-bold text-[#0B132C]">No records found</p>
                    <p class="mt-2 text-[13px] text-gray-500">Your tickets and passes will appear here.</p>
                </div>
            @endforelse
        </div>
    @elseif ($variant === 'visit')
        <div class="space-y-3">
            @forelse ($items as [$name, $meta, $status, $href])
                <article class="flex flex-col gap-4 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <h2 class="text-[17px] font-bold text-[#0B132C]">{{ $name }}</h2>
                        <p class="mt-1 text-[14px] text-gray-500">{{ $meta }}</p>
                    </div>
                    <div class="flex shrink-0 items-center gap-3">
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-[12px] font-semibold text-gray-600">{{ $status }}</span>
                        <a href="{{ $href }}" class="inline-flex h-9 items-center justify-center rounded-lg bg-[#3723db] px-4 text-[13px] font-semibold text-white">View</a>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-gray-200 bg-white px-6 py-12 text-center">
                    <p class="text-[15px] font-bold text-[#0B132C]">No visit history yet</p>
                    <p class="mt-2 text-[13px] text-gray-500">Register for an exhibition to see your visits here.</p>
                </div>
            @endforelse
        </div>
    @else
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($items as [$name, $meta, $status, $href])
                <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <h2 class="text-[17px] font-bold text-[#0B132C]">{{ $name }}</h2>
                    <p class="mt-2 text-[14px] text-gray-500">{{ $meta }}</p>
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <span class="rounded-full bg-[#F4F2FF] px-3 py-1 text-[12px] font-semibold text-[#3723db]">{{ $status }}</span>
                        <a href="{{ $href }}" class="text-[13px] font-semibold text-[#3723db]">Open</a>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-gray-200 bg-white px-6 py-12 text-center">
                    <p class="text-[15px] font-bold text-[#0B132C]">Nothing here yet</p>
                    <p class="mt-2 text-[13px] text-gray-500">Browse exhibitions to get started.</p>
                </div>
            @endforelse
        </div>
    @endif
</section>
@endsection
