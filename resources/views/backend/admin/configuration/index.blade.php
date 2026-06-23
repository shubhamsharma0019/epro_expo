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

        <div>
            <h2 class="text-[28px] font-bold text-[#0B132C]">{{ $pageTitle }}</h2>
            <p class="mt-2 text-[14px] text-gray-500">{{ $pageDescription }}</p>
        </div>

        <form method="POST" action="{{ $submitUrl }}" class="space-y-6">
            @csrf

            @foreach ($sections as $section)
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="mb-5">
                        <h3 class="text-[18px] font-bold text-[#0B132C]">{{ $section['title'] }}</h3>
                        <p class="mt-1 text-[13px] text-gray-500">{{ $section['description'] }}</p>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        @foreach ($section['fields'] as $field)
                            <div class="{{ ($field['type'] ?? 'text') === 'textarea' ? 'md:col-span-2' : '' }}">
                                <label class="mb-2 block text-[13px] font-semibold text-[#0B132C]">
                                    {{ $field['label'] }}
                                </label>

                                @if (($field['type'] ?? 'text') === 'textarea')
                                    <textarea
                                        name="settings[{{ $field['key'] }}]"
                                        rows="4"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]"
                                    >{{ old('settings.' . $field['key'], $field['value'] ?? '') }}</textarea>
                                @elseif (($field['type'] ?? 'text') === 'select')
                                    <select
                                        name="settings[{{ $field['key'] }}]"
                                        class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]"
                                    >
                                        @foreach (($field['options'] ?? []) as $optionValue => $optionLabel)
                                            <option value="{{ $optionValue }}" @selected((string) old('settings.' . $field['key'], $field['value'] ?? '') === (string) $optionValue)>
                                                {{ $optionLabel }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input
                                        type="{{ $field['type'] ?? 'text' }}"
                                        name="settings[{{ $field['key'] }}]"
                                        value="{{ old('settings.' . $field['key'], $field['value'] ?? '') }}"
                                        class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]"
                                    >
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="admin-form-actions flex justify-end">
                <button type="submit" class="inline-flex h-11 items-center justify-center rounded-xl bg-[#3723db] px-5 text-[14px] font-semibold text-white transition hover:bg-[#2515a6]">
                    {{ $submitLabel }}
                </button>
            </div>
        </form>
    </section>
@endsection
