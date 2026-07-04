<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - EproExpo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans text-[#020617] antialiased" style="background: linear-gradient(135deg, #EEF3FF 0%, #FFF5EE 100%);">
@php
    $flowContext = $flowContext ?? request('flow');
    $isEventTicketFlow = $flowContext === 'event_ticket';
    $isExhibitionTicketFlow = $flowContext === 'exhibition_ticket';
    $eventSlug = $eventSlug ?? request('event');
    $exhibitionSlug = $exhibitionSlug ?? request('exhibition');
    $contextCard = $contextCard ?? [
        'label' => 'Visitor Login',
        'title' => 'Your Expo Dashboard',
        'meta' => 'Tickets, passes, visits and enquiries in one place.',
        'step' => 'Secure sign in',
        'progress' => 100,
        'icon' => 'fa-compass',
    ];
@endphp
<main class="grid min-h-screen w-full overflow-hidden lg:grid-cols-[0.92fr_1.08fr]">
    <section class="relative hidden overflow-hidden bg-[#EFF6FF]/80 p-8 backdrop-blur-[1px] lg:flex lg:flex-col lg:justify-between">
        <x-shared.frontend-brand-logo />

        <div>
            <p class="mb-3 text-[12px] font-bold uppercase tracking-[0.18em] text-[#2563EB]">{{ $isEventTicketFlow ? 'Event Ticket Login' : ($isExhibitionTicketFlow ? 'Visitor Pass Login' : 'Visitor Login') }}</p>
            <h1 class="max-w-[460px] text-[46px] font-extrabold leading-[1.04] tracking-[-0.03em] text-[#020617]">{{ $isEventTicketFlow ? 'Login to continue your event ticket booking.' : ($isExhibitionTicketFlow ? 'Login to access your visitor dashboard.' : 'Manage your tickets, passes, visits and enquiries.') }}</h1>
            <p class="mt-5 max-w-[390px] text-[15px] font-medium leading-7 text-[#64748B]">{{ $isEventTicketFlow ? 'Sign in first, then continue the same event ticket booking flow with your own account and dashboard.' : ($isExhibitionTicketFlow ? 'Existing visitors land on their exhibition dashboard first, while new visitors can still register and continue the pass flow.' : 'Sign in to continue your expo journey and keep every event touchpoint in one focused dashboard.') }}</p>
        </div>

        <div class="rounded-[14px] bg-white p-5 shadow-[0_12px_32px_rgba(15,23,42,0.05)]">
            <div class="flex items-center justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-[11px] font-semibold text-[#64748B]">{{ $contextCard['label'] }}</p>
                    <h2 class="mt-2 break-words text-[22px] font-bold text-[#020617]">{{ $contextCard['title'] }}</h2>
                    @if (filled($contextCard['meta'] ?? null))
                        <p class="mt-1 break-words text-[12px] font-medium leading-5 text-[#64748B]">{{ $contextCard['meta'] }}</p>
                    @endif
                </div>
                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-[10px] bg-[#2563EB] text-white"><i class="fa-solid {{ $contextCard['icon'] }}"></i></span>
            </div>
            @if (($contextCard['progress'] ?? 100) < 100)
                <div class="mt-4 flex items-center justify-between text-[11px] font-semibold text-[#64748B]">
                    <span>{{ $contextCard['step'] }}</span>
                    <span class="text-[#2563EB]">{{ $contextCard['progress'] }}%</span>
                </div>
                <div class="mt-2 h-[7px] overflow-hidden rounded-full bg-blue-100">
                    <div class="h-full rounded-full bg-[#2563EB]" style="width: {{ min(100, max(8, (int) ($contextCard['progress'] ?? 100))) }}%"></div>
                </div>
            @endif
        </div>
    </section>

    <section class="flex items-center justify-center bg-white/90 px-5 py-10 backdrop-blur-sm sm:px-10">
        <div class="w-full max-w-[430px]">
            <div class="mb-9 lg:hidden">
                <x-shared.frontend-brand-logo size="compact" />
            </div>

            @if ($isEventTicketFlow || $isExhibitionTicketFlow)
                <div class="mb-6 rounded-[14px] border border-[#E2E8F0] bg-[#EFF6FF] p-4 lg:hidden">
                    <p class="text-[11px] font-semibold text-[#64748B]">{{ $contextCard['label'] }}</p>
                    <h2 class="mt-2 break-words text-[18px] font-bold text-[#020617]">{{ $contextCard['title'] }}</h2>
                    @if (filled($contextCard['meta'] ?? null))
                        <p class="mt-1 break-words text-[12px] font-medium text-[#64748B]">{{ $contextCard['meta'] }}</p>
                    @endif
                </div>
            @endif

            <p class="text-[12px] font-bold uppercase tracking-[0.18em] text-[#2563EB]">Welcome Back</p>
            <h2 class="mt-3 text-[34px] font-extrabold tracking-[-0.03em] text-[#020617]">User Login</h2>
            <p class="mt-3 text-[14px] font-medium leading-6 text-[#64748B]">{{ $isEventTicketFlow ? 'Login first, then continue the same ticket booking process for this event.' : ($isExhibitionTicketFlow ? 'Existing visitor accounts go to the exhibition dashboard first, and new visitors can create an account to continue the pass flow.' : 'Access your visitor dashboard, booked tickets, saved booths and enquiries.') }}</p>

            <form method="POST" action="{{ $isEventTicketFlow ? route('events.visitor.login.store') : ($isExhibitionTicketFlow ? route('exhibitions.visitor.login.store') : url('/user/login')) }}" class="mt-8 space-y-5">
                @csrf
                <input type="hidden" name="flow_context" value="{{ $flowContext }}">
                <label class="block">
                    <span class="text-[13px] font-bold text-[#334155]">Email</span>
                    <input name="email" type="email" value="{{ old('email') }}" required class="mt-2 h-[52px] w-full rounded-[8px] border border-[#E2E8F0] bg-[#F8FAFC] px-4 text-[14px] font-semibold outline-none transition focus:border-[#2563EB] focus:bg-white">
                </label>

                <label class="block">
                    <span class="text-[13px] font-bold text-[#334155]">Password</span>
                    <input name="password" type="password" required class="mt-2 h-[52px] w-full rounded-[8px] border border-[#E2E8F0] bg-[#F8FAFC] px-4 text-[14px] font-semibold outline-none transition focus:border-[#2563EB] focus:bg-white">
                </label>

                <div class="flex flex-col gap-3 text-[13px] font-semibold text-[#64748B] sm:flex-row sm:items-center sm:justify-between">
                    <label class="flex items-center gap-2"><input type="checkbox" name="remember" class="rounded border-[#CBD5E1] text-[#2563EB]"> Remember me</label>
                    <a href="#" class="text-[#2563EB]">Forgot password?</a>
                </div>

                @if ($errors->any())
                    <div class="rounded-[8px] bg-red-50 px-4 py-3 text-[13px] font-bold text-red-600">{{ $errors->first() }}</div>
                @endif

                <button type="submit" class="flex h-[52px] w-full items-center justify-center rounded-[8px] bg-[#2563EB] text-[15px] font-bold text-white shadow-[0_12px_30px_rgba(37,99,235,0.22)] transition hover:bg-[#1D4ED8]">
                    Login
                </button>
            </form>

            <p class="mt-7 text-center text-[14px] font-medium text-[#64748B]">New visitor? <a href="{{ $isEventTicketFlow ? route('events.visitor.register', array_filter(['event' => $eventSlug])) : ($isExhibitionTicketFlow ? route('exhibitions.visitor.register', array_filter(['exhibition' => $exhibitionSlug])) : url('/user/register')) }}" class="font-bold text-[#2563EB]">Create account</a></p>
        </div>
    </section>
</main>
</body>
</html>
