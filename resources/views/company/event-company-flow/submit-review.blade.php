@extends('layouts.company-event')

@section('title', 'Submit Review | eproexpo')

@section('content')
@php
    use App\Support\CompanyEventFlowProgress;

    $ticketTypes = collect($ticketTypes ?? []);
    $eventBranding = $eventBranding ?? $companyEvent->branding;

    $eventDate = $companyEvent->starts_at
        ? $companyEvent->starts_at->format('M d') . ($companyEvent->ends_at ? ' - ' . $companyEvent->ends_at->format('d, Y') : ', ' . $companyEvent->starts_at->format('Y'))
        : 'Date TBD';
    $eventDays = $companyEvent->starts_at && $companyEvent->ends_at
        ? max(1, $companyEvent->starts_at->copy()->startOfDay()->diffInDays($companyEvent->ends_at->copy()->startOfDay()) + 1)
        : 1;
    $ticketCapacity = (int) $ticketTypes->sum('quantity_total');
    $eventCapacityValue = (int) ($companyEvent->capacity ?: $ticketCapacity);
    $eventCapacity = $eventCapacityValue > 0 ? number_format($eventCapacityValue) : '0';
    $eventCapacitySource = $companyEvent->capacity ? 'Based on event capacity' : ($ticketCapacity > 0 ? 'Based on ticket sales configuration' : 'No attendee capacity configured yet');

    $checklistItems = CompanyEventFlowProgress::checklist($companyEvent);
    $completedSections = CompanyEventFlowProgress::completedSectionsCount($companyEvent);
    $totalSections = CompanyEventFlowProgress::totalSectionsCount($companyEvent);
    $requiredComplete = CompanyEventFlowProgress::requiredSectionsComplete($companyEvent);
    $progressPercent = CompanyEventFlowProgress::progressPercent($companyEvent);
    $reviewNotes = old('company_notes', $publishRequest->company_notes ?? 'Our event is ready for review. Please let us know if any additional information is required.');
    $reviewNotesLength = \Illuminate\Support\Str::length($reviewNotes);
@endphp

<form method="POST" action="{{ route('company.event-company-flow.submit.store', $companyEvent) }}">
    @csrf
