<header class="border-b border-gray-100 px-4 py-4 md:px-10 md:py-5 flex items-center justify-between bg-white w-full h-full">
    <div class="flex items-center gap-3">
        <!-- Hamburger Menu for Mobile -->
        <button id="mobile-menu-toggle" class="lg:hidden text-gray-500 hover:text-primary-600 focus:outline-none transition p-1.5 rounded-lg hover:bg-gray-100 cursor-pointer">
            <i class="ph ph-list text-[26px]"></i>
        </button>
    </div>
    <div class="flex items-center gap-6 ml-auto">
        <button class="text-gray-500 hover:text-primary-600 transition">
            <i class="ph ph-bell text-[22px]"></i>
        </button>
        <button class="text-gray-500 hover:text-primary-600 transition">
            <i class="ph ph-envelope-simple text-[22px]"></i>
        </button>
@php
    $activeSlug = $slug ?? request()->route('slug') ?? 'global-tech-expo-2024';
@endphp
        <div class="relative inline-block text-left" id="profileDropdownContainer">
            <button type="button" id="profileDropdownBtn" class="flex items-center gap-3 cursor-pointer pl-4 border-l border-gray-100 hover:opacity-85 transition-opacity focus:outline-none bg-transparent border-0 p-0">
                @auth
                    <div class="text-right hidden sm:block">
                        <div class="text-[13px] font-bold text-[#1E293B]">{{ auth()->user()->name }}</div>
                        <div class="text-[11px] text-gray-500 font-medium">{{ ucfirst(auth()->user()->role ?? 'Visitor') }}</div>
                    </div>
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#5A32FA] to-[#246BFF] text-[14px] font-medium text-white shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </span>
                @else
                    <div class="text-right hidden sm:block">
                        <div class="text-[13px] font-bold text-[#1E293B]">Guest Visitor</div>
                        <div class="text-[11px] text-gray-500 font-medium">Guest</div>
                    </div>
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-gray-400 to-gray-500 text-[14px] font-medium text-white shadow-sm">
                        G
                    </span>
                @endauth
                <i class="ph ph-caret-down text-[14px] text-gray-400"></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="profileDropdownMenu" class="hidden absolute right-0 z-50 mt-2.5 w-48 origin-top-right rounded-xl bg-white py-1.5 shadow-[0_10px_30px_rgba(0,0,0,0.08)] ring-1 ring-black/5 focus:outline-none transition-all duration-200 border border-gray-50">
                @auth
                    <a href="{{ route('exhibitions.visitor.dashboard', $activeSlug) }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="ph ph-layout text-[16px] text-gray-500"></i>
                        Visitor Dashboard
                    </a>
                    <a href="{{ url('/user/dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="ph ph-ticket text-[16px] text-gray-500"></i>
                        My Passes
                    </a>
                    <hr class="border-gray-100 my-1">
                    <form method="POST" action="{{ url('/user/logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-red-600 hover:bg-red-50/50 transition-colors text-left bg-transparent border-0 cursor-pointer">
                            <i class="ph ph-sign-out text-[16px] text-red-500"></i>
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ url('/user/login') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="ph ph-sign-in text-[16px] text-gray-500"></i>
                        Login
                    </a>
                    <a href="{{ url('/user/register') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="ph ph-user-plus text-[16px] text-gray-500"></i>
                        Register
                    </a>
                @endauth
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const btn = document.getElementById('profileDropdownBtn');
                const menu = document.getElementById('profileDropdownMenu');
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
    </div>
</header>

