<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EproExpo')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('frontend.shared.partials.responsive-fixes')
</head>

<body class="min-h-screen bg-white font-[Inter] text-[#071044] antialiased">
    <header class="sticky top-0 z-50 border-b border-[#EEF0F7] bg-white/90 backdrop-blur-xl">
        <div class="mx-auto flex max-w-[1440px] items-center justify-between px-4 py-4 sm:px-6 lg:px-8 lg:py-5">
            <x-shared.frontend-brand-logo />

            <nav class="hidden items-center gap-10 text-[14px] font-semibold text-[#071044] lg:flex">
                <a class="hover:text-[#5726E8]" href="{{ route('events.home') }}">Explore Events</a>
                <a class="text-[#5726E8]" href="{{ route('exhibitions.index') }}">Exhibitions</a>
                <a class="hover:text-[#5726E8]" href="{{ route('home') }}#features">Features</a>
                <a class="hover:text-[#5726E8]" href="{{ route('home') }}#pricing">Pricing</a>
                <a class="hover:text-[#5726E8]" href="{{ route('home') }}#about">About Us</a>
            </nav>

            <div class="hidden items-center gap-4 lg:flex">
                @auth
                    @php
                        $activeSlug = $activeSlug ?? $slug ?? request()->route('slug') ?? 'global-tech-expo-2024';
                    @endphp
                    <div class="relative inline-block text-left" id="blankLayoutDropdownContainer">
                        <button type="button" id="blankLayoutDropdownBtn" class="flex items-center gap-3 cursor-pointer pl-4 border-l border-gray-200 hover:opacity-85 transition-opacity focus:outline-none bg-transparent border-0 p-0">
                            <div class="text-right hidden sm:block">
                                <div class="text-[13px] font-bold text-[#1E293B]">{{ auth()->user()->name }}</div>
                                <div class="text-[11px] text-gray-500 font-medium">{{ ucfirst(auth()->user()->role ?? 'Visitor') }}</div>
                            </div>
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#5A32FA] to-[#246BFF] text-[14px] font-medium text-white shadow-sm">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </span>
                            <i class="fa-solid fa-caret-down text-[14px] text-gray-400"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="blankLayoutDropdownMenu" class="hidden absolute right-0 z-50 mt-2.5 w-48 origin-top-right rounded-xl bg-white py-1.5 shadow-[0_10px_30px_rgba(0,0,0,0.08)] ring-1 ring-black/5 focus:outline-none transition-all duration-200 border border-gray-100">
                            <a href="{{ route('frontend.user.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-gauge text-[14px] text-gray-500 w-4 text-center"></i>
                                Visitor Dashboard
                            </a>
                            <a href="{{ url('/user/dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-ticket text-[14px] text-gray-500 w-4 text-center"></i>
                                My Passes
                            </a>
                            <hr class="border-gray-100 my-1">
                            <form method="POST" action="{{ url('/user/logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-red-600 hover:bg-red-50/50 transition-colors text-left bg-transparent border-0 cursor-pointer">
                                    <i class="fa-solid fa-right-from-bracket text-[14px] text-red-500 w-4 text-center"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const btn = document.getElementById('blankLayoutDropdownBtn');
                            const menu = document.getElementById('blankLayoutDropdownMenu');
                            if (btn && menu) {
                                btn.addEventListener('click', (e) => {
                                    e.stopPropagation();
                                    menu.classList.toggle('hidden');
                                });
                                document.addEventListener('click', (e) => {
                                    if (!btn.contains(e.target) && !menu.contains(e.target)) {
                                        menu.classList.add('hidden');
                                    }
                                });
                            }
                        });
                    </script>
                @else
                    <a href="#exhibition-list" class="rounded-lg bg-gradient-to-r from-[#6D28D9] to-[#4B16D8] px-6 py-3 text-[14px] font-bold text-white shadow-[0_12px_24px_rgba(91,46,255,0.26)]">Get Started</a>
                @endauth
            </div>

            <button type="button" data-blank-mobile-menu-button class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-[#E0E4EF] text-[#071044] lg:hidden" aria-label="Open menu">
                <i class="fa-solid fa-bars text-[18px]"></i>
            </button>
        </div>

        <div data-blank-mobile-menu class="hidden border-t border-[#EEF0F7] bg-white px-4 py-5 sm:px-6 lg:hidden">
            <div class="flex flex-col gap-4 text-[15px] font-semibold text-[#071044]">
                <a href="{{ route('events.home') }}">Explore Events</a>
                <a href="{{ route('exhibitions.index') }}" class="text-[#5726E8]">Exhibitions</a>
                <a href="{{ route('home') }}#features">Features</a>
                <a href="{{ route('home') }}#pricing">Pricing</a>
                <a href="{{ route('home') }}#about">About Us</a>
                @auth
                    @php
                        $activeSlug = $activeSlug ?? $slug ?? request()->route('slug') ?? 'global-tech-expo-2024';
                    @endphp
                    <a href="{{ route('frontend.user.dashboard') }}" class="hover:text-[#5726E8]">Visitor Dashboard</a>
                    <a href="{{ url('/user/dashboard') }}" class="hover:text-[#5726E8]">My Passes</a>
                    <form method="POST" action="{{ url('/user/logout') }}" class="w-full m-0">
                        @csrf
                        <button type="submit" class="w-full text-left font-semibold text-red-600 bg-transparent border-0 p-0 text-[15px] cursor-pointer">Logout</button>
                    </form>
                @else
                    <a href="#exhibition-list" class="rounded-lg bg-[#5726E8] px-5 py-3 text-center font-bold text-white">Get Started</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="min-h-screen min-w-0">
        @yield('content')
    </main>

    @stack('scripts')
    <script>
        (() => {
            const button = document.querySelector('[data-blank-mobile-menu-button]');
            const menu = document.querySelector('[data-blank-mobile-menu]');

            if (!button || !menu) {
                return;
            }

            button.addEventListener('click', () => menu.classList.toggle('hidden'));
            menu.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => menu.classList.add('hidden'));
            });
        })();
    </script>
</body>
</html>
