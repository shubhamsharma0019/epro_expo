@php
    $assetBase = asset('images/events-home');
    $categories = $categories ?? [];
    $events = $events ?? [];
    $countries = $countries ?? [];
    $slots = $slots ?? [];
    $tickets = $tickets ?? [];
    $sampleTicket = $sampleTicket ?? null;

    $steps = [
        ['Find Your Event', 'Browse events by category, country, or search for specific topics.'],
        ['Choose Your Slot', 'Select the event and pick from available time slots.'],
        ['Book & Pay', 'Secure your spot by booking your ticket online.'],
        ['Get Your Ticket', 'Receive your e-ticket instantly via email and dashboard.'],
        ['Join & Enjoy', 'Join the event live and enjoy the sessions and interactions.'],
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EproExpo Events</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('frontend.shared.partials.responsive-fixes')
</head>
<body class="event-home bg-[#fbfbff] font-['Inter',sans-serif] text-[#071044] antialiased">
    @include('frontend.events.partials.home.header')

    <main class="mx-auto max-w-[1540px] px-4 pb-8 pt-5 sm:px-6 sm:pt-7 lg:px-8">
        @include('frontend.events.partials.home.hero')
        @include('frontend.events.partials.home.categories')
        @include('frontend.events.partials.home.trending')
        @include('frontend.events.partials.home.discovery')
    </main>

    @include('frontend.events.partials.home.footer')
</body>
</html>
