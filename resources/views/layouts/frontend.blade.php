<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EproExpo - Exhibition & Event Management Platform')</title>

    {{-- Bunny Font: Inter --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('frontend.shared.partials.responsive-fixes')
</head>

<body class="min-h-screen bg-white font-[Inter] text-[#071044] antialiased">

    <div class="min-h-screen flex flex-col overflow-x-hidden">

        {{-- Header --}}
        @include('components.frontend.frontend-header')

        {{-- Main Content --}}
        <main class="flex-1 min-w-0">
            @yield('content')
        </main>

    </div>

    @stack('scripts')
</body>
</html>
