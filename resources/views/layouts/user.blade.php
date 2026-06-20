<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EproExpo User')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('frontend.shared.partials.responsive-fixes')
    <style>
        .user-app {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .user-app h1,
        .user-app h2,
        .user-app h3,
        .user-app h4,
        .user-app h5,
        .user-app h6 {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-weight: 500 !important;
            letter-spacing: 0;
        }
    </style>
</head>
<body class="user-app bg-[#F5F7FC] font-sans text-navy overflow-x-hidden antialiased lg:h-screen lg:overflow-hidden">
    <div class="flex min-h-screen w-full flex-col bg-[#F5F7FC] lg:flex-row lg:h-screen lg:overflow-hidden">
        <div id="user-sidebar-overlay" class="fixed inset-0 z-40 hidden bg-[#071044]/40 lg:hidden"></div>
        @include('components.user.user-sidebar')
        <main class="flex-1 min-w-0 bg-[#F5F7FC] flex flex-col lg:h-screen lg:overflow-hidden">
            @include('components.user.user-topbar')
            <div class="flex-1 overflow-y-auto">
                @yield('content')
                @include('components.user.user-footer')
            </div>
        </main>
    </div>
    <script>
        (() => {
            const sidebar = document.getElementById('user-sidebar');
            const overlay = document.getElementById('user-sidebar-overlay');
            const openButtons = document.querySelectorAll('[data-user-sidebar-open]');
            const closeButtons = document.querySelectorAll('[data-user-sidebar-close]');
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
        })();
    </script>
</body>
</html>
