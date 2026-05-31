<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'EproExpo Admin')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-app bg-[#F5F7FC] font-sans text-navy overflow-x-hidden antialiased">
    <div class="flex min-h-screen w-full flex-col bg-[#F5F7FC] lg:flex-row">
        <div id="admin-sidebar-overlay" class="fixed inset-0 z-40 hidden bg-[#071044]/40 lg:hidden"></div>

        @include('components.admin.admin-sidebar')

        <main class="flex-1 min-w-0 bg-[#F5F7FC]">
            @include('components.admin.admin-topbar')

            @yield('content')

            @include('components.admin.admin-footer')
        </main>
    </div>

    @stack('scripts')
    <script>
        (() => {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('admin-sidebar-overlay');
            const openButtons = document.querySelectorAll('[data-admin-sidebar-open]');
            const closeButtons = document.querySelectorAll('[data-admin-sidebar-close]');

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
                    overlay?.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        })();
    </script>
</body>

</html>
