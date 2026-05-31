@extends('layouts.company')

@section('title', 'Booth Branding | eproexpo')
@section('page-title', 'Booth Branding')

@section('content')
@php
    $branding = $branding ?? null;
    $profile = $booking->boothProfile;
    $bannerUrl = $branding?->booth_banner ? asset('storage/' . $branding->booth_banner) : asset('assets/exhibition/images/booth_banner.png');
    
    $backgroundUrl = $branding?->booth_background 
        ? (str_starts_with($branding->booth_background, 'assets/') ? asset($branding->booth_background) : asset('storage/' . $branding->booth_background)) 
        : asset('assets/exhibition/images/booth_banner.png');

    $primaryColor = old('primary_color', $branding?->primary_color ?? '#3D1B9B');
    $secondaryColor = old('secondary_color', $branding?->secondary_color ?? '#0EA5E9');
    $welcomeHeading = old('welcome_heading', $branding?->welcome_heading ?? '');
    $themeTemplate = old('theme_template', $branding?->theme_template ?? '');
    $ctaButtonText = old('cta_button_text', $branding?->cta_button_text ?? '');
    $ctaButtonLink = old('cta_button_link', $branding?->cta_button_link ?? '');

    $presets = [
        [
            'name' => 'Office',
            'path' => 'assets/images/pavilions/business-pavilion.png',
        ],
        [
            'name' => 'Technology Hall',
            'path' => 'assets/images/pavilions/innovation-pavilion.png',
        ],
        [
            'name' => 'Creative Studio',
            'path' => 'assets/images/pavilions/education-pavilion.png',
        ],
        [
            'name' => 'Nature',
            'path' => 'assets/images/pavilions/sustainability-pavilion.png',
        ],
        [
            'name' => 'Abstract',
            'path' => 'assets/images/pavilions/automotive-pavilion.png',
        ],
    ];
@endphp

