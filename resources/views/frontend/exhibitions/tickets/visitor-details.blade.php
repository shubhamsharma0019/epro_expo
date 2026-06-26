@php
    $title = $title ?? 'Exhibition';
    $bannerImage = $bannerImage ?? asset('images/exhibitions/hero-pavilion-scene.png');
    $dateStr = $dateStr ?? 'Date TBD';
    $location = $location ?? 'Virtual';
    $timeStr = $timeStr ?? 'Time TBD';
    $priceLabel = $priceLabel ?? 'Free';
    $showVisitorSidebar = $showVisitorSidebar ?? false;
    $prefill = $prefill ?? [];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Get Visitor Pass - EproExpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#F4F0FF', 100: '#E0D4FC', 500: '#5A32FA', 600: '#4A22E0', 700: '#3D1CBA' }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FFFFFF; }
        .form-input {
            width: 100%;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            color: #1E293B;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-input:focus { border-color: #5A32FA; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .required { color: #EF4444; }
    </style>
    @include('frontend.exhibitions.visitor.partials.ticket-responsive')
</head>
<body class="text-[#1E293B] font-sans flex min-h-screen flex-col lg:h-screen lg:overflow-hidden">
    @include('frontend.exhibitions.tickets.partials.visitor-sidebar-shell')

    <main class="flex min-h-0 flex-1 flex-col bg-white lg:h-screen lg:overflow-hidden">
        <div id="header-container" class="relative z-40 w-full shrink-0">@include('frontend.exhibitions.tickets.header', ['hideMobileMenu' => !($showVisitorSidebar ?? false)])</div>

        <div class="ticket-flow-main flex-1 overflow-y-auto px-4 py-6 sm:px-8 lg:px-12 lg:py-8 relative bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]">
            <a href="{{ route('exhibitions.show', $slug) }}" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-700 transition-colors mb-6 text-[14px]">
                <i class="ph ph-arrow-left text-lg"></i> Back to Exhibition Details
            </a>

            <div class="mb-8 flex flex-col gap-6 border-b border-gray-100 pb-6 sm:pb-8 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex min-w-0 gap-4 sm:gap-5">
                    <div class="ticket-flow-hero-img h-[72px] w-[72px] shrink-0 rounded-2xl border border-gray-100 bg-cover bg-center shadow-sm sm:h-[100px] sm:w-[100px]" style="background-image: url('{{ $bannerImage }}');"></div>
                    <div class="flex min-w-0 flex-col justify-center">
                        <h1 class="mb-2 text-lg font-bold tracking-tight text-[#1E1B4B] sm:text-[22px]">{{ $title }}</h1>
                        <div class="mb-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-[12px] font-medium text-[#475569] sm:text-[13px]">
                            <div class="flex items-center gap-1.5"><i class="ph ph-calendar-blank text-[16px]"></i><span>{{ $dateStr }}</span></div>
                            <span class="hidden h-1 w-1 rounded-full bg-gray-300 sm:inline"></span>
                            <div class="flex items-center gap-1.5"><i class="ph ph-clock text-[16px]"></i><span>{{ $timeStr }}</span></div>
                        </div>
                        <div class="flex items-center gap-1.5 text-[12px] font-medium text-[#475569] sm:text-[13px]">
                            <i class="ph ph-map-pin shrink-0 text-[16px]"></i><span class="break-words">{{ $location }}</span>
                        </div>
                    </div>
                </div>
                @include('frontend.exhibitions.tickets.partials.visitor-flow-stepper', ['currentStep' => 1])
            </div>

            <div class="ticket-flow-two-col flex flex-col gap-6 lg:flex-row lg:gap-8">
                <div class="min-w-0 flex-1">
                    <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                        <p class="text-[12px] font-bold uppercase tracking-[0.16em] text-primary-600">Visitor Registration</p>
                        <h2 class="mt-2 text-[24px] font-bold text-[#1E1B4B]">Your Information</h2>
                        <p class="mt-2 text-[14px] font-medium text-gray-500">Enter your details to continue with visitor pass booking.</p>

                        @if ($errors->any())
                            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[14px] font-medium text-red-700">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('exhibitions.tickets.visitor-details.store', $slug) }}" class="mt-8 space-y-5">
                            @csrf
                            <input type="hidden" name="slug" value="{{ $slug }}">

                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <label class="md:col-span-2">
                                    <span class="form-label">Full Name <span class="required">*</span></span>
                                    <input type="text" name="name" value="{{ $prefill['name'] ?? '' }}" required class="form-input">
                                </label>
                                <label>
                                    <span class="form-label">Email <span class="required">*</span></span>
                                    <input type="email" name="email" value="{{ $prefill['email'] ?? '' }}" required class="form-input">
                                </label>
                                <label>
                                    <span class="form-label">Password <span class="required">*</span></span>
                                    <input type="password" name="password" required minlength="8" class="form-input">
                                    <span class="mt-1 block text-[12px] text-gray-500">Minimum 8 characters. Use your existing password if you already have an account.</span>
                                </label>
                                <label>
                                    <span class="form-label">Phone Number <span class="required">*</span></span>
                                    <input type="tel" name="phone" value="{{ $prefill['phone'] ?? '' }}" required class="form-input">
                                </label>
                                <label>
                                    <span class="form-label">Gender <span class="required">*</span></span>
                                    <select name="gender" required class="form-input">
                                        <option value="" disabled {{ ($prefill['gender'] ?? '') ? '' : 'selected' }}>Select gender</option>
                                        @foreach (['male' => 'Male', 'female' => 'Female', 'other' => 'Other', 'prefer_not_to_say' => 'Prefer not to say'] as $value => $label)
                                            <option value="{{ $value }}" @selected(($prefill['gender'] ?? '') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="md:col-span-2">
                                    <span class="form-label">City <span class="required">*</span></span>
                                    <input type="text" name="city" value="{{ $prefill['city'] ?? '' }}" required class="form-input">
                                </label>
                            </div>

                            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-8 sm:flex-row sm:items-center sm:justify-between">
                                <a href="{{ route('exhibitions.show', $slug) }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 px-6 py-3 text-[15px] font-bold text-gray-600 hover:bg-gray-50">
                                    <i class="ph ph-arrow-left text-lg"></i> Back
                                </a>
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary-600 px-8 py-3 text-[15px] font-bold text-white shadow-[0_4px_14px_rgba(90,50,250,0.25)] hover:bg-primary-700">
                                    Continue to Pass Selection <i class="ph ph-arrow-right text-lg"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="ticket-flow-sidebar w-full shrink-0 lg:w-[340px]">
                    <div class="rounded-2xl border border-gray-100 bg-[#FAFAFA] p-6 shadow-sm lg:sticky lg:top-0">
                        <div class="mb-5 h-[120px] rounded-2xl bg-cover bg-center" style="background-image:url('{{ $bannerImage }}')"></div>
                        <h3 class="text-[18px] font-bold text-[#1E1B4B]">{{ $title }}</h3>
                        <div class="mt-4 space-y-2 text-[14px] text-gray-600">
                            <p><span class="font-bold text-[#1E1B4B]">Date:</span> {{ $dateStr }}</p>
                            <p><span class="font-bold text-[#1E1B4B]">Venue:</span> {{ $location }}</p>
                            <p><span class="font-bold text-[#1E1B4B]">From:</span> {{ $priceLabel }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
