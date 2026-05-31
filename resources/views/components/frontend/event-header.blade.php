<!-- ================= HEADER START ================= -->
<header class="sticky top-0 z-10 flex min-h-[72px] w-full items-center justify-between gap-4 border-b border-[#EEEAF6] bg-white px-4 py-3 sm:px-6 lg:h-[88px] lg:px-8 lg:py-0">

    <div class="flex items-center">
        <button id="menuToggle"
            class="w-10 h-10 flex items-center justify-center rounded-lg text-[#666C8E] hover:bg-[#F6F4FB] transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.9">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>
    </div>

    <div class="flex min-w-0 items-center gap-4 text-[#28316A] sm:gap-7">

        <button
            class="hidden items-center gap-2 text-[14px] font-medium text-[#28316A] transition hover:text-[#5B35D5] sm:flex">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.6 9h16.8M3.6 15h16.8M12 3c2.4 2.45 3.75 5.65 3.75 9S14.4 18.55 12 21M12 3c-2.4 2.45-3.75 5.65-3.75 9S9.6 18.55 12 21" />
            </svg>
            <span>EN</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
            </svg>
        </button>

        <button class="relative text-[#28316A] hover:text-[#5B35D5] transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-[20px] h-[20px]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75v-.7V9a6 6 0 1 0-12 0v.05-.05.7a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.565 1.08 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>
            <span class="absolute -top-0.5 -right-0.5 w-2 h-2 rounded-full bg-[#FF5B6E]"></span>
        </button>

        <div id="profileDropdownBtn" class="relative flex items-center gap-3 cursor-pointer select-none">
            <img src="https://i.pravatar.cc/100?img=12" alt="User"
                class="w-10 h-10 rounded-full object-cover ring-2 ring-[#4B5BFF]" />

            <div class="hidden leading-tight sm:block">
                <h3 class="text-[16px] font-semibold text-[#28316A]">
                    John Doe
                </h3>
                <p class="text-[13px] text-[#6A708F] mt-1">
                    Exhibitor
                </p>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-4 h-4 text-[#28316A] sm:block" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
            </svg>

            <div id="profileDropdown"
                class="hidden absolute top-[58px] right-0 w-52 bg-white border border-[#ECE8F5] rounded-2xl shadow-[0_18px_50px_rgba(24,31,74,0.08)] overflow-hidden z-50">
                <a href="{{ url('/events/profile') }}" class="block px-5 py-3 text-sm text-[#3A416A] hover:bg-[#F7F4FF]">My Profile</a>
                <a href="{{ url('/events/profile/settings') }}" class="block px-5 py-3 text-sm text-[#3A416A] hover:bg-[#F7F4FF]">Settings</a>
                <a href="#" class="block px-5 py-3 text-sm text-[#D1445B] hover:bg-[#FFF4F6]">Logout</a>
            </div>
        </div>

    </div>

</header>
<!-- ================= HEADER END ================= -->
