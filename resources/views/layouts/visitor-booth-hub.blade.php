@php
    $pageUser = $user ?? auth()->user();
    $initials = collect(explode(' ', $pageUser->name ?? 'V'))->filter()->take(2)->map(fn ($w) => strtoupper(substr($w, 0, 1)))->implode('');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Booth Hub - eproexpo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#4c33c3',
                        textMain: '#1e293b',
                        textMuted: '#64748b',
                        bgMain: '#f8f9fc',
                    },
                    boxShadow: {
                        card: '0 2px 10px rgba(0,0,0,0.03)',
                        nav: '0 2px 10px rgba(0,0,0,0.02)',
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @include('frontend.user.partials.visitor-portal-responsive')
    @include('frontend.shared.partials.responsive-fixes')
    @yield('page-styles')
</head>
<body class="font-sans text-textMain bg-bgMain antialiased min-h-screen overflow-x-hidden">

    <nav class="h-[72px] bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 shadow-nav z-50 sticky top-0">
        <div class="flex items-center gap-4">
            <x-shared.frontend-brand-logo subtitle="" />
        </div>

        <div class="relative" id="boothHubUserMenu">
            <button type="button" id="boothHubUserBtn" class="flex items-center gap-2 md:gap-3 pl-4 md:pl-5 border-l border-gray-200 cursor-pointer group focus:outline-none">
                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-semibold text-[15px]">{{ $initials }}</div>
                <div class="leading-tight hidden sm:block text-left">
                    <div class="text-[13px] font-bold text-slate-800 group-hover:text-primary transition-colors">{{ $pageUser->name }}</div>
                    <div class="text-[11px] font-medium text-slate-500">Visitor</div>
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
            </button>
            <div id="boothHubUserDropdown" class="absolute right-0 z-50 mt-2 hidden w-48 origin-top-right rounded-xl border border-gray-100 bg-white py-1.5 shadow-lg">
                <a href="{{ route('frontend.user.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50">
                    <i class="fa-solid fa-chart-pie text-[14px] text-gray-500"></i> Dashboard
                </a>
                <a href="{{ route('frontend.user.passes') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50">
                    <i class="fa-solid fa-ticket-simple text-[14px] text-gray-500"></i> My Passes
                </a>
                <a href="{{ route('frontend.user.profile') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-gray-50">
                    <i class="fa-regular fa-user text-[14px] text-gray-500"></i> Profile
                </a>
                <hr class="my-1 border-gray-100">
                <a href="{{ route('frontend.user.logout.confirm') }}" class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-semibold text-red-600 hover:bg-red-50">
                    <i class="fa-solid fa-right-from-bracket text-[14px] text-red-500"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('boothHubUserBtn');
            const menu = document.getElementById('boothHubUserDropdown');
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

    @yield('content')
</body>
</html>
