<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register - EproExpo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-[#020617] antialiased">
@php
    $flowContext = $flowContext ?? request('flow');
    $isEventTicketFlow = $flowContext === 'event_ticket';
    $isExhibitionTicketFlow = $flowContext === 'exhibition_ticket';
    $eventSlug = $eventSlug ?? request('event');
    $exhibitionSlug = $exhibitionSlug ?? request('exhibition');
@endphp
<main class="grid min-h-screen w-full overflow-hidden bg-white lg:grid-cols-[0.88fr_1.12fr]">
    <section class="relative hidden overflow-hidden bg-[#EFF6FF] p-8 lg:flex lg:flex-col lg:justify-between">
        <x-shared.frontend-brand-logo />

        <div>
            <p class="mb-3 text-[12px] font-bold uppercase tracking-[0.18em] text-[#2563EB]">{{ $isEventTicketFlow ? 'Event Ticket Register' : ($isExhibitionTicketFlow ? 'Visitor Pass Register' : 'Visitor Account') }}</p>
            <h1 class="max-w-[450px] text-[44px] font-extrabold leading-[1.05] tracking-[-0.03em] text-[#020617]">{{ $isEventTicketFlow ? 'Create your account and continue event booking.' : ($isExhibitionTicketFlow ? 'Create your account and continue visitor pass booking.' : 'Create your personal expo workspace.') }}</h1>
            <p class="mt-5 max-w-[390px] text-[15px] font-medium leading-7 text-[#64748B]">{{ $isEventTicketFlow ? 'Register once, then continue the same event ticket booking process with your own tickets and dashboard.' : ($isExhibitionTicketFlow ? 'Register once, continue the same exhibition visitor pass flow, then manage your pass from your own dashboard.' : 'Book event tickets, save exhibition booths, track visits and manage enquiries from a calm visitor dashboard.') }}</p>
        </div>

        <div class="grid gap-4">
            @foreach ([['Tickets', 'Book and store all event tickets'], ['Passes', 'Access visitor QR passes fast'], ['Enquiries', 'Follow up with exhibitors']] as [$title, $copy])
                <div class="rounded-[12px] bg-white p-4 shadow-[0_12px_32px_rgba(15,23,42,0.05)]">
                    <h2 class="text-[14px] font-bold text-[#020617]">{{ $title }}</h2>
                    <p class="mt-1 text-[12px] font-medium text-[#64748B]">{{ $copy }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="flex items-center justify-center px-5 py-10 sm:px-10">
        <div class="w-full max-w-[560px]">
            <div class="mb-8 lg:hidden">
                <x-shared.frontend-brand-logo size="compact" />
            </div>

            <p class="text-[12px] font-bold uppercase tracking-[0.18em] text-[#2563EB]">Join As Visitor</p>
            <h2 class="mt-3 text-[34px] font-extrabold tracking-[-0.03em] text-[#020617]">Create User Account</h2>
            <p class="mt-3 text-[14px] font-medium leading-6 text-[#64748B]">{{ $isEventTicketFlow ? 'Create your account first, then continue the same event ticket booking flow.' : ($isExhibitionTicketFlow ? 'Create your account first, then continue the same exhibition visitor pass flow.' : 'Register to manage event tickets, exhibition passes, saved booths and visitor enquiries.') }}</p>

            <form method="POST" action="{{ $isEventTicketFlow ? route('events.visitor.register.store') : ($isExhibitionTicketFlow ? route('exhibitions.visitor.register.store') : url('/user/register')) }}" class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2">
                @csrf
                <input type="hidden" name="flow_context" value="{{ $flowContext }}">
                <label class="block sm:col-span-2">
                    <span class="text-[13px] font-bold text-[#334155]">Full Name</span>
                    <input name="name" value="{{ old('name') }}" required class="mt-2 h-[52px] w-full rounded-[8px] border border-[#E2E8F0] bg-[#F8FAFC] px-4 text-[14px] font-semibold outline-none transition focus:border-[#2563EB] focus:bg-white">
                </label>

                <label class="block">
                    <span class="text-[13px] font-bold text-[#334155]">Email</span>
                    <input name="email" type="email" value="{{ old('email') }}" required class="mt-2 h-[52px] w-full rounded-[8px] border border-[#E2E8F0] bg-[#F8FAFC] px-4 text-[14px] font-semibold outline-none transition focus:border-[#2563EB] focus:bg-white">
                </label>

                <label class="block">
                    <span class="text-[13px] font-bold text-[#334155]">Phone</span>
                    <input name="phone" value="{{ old('phone') }}" class="mt-2 h-[52px] w-full rounded-[8px] border border-[#E2E8F0] bg-[#F8FAFC] px-4 text-[14px] font-semibold outline-none transition focus:border-[#2563EB] focus:bg-white">
                </label>

                <label class="block">
                    <span class="text-[13px] font-bold text-[#334155]">Password</span>
                    <input name="password" type="password" required class="mt-2 h-[52px] w-full rounded-[8px] border border-[#E2E8F0] bg-[#F8FAFC] px-4 text-[14px] font-semibold outline-none transition focus:border-[#2563EB] focus:bg-white">
                </label>

                <label class="block">
                    <span class="text-[13px] font-bold text-[#334155]">Confirm Password</span>
                    <input name="password_confirmation" type="password" required class="mt-2 h-[52px] w-full rounded-[8px] border border-[#E2E8F0] bg-[#F8FAFC] px-4 text-[14px] font-semibold outline-none transition focus:border-[#2563EB] focus:bg-white">
                </label>

                @if ($errors->any())
                    <div class="rounded-[8px] bg-red-50 px-4 py-3 text-[13px] font-bold text-red-600 sm:col-span-2">{{ $errors->first() }}</div>
                @endif

                <button type="submit" class="flex h-[52px] items-center justify-center rounded-[8px] bg-[#2563EB] text-[15px] font-bold text-white shadow-[0_12px_30px_rgba(37,99,235,0.22)] transition hover:bg-[#1D4ED8] sm:col-span-2">
                    Create Account
                </button>
            </form>

            <p class="mt-7 text-center text-[14px] font-medium text-[#64748B]">Already registered? <a href="{{ $isEventTicketFlow ? route('events.visitor.login', array_filter(['event' => $eventSlug])) : ($isExhibitionTicketFlow ? route('exhibitions.visitor.login', array_filter(['exhibition' => $exhibitionSlug])) : url('/user/login')) }}" class="font-bold text-[#2563EB]">Login</a></p>
        </div>
    </section>
</main>
</body>
</html>
