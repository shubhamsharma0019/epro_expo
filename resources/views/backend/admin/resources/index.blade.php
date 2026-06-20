@extends('layouts.admin')

@section('title', $pageTitle)
@section('page-title', $pageTitle)

@section('content')
    <section class="space-y-6 px-5 py-6 sm:px-8">
        @if (session('status'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-[14px] font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h2 class="text-[28px] font-bold text-[#0B132C]">{{ $pageTitle }}</h2>
                <p class="mt-2 text-[14px] text-gray-500">{{ $pageDescription }}</p>
            </div>
            @if ($createUrl && $createLabel)
                <a href="{{ $createUrl }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#3723db] px-5 text-[14px] font-semibold text-white transition hover:bg-[#2515a6]">
                    {{ $createLabel }}
                </a>
            @endif
        </div>

        @if (! empty($stats))
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($stats as $stat)
                    <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                        <p class="text-[12px] font-semibold uppercase tracking-[0.16em] text-gray-400">{{ $stat['label'] }}</p>
                        <p class="mt-3 text-[28px] font-bold text-[#0B132C]">{{ $stat['value'] }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <form method="GET" class="flex flex-col gap-4 rounded-2xl border border-gray-100 bg-white p-4 shadow-sm lg:flex-row lg:items-center">
            <div class="flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search..."
                    class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]"
                >
            </div>
            @if (! empty($filters))
                <div class="lg:w-[220px]">
                    <select name="status" class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]">
                        @foreach ($filters as $optionValue => $label)
                            <option value="{{ $optionValue }}" @selected($status === $optionValue)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <button type="submit" class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-200 px-5 text-[14px] font-semibold text-[#0B132C] transition hover:bg-gray-50">
                Filter
            </button>
        </form>

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[980px] divide-y divide-gray-100">
                    <thead class="bg-[#F8F9FC]">
                        <tr>
                            @foreach ($columns as $column)
                                <th class="px-3 py-3 text-left text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap">{{ $column }}</th>
                            @endforeach
                            @php $hasActions = collect($rows instanceof \Illuminate\Pagination\AbstractPaginator ? $rows->items() : $rows)->contains(fn ($row) => ! empty($row['actions'] ?? [])); @endphp
                            @if ($hasActions)
                                <th class="w-[210px] px-3 py-3 text-right text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse (($rows instanceof \Illuminate\Pagination\AbstractPaginator ? $rows->items() : $rows) as $row)
                            <tr class="hover:bg-gray-50/80">
                                @foreach ($row['cells'] as $cell)
                                    <td class="px-3 py-3 text-[14px] text-[#0B132C] align-middle">{!! $cell !!}</td>
                                @endforeach
                                @if ($hasActions)
                                    <td class="w-[210px] px-3 py-3 whitespace-nowrap">
                                        <div class="flex flex-nowrap items-center justify-end gap-2">
                                            @foreach (($row['actions'] ?? []) as $action)
                                                @if (($action['method'] ?? 'GET') === 'POST')
                                                    <form method="POST" action="{{ $action['href'] }}" class="shrink-0">
                                                        @csrf
                                                        <button type="submit" class="inline-flex h-9 items-center justify-center rounded-lg px-2.5 text-[12px] font-semibold whitespace-nowrap {{ ($action['variant'] ?? '') === 'danger' ? 'bg-rose-50 text-rose-700' : 'bg-green-50 text-green-700' }}">
                                                            {{ $action['label'] }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ $action['href'] }}" class="inline-flex h-9 shrink-0 items-center justify-center rounded-lg px-2.5 text-[12px] font-semibold text-[#3723db] whitespace-nowrap">
                                                        {{ $action['label'] }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
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
            <div class="rounded-2xl border border-gray-100 bg-white px-4 py-3 shadow-sm">
                {{ $rows->links() }}
            </div>
        @endif
    </section>
@endsection
