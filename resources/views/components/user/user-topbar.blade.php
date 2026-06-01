@php
    $quickLinks = [
        ['Home', '/', 'fa-solid fa-house'],
        ['Events', '/events', 'fa-regular fa-calendar'],
        ['Exhibitions', '/exhibitions', 'fa-solid fa-building-columns'],
        ['My Passes', '/user/exhibition-tickets', 'fa-regular fa-id-card'],
    ];
@endphp

<header class="sticky top-0 z-30 border-b border-[#E7EAF3] bg-white/96 backdrop-blur-xl">
    <div class="flex h-[76px] items-center gap-4 px-5 sm:px-8 lg:px-8">
        <button type="button" data-user-sidebar-open class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl border border-[#E7EAF3] bg-white text-[#071044] shadow-sm lg:hidden">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="hidden shrink-0 items-center gap-2 rounded-full border border-[#E7EAF3] bg-[#F8FAFF] p-1 lg:flex">
            @foreach ($quickLinks as [$label, $href, $icon])
                <a href="{{ url($href) }}" class="inline-flex h-9 items-center gap-2 rounded-full px-4 text-[13px] font-medium text-[#34405F] transition hover:bg-white hover:text-[#5b2eff] hover:shadow-sm">
                    <i class="{{ $icon }} text-[12px]"></i>
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="min-w-0 flex-1">
            <label class="relative block max-w-[620px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[14px] text-[#7A849D]"></i>
                <input type="search" placeholder="Search events, booths, tickets..." class="h-12 w-full rounded-full border border-[#E2E7F3] bg-[#F7F9FE] pl-11 pr-20 text-[14px] font-medium text-[#071044] outline-none transition placeholder:text-[#8A94AD] focus:border-[#5b2eff] focus:bg-white focus:ring-4 focus:ring-[#5b2eff]/10">
                <span class="pointer-events-none absolute right-3 top-1/2 hidden -translate-y-1/2 rounded-full border border-[#E7EAF3] bg-white px-2.5 py-1 text-[11px] font-medium text-[#8A94AD] sm:inline-flex">Ctrl K</span>
            </label>
        </div>

        <div class="flex shrink-0 items-center gap-2 sm:gap-3">
            <a href="{{ url('/user/tickets') }}" class="hidden h-11 items-center justify-center gap-2 rounded-full border border-[#E7EAF3] bg-white px-4 text-[13px] font-medium text-[#071044] shadow-sm transition hover:border-[#5b2eff] hover:text-[#5b2eff] md:inline-flex">
                <i class="fa-solid fa-ticket text-[12px]"></i>
                Tickets
            </a>
            <button type="button" class="relative flex h-11 w-11 items-center justify-center rounded-full border border-[#E7EAF3] bg-white text-[#071044] shadow-sm transition hover:border-[#5b2eff] hover:text-[#5b2eff]">
                <i class="fa-regular fa-bell text-[18px]"></i>
                <span class="absolute right-2.5 top-2.5 h-2 w-2 rounded-full bg-[#246BFF] ring-2 ring-white"></span>
            </button>
            <div class="relative inline-block text-left" id="userTopbarDropdownContainer">
                <button type="button" id="userTopbarDropdownBtn" class="flex items-center gap-3 cursor-pointer pl-4 border-l border-[#E7EAF3] hover:opacity-85 transition-opacity focus:outline-none bg-transparent border-0 p-0">
                    <div class="text-right hidden sm:block">
                        <div class="text-[13px] font-bold text-[#1E293B]">{{ auth()->user()->name ?? 'Unknown User' }}</div>
                        <div class="text-[11px] text-gray-500 font-medium">Visitor</div>
                    </div>
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#5b2eff] to-[#246BFF] text-[14px] font-medium text-white shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </span>
                    <i class="fa-solid fa-caret-down text-[14px] text-gray-400"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="userTopbarDropdownMenu" class="hidden absolute right-0 z-50 mt-2.5 w-48 origin-top-right rounded-xl bg-white py-1.5 shadow-[0_10px_30px_rgba(0,0,0,0.08)] ring-1 ring-black/5 focus:outline-none transition-all duration-200 border border-[#E7EAF3]">
                    <a href="{{ route('exhibitions.visitor.dashboard', 'global-tech-expo-2024') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-gauge text-[14px] text-gray-500 w-4 text-center"></i>
                        Visitor Dashboard
                    </a>
                    <a href="{{ url('/user/dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-ticket text-[14px] text-gray-500 w-4 text-center"></i>
                        My Passes
                    </a>
                    <a href="{{ url('/user/profile') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-user text-[14px] text-gray-500 w-4 text-center"></i>
                        My Profile
                    </a>
                    <hr class="border-[#E7EAF3] my-1">
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
                    const btn = document.getElementById('userTopbarDropdownBtn');
                    const menu = document.getElementById('userTopbarDropdownMenu');
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
    </div>

    <div class="flex gap-2 overflow-x-auto border-t border-[#F0F2F8] px-5 py-2 sm:px-8 lg:hidden">
        @foreach ($quickLinks as [$label, $href, $icon])
            <a href="{{ url($href) }}" class="inline-flex h-9 shrink-0 items-center gap-2 rounded-full bg-[#F8FAFF] px-4 text-[13px] font-medium text-[#34405F]">
                <i class="{{ $icon }} text-[12px]"></i>
                {{ $label }}
            </a>
        @endforeach
    </div>
</header>
