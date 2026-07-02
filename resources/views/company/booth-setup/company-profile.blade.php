@extends('layouts.company')

@section('title', 'Company Profile | eproexpo')
@section('page-title', 'Company Profile')

@section('content')
@php
    $profile = $profile ?? null;
    $logoUrl = $profile?->company_logo ? asset('storage/' . $profile->company_logo) : null;
@endphp
        <section class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto w-full max-w-[1400px] rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 lg:p-8">
                
                <h1 class="text-[28px] font-bold text-[#1E1B4B] tracking-tight mb-8">Company Profile</h1>
                @if (session('status'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="{{ route('company.booth-setup.profile.update', $booking) }}" enctype="multipart/form-data">
                    @csrf

                <!-- Form Grid -->
                <div class="grid grid-cols-12 gap-x-6 gap-y-6">
                    
                    <!-- Logo Upload Area (Spans 4 columns, 3 rows tall) -->
                    <div class="col-span-12 lg:col-span-4 lg:row-span-3">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Company Logo</label>
                        <label class="flex h-[220px] cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-[#8B5CF6] bg-white p-6 transition-colors hover:bg-purple-50">
                            <div class="mb-4 flex h-20 w-20 items-center justify-center overflow-hidden rounded-xl bg-[#F4F0FF] text-[#3D1B9B]">
                                <img id="company-logo-preview" src="{{ $logoUrl }}" alt="Company Logo Preview" class="{{ $logoUrl ? '' : 'hidden' }} h-full w-full object-contain">
                                <svg id="company-logo-empty" class="{{ $logoUrl ? 'hidden' : '' }} h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 7.5 12 3m0 0L7.5 7.5M12 3v13.5" />
                                </svg>
                            </div>
                            <p class="text-center text-[#3D1B9B] text-[13px] font-medium leading-relaxed px-4">
                                Click to upload or drag and drop<br>PNG, JPG or SVG (Max. 5MB)
                            </p>
                            <p id="company-logo-name" class="mt-3 max-w-full truncate text-xs font-semibold text-[#6B7280]">{{ $profile?->company_logo ? basename($profile->company_logo) : '' }}</p>
                            <input id="company-logo-input" type="file" name="company_logo" class="hidden" accept="image/*">
                        </label>
                    </div>

                    <!-- Row 1 right side -->
                    <div class="col-span-12 lg:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Company Name <span class="text-red-500">*</span></label>
                        <input type="text" name="company_name" value="{{ old('company_name', $profile?->company_name) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Contact Person <span class="text-red-500">*</span></label>
                        <input type="text" name="contact_person" value="{{ old('contact_person', $profile?->contact_person) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>

                    <!-- Row 2 right side -->
                    <div class="col-span-12 lg:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Industry <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="industry" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B] appearance-none bg-white cursor-pointer">
                                <option value="">Select industry</option>
                                @foreach (['Artificial Intelligence', 'Software Development', 'Cloud Computing'] as $industry)
                                    <option @selected(old('industry', $profile?->industry) === $industry)>{{ $industry }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $profile?->email) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>

                    <!-- Row 3 right side -->
                    <div class="col-span-12 lg:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $profile?->tagline) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Phone <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" value="{{ old('phone', $profile?->phone) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>

                    <!-- Row 4 -->
                    <div class="col-span-12 lg:col-span-8">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">About Company <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <textarea id="about-company-input" rows="3" maxlength="300" name="about_company" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B] resize-none pb-8">{{ old('about_company', $profile?->about_company) }}</textarea>
                            <span id="about-company-count" class="absolute bottom-3 right-4 text-[12px] text-gray-400 font-medium">0/300</span>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Website</label>
                        <input type="url" name="website" value="{{ old('website', $profile?->website) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#111827] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>

                    <!-- Row 5 -->
                    <div class="col-span-12 lg:col-span-5">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Address <span class="text-red-500">*</span></label>
                        <input type="text" name="address" value="{{ old('address', $profile?->address) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">City <span class="text-red-500">*</span></label>
                        <input type="text" name="city" value="{{ old('city', $profile?->city) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-2">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">State <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="state" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B] appearance-none bg-white cursor-pointer">
                                <option value="">Select state</option>
                                @foreach (['Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal', 'Delhi'] as $state)
                                    <option @selected(old('state', $profile?->state) === $state)>{{ $state }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-2">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Zip Code <span class="text-red-500">*</span></label>
                        <input type="text" name="zip_code" value="{{ old('zip_code', $profile?->zip_code) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B]">
                    </div>

                    <!-- Row 6 -->
                    <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                        <label class="block text-[#1E1B4B] font-bold text-[14px] mb-2">Country <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="country" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] focus:ring-1 focus:ring-[#3D1B9B] appearance-none bg-white cursor-pointer">
                                <option value="">Select country</option>
                                @foreach (['India', 'United States', 'Canada', 'United Kingdom'] as $country)
                                    <option @selected(old('country', $profile?->country) === $country)>{{ $country }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 rounded-xl border border-gray-100 bg-[#FAFAFA] p-4 sm:p-6">
                    <h2 class="mb-1 text-[15px] font-bold text-[#1E1B4B]">Booth Highlights</h2>
                    <p class="mb-4 text-[12px] text-[#6B7280]">These numbers appear on your booth preview for visitors.</p>
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                        <div>
                            <label class="mb-2 block text-[13px] font-bold text-[#1E1B4B]">Years Experience</label>
                            <input type="text" name="years_experience" value="{{ old('years_experience', $profile?->years_experience ?: ($profile?->highlight_stats['years_experience'] ?? '')) }}" placeholder="10+" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#111827] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        </div>
                        <div>
                            <label class="mb-2 block text-[13px] font-bold text-[#1E1B4B]">Clients</label>
                            <input type="text" name="clients_count" value="{{ old('clients_count', $profile?->clients_count ?: ($profile?->highlight_stats['clients'] ?? '')) }}" placeholder="250+" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#111827] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        </div>
                        <div>
                            <label class="mb-2 block text-[13px] font-bold text-[#1E1B4B]">Countries</label>
                            <input type="text" name="countries_served" value="{{ old('countries_served', $profile?->countries_served ?: ($profile?->highlight_stats['countries'] ?? '')) }}" placeholder="25+" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#111827] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        </div>
                        <div>
                            <label class="mb-2 block text-[13px] font-bold text-[#1E1B4B]">Expert Team</label>
                            <input type="text" name="expert_team_size" value="{{ old('expert_team_size', $profile?->expert_team_size ?: ($profile?->highlight_stats['team_size'] ?? '')) }}" placeholder="100+" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#111827] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        </div>
                    </div>
                </div>

                <!-- Social Links Section -->
                <div class="mt-8 rounded-xl border border-gray-100 bg-[#FAFAFA] p-4 sm:p-6">
                    <h2 class="text-[#1E1B4B] font-bold text-[15px] mb-4">Social Links</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                        
                        <!-- LinkedIn -->
                        <div class="flex items-center">
                            <div class="w-9 h-9 bg-[#0077B5] rounded flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                </svg>
                            </div>
                            <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile?->linkedin_url) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] bg-white">
                        </div>

                        <!-- Facebook -->
                        <div class="flex items-center">
                            <div class="w-9 h-9 bg-[#1877F2] rounded flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                                </svg>
                            </div>
                            <input type="url" name="facebook_url" value="{{ old('facebook_url', $profile?->facebook_url) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] bg-white">
                        </div>

                        <!-- Twitter / X -->
                        <div class="flex items-center">
                            <div class="w-9 h-9 bg-[#1DA1F2] rounded flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </div>
                            <input type="url" name="twitter_url" value="{{ old('twitter_url', $profile?->twitter_url) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] bg-white">
                        </div>

                        <!-- YouTube -->
                        <div class="flex items-center">
                            <div class="w-9 h-9 bg-[#FF0000] rounded flex items-center justify-center mr-3 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                </svg>
                            </div>
                            <input type="url" name="youtube_url" value="{{ old('youtube_url', $profile?->youtube_url) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[#6B7280] text-[14px] focus:outline-none focus:border-[#3D1B9B] bg-white">
                        </div>

                    </div>
                </div>

                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('company.booth-setup.index', $booking) }}" class="inline-flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-6 py-3 text-[15px] font-bold text-[#1E1B4B] transition-colors hover:border-[#3D1B9B] hover:text-[#3D1B9B] sm:w-auto">
                        Back to Setup
                    </a>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <button type="submit" name="next" value="stay" class="inline-flex w-full items-center justify-center rounded-lg border border-[#D8D1FF] bg-white px-6 py-3 text-[15px] font-bold text-[#3D1B9B] transition-colors hover:border-[#3D1B9B] hover:bg-[#FBFAFF] sm:w-auto">
                            Save Draft
                        </button>
                        <button type="submit" name="next" value="branding" class="inline-flex w-full items-center justify-center rounded-lg bg-[#3D1B9B] px-8 py-3 text-[15px] font-bold text-white shadow-md transition-colors hover:bg-[#31167D] sm:w-auto">
                        Save & Continue <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
                </form>

            </div>
        </section>
@endsection

@push('scripts')
<script>
    (() => {
        const logoInput = document.getElementById('company-logo-input');
        const logoPreview = document.getElementById('company-logo-preview');
        const logoEmpty = document.getElementById('company-logo-empty');
        const logoName = document.getElementById('company-logo-name');
        const aboutInput = document.getElementById('about-company-input');
        const aboutCount = document.getElementById('about-company-count');

        logoInput?.addEventListener('change', () => {
            const file = logoInput.files?.[0];
            if (!file) {
                return;
            }

            logoPreview.src = URL.createObjectURL(file);
            logoPreview.classList.remove('hidden');
            logoEmpty?.classList.add('hidden');
            if (logoName) {
                logoName.textContent = file.name;
            }
        });

        const updateAboutCount = () => {
            if (aboutInput && aboutCount) {
                aboutCount.textContent = `${aboutInput.value.length}/300`;
            }
        };

        aboutInput?.addEventListener('input', updateAboutCount);
        updateAboutCount();
    })();
</script>
@endpush