<!-- Mobile Navigation Drawer -->
<div id="mobile-drawer" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div id="mobile-drawer-backdrop" class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity opacity-0 duration-300"></div>
    
    <!-- Drawer Content -->
    <aside id="mobile-drawer-content" class="absolute top-0 bottom-0 left-0 w-64 bg-white shadow-xl flex flex-col h-full z-10 -translate-x-full transition-transform duration-300">
        <!-- Drawer Header -->
        <div class="p-6 flex items-center justify-between border-b border-gray-50">
            <div class="flex items-center gap-3">
                <div class="bg-primary-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-lg">e</div>
                <span class="font-bold text-xl text-[#1E1B4B] tracking-tight">eproexpo</span>
            </div>
            <button id="mobile-drawer-close" class="text-gray-400 hover:text-gray-600 transition p-1.5 rounded-lg hover:bg-gray-50 cursor-pointer">
                <i class="ph ph-x text-[22px]"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 space-y-1 mt-4 overflow-y-auto no-scrollbar">
            <a href="{{ url('/exhibitions') }}" class="flex items-center gap-4 mx-4 px-4 py-2.5 text-gray-500 hover:text-gray-900 rounded-xl font-medium text-[13px] transition-colors">
                <i class="ph ph-house text-[20px]"></i>
                <span>Home</span>
            </a>
            <a href="lobby.html" class="flex items-center gap-4 mx-4 px-4 py-2.5 text-gray-500 hover:text-gray-900 rounded-xl font-medium text-[13px] transition-colors">
                <i class="ph ph-monitor-play text-[20px]"></i>
                <span>Lobby</span>
            </a>
            <a href="{{ url('/exhibitions') }}" class="flex items-center gap-4 mx-4 px-4 py-2.5 text-gray-500 hover:text-gray-900 rounded-xl font-medium text-[13px] transition-colors">
                <i class="ph ph-image text-[20px]"></i>
                <span>Exhibitions</span>
            </a>
            <a href="pavallion.html" class="flex items-center gap-4 mx-4 px-4 py-2.5 text-gray-500 hover:text-gray-900 rounded-xl font-medium text-[13px] transition-colors">
                <i class="ph ph-bank text-[20px]"></i>
                <span>Pavilions</span>
            </a>
            <a href="halls.html" class="flex items-center gap-4 mx-4 px-4 py-2.5 text-gray-500 hover:text-gray-900 rounded-xl font-medium text-[13px] transition-colors">
                <i class="ph ph-buildings text-[20px]"></i>
                <span>Halls</span>
            </a>
            <a href="resources.html" class="flex items-center gap-4 mx-4 px-4 py-2.5 text-gray-500 hover:text-gray-900 rounded-xl font-medium text-[13px] transition-colors">
                <i class="ph ph-files text-[20px]"></i>
                <span>Resources</span>
            </a>
            
            <div class="pt-4 pb-2 px-8 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Account</div>
            
            <a href="my-visits.html" class="flex items-center gap-4 mx-4 px-4 py-2.5 text-gray-500 hover:text-gray-900 rounded-xl font-medium text-[13px] transition-colors">
                <i class="ph ph-map-pin text-[20px]"></i>
                <span>My Visits</span>
            </a>
            <a href="my-tickets.html" class="flex items-center gap-4 mx-4 px-4 py-2.5 text-gray-500 hover:text-gray-900 rounded-xl font-medium text-[13px] transition-colors">
                <i class="ph ph-ticket text-[20px]"></i>
                <span>My Tickets</span>
            </a>
            <a href="checkin.html" class="flex items-center gap-4 mx-4 px-4 py-2.5 text-gray-500 hover:text-gray-900 rounded-xl font-medium text-[13px] transition-colors">
                <i class="ph ph-check-square-offset text-[20px]"></i>
                <span>Check-In</span>
            </a>
        </nav>
    </aside>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const closeBtn = document.getElementById('mobile-drawer-close');
        const drawer = document.getElementById('mobile-drawer');
        const backdrop = document.getElementById('mobile-drawer-backdrop');
        const content = document.getElementById('mobile-drawer-content');

        if (toggleBtn && drawer && backdrop && content) {
            function openDrawer() {
                drawer.classList.remove('hidden');
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                    content.classList.remove('-translate-x-full');
                    content.classList.add('translate-x-0');
                }, 10);
            }

            function closeDrawer() {
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0');
                content.classList.remove('translate-x-0');
                content.classList.add('-translate-x-full');
                setTimeout(() => {
                    drawer.classList.add('hidden');
                }, 300);
            }

            toggleBtn.addEventListener('click', openDrawer);
            closeBtn.addEventListener('click', closeDrawer);
            backdrop.addEventListener('click', closeDrawer);
            
            // Highlight current page active link in drawer
            const currentPath = window.location.pathname.split('/').pop() || 'exhibitions';
            const links = content.querySelectorAll('nav a');
            links.forEach(link => {
                const linkPath = link.getAttribute('href');
                if ((linkPath && linkPath.includes(currentPath)) || (currentPath === 'exhibitions' && linkPath && linkPath.includes('exhibitions'))) {
                    link.className = 'flex items-center gap-4 mx-4 px-4 py-2.5 bg-primary-50 text-primary-600 rounded-xl font-bold text-[13px] transition-colors';
                }
            });
        }
    });
</script>
