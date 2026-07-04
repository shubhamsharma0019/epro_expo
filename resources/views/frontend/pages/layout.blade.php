@php
    $pageTitle = $pageTitle ?? 'EproExpo';
    $activeNav = $activeNav ?? null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} - EproExpo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('frontend.shared.partials.home-brand-styles')
    @include('frontend.shared.partials.site-navbar-styles')
    @include('frontend.shared.partials.responsive-fixes')
    @stack('head')
</head>
<body class="bg-white font-['Inter',sans-serif] text-[#071044] antialiased">
    @include('frontend.shared.partials.site-navbar', [
        'activeNav' => $activeNav,
        'menuId' => 'pagesNav',
    ])

    <main class="mx-auto max-w-[1540px] px-4 pb-8 pt-5 sm:px-6 sm:pt-7 lg:px-8">
        @yield('content')
    </main>

    @include('frontend.events.partials.home.footer')
    @stack('scripts')
</body>
</html>
