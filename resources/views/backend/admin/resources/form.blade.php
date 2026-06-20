@extends('layouts.admin')

@section('title', $pageTitle)
@section('page-title', $pageTitle)

@section('content')
    <section class="px-5 py-6 sm:px-8">
        <div class="mx-auto max-w-4xl rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="mb-6">
                <h2 class="text-[28px] font-bold text-[#0B132C]">{{ $pageTitle }}</h2>
                <p class="mt-2 text-[14px] text-gray-500">{{ $pageDescription }}</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-[14px] font-medium text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ $submitUrl }}" class="space-y-5">
                @csrf
                @if (($method ?? 'POST') !== 'POST')
                    @method($method)
                @endif
                <div class="grid gap-5 md:grid-cols-2">
                    @foreach ($fields as $field)
                        <div class="{{ ($field['type'] ?? 'text') === 'textarea' ? 'md:col-span-2' : '' }}">
                            <label class="mb-2 block text-[13px] font-semibold text-[#0B132C]">
                                {{ $field['label'] }}
                                @if (! empty($field['required']))
                                    <span class="text-rose-500">*</span>
                                @endif
                            </label>

                            @if (($field['type'] ?? 'text') === 'textarea')
                                <textarea
                                    name="{{ $field['name'] }}"
                                    rows="5"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]"
                                >{{ old($field['name'], $field['value'] ?? '') }}</textarea>
                            @elseif (($field['type'] ?? 'text') === 'select')
                                <select
                                    name="{{ $field['name'] }}"
                                    class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]"
                                >
                                    @foreach (($field['options'] ?? []) as $optionValue => $optionLabel)
                                        <option value="{{ $optionValue }}" @selected((string) old($field['name'], $field['value'] ?? '') === (string) $optionValue)>{{ $optionLabel }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input
                                    type="{{ $field['type'] ?? 'text' }}"
                                    name="{{ $field['name'] }}"
                                    value="{{ old($field['name'], $field['value'] ?? '') }}"
                                    @if (! empty($field['step'])) step="{{ $field['step'] }}" @endif
                                    class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]"
                                >
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ url()->previous() }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-gray-200 px-5 text-[14px] font-semibold text-[#0B132C] transition hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#3723db] px-5 text-[14px] font-semibold text-white transition hover:bg-[#2515a6]">
                        {{ $submitLabel }}
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
