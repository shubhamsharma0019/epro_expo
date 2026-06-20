<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('title', 'EproExpo Company')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('frontend.shared.partials.responsive-fixes')
</head>

<body class="h-screen overflow-hidden bg-gray-50 font-outfit text-gray-900 antialiased">
    <div id="company-sidebar-overlay" class="fixed inset-0 z-40 hidden bg-gray-900/40 lg:hidden"></div>
    <div class="flex h-screen overflow-hidden">
        @include('backend.company.partials.dashboard-sidebar')

        <div class="flex h-screen min-w-0 flex-1 flex-col overflow-hidden">
            @include('backend.company.partials.dashboard-topbar')

            @if (session('admin_impersonator_id'))
                <div class="border-b border-amber-200 bg-amber-50 px-4 py-3 text-[13px] font-semibold text-amber-900 sm:px-8">
                    Admin mode: managing {{ session('company_name', 'company') }}.
                    <form method="POST" action="{{ route('admin.companies.stop-impersonation') }}" class="inline">
                        @csrf
                        <button type="submit" class="ml-2 underline">Exit company mode</button>
                    </form>
                </div>
            @endif

            <main class="min-w-0 flex-1 overflow-y-auto bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
    <script>
        (() => {
            const sidebar = document.getElementById('company-sidebar');
            const overlay = document.getElementById('company-sidebar-overlay');
            const openButtons = document.querySelectorAll('[data-company-sidebar-open]');
            const closeButtons = document.querySelectorAll('[data-company-sidebar-close]');

            const openSidebar = () => {
                sidebar?.classList.remove('-translate-x-full');
                overlay?.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };

            const closeSidebar = () => {
                sidebar?.classList.add('-translate-x-full');
                overlay?.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            openButtons.forEach((button) => button.addEventListener('click', openSidebar));
            closeButtons.forEach((button) => button.addEventListener('click', closeSidebar));
            overlay?.addEventListener('click', closeSidebar);

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });
        })();
    </script>
</body>

</html>
