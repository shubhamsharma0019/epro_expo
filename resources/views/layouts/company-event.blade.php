<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Company Event Flow | eproexpo')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('frontend.shared.partials.responsive-fixes')
    @include('components.company.company-layout-styles')
    <style>
        @media (min-width: 1024px) {
            #company-event-sidebar {
                box-sizing: border-box;
                width: 280px;
            }

            .company-event-flow-main {
                margin-left: 280px;
            }
        }

        @media (max-width: 1023px) {
            .company-event-flow-main {
                padding-top: 0;
            }

            .company-event-flow-main-no-topbar {
                padding-top: 0;
            }
        }

        .text-textMain { color: #1C1364; }
        .text-textMuted { color: #6B7280; }
        .text-primary { color: #5B32F6; }
        .text-success { color: #10B981; }
        .text-warning { color: #F59E0B; }
        .bg-primary { background-color: #5B32F6; }
        .bg-primary-light { background-color: #F3F4F6; }
        .bg-success-light { background-color: #ECFDF5; }
        .bg-warning-light { background-color: #FFFBEB; }
        .border-primary { border-color: #5B32F6; }
        .border-borderLight { border-color: #E5E7EB; }
        .hover\:text-primary:hover { color: #5B32F6; }
        .hover\:bg-primary:hover { background-color: #5B32F6; }
        .hover\:border-primary:hover { border-color: #5B32F6; }
    </style>
    @stack('styles')
</head>

<body class="company-event-flow overflow-x-hidden bg-white font-sans text-[#1C1364] antialiased">
    <div id="company-event-sidebar-overlay" class="fixed inset-0 z-40 hidden bg-[#1C1364]/35 lg:hidden"></div>

    @include('company.event-company-flow.layout.sidebar')

    @php
        $hideCompanyEventTopbar = trim($__env->yieldContent('hideTopbar')) === 'true';
    @endphp

    <main class="company-event-flow-main {{ $hideCompanyEventTopbar ? 'company-event-flow-main-no-topbar' : '' }} min-h-screen min-w-0 overflow-x-hidden bg-[#F8F9FC] transition-all duration-300">
        @unless ($hideCompanyEventTopbar)
            @include('company.event-company-flow.layout.topbar')
        @endunless

        @if (session('status'))
            <div class="mx-5 mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-700 sm:mx-8 lg:mx-10">
                {{ session('status') }}
            </div>
        @endif

        @if (($errors ?? null)?->any())
            <div class="mx-5 mt-5 rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700 sm:mx-8 lg:mx-10">
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
    <script>
        (() => {
            const sidebar = document.getElementById('company-event-sidebar');
            const overlay = document.getElementById('company-event-sidebar-overlay');
            const openButtons = document.querySelectorAll('[data-company-event-sidebar-open]');
            const closeButtons = document.querySelectorAll('[data-company-event-sidebar-close]');

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
    @include('company.layout.notification-badge-script')
</body>

</html>