<div class="px-4 md:px-10 py-10 max-w-[1250px] w-full flex flex-col mx-auto flex-1 gap-10">
        <div class="flex flex-col xl:flex-row gap-10 md:gap-14">
            
            <!-- Left Column -->
            <div class="flex-1 flex flex-col gap-10">
                
                <!-- Setup Checklist -->
                <div>
                    <h3 class="text-[16px] font-bold text-[#1C1364] mb-5">Setup Checklist</h3>
                    <div class="border border-gray-100 rounded-[12px] bg-white flex flex-col shadow-[0_2px_8px_rgba(0,0,0,0.01)] overflow-hidden">
                        
                        @foreach ($checklistItems as $item)
                            @php
                                $isComplete = $item['complete'];
                                $statusLabel = $isComplete ? 'Completed' : 'Pending';
                                $statusColor = $isComplete ? '#10B981' : '#F59E0B';
                            @endphp
                            <div class="flex flex-col min-[450px]:flex-row min-[450px]:items-center justify-between p-4 px-5 gap-3 min-[450px]:gap-0 {{ $loop->last ? '' : 'border-b border-gray-50' }} hover:bg-gray-50/50 transition-colors">
                                <div class="flex min-w-0 items-center gap-3">
                                    @if ($isComplete)
                                        <svg class="text-[#10B981]" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                                    @else
                                        <span class="inline-flex h-[18px] w-[18px] items-center justify-center rounded-full border text-[10px] font-bold" style="border-color: {{ $statusColor }}; color: {{ $statusColor }};">!</span>
                                    @endif
                                    <span class="text-[14px] font-bold text-[#1C1364]">{{ $item['label'] }}</span>
                                </div>
                                <div class="flex shrink-0 items-center gap-2 pl-3">
                                    <span class="text-[13px] font-bold whitespace-nowrap" style="color: {{ $statusColor }}">{{ $statusLabel }}</span>
                                    <svg class="text-[#5B6B8A]" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Right Column -->
            <div class="w-full xl:w-[440px] flex flex-col gap-10">
                
                <!-- Review Summary -->
                <div>
                    <h3 class="text-[16px] font-bold text-[#1C1364] mb-5">Review Summary</h3>
                    <div class="border border-gray-100 rounded-[12px] bg-white flex flex-col shadow-[0_2px_10px_rgba(0,0,0,0.01)] overflow-hidden">
                        
                        <!-- Row 1 -->
                        <div class="p-4 sm:p-6 flex flex-col min-[450px]:flex-row min-[450px]:items-center gap-4 sm:gap-6 border-b border-gray-50">
                            <div class="w-[52px] h-[52px] rounded-[12px] bg-[#ECFDF5] text-[#10B981] flex items-center justify-center shrink-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect><polyline points="9 14 11 16 15 11"></polyline></svg>
                            </div>
                            <div class="flex flex-col flex-1">
                                <span id="summary-sections-count" class="text-[16px] font-bold text-[#1C1364] mb-0.5">{{ $completedSections }}/{{ $totalSections }}</span>
                                <span class="text-[13px] font-medium text-[#5B6B8A]">Completed Sections</span>
                            </div>
                            <div class="text-[12px] font-medium text-[#5B6B8A] w-[140px] leading-tight">
                                {{ $requiredComplete ? 'All required sections are completed' : 'Complete required sections before review' }}
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="p-4 sm:p-6 flex flex-col min-[450px]:flex-row min-[450px]:items-center gap-4 sm:gap-6 border-b border-gray-50">
                            <div class="flex h-[52px] w-[52px] shrink-0 items-center justify-center rounded-[12px] bg-gray-100 text-[#4C10D0]">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                            <div class="flex flex-col flex-1">
                                <span id="summary-attendees" class="text-[16px] font-bold text-[#1C1364] mb-0.5">{{ $eventCapacity }}</span>
                                <span class="text-[13px] font-medium text-[#5B6B8A]">Expected Attendees</span>
                            </div>
                            <div class="text-[12px] font-medium text-[#5B6B8A] w-[140px] leading-tight">
                                {{ $eventCapacitySource }}
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="p-4 sm:p-6 flex flex-col min-[450px]:flex-row min-[450px]:items-center gap-4 sm:gap-6">
                            <div class="w-[52px] h-[52px] rounded-[12px] bg-[#EFF6FF] text-[#3B82F6] flex items-center justify-center shrink-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            </div>
                            <div class="flex flex-col flex-1 col-span-2">
                                <span id="summary-dates" class="text-[16px] font-bold text-[#1C1364] mb-0.5">{{ $eventDate }}</span>
                                <span id="summary-duration" class="text-[13px] font-medium text-[#5B6B8A]">{{ $eventDays }} {{ str('Day')->plural($eventDays) }} Event</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

                <!-- Overall Progress -->
                <div>
                    <h3 class="text-[16px] font-bold text-[#1C1364] mb-4">Overall Progress</h3>
                    
                    <div class="flex items-center gap-4 mb-8">
                        <div class="flex-1 h-3.5 bg-gray-100 rounded-full overflow-hidden">
                            <div id="progress-bar-fill" class="h-full bg-[#4C10D0] rounded-full transition-all duration-300" style="width: {{ $progressPercent }}%"></div>
                        </div>
                        <span id="progress-text" class="text-[15px] font-bold text-[#1C1364]">{{ $progressPercent }}%</span>
                    </div>

                    <!-- Alert Box -->
                    <div class="{{ $requiredComplete ? 'bg-[#F0FDF4] border-[#DCFCE7]' : 'bg-[#FFFBEB] border-[#FEF3C7]' }} border rounded-[12px] p-4 sm:p-6 flex gap-4">
                        <div class="{{ $requiredComplete ? 'text-[#10B981]' : 'text-[#F59E0B]' }} shrink-0 mt-0.5">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                        <div class="flex flex-col gap-1.5 text-left">
                            <span class="text-[14px] font-bold {{ $requiredComplete ? 'text-[#10B981]' : 'text-[#F59E0B]' }}">{{ $requiredComplete ? 'Your event is ready for review!' : 'Your event needs a few required details.' }}</span>
                            <span class="text-[13px] font-medium text-[#5B6B8A] leading-relaxed">{{ $requiredComplete ? 'Once submitted, our review team will verify your event details. You will be notified via email.' : 'Complete Basic Details, Branding, and Tickets / Passes before submitting for review.' }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div class="rounded-[14px] border border-gray-100 bg-white p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                        <div class="mb-4 flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-[15px] font-bold text-[#1C1364] mb-1">Review Notes</h3>
                                <p class="text-[13px] text-[#5B6B8A]">Add any additional information for the review team.</p>
                            </div>
                            <span id="char-counter" class="shrink-0 rounded-full bg-gray-50 px-3 py-1 text-[12px] font-bold text-[#5B6B8A]">{{ $reviewNotesLength }}/500</span>
                        </div>
                        <textarea id="review-notes" name="company_notes" class="w-full min-h-[170px] p-5 bg-[#FCFCFD] border border-gray-200 rounded-[12px] text-[13px] font-medium text-[#1C1364] leading-relaxed focus:outline-none focus:border-[#4C10D0] resize-none shadow-inner" placeholder="Enter notes..." maxlength="500">{{ $reviewNotes }}</textarea>
                    </div>

                    <div class="rounded-[14px] border border-gray-100 bg-white p-6 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                        <div class="mb-4">
                            <h3 class="text-[15px] font-bold text-[#1C1364] mb-1">Documents & Links</h3>
                            <p class="text-[13px] text-[#5B6B8A]">Attached event resources from your setup.</p>
                        </div>
                        <div class="flex min-h-[170px] flex-col gap-3">
                            @if (filled($eventBranding?->brochure_path))
                                <div id="brochure-slot" class="border border-gray-100 rounded-[12px] bg-[#FCFCFD] p-4 flex items-center justify-between gap-4 shadow-sm">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[13px] font-bold text-[#1C1364]">Event Brochure</p>
                                        <p class="text-[12px] font-medium text-[#5B6B8A]">Uploaded</p>
                                    </div>
                                    <a href="{{ asset('storage/' . $eventBranding->brochure_path) }}" target="_blank" rel="noopener" class="inline-flex h-9 items-center justify-center rounded-lg border border-gray-200 px-4 text-[12px] font-bold text-[#4C10D0] hover:bg-gray-50">View</a>
                                </div>
                            @endif

                            @if (filled($companyEvent->website))
                                <div id="guide-slot" class="border border-gray-100 rounded-[12px] bg-[#FCFCFD] p-4 flex items-center justify-between gap-4 shadow-sm">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[13px] font-bold text-[#1C1364]">Event Website</p>
                                        <p class="truncate text-[12px] font-medium text-[#5B6B8A]">{{ $companyEvent->website }}</p>
                                    </div>
                                    <a href="{{ \Illuminate\Support\Str::startsWith($companyEvent->website, ['http://', 'https://']) ? $companyEvent->website : 'https://' . $companyEvent->website }}" target="_blank" rel="noopener" class="inline-flex h-9 items-center justify-center rounded-lg border border-gray-200 px-4 text-[12px] font-bold text-[#4C10D0] hover:bg-gray-50">Open</a>
                                </div>
                            @endif

                            @unless (CompanyEventFlowProgress::resourcesComplete($companyEvent))
                                <div class="grid min-h-[92px] place-items-center rounded-[8px] border border-dashed border-gray-200 bg-white p-4 text-center text-[13px] font-medium text-[#5B6B8A]">
                                    No documents or links added yet.
                                </div>
                            @endunless
                        </div>
                    </div>
                </div>

                <!-- Bottom Buttons -->
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('company.event-company-flow.preview', $companyEvent) }}" class="inline-flex h-12 items-center justify-center rounded-lg border border-gray-200 bg-white px-8 text-[14px] font-bold text-[#1C1364] shadow-sm hover:bg-gray-50">
                        Back
                    </a>
                    <button id="submit-review-btn" type="submit" @disabled(! $requiredComplete) style="background-color: #4C10D0; color: #FFFFFF;" class="inline-flex h-12 w-full items-center justify-center rounded-lg px-8 text-[14px] font-bold shadow-[0_4px_14px_rgba(76,16,208,0.3)] transition-colors hover:bg-[#3d0ba8] focus:outline-none sm:w-auto sm:min-w-[260px] disabled:cursor-not-allowed disabled:opacity-50">
                        Submit for Review
                    </button>
                </div>
                
            </div>
    </form>
@endsection

@push('scripts')
<script>
    const reviewNotes = document.getElementById('review-notes');
    const charCounter = document.getElementById('char-counter');

    reviewNotes?.addEventListener('input', () => {
        if (charCounter) {
            charCounter.textContent = `${reviewNotes.value.length}/500`;
        }
    });
</script>
@endpush
