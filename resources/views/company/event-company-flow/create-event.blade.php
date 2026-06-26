@extends('layouts.company-event')

@section('title', 'Create Event | eproexpo')

@section('content')
@php
    $eventTemplates = $eventTemplates ?? [];
    $eventCategories = $eventCategories ?? [];
    $templateValues = collect($eventTemplates ?? [])->mapWithKeys(fn ($template) => [$template['key'] => $template['values']])->all();
    $defaultCategory = $eventCategories[0]['name'] ?? 'Technology';
    $selectedCategory = old('category', filled($companyEvent->category) ? $companyEvent->category : $defaultCategory);
    $templateUi = [
        'conference' => [
            'card' => 'relative group border border-gray-100 rounded-2xl p-4 sm:p-6 flex flex-col hover:shadow-[0_12px_30px_rgba(91,50,246,0.06)] hover:-translate-y-1 hover:border-primary/40 transition-all duration-300 bg-white',
            'icon' => 'w-11 h-11 rounded-xl bg-primary-light text-primary flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300',
            'title' => 'text-[14px] font-bold text-textMain mb-1.5 group-hover:text-primary transition-colors',
            'button' => 'w-full py-2.5 border border-[#5B32F6] bg-[#5B32F6] text-white text-[12px] font-bold rounded-xl hover:bg-[#4C10D0] hover:border-[#4C10D0] transition-all duration-200 shadow-sm',
        ],
        'expo' => [
            'card' => 'group border border-gray-100 rounded-2xl p-4 sm:p-6 flex flex-col hover:shadow-[0_12px_30px_rgba(91,50,246,0.06)] hover:-translate-y-1 hover:border-[#2563EB]/40 transition-all duration-300 bg-white',
            'icon' => 'w-11 h-11 rounded-xl bg-[#EFF6FF] text-[#2563EB] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300',
            'title' => 'text-[14px] font-bold text-textMain mb-1.5 group-hover:text-[#2563EB] transition-colors',
            'button' => 'w-full py-2.5 border border-[#5B32F6] bg-[#5B32F6] text-white text-[12px] font-bold rounded-xl hover:bg-[#4C10D0] hover:border-[#4C10D0] transition-all duration-200 shadow-sm',
        ],
        'seminar' => [
            'card' => 'group border border-gray-100 rounded-2xl p-4 sm:p-6 flex flex-col hover:shadow-[0_12px_30px_rgba(91,50,246,0.06)] hover:-translate-y-1 hover:border-[#059669]/40 transition-all duration-300 bg-white',
            'icon' => 'w-11 h-11 rounded-xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300',
            'title' => 'text-[14px] font-bold text-textMain mb-1.5 group-hover:text-[#059669] transition-colors',
            'button' => 'w-full py-2.5 border border-[#5B32F6] bg-[#5B32F6] text-white text-[12px] font-bold rounded-xl hover:bg-[#4C10D0] hover:border-[#4C10D0] transition-all duration-200 shadow-sm',
        ],
        'networking' => [
            'card' => 'group border border-gray-100 rounded-2xl p-4 sm:p-6 flex flex-col hover:shadow-[0_12px_30px_rgba(91,50,246,0.06)] hover:-translate-y-1 hover:border-[#EA580C]/40 transition-all duration-300 bg-white',
            'icon' => 'w-11 h-11 rounded-xl bg-[#FFF7ED] text-[#EA580C] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300',
            'title' => 'text-[14px] font-bold text-textMain mb-1.5 group-hover:text-[#EA580C] transition-colors',
            'button' => 'w-full py-2.5 border border-[#5B32F6] bg-[#5B32F6] text-white text-[12px] font-bold rounded-xl hover:bg-[#4C10D0] hover:border-[#4C10D0] transition-all duration-200 shadow-sm',
        ],
        'custom' => [
            'card' => 'group border border-gray-100 rounded-2xl p-4 sm:p-6 flex flex-col hover:shadow-[0_12px_30px_rgba(91,50,246,0.06)] hover:-translate-y-1 hover:border-gray-400 transition-all duration-300 bg-white',
            'icon' => 'w-11 h-11 rounded-xl bg-gray-50 text-gray-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300',
            'title' => 'text-[14px] font-bold text-textMain mb-1.5 group-hover:text-gray-700 transition-colors',
            'button' => 'w-full py-2.5 border border-[#5B32F6] bg-[#5B32F6] text-white text-[12px] font-bold rounded-xl hover:bg-[#4C10D0] hover:border-[#4C10D0] transition-all duration-200 shadow-sm',
        ],
    ];
