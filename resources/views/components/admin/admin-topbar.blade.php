<header class="sticky top-0 z-30 flex h-[76px] items-center justify-between border-b border-gray-100 bg-white px-5 sm:px-8">
    <div class="flex items-center gap-4">
        <button
            type="button"
            class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-[#0B132C] lg:hidden"
            data-admin-sidebar-open
            aria-label="Open sidebar"
        >
            <i class="ph ph-list text-xl"></i>
        </button>
        <div class="admin-topbar-title min-w-0 sm:block">
            <p class="hidden text-[12px] font-medium uppercase tracking-[0.18em] text-gray-400 sm:block">Admin Workspace</p>
            <h1 class="truncate text-[16px] font-bold text-[#0B132C] sm:text-[18px]">@yield('page-title', 'Dashboard')</h1>
        </div>
    </div>

    <div class="flex items-center gap-3 sm:gap-5">
        <div class="hidden md:block">
            <form method="GET" action="{{ url()->current() }}" class="relative">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ $adminTopbar['search'] ?? request('search') }}"
                    placeholder="Search admin data..."
                    class="h-11 w-[280px] rounded-xl border border-gray-200 bg-[#F8F9FC] pl-10 pr-4 text-[14px] text-[#0B132C] outline-none transition focus:border-[#3723db] focus:ring-1 focus:ring-[#3723db]"
                >
            </form>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ $adminTopbar['notifications_url'] ?? route('admin.notifications.index') }}" class="relative inline-flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition hover:border-[#3723db] hover:text-[#3723db]" aria-label="Admin notifications">
                <i class="ph ph-bell text-lg"></i>
                @if (($adminTopbar['notifications'] ?? 0) > 0)
                    <span class="absolute -right-1 -top-1 inline-flex min-w-[18px] items-center justify-center rounded-full bg-[#FF5B6B] px-1.5 text-[10px] font-bold text-white">
                        {{ $adminTopbar['notifications'] }}
                    </span>
                @endif
            </a>
            <a href="{{ $adminTopbar['messages_url'] ?? route('admin.enquiries.index') }}" class="relative inline-flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition hover:border-[#3723db] hover:text-[#3723db]" aria-label="Admin enquiries">
                <i class="ph ph-chat-circle-dots text-lg"></i>
                @if (($adminTopbar['messages'] ?? 0) > 0)
                    <span class="absolute -right-1 -top-1 inline-flex min-w-[18px] items-center justify-center rounded-full bg-[#3B82F6] px-1.5 text-[10px] font-bold text-white">
                        {{ $adminTopbar['messages'] }}
                    </span>
                @endif
            </a>
        </div>

        <div class="hidden sm:block">
            <a href="{{ $adminTopbar['profile_url'] ?? route('admin.settings.index') }}" class="inline-flex items-center gap-3 rounded-full border border-gray-200 px-2.5 py-1.5 transition hover:bg-gray-50">
                <img src="{{ $adminTopbar['avatar_url'] ?? 'https://ui-avatars.com/api/?name=Admin+User&background=3723db&color=fff' }}" alt="Admin" class="h-9 w-9 rounded-full">
                <span class="text-left">
                    <span class="block text-[13px] font-bold leading-none text-[#0B132C]">{{ $adminTopbar['name'] ?? 'Admin User' }}</span>
                    <span class="block pt-1 text-[11px] font-medium leading-none text-gray-500">{{ $adminTopbar['role'] ?? 'Super Admin' }}</span>
                </span>
            </a>
        </div>
    </div>
</header>
