@extends('layouts.admin')

@section('title', $pageTitle)
@section('page-title', $pageTitle)

@section('content')
    <section class="admin-page-section px-5 py-6 sm:px-8">
        <div class="mx-auto w-full max-w-4xl rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6">
            <div class="mb-6">
                <h2 class="admin-page-title font-bold text-[#0B132C]">{{ $pageTitle }}</h2>
                <p class="admin-page-description mt-2 text-gray-500">{{ $pageDescription }}</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-[14px] font-medium text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            @php
                $hasFileField = collect($fields)->contains(fn ($field) => ($field['type'] ?? 'text') === 'file');
            @endphp

            <form method="POST" action="{{ $submitUrl }}" @if ($hasFileField) enctype="multipart/form-data" @endif class="space-y-5">
                @csrf
                @if (($method ?? 'POST') !== 'POST')
                    @method($method)
                @endif
                <div class="grid gap-5 md:grid-cols-2">
                    @foreach ($fields as $field)
                        <div class="{{ in_array(($field['type'] ?? 'text'), ['textarea', 'file', 'info'], true) ? 'md:col-span-2' : '' }}">
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
                            @elseif (($field['type'] ?? 'text') === 'file')
                                <input
                                    type="file"
                                    name="{{ $field['name'] }}"
                                    @if (! empty($field['accept'])) accept="{{ $field['accept'] }}" @endif
                                    @if (! empty($field['required'])) required @endif
                                    class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-[14px] text-[#0B132C] file:mr-4 file:rounded-lg file:border-0 file:bg-[#F4F2FF] file:px-4 file:py-2 file:text-[13px] file:font-semibold file:text-[#3723db]"
                                >
                                @if (! empty($field['help']))
                                    <p class="mt-2 text-[12px] text-gray-500">{{ $field['help'] }}</p>
                                @endif
                                @if (! empty($field['value']))
                                    <img src="{{ asset($field['value']) }}" alt="Current upload" class="mt-3 h-28 w-full max-w-md rounded-xl border border-gray-100 object-cover">
                                @endif
                            @elseif (($field['type'] ?? 'text') === 'info')
                                <div class="rounded-xl border border-[#E6E1FF] bg-[#F9F8FF] px-4 py-3 text-[14px] font-semibold text-[#0B132C]">
                                    {{ $field['value'] ?? '' }}
                                </div>
                                @if (! empty($field['help']))
                                    <p class="mt-2 text-[12px] text-gray-500">{{ $field['help'] }}</p>
                                @endif
                            @elseif (($field['type'] ?? 'text') === 'select')
                                <select
                                    name="{{ $field['name'] }}"
                                    class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]"
                                >
                                    @foreach (($field['options'] ?? []) as $optionValue => $optionLabel)
                                        <option value="{{ $optionValue }}" @selected((string) old($field['name'], $field['value'] ?? '') === (string) $optionValue)>{{ $optionLabel }}</option>
                                    @endforeach
                                </select>
                                @if (! empty($field['help']))
                                    <p class="mt-2 text-[12px] text-gray-500">{{ $field['help'] }}</p>
                                @endif
                            @else
                                <input
                                    type="{{ $field['type'] ?? 'text' }}"
                                    name="{{ $field['name'] }}"
                                    value="{{ old($field['name'], $field['value'] ?? '') }}"
                                    @if (! empty($field['placeholder'])) placeholder="{{ $field['placeholder'] }}" @endif
                                    @if (! empty($field['step'])) step="{{ $field['step'] }}" @endif
                                    @if (! empty($field['min'])) min="{{ $field['min'] }}" @endif
                                    @if (! empty($field['max'])) max="{{ $field['max'] }}" @endif
                                    @if (! empty($field['required'])) required @endif
                                    class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]"
                                >
                                @if (! empty($field['help']))
                                    <p class="mt-2 text-[12px] text-gray-500">{{ $field['help'] }}</p>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="admin-form-actions flex justify-end gap-3 pt-2">
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

    @if (! empty($hallNextBoothNumbers))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const nextNumbers = @json($hallNextBoothNumbers);
                const hallSelect = document.querySelector('select[name="hall_id"]');
                const numberInput = document.querySelector('input[name="booth_number"]');

                if (! hallSelect || ! numberInput) {
                    return;
                }

                const applyNextNumber = () => {
                    const hallId = hallSelect.value;

                    if (hallId && nextNumbers[hallId]) {
                        numberInput.value = nextNumbers[hallId];
                    }
                };

                hallSelect.addEventListener('change', applyNextNumber);
                applyNextNumber();
            });
        </script>
    @endif
@endsection