@endphp

<form id="company-event-create-form" method="POST" action="{{ route('company.event-company-flow.create.store') }}" class="hidden">
    @csrf
    <input id="create-event-type" type="hidden" name="event_type" value="{{ old('event_type', $companyEvent->event_type ?: 'in_person') }}">
    <input id="create-event-mode" type="hidden" name="event_mode" value="{{ old('event_mode', $companyEvent->event_mode ?: 'in_person') }}">
    <input id="create-event-category" type="hidden" name="category" value="{{ old('category', $selectedCategory) }}">
    <input id="create-sub-category" type="hidden" name="sub_category" value="{{ old('sub_category', $companyEvent->sub_category ?: 'Other') }}">
    <input id="create-title" type="hidden" name="title" value="{{ old('title', $companyEvent->title === 'Untitled Company Event' ? 'Global Innovation Summit 2026' : $companyEvent->title) }}">
    <input id="create-starts-at" type="hidden" name="starts_at" value="{{ old('starts_at', optional($companyEvent->starts_at)->format('Y-m-d H:i:s')) }}">
    <input id="create-ends-at" type="hidden" name="ends_at" value="{{ old('ends_at', optional($companyEvent->ends_at)->format('Y-m-d H:i:s')) }}">
    <input id="create-timezone" type="hidden" name="timezone" value="{{ old('timezone', $companyEvent->timezone ?: 'Asia/Kolkata') }}">
    <input id="create-venue-name" type="hidden" name="venue_name" value="{{ old('venue_name', $companyEvent->venue_name) }}">
    <input id="create-venue-address" type="hidden" name="venue_address" value="{{ old('venue_address', $companyEvent->venue_address) }}">
    <input id="create-city" type="hidden" name="city" value="{{ old('city', $companyEvent->city) }}">
    <input id="create-country" type="hidden" name="country" value="{{ old('country', $companyEvent->country) }}">
    <input id="create-website" type="hidden" name="website" value="{{ old('website', $companyEvent->website) }}">
    <input id="create-summary" type="hidden" name="summary" value="{{ old('summary', $companyEvent->summary) }}">
    <input id="create-description" type="hidden" name="description" value="{{ old('description', $companyEvent->description) }}">
    <input type="hidden" name="next" value="branding">
</form>

