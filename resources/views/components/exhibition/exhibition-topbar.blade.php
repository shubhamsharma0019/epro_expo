@php
    $activeSlug = request()->route('slug') ?? 'global-tech-expo-2026';

    $topLinks = [
        ['Browse', route('exhibitions.index'), request()->routeIs('exhibitions.index') || request()->routeIs('exhibitions.browse') || request()->routeIs('exhibitions.show')],
        ['Companies', route('exhibitions.visitor.companies', $activeSlug), request()->routeIs('exhibitions.visitor.companies*')],
        ['Halls & Map', route('exhibitions.visitor.floor-map', $activeSlug), request()->routeIs('exhibitions.visitor.floor-map') || request()->routeIs('exhibitions.halls.*') || request()->routeIs('exhibitions.visitor-halls.*')],
        ['Sessions', route('exhibitions.visitor.sessions', $activeSlug), request()->routeIs('exhibitions.visitor.sessions')],
    ];
@endphp

<header class="sticky top-0 z-30 border-b border-borderColor bg-white/95 px-5 py-3 shadow-sm backdrop-blur sm:px-8 lg:px-8">
    <div class="flex min-h-[60px] items-center justify-between gap-4">
        <div class="flex min-w-0 items-center gap-3">
            <button type="button" data-sidebar-open class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-borderColor text-navy lg:hidden">
                <i class="fa-solid fa-bars text-[16px]"></i>
            </button>

            <nav class="hidden min-w-0 items-center gap-1 rounded-xl bg-[#FBFAFF] p-1 lg:flex">
                @foreach ($topLinks as [$label, $href, $active])
                    <a href="{{ $href }}" class="inline-flex h-10 items-center rounded-lg px-4 text-[13px] font-semibold transition {{ $active ? 'bg-white text-purple shadow-sm' : 'text-navy hover:text-purple' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>

            <div class="min-w-0 lg:hidden">
                <p class="truncate text-[15px] font-semibold text-navy">Visitor Exhibition</p>
                <p class="truncate text-[12px] font-medium text-[#5A6480]">Companies, halls, pass and sessions</p>
            </div>
        </div>

        <div class="flex shrink-0 items-center gap-2 sm:gap-3">
            <a href="{{ route('exhibitions.tickets.select', $activeSlug) }}" class="hidden h-10 items-center rounded-lg bg-[#5b2eff] px-4 text-[13px] font-bold text-white shadow-[0_8px_18px_rgba(91,46,255,0.18)] sm:inline-flex">
                Get Pass
            </a>

            <a href="{{ route('exhibitions.visitor.notifications', $activeSlug) }}" class="grid h-10 w-10 place-items-center rounded-lg border border-borderColor text-navy hover:bg-[#F8F7FF] hover:text-purple" title="Notifications">
                <i class="fa-regular fa-bell text-[17px]"></i>
            </a>

            <div class="relative inline-block text-left" id="exhTopbarDropdownContainer">
                <button type="button" id="exhTopbarDropdownBtn" class="flex items-center gap-3 cursor-pointer pl-4 border-l border-borderColor hover:opacity-85 transition-opacity focus:outline-none bg-transparent border-0 p-0">
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
                    <i class="fa-solid fa-caret-down text-[14px] text-gray-400"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="exhTopbarDropdownMenu" class="hidden absolute right-0 z-50 mt-2.5 w-48 origin-top-right rounded-xl bg-white py-1.5 shadow-[0_10px_30px_rgba(0,0,0,0.08)] ring-1 ring-black/5 focus:outline-none transition-all duration-200 border border-borderColor">
                    @auth
                        <a href="{{ route('exhibitions.visitor.dashboard', $activeSlug) }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-gauge text-[14px] text-gray-500 w-4 text-center"></i>
                            Visitor Dashboard
                        </a>
                        <a href="{{ url('/user/dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-ticket text-[14px] text-gray-500 w-4 text-center"></i>
                            My Passes
                        </a>
                        <hr class="border-borderColor my-1">
                        <form method="POST" action="{{ url('/user/logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-red-600 hover:bg-red-50/50 transition-colors text-left bg-transparent border-0 cursor-pointer">
                                <i class="fa-solid fa-right-from-bracket text-[14px] text-red-500 w-4 text-center"></i>
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ url('/user/login') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-right-to-bracket text-[14px] text-gray-500 w-4 text-center"></i>
                            Login
                        </a>
                        <a href="{{ url('/user/register') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-user-plus text-[14px] text-gray-500 w-4 text-center"></i>
                            Register
                        </a>
                    @endauth
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const btn = document.getElementById('exhTopbarDropdownBtn');
                    const menu = document.getElementById('exhTopbarDropdownMenu');
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
</header>