<section class="px-4 py-6 sm:px-6 lg:px-8">
    <form method="POST" action="{{ route('company.booth-setup.branding.update', $booking) }}" enctype="multipart/form-data" class="mx-auto w-full max-w-[1400px] rounded-2xl border border-gray-100 bg-white p-8 shadow-sm">
        @csrf

        <div class="mb-8">
            <h1 class="text-[28px] font-bold tracking-tight text-[#1E1B4B]">Booth Branding</h1>
            <p class="mt-2 text-[15px] text-[#6B7280]">Customize the look and feel of your virtual booth.</p>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
        @endif

        <div class="grid grid-cols-1 gap-8 xl:grid-cols-12 xl:items-start xl:gap-10">
            <div class="space-y-8 xl:col-span-7">
                <div>
                    <div class="mb-3">
                        <h3 class="text-[15px] font-bold text-[#1E1B4B]">Booth Banner</h3>
                        <p class="text-[13px] text-gray-500">Recommended size: 1920 x 400 px</p>
                    </div>
                    <div class="flex flex-col items-center gap-4 md:flex-row">
                        <div class="h-[80px] w-full overflow-hidden rounded-lg border border-gray-200 md:w-[320px]">
                            <img id="banner-preview" src="{{ $bannerUrl }}" class="h-full w-full object-cover" alt="Banner Preview">
                        </div>
                        <button type="button" data-file-trigger="booth-banner-input" class="whitespace-nowrap rounded-lg border border-[#3D1B9B] px-6 py-2 text-[14px] font-medium text-[#3D1B9B] transition-colors hover:bg-purple-50">
                            Change Banner
                        </button>
                        <input id="booth-banner-input" type="file" name="booth_banner" class="hidden" accept="image/*" data-preview="banner-preview preview-banner-bg">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <div>
                        <h3 class="mb-4 text-[14px] font-bold text-[#1E1B4B]">Primary Color</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-[14px] font-semibold text-[#1E1B4B]">Secondary Color</span>
                                <label class="relative flex w-[110px] cursor-pointer items-center justify-between rounded-lg border border-gray-200 bg-white p-1 shadow-sm">
                                    <span data-color-chip="primary_color" class="h-7 w-10 rounded-md" style="background-color: {{ $primaryColor }}"></span>
                                    <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <input type="color" name="primary_color" value="{{ $primaryColor }}" class="absolute inset-0 cursor-pointer opacity-0">
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[14px] font-semibold text-[#1E1B4B]">Welcome Color</span>
                                <label class="relative flex w-[110px] cursor-pointer items-center justify-between rounded-lg border border-gray-200 bg-white p-1 shadow-sm">
                                    <span data-color-chip="secondary_color" class="h-7 w-10 rounded-md" style="background-color: {{ $secondaryColor }}"></span>
                                    <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <input type="color" name="secondary_color" value="{{ $secondaryColor }}" class="absolute inset-0 cursor-pointer opacity-0">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="mb-4 text-[14px] font-bold text-[#1E1B4B]">Text Color</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span data-color-label="primary_color" class="text-[14px] font-semibold text-[#1E1B4B]">{{ $primaryColor }}</span>
                                <div class="flex w-[110px] items-center justify-between rounded-lg border border-gray-200 bg-white p-1 shadow-sm">
                                    <span data-color-chip="primary_color" class="h-7 w-10 rounded-md" style="background-color: {{ $primaryColor }}"></span>
                                    <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[14px] font-semibold text-[#1E1B4B]">Welcome Heading <span class="text-red-500">*</span></span>
                                <div class="flex w-[110px] items-center justify-between rounded-lg border border-gray-200 bg-white p-1 shadow-sm">
                                    <span data-color-chip="secondary_color" class="h-7 w-10 rounded-md" style="background-color: {{ $secondaryColor }}"></span>
                                    <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <label class="block">
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Welcome Heading</span>
                    <input type="text" name="welcome_heading" value="{{ $welcomeHeading }}" placeholder="Welcome to your booth" data-branding-input data-preview-text="preview-heading" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#111827] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                </label>

                <label class="block">
                    <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Theme / Template</span>
                    <select name="theme_template" class="w-full appearance-none rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] text-[#6B7280] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                        <option value="">Select theme</option>
                        @foreach (['Tech Modern', 'Classic Corporate', 'Creative Studio'] as $theme)
                            <option value="{{ $theme }}" @selected($themeTemplate === $theme)>{{ $theme }}</option>
                        @endforeach
                    </select>
                </label>

                <div>
                    <label class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Booth Background</label>
                    
                    <!-- Hidden input to store the selected preset path -->
                    <input type="hidden" name="preset_background" id="selected-preset-input" value="{{ str_starts_with($branding?->booth_background ?? '', 'assets/') ? $branding->booth_background : '' }}">

                    <div class="flex space-x-3 overflow-x-auto pb-2 scrollbar-hide">
                        <!-- Custom File Upload Option -->
                        @php
                            $isCustomSelected = $branding?->booth_background && !str_starts_with($branding->booth_background, 'assets/');
                            // If there is no custom file, show default banner as thumbnail
                            $customThumbUrl = $isCustomSelected ? asset('storage/' . $branding->booth_background) : asset('assets/exhibition/images/booth_banner.png');
                        @endphp
                        <button type="button" id="custom-bg-btn" onclick="triggerCustomUpload()" class="relative h-14 w-20 flex-shrink-0 cursor-pointer overflow-hidden rounded-lg border-2 {{ $isCustomSelected || !$branding?->booth_background ? 'border-[#3D1B9B]' : 'border-gray-200 hover:border-gray-300' }}">
                            <img id="background-preview" src="{{ $customThumbUrl }}" class="h-full w-full object-cover" alt="Custom Upload">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-[10px] font-bold text-white text-center">Upload</span>
                            </div>
                            <span id="custom-bg-checkmark" class="absolute bottom-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-[#3D1B9B] text-white {{ $isCustomSelected || !$branding?->booth_background ? '' : 'hidden' }}">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                        </button>

                        <!-- Presets -->
                        @foreach ($presets as $preset)
                            @php
                                $isPresetSelected = $branding?->booth_background === $preset['path'];
                            @endphp
                            <button type="button" 
                                    onclick="selectPresetBackground('{{ $preset['path'] }}', '{{ asset($preset['path']) }}', this)" 
                                    class="preset-bg-btn relative h-14 w-20 flex-shrink-0 cursor-pointer overflow-hidden rounded-lg border-2 {{ $isPresetSelected ? 'border-[#3D1B9B]' : 'border-gray-200 hover:border-gray-300' }}"
                                    data-preset-path="{{ $preset['path'] }}">
                                <img src="{{ asset($preset['path']) }}" class="h-full w-full object-cover" alt="{{ $preset['name'] }}">
                                <div class="absolute inset-0 bg-black/20 flex items-end justify-center">
                                    <span class="bg-black/60 px-1 py-0.5 text-[8px] font-semibold text-white truncate w-full text-center">{{ $preset['name'] }}</span>
                                </div>
                                <span class="preset-checkmark absolute bottom-5 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-[#3D1B9B] text-white {{ $isPresetSelected ? '' : 'hidden' }}">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                            </button>
                        @endforeach
                        
                        <!-- Hidden input for file upload -->
                        <input id="booth-background-input" type="file" name="booth_background" class="hidden" accept="image/*">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <label class="block">
                        <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">CTA Button Text</span>
                        <input type="text" name="cta_button_text" value="{{ $ctaButtonText }}" placeholder="Let's Connect" data-branding-input data-preview-text="preview-cta" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#111827] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">CTA Button Link</span>
                        <input type="url" name="cta_button_link" value="{{ $ctaButtonLink }}" placeholder="https://example.com/contact" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] text-[#111827] focus:border-[#3D1B9B] focus:outline-none focus:ring-1 focus:ring-[#3D1B9B]">
                    </label>
                </div>
            </div>

            <div class="space-y-6 xl:sticky xl:top-6 xl:col-span-5">
                <div>
                    <h3 class="mb-3 text-[15px] font-bold text-[#1E1B4B]">Live Preview</h3>
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div id="preview-banner-bg" class="relative flex min-h-[260px] flex-col items-center justify-center overflow-hidden bg-cover bg-center px-8 py-12 text-center" style="background-image: linear-gradient(135deg, #021035D9, #122b7aD9), url('{{ $backgroundUrl }}');">
                            <p class="relative z-10 mb-4 text-[11px] font-bold tracking-[0.2em] text-white">{{ strtoupper($profile?->company_name ?? 'YOUR COMPANY') }}</p>
                            <h2 id="preview-heading" class="relative z-10 mb-2 text-[24px] font-bold text-white">{{ $welcomeHeading ?: 'Welcome to your booth' }}</h2>
                            <p class="relative z-10 mb-6 text-[13px] text-white/80">{{ $profile?->tagline ?: 'Showcase your brand, products and team.' }}</p>
                            <button id="preview-cta" type="button" class="relative z-10 rounded-lg bg-[#5622D6] px-6 py-2 text-[14px] font-semibold text-white transition-colors hover:bg-[#4319a8]">
                                {{ $ctaButtonText ?: "Let's Connect" }}
                            </button>
                        </div>

                        <div class="bg-white px-6 py-8">
                            <div class="grid grid-cols-3 gap-4 text-center">
                                @foreach ([['Products', $booking->boothProducts->count()], ['Documents', $booking->boothDocuments->count()], ['Team', $booking->boothTeamMembers->count()]] as [$label, $count])
                                    <div class="flex flex-col items-center">
                                        <div class="mb-2 flex h-10 w-10 items-center justify-center rounded-full border border-purple-100 bg-purple-50 text-[#3D1B9B]">
                                            <i class="ph ph-squares-four text-lg"></i>
                                        </div>
                                        <p class="mb-1 text-[13px] font-bold text-[#1E1B4B]">{{ $label }}</p>
                                        <p class="text-[15px] font-extrabold text-[#1E1B4B]">{{ $count }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-3 text-[16px] font-bold text-[#1E1B4B]">About Us</h3>
                    <p class="mb-6 text-[14px] leading-relaxed text-[#6B7280] break-words whitespace-pre-line">
                        {{ $profile?->about_company ?: 'Add your company profile first to show your story here.' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-10 flex flex-col-reverse gap-3 border-t border-gray-100 pt-8 sm:flex-row sm:items-center sm:justify-between">
            <button type="submit" name="action" value="reset" class="inline-flex w-full items-center justify-center rounded-lg border border-gray-200 px-8 py-3 text-[14px] font-bold text-[#3D1B9B] transition-colors hover:bg-gray-50 sm:w-auto">
                Reset to Default
            </button>
            <div class="flex flex-col gap-3 sm:flex-row">
                <button type="submit" name="action" value="continue" class="inline-flex w-full items-center justify-center rounded-lg bg-[#3D1B9B] px-8 py-3 text-[15px] font-bold text-white shadow-md transition-colors hover:bg-[#31167D] sm:w-auto">
                    Save & Continue
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
    (() => {
        const primaryInput = document.querySelector('[name="primary_color"]');
        const secondaryInput = document.querySelector('[name="secondary_color"]');
        const banner = document.getElementById('preview-banner-bg');
        const cta = document.getElementById('preview-cta');

        const refreshColors = () => {
            const primary = primaryInput?.value || '#3D1B9B';
            const secondary = secondaryInput?.value || '#0EA5E9';
            document.querySelectorAll('[data-color-chip="primary_color"]').forEach((chip) => chip.style.backgroundColor = primary);
            document.querySelectorAll('[data-color-chip="secondary_color"]').forEach((chip) => chip.style.backgroundColor = secondary);
            document.querySelectorAll('[data-color-label="primary_color"]').forEach((label) => label.textContent = primary);
        };

        document.querySelectorAll('[data-file-trigger]').forEach((button) => {
            button.addEventListener('click', () => document.getElementById(button.dataset.fileTrigger)?.click());
        });

        document.querySelectorAll('input[type="file"][data-preview]').forEach((input) => {
            input.addEventListener('change', () => {
                const file = input.files?.[0];
                if (!file) {
                    return;
                }

                const url = URL.createObjectURL(file);
                input.dataset.preview.split(' ').forEach((previewId) => {
                    const preview = document.getElementById(previewId);
                    if (!preview) {
                        return;
                    }
                    if (preview.tagName === 'IMG') {
                        preview.src = url;
                    } else {
                        preview.dataset.imageUrl = url;
                        preview.style.backgroundImage = `linear-gradient(135deg, #021035D9, #122b7aD9), url('${url}')`;
                    }
                });
            });
        });

        // Background Picker Logic
        const backgroundInput = document.getElementById('booth-background-input');
        const presetInput = document.getElementById('selected-preset-input');
        const customBgBtn = document.getElementById('custom-bg-btn');
        const customBgCheckmark = document.getElementById('custom-bg-checkmark');
        const backgroundPreview = document.getElementById('background-preview');

        window.triggerCustomUpload = () => {
            backgroundInput.click();
        };

        window.selectPresetBackground = (path, url, button) => {
            presetInput.value = path;
            backgroundInput.value = ''; // clear file selection

            backgroundPreview.src = url;
            if (banner) {
                banner.style.backgroundImage = `linear-gradient(135deg, #021035D9, #122b7aD9), url('${url}')`;
            }

            // Reset borders and checkmarks on custom button
            customBgBtn.classList.remove('border-[#3D1B9B]');
            customBgBtn.classList.add('border-gray-200', 'hover:border-gray-300');
            customBgCheckmark.classList.add('hidden');

            // Reset borders and checkmarks on presets
            document.querySelectorAll('.preset-bg-btn').forEach((btn) => {
                btn.classList.remove('border-[#3D1B9B]');
                btn.classList.add('border-gray-200', 'hover:border-gray-300');
                btn.querySelector('.preset-checkmark').classList.add('hidden');
            });

            // Highlight selected preset
            button.classList.add('border-[#3D1B9B]');
            button.classList.remove('border-gray-200', 'hover:border-gray-300');
            button.querySelector('.preset-checkmark').classList.remove('hidden');
        };

        backgroundInput?.addEventListener('change', () => {
            const file = backgroundInput.files?.[0];
            if (!file) {
                return;
            }

            const url = URL.createObjectURL(file);
            presetInput.value = ''; // clear preset selection

            backgroundPreview.src = url;
            if (banner) {
                banner.style.backgroundImage = `linear-gradient(135deg, #021035D9, #122b7aD9), url('${url}')`;
            }

            // Reset borders and checkmarks on presets
            document.querySelectorAll('.preset-bg-btn').forEach((btn) => {
                btn.classList.remove('border-[#3D1B9B]');
                btn.classList.add('border-gray-200', 'hover:border-gray-300');
                btn.querySelector('.preset-checkmark').classList.add('hidden');
            });

            // Highlight custom button
            customBgBtn.classList.add('border-[#3D1B9B]');
            customBgBtn.classList.remove('border-gray-200', 'hover:border-gray-300');
            customBgCheckmark.classList.remove('hidden');
        });

        document.querySelectorAll('[data-preview-text]').forEach((input) => {
            const target = document.getElementById(input.dataset.previewText);
            const fallback = target?.textContent || '';
            const update = () => {
                if (target) {
                    target.textContent = input.value || fallback;
                }
            };
            input.addEventListener('input', update);
            update();
        });

        primaryInput?.addEventListener('input', refreshColors);
        secondaryInput?.addEventListener('input', refreshColors);
        refreshColors();
    })();
</script>
@endpush
