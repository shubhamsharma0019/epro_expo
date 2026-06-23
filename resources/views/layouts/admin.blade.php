<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'EproExpo Admin')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('frontend.shared.partials.responsive-fixes')
    @include('components.admin.admin-layout-styles')
    <style>
        /* Sidebar Fix: Ensure the sidebar is fixed and has a constant width on desktop viewports */
        @media (min-width: 1024px) {
            #admin-sidebar {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                width: 260px !important;
                transform: translate(0, 0) !important;
                z-index: 50 !important;
            }
            
            /* Ensure the main content is shifted to the right and never overlaps with the fixed sidebar */
            .admin-app main {
                margin-left: 260px !important;
                width: calc(100% - 260px) !important;
                min-width: 0 !important;
            }
        }
    </style>
</head>

<body class="admin-app bg-[#F5F7FC] font-sans text-navy overflow-x-hidden antialiased">
    <div id="admin-sidebar-overlay" class="fixed inset-0 z-40 hidden bg-[#071044]/40 lg:hidden"></div>

    @include('components.admin.admin-sidebar')

    <main class="min-h-screen min-w-0 bg-[#F5F7FC] lg:ml-[260px]">
        @include('components.admin.admin-topbar')

        <div class="admin-main-content">
            @yield('content')
        </div>

        @include('components.admin.admin-footer')
    </main>

    <script src="{{ asset('admin_assets/admin-sidebar-active.js') }}"></script>
    @stack('scripts')
    <script>
        (() => {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('admin-sidebar-overlay');
            const openButtons = document.querySelectorAll('[data-admin-sidebar-open]');
            const closeButtons = document.querySelectorAll('[data-admin-sidebar-close]');

            const openSidebar = () => {
                sidebar?.classList.remove('-translate-x-full');
                sidebar?.classList.add('translate-x-0');
                overlay?.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };

            const closeSidebar = () => {
                sidebar?.classList.add('-translate-x-full');
                sidebar?.classList.remove('translate-x-0');
                overlay?.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            openButtons.forEach((button) => button.addEventListener('click', openSidebar));
            closeButtons.forEach((button) => button.addEventListener('click', closeSidebar));
            overlay?.addEventListener('click', closeSidebar);

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    sidebar?.classList.remove('-translate-x-full');
                    sidebar?.classList.remove('translate-x-0');
                    overlay?.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        })();
    </script>
</body>

</html>