<div class="px-4 py-6 sm:px-6 md:px-10 md:py-8">
    <div class="mb-8">
        <h1 class="text-[22px] sm:text-[24px] font-bold tracking-tight text-[#1C1364]">Create New Event</h1>
    </div>

    <div class="border border-gray-100 rounded-[16px] sm:rounded-[20px] p-4 sm:p-6 md:p-8 bg-white shadow-[0_2px_10px_rgba(0,0,0,0.01)]">
        <div class="mb-10">
            <h3 class="text-[15px] font-bold mb-4">Event Type</h3>
            <div class="max-w-md">
                <div class="border border-primary/30 bg-gradient-to-br from-primary-light/60 to-primary-light/20 rounded-2xl p-5 sm:p-6 relative overflow-hidden transition-all shadow-[0_4px_20px_rgba(91,50,246,0.04)]">
                    <div class="absolute top-0 right-0 bg-primary text-white text-[10px] font-extrabold px-3.5 py-1.5 rounded-bl-xl uppercase tracking-wider">
                        Selected
                    </div>
                    <div class="flex flex-col gap-4 min-[420px]:flex-row min-[420px]:items-start">
                        <div class="w-12 h-12 rounded-xl bg-primary text-white flex items-center justify-center shrink-0 shadow-md shadow-primary/20">
                            <svg class="w-6 h-6 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <div class="pr-0 min-[420px]:pr-12">
                            <h4 class="text-[15px] font-bold text-textMain mb-1.5">Offline / In-Person Event</h4>
                            <p class="text-[13px] text-textMuted leading-relaxed">Host your event at a physical venue. Participants will attend in person at the specified location.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-10">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="text-[15px] font-bold">Start from Template</h3>
                <span class="text-[12px] text-textMuted font-medium">Choose a pre-filled layout to save time</span>
            </div>
            <div class="grid grid-cols-1 min-[520px]:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4 md:gap-5">
                @foreach ($eventTemplates as $template)
                    @php
                        $ui = $templateUi[$template['key']] ?? $templateUi['custom'];
                    @endphp
                    <div class="{{ $ui['card'] }}">
                        @if ($template['badge'])
                            <div class="absolute -top-2.5 left-4 bg-gradient-to-r from-orange-500 to-amber-500 text-white text-[9px] font-extrabold px-2.5 py-0.5 rounded-full shadow-sm uppercase tracking-wider">
                                {{ $template['badge'] }}
                            </div>
                        @endif
                        <div class="{{ $ui['icon'] }}">
                            <svg class="w-5.5 h-5.5 stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $template['icon'] }}"></path></svg>
                        </div>
                        <h4 class="{{ $ui['title'] }}">{{ $template['title'] }}</h4>
                        <p class="text-[12px] text-textMuted leading-relaxed flex-1 mb-5">{{ $template['copy'] }}</p>
                        <button type="button" onclick="useTemplate('{{ $template['key'] }}')" class="{{ $ui['button'] }}">Use Template</button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-4">
            <h3 class="text-[15px] font-bold mb-4">Event Category</h3>
            <div id="category-list" class="grid grid-cols-2 gap-3 sm:flex sm:flex-wrap">
                @foreach ($eventCategories as $category)
                    <button
                        type="button"
                        data-category="{{ $category['name'] }}"
                        class="category-chip min-h-11 px-3 sm:px-5 py-2.5 border text-[13px] rounded-[12px] shadow-sm flex items-center justify-center sm:justify-start gap-2 active:scale-95 transition-all duration-200 {{ $selectedCategory === $category['name'] ? 'border-2 border-primary text-primary bg-primary-light/50 font-bold' : 'border-gray-100 text-[#1C1364] font-semibold hover:border-primary hover:text-primary bg-white' }}"
                    >
                        <span>{{ $category['short'] }}</span> {{ $category['name'] }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const templateValues = @json($templateValues);
    const initialCategory = @json($selectedCategory);
    const categoryChipActiveClass = 'category-chip min-h-11 px-3 sm:px-5 py-2.5 border-2 border-primary text-primary bg-primary-light/50 text-[13px] font-bold rounded-[12px] shadow-sm flex items-center justify-center sm:justify-start gap-2 active:scale-95 transition-all duration-200';
    const categoryChipInactiveClass = 'category-chip min-h-11 px-3 sm:px-5 py-2.5 border border-gray-100 text-[#1C1364] text-[13px] font-semibold rounded-[12px] hover:border-primary hover:text-primary transition-all duration-200 bg-white shadow-sm flex items-center justify-center sm:justify-start gap-2 active:scale-95';

    function applyCategorySelection(category) {
        const hiddenInput = document.getElementById('create-event-category');
        if (hiddenInput) {
            hiddenInput.value = category;
        }

        document.querySelectorAll('#category-list .category-chip').forEach((button) => {
            const isActive = button.dataset.category === category;
            button.className = isActive ? categoryChipActiveClass : categoryChipInactiveClass;
        });
    }

    document.getElementById('category-list')?.addEventListener('click', (event) => {
        const button = event.target.closest('[data-category]');
        if (!button) {
            return;
        }

        applyCategorySelection(button.dataset.category);
    });

    applyCategorySelection(initialCategory);

    function useTemplate(type) {
        const values = templateValues[type] || templateValues.custom || {};
        const category = type === 'custom'
            ? (document.getElementById('create-event-category')?.value || initialCategory)
            : (values.category || document.getElementById('create-event-category')?.value || initialCategory);

        document.getElementById('create-title').value = values.title || 'Untitled Company Event';
        document.getElementById('create-event-category').value = category;
        applyCategorySelection(category);
        document.getElementById('create-sub-category').value = values.subCategory || 'Other';
        document.getElementById('create-starts-at').value = values.startsAt || '';
        document.getElementById('create-ends-at').value = values.endsAt || '';
        document.getElementById('create-timezone').value = values.timezone || 'Asia/Kolkata';
        document.getElementById('create-venue-name').value = values.venueName || '';
        document.getElementById('create-venue-address').value = values.venueAddress || '';
        document.getElementById('create-city').value = values.city || '';
        document.getElementById('create-country').value = values.country || '';
        document.getElementById('create-website').value = values.website || '';
        document.getElementById('create-summary').value = values.summary || '';
        document.getElementById('create-description').value = values.description || '';
        document.getElementById('company-event-create-form').submit();
    }
</script>
@endpush
