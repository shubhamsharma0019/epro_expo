<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EproExpo')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('frontend.shared.partials.home-brand-styles')
    @include('frontend.shared.partials.site-navbar-styles')
    @include('frontend.shared.partials.responsive-fixes')
    @stack('head')
</head>

<body class="min-h-screen bg-white font-[Inter] text-[#071044] antialiased">
    @php
        $activeNav = $activeNav ?? (request()->routeIs('exhibitions.*') ? 'exhibitions' : null);
        $footerPage = $activeNav === 'exhibitions' ? 'exhibitions' : 'home';
    @endphp

    @include('frontend.shared.partials.site-navbar', [
        'activeNav' => $activeNav,
        'menuId' => 'exhibitionsNav',
    ])

    <main class="min-h-screen min-w-0">
        @yield('content')
    </main>

    @include('frontend.shared.partials.marketing-footer-shell', ['footerPage' => $footerPage])

    @stack('scripts')
</body>
</html>
