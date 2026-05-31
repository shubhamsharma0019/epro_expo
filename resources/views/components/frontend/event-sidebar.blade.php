<!-- ================= SIDEBAR START ================= -->
<div id="sidebar">
<aside
    class="fixed left-0 top-0 z-30 flex h-[100dvh] w-[232px] -translate-x-full flex-col overflow-hidden border-r border-[#EEEAF6] bg-white text-[#2E315A] shadow-[8px_0_24px_rgba(7,16,68,0.12)] transition-transform duration-200 lg:translate-x-0 lg:shadow-none">

    <div class="h-[88px] px-6 flex items-center border-b border-[#EEEAF6]">
        <x-shared.brand-logo href="{{ url('/events/dashboard') }}" mark-class="h-11 w-11 rounded-[16px] text-[20px]" title-class="text-[23px]" subtitle-class="text-[11px]" />
    </div>

    <nav class="flex-1 px-4 py-6 overflow-y-auto">
        <ul class="space-y-1.5 text-[14px] font-medium">

            <li>
                <a href="{{ url('/events/dashboard') }}" data-nav-item
                    class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-xl text-[#3B406A] hover:bg-[#F7F4FF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 9.75 12 3l8.25 6.75V20.25a.75.75 0 0 1-.75.75H14.25V14.25h-4.5V21H4.5a.75.75 0 0 1-.75-.75V9.75Z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/exhibitions/pavilions') }}" data-nav-item
                    class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-xl text-[#3B406A] hover:bg-[#F7F4FF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25v8.25A2.25 2.25 0 0 1 18.75 18.75H5.25A2.25 2.25 0 0 1 3 16.5V8.25m18 0A2.25 2.25 0 0 0 18.75 6H16.5l-1.04-1.56A1.5 1.5 0 0 0 14.21 3.75H9.79a1.5 1.5 0 0 0-1.25.69L7.5 6H5.25A2.25 2.25 0 0 0 3 8.25m18 0-9 5.25-9-5.25" />
                    </svg>
                    <span>Packages</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/exhibitions/halls') }}" data-nav-item
                    class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-xl text-[#3B406A] hover:bg-[#F7F4FF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 20.25h16.5M5.25 20.25V8.625L12 4.5l6.75 4.125V20.25M9 9.75h.008v.008H9V9.75Zm0 3.75h.008v.008H9V13.5Zm6-3.75h.008v.008H15V9.75Zm0 3.75h.008v.008H15V13.5Z" />
                    </svg>
                    <span>Halls</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/exhibitions/booths/sizes') }}" data-nav-item
                    class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-xl text-[#3B406A] hover:bg-[#F7F4FF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 6.75h9m-11.25 4.5h13.5M6 18.75h12A2.25 2.25 0 0 0 20.25 16.5v-9A2.25 2.25 0 0 0 18 5.25H6A2.25 2.25 0 0 0 3.75 7.5v9A2.25 2.25 0 0 0 6 18.75Z" />
                    </svg>
                    <span>Booths</span>
                </a>
            </li>

            <li class="pt-2">
                <a href="{{ url('/events/listings') }}" data-nav-item aria-current="page"
                    class="sidebar-link is-active flex items-center gap-4 px-4 py-3 rounded-xl bg-[#F3EEFF] text-[#5B35D5]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 2.25v3m7.5-3v3M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v12.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" />
                    </svg>
                    <span>Events</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/exhibitions/booking/my-bookings') }}" data-nav-item
                    class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-xl text-[#3B406A] hover:bg-[#F7F4FF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 3.75h9A2.25 2.25 0 0 1 18.75 6v14.25L12 16.5l-6.75 3.75V6A2.25 2.25 0 0 1 7.5 3.75Z" />
                    </svg>
                    <span>My Bookings</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/events/networking/attendees') }}" data-nav-item
                    class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-xl text-[#3B406A] hover:bg-[#F7F4FF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.75a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3m12 0H21m-3 0H6m12 0v.75A1.5 1.5 0 0 1 16.5 21h-9A1.5 1.5 0 0 1 6 19.5v-.75m9-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 1.5a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0ZM7.5 11.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    <span>Leads</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/events/networking/meetings') }}" data-nav-item
                    class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-xl text-[#3B406A] hover:bg-[#F7F4FF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 10.5 19.5 8.25A1.5 1.5 0 0 1 21.75 9.54v4.92a1.5 1.5 0 0 1-2.25 1.29l-3.75-2.25v2.25A2.25 2.25 0 0 1 13.5 18H5.25A2.25 2.25 0 0 1 3 15.75V8.25A2.25 2.25 0 0 1 5.25 6h8.25a2.25 2.25 0 0 1 2.25 2.25v2.25Z" />
                    </svg>
                    <span>Meetings</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/events/live/livestream') }}" data-nav-item
                    class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-xl text-[#3B406A] hover:bg-[#F7F4FF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 18.75h16.5M6.75 16.5V9.75m5.25 6.75V5.25m5.25 11.25v-4.5" />
                    </svg>
                    <span>Reports</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/events/tickets/invoice') }}" data-nav-item
                    class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-xl text-[#3B406A] hover:bg-[#F7F4FF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 3.75h6l4.5 4.5v10.5A1.5 1.5 0 0 1 16.5 20.25h-9A1.5 1.5 0 0 1 6 18.75V5.25A1.5 1.5 0 0 1 7.5 3.75Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 3.75v4.5H18" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 15h6" />
                    </svg>
                    <span>Invoices</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/events/profile') }}" data-nav-item
                    class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-xl text-[#3B406A] hover:bg-[#F7F4FF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-8.25 12a5.25 5.25 0 1 1 10.5 0" />
                    </svg>
                    <span>Profile</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/events/live/feedback') }}" data-nav-item
                    class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-xl text-[#3B406A] hover:bg-[#F7F4FF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.75 18.75V16.5a2.25 2.25 0 0 1 2.25-2.25h0A2.25 2.25 0 0 1 14.25 16.5v2.25m-4.5 0h4.5M6 16.5A6 6 0 1 1 18 16.5" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 10.5H3.75A1.5 1.5 0 0 0 2.25 12v1.5A1.5 1.5 0 0 0 3.75 15H4.5m15 0h.75a1.5 1.5 0 0 0 1.5-1.5V12a1.5 1.5 0 0 0-1.5-1.5h-.75" />
                    </svg>
                    <span>Support</span>
                </a>
            </li>

            <li class="pt-5 mt-3">
                <a href="{{ url('/') }}" data-nav-item
                    class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-xl text-[#3B406A] hover:bg-[#F7F4FF] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[21px] h-[21px]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.85">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-7.5a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 6 21h7.5a2.25 2.25 0 0 0 2.25-2.25V15" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 15l3-3m0 0-3-3m3 3H9" />
                    </svg>
                    <span>Logout</span>
                </a>
            </li>

        </ul>
    </nav>

</aside>
</div>
<!-- ================= SIDEBAR END ================= -->
