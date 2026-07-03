@extends('layouts.admin')

@section('title', $pageTitle)
@section('page-title', $pageTitle)

@section('content')
    @php
        $rowItems = $rows instanceof \Illuminate\Pagination\AbstractPaginator ? $rows->items() : $rows;
        $hasActions = collect($rowItems)->contains(fn ($row) => ! empty($row['actions'] ?? []));
    @endphp

    <section class="admin-page-section space-y-6 px-5 py-6 sm:px-8">
        @if (session('status'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-[14px] font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="min-w-0">
                <h2 class="admin-page-title font-bold text-[#0B132C]">{{ $pageTitle }}</h2>
                <p class="admin-page-description mt-2 text-gray-500">{{ $pageDescription }}</p>
            </div>
            @if ($createUrl && $createLabel)
                <a href="{{ $createUrl }}" class="inline-flex h-11 w-full items-center justify-center rounded-xl bg-[#3723db] px-5 text-[14px] font-semibold text-white transition hover:bg-[#2515a6] sm:w-auto">
                    {{ $createLabel }}
                </a>
            @endif
        </div>

        @if (! empty($stats))
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($stats as $stat)
                    <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                        <p class="text-[12px] font-semibold uppercase tracking-[0.16em] text-gray-400">{{ $stat['label'] }}</p>
                        <p class="admin-stat-value mt-3 font-bold text-[#0B132C]">{{ $stat['value'] }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <form method="GET" class="flex flex-col gap-3 rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:gap-4 lg:flex-row lg:items-center">
            <div class="min-w-0 flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search..."
                    class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]"
                >
            </div>
            @if (! empty($filters))
                <div class="w-full lg:w-[220px]">
                    <select name="status" class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]">
                        @foreach ($filters as $optionValue => $label)
                            <option value="{{ $optionValue }}" @selected($status === $optionValue)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <button type="submit" class="inline-flex h-11 w-full items-center justify-center rounded-xl border border-gray-200 px-5 text-[14px] font-semibold text-[#0B132C] transition hover:bg-gray-50 sm:w-auto">
                Filter
            </button>
        </form>

        <div class="space-y-3 lg:hidden">
            @forelse ($rowItems as $row)
                <article class="admin-mobile-card rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <div class="space-y-3">
                        @foreach ($columns as $index => $column)
                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-400">{{ $column }}</p>
                                <div class="mt-1 break-words text-[14px] text-[#0B132C]">{!! $row['cells'][$index] ?? '' !!}</div>
                            </div>
                        @endforeach
                    </div>

                    @if ($hasActions && ! empty($row['actions']))
                        <div class="mt-4 border-t border-gray-100 pt-4">
                            @include('admin.resources.partials.row-actions', ['actions' => $row['actions'], 'variant' => 'mobile'])
                        </div>
                    @endif
                </article>
            @empty
                <div class="rounded-2xl border border-gray-100 bg-white px-4 py-8 text-center text-[14px] text-gray-500 shadow-sm">
                    No records found.
                </div>
            @endforelse
        </div>

        <div class="hidden overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm lg:block">
            <div class="admin-table-scroll">
                <table class="divide-y divide-gray-100">
                    <thead class="bg-[#F8F9FC]">
                        <tr>
                            @foreach ($columns as $column)
                                <th class="whitespace-nowrap px-3 py-3 text-left text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500">{{ $column }}</th>
                            @endforeach
                            @if ($hasActions)
                                <th class="min-w-[280px] whitespace-nowrap px-3 py-3 text-right text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($rowItems as $row)
                            <tr class="hover:bg-gray-50/80">
                                @foreach ($row['cells'] as $cell)
                                    <td class="px-3 py-3 align-middle text-[14px] text-[#0B132C]">{!! $cell !!}</td>
                                @endforeach
                                @if ($hasActions)
                                    <td class="min-w-[280px] px-3 py-3 align-middle">
                                        @if (! empty($row['actions']))
                                            @include('admin.resources.partials.row-actions', ['actions' => $row['actions'], 'variant' => 'desktop'])
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) + ($hasActions ? 1 : 0) }}" class="px-4 py-8 text-center text-[14px] text-gray-500">
                                    No records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($rows instanceof \Illuminate\Pagination\AbstractPaginator)
            <div class="admin-pagination rounded-2xl border border-gray-100 bg-white px-4 py-3 shadow-sm">
                {{ $rows->links() }}
            </div>
        @endif
    </section>
@endsection
