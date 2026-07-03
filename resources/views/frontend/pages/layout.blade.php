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
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('frontend.shared.partials.responsive-fixes')
    @stack('head')
</head>
<body class="event-home bg-[#fbfbff] font-['Inter',sans-serif] text-[#071044] antialiased">
    @include('frontend.events.partials.home.header', ['activeNav' => $activeNav])

    <main class="mx-auto max-w-[1540px] px-4 pb-8 pt-5 sm:px-6 sm:pt-7 lg:px-8">
        @yield('content')
    </main>

    @include('frontend.events.partials.home.footer')
    @stack('scripts')
</body>
</html>
