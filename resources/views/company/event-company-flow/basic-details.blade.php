@extends('layouts.company-event')

@section('title', 'Event Basic Details | eproexpo')

@push('styles')
<style>
/* Custom select styling to match image */
        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }
        .custom-date {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }
</style>
@endpush

@section('content')
@php
    $eventCategories = $eventCategories ?? [];
    $eventSubCategories = $eventSubCategories ?? [];
    $eventTimezones = $eventTimezones ?? [];
    $selectedCategory = old('category', filled($companyEvent->category) ? $companyEvent->category : ($eventCategories[0]['name'] ?? 'Technology'));
    $selectedSubCategory = old('sub_category', $companyEvent->sub_category ?: 'Other');
    $selectedTimezone = old('timezone', $companyEvent->timezone ?: 'Asia/Kolkata');
    $organizerName = $currentCompany?->contact_person_name ?? $currentCompany?->owner_name ?? $currentCompany?->company_name ?? $currentCompany?->name ?? '';
    $organizerEmail = $currentCompany?->email ?? '';
    $organizerPhone = $currentCompany?->phone ?? '';
@endphp
<div class="mx-auto w-full max-w-[1280px] px-4 py-6 sm:px-6 md:px-10 md:py-8">
            <!-- Header Title -->
            <div class="mb-10">
                <h1 class="text-[22px] font-bold tracking-tight text-textMain">Event Basic Details</h1>
            </div>

            <!-- Form Card -->
            <div class="border border-gray-100 rounded-[20px] p-4 md:p-8 bg-white shadow-[0_2px_10px_rgba(0,0,0,0.01)]">
                <form id="basic-details-form" method="POST" action="{{ route('company.event-company-flow.basic.update', $companyEvent) }}" class="flex flex-col gap-8">
                    @csrf
                    <input type="hidden" name="next" value="branding">
                    <input type="hidden" name="event_mode" value="{{ old('event_mode', $companyEvent->event_mode ?: 'in_person') }}">
                    <input type="hidden" name="event_type" value="{{ old('event_type', $companyEvent->event_type ?: 'in_person') }}">
                    <!-- Row 1: Name, Category, Sub-Category -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[13px] font-bold text-textMain">Event Name <span class="text-red-500">*</span></label>
                            <input id="event-name" name="title" type="text" value="{{ old('title', $companyEvent->title === 'Untitled Company Event' ? '' : $companyEvent->title) }}" required class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm" />
                        </div>
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[13px] font-bold text-textMain">Event Category <span class="text-red-500">*</span></label>
                            <select id="event-category" name="category" class="custom-select px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm bg-white cursor-pointer">
                                @foreach ($eventCategories as $category)
                                    <option value="{{ $category['name'] }}" @selected($selectedCategory === $category['name'])>{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[13px] font-bold text-textMain">Event Sub-Category</label>
                            <select id="event-subcategory" name="sub_category" class="custom-select px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm bg-white cursor-pointer">
                                @foreach ($eventSubCategories as $subCategory)
                                    <option value="{{ $subCategory }}" @selected($selectedSubCategory === $subCategory)>{{ $subCategory }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Row 2: Dates, Timezone -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[13px] font-bold text-textMain">Start Date <span class="text-red-500">*</span></label>
                            <input id="start-date" name="starts_at" type="datetime-local" value="{{ old('starts_at', optional($companyEvent->starts_at)->format('Y-m-d\TH:i')) }}" class="custom-date px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm cursor-pointer" />
                        </div>
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[13px] font-bold text-textMain">End Date <span class="text-red-500">*</span></label>
                            <input id="end-date" name="ends_at" type="datetime-local" value="{{ old('ends_at', optional($companyEvent->ends_at)->format('Y-m-d\TH:i')) }}" class="custom-date px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm cursor-pointer" />
                        </div>
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[13px] font-bold text-textMain">Time Zone</label>
                            <select id="timezone" name="timezone" class="custom-select px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm bg-white cursor-pointer">
                                @foreach ($eventTimezones as $timezone)
                                    <option value="{{ $timezone['value'] }}" @selected($selectedTimezone === $timezone['value'])>{{ $timezone['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Row 3: Event Mode -->
                    <div class="flex flex-col gap-4 mt-2">
                        <label class="text-[13px] font-bold text-textMain">Event Mode <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-8">
                            <label class="flex items-center gap-2.5 cursor-default">
                                <div class="w-4 h-4 rounded-full border border-primary flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 rounded-full bg-primary"></div>
                                </div>
                                <span class="text-[14px] text-textMain font-medium">In-Person (Offline)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Row 4: Venue & Website -->
                    <div class="grid grid-cols-1 md:grid-cols-[1.2fr_1fr] gap-6 mt-2">
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[13px] font-bold text-textMain">Venue / Location <span class="text-red-500">*</span></label>
                            <input id="venue" name="venue_address" type="text" value="{{ old('venue_address', $companyEvent->venue_address) }}" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm" />
                        </div>
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[13px] font-bold text-textMain">Event Website</label>
                            <input id="website" name="website" type="url" value="{{ old('website', $companyEvent->website) }}" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm" />
                        </div>
                    </div>

                    <!-- Row 5: Description -->
                    <div class="flex flex-col gap-2.5 mt-2 relative">
                        <label class="text-[13px] font-bold text-textMain">Short Description <span class="text-red-500">*</span></label>
                        <textarea id="description" name="summary" rows="4" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm resize-none">{{ old('summary', $companyEvent->summary) }}</textarea>
                        <span id="char-counter" class="absolute bottom-3 right-4 text-[11px] text-gray-400 font-medium">143/200</span>
                    </div>

                    <!-- Row 6: Organizer Contact Section -->
                    <div class="mt-6">
                        <h3 class="text-[15px] font-bold text-textMain mb-5">Organizer Contact</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="flex flex-col gap-2.5">
                                <label class="text-[13px] font-bold text-textMain">Name</label>
                                <input id="org-name" type="text" value="{{ $organizerName }}" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm" />
                            </div>
                            <div class="flex flex-col gap-2.5">
                                <label class="text-[13px] font-bold text-textMain">Email</label>
                                <input id="org-email" type="text" value="{{ $organizerEmail }}" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm" />
                            </div>
                            <div class="flex flex-col gap-2.5">
                                <label class="text-[13px] font-bold text-textMain">Phone</label>
                                <input id="org-phone" type="text" value="{{ $organizerPhone }}" class="px-4 py-3 border border-borderLight rounded-lg text-[13px] text-textMain w-full focus:outline-none focus:border-primary shadow-sm" />
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="flex justify-end mt-4">
                        <button type="submit" style="background-color: #5B32F6; color: #FFFFFF;" class="w-full sm:w-auto text-center px-8 py-3 rounded-lg text-[14px] font-semibold shadow-sm hover:bg-[#4a26d1] transition-colors focus:outline-none">Save & Continue</button>
                    </div>
                </form>
            </div>
            
        </div>
@endsection
