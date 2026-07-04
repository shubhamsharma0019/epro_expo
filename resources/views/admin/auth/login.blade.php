<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eproexpo - Admin Login</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom checkbox style to match the green square with check */
        .custom-checkbox {
            appearance: none;
            background-color: #fff;
            margin: 0;
            font: inherit;
            color: currentColor;
            width: 1.15em;
            height: 1.15em;
            border: 1px solid #d1d5db;
            border-radius: 0.25em;
            display: grid;
            place-content: center;
        }

        .custom-checkbox::before {
            content: "";
            width: 0.65em;
            height: 0.65em;
            clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
            transform: scale(0);
            transform-origin: bottom left;
            transition: 120ms transform ease-in-out;
            box-shadow: inset 1em 1em white;
            background-color: white;
        }

        .custom-checkbox:checked {
            background-color: #10B981; /* Emerald 500 */
            border-color: #10B981;
        }

        .custom-checkbox:checked::before {
            transform: scale(1);
        }
    
        /* Enterprise responsive fixes: prevent side scroll while keeping all data visible */
        html, body { max-width: 100%; overflow-x: hidden; }
        *, *::before, *::after { box-sizing: border-box; }
        main, header, section, .main-scrollbar { min-width: 0; }
        img, svg, video, canvas { max-width: 100%; height: auto; }
        input, select, textarea { max-width: 100%; }
        table { width: 100%; table-layout: fixed; border-collapse: collapse; }
        th, td { white-space: normal !important; overflow-wrap: anywhere; word-break: break-word; vertical-align: top; }
        thead th { line-height: 1.25; letter-spacing: .02em; }
        .overflow-x-visible, .overflow-x-visible { overflow-x: visible !important; }
        .whitespace-normal { white-space: normal !important; }
        .no-scrollbar { scrollbar-width: none; }
        @media (max-width: 1280px) {
            .main-scrollbar { padding-left: 1rem !important; padding-right: 1rem !important; }
            th, td { padding-left: .75rem !important; padding-right: .75rem !important; font-size: 12px !important; }
            header input { width: 240px !important; }
            .tracking-wider { letter-spacing: .02em !important; }
        }
        @media (max-width: 1024px) {
            .lg\:flex-row { flex-direction: column !important; }
            .lg\:items-end { align-items: flex-start !important; }
            th, td { padding-left: .55rem !important; padding-right: .55rem !important; font-size: 11.5px !important; }
            .gap-6 { gap: 1rem !important; }
        }

    
        /* Blade alignment fixes: keep layout clean without horizontal page scroll */
        html, body { max-width: 100%; overflow-x: hidden; }
        *, *::before, *::after { box-sizing: border-box; }
        main, header, section, .main-scrollbar, .grid, .flex-1 { min-width: 0; }
        img, svg, video, canvas { max-width: 100%; height: auto; }
        input, select, textarea { max-width: 100%; }
        .max-w-\[1400px\] { max-width: min(1400px, 100%) !important; }
        .overflow-x-auto, .overflow-x-visible { overflow-x: hidden !important; }
        table { width: 100%; table-layout: fixed; border-collapse: collapse; }
        th, td { white-space: normal !important; overflow-wrap: anywhere; word-break: break-word; vertical-align: top; }
        thead th { line-height: 1.25; letter-spacing: .02em; }
        @media (max-width: 768px) {
            header { padding-left: 1rem !important; padding-right: 1rem !important; }
            .px-8 { padding-left: 1rem !important; padding-right: 1rem !important; }
            .p-8, .lg\:p-8 { padding: 1rem !important; }
        }
    </style>
</head>
<body class="min-h-screen bg-white">
    <div class="flex min-h-screen flex-col lg:flex-row">
        
        <!-- Left Side: Illustration Area (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 bg-[#f8f7fc] items-center justify-center relative overflow-hidden p-12">
            <!-- Include the 3D illustration generated -->
            <img src="{{ asset('admin_assets/illustration.png') }}" alt="Secure Server Dashboard" class="w-full max-w-2xl h-auto object-contain relative z-10 drop-shadow-2xl" />
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex flex-col px-8 sm:px-16 lg:px-24 xl:px-32 py-12">
            
            <div class="flex flex-col h-full justify-center max-w-[440px] w-full mx-auto relative">
                
                <!-- Main Form Content -->
                <div class="flex-1 flex flex-col justify-center mt-12 mb-12">
                    
                    <!-- Logo -->
                    <div class="flex items-center gap-4 mb-12">
                        <x-shared.frontend-brand-logo
                            href="{{ route('admin.dashboard') }}"
                            subtitle="ADMIN PORTAL"
                        />
                    </div>

                    <!-- Headings -->
                    <h1 class="text-[34px] font-bold text-[#1a1c29] mb-3">Welcome Back, Admin</h1>
                    <p class="text-[#64748B] text-[17px] mb-12 font-medium">Sign in to your admin dashboard</p>

                    <!-- Form -->
                    <form action="{{ route('admin.login.store') }}" method="POST" class="space-y-6">
                        @csrf
                        @if ($errors->any())
                            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-[14px] font-medium text-red-700">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        
                        <!-- Email -->
                        <div class="space-y-2.5">
                            <label for="email" class="block text-[15px] font-semibold text-[#1a1c29]">Email Address</label>
                            <input type="email" name="email" id="email" class="w-full px-4 py-3.5 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#3723db] focus:border-transparent transition-all text-[15px] text-gray-800" value="{{ old('email', 'admin@example.com') }}" placeholder="Enter your email" required>
                        </div>

                        <!-- Password -->
                        <div class="space-y-2.5">
                            <label for="password" class="block text-[15px] font-semibold text-[#1a1c29]">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" class="w-full px-4 py-3.5 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#3723db] focus:border-transparent transition-all text-[15px] text-gray-800 tracking-[0.2em]" value="password" placeholder="Enter your password" required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                    <i class="ph ph-eye text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-1">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember-me" type="checkbox" class="custom-checkbox cursor-pointer" checked>
                                <label for="remember-me" class="ml-2.5 block text-[15px] font-medium text-[#475569] cursor-pointer select-none">
                                    Remember me
                                </label>
                            </div>
                            
                            <div class="text-[15px]">
                                <a href="#" class="font-medium text-[#3723db] hover:text-[#2515a6] transition-colors">
                                    Forgot Password?
                                </a>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-5">
                            <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-[10px] shadow-md text-[16px] font-semibold text-white bg-[#3723db] hover:bg-[#2515a6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3723db] transition-all transform active:scale-[0.98]">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Footer -->
                <div class="text-[#64748B] text-[14px] font-medium mt-auto pb-4">
                    &copy; 2024 EproExpo. All rights reserved.
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>
