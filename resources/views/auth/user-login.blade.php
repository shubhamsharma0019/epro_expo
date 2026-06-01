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
<body class="min-h-screen bg-white font-sans text-[#020617] antialiased">
<main class="grid min-h-screen w-full overflow-hidden bg-white lg:grid-cols-[0.92fr_1.08fr]">
    <section class="relative hidden overflow-hidden bg-gradient-to-br from-[#EFF6FF] via-[#F4F0FF] to-[#EAF2FF] p-8 lg:flex lg:flex-col lg:justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="grid grid-cols-2 gap-[3px]">
                <i class="h-[10px] w-[10px] rounded-[2px] bg-[#2563EB]"></i>
                <i class="h-[10px] w-[10px] rounded-[2px] bg-sky-400"></i>
                <i class="h-[10px] w-[10px] rounded-[2px] bg-sky-400"></i>
                <i class="h-[10px] w-[10px] rounded-[2px] bg-[#2563EB]"></i>
            </span>
            <span class="text-[22px] font-bold text-[#020617]">EproExpo</span>
        </a>

        <div>
            <p class="mb-3 text-[12px] font-bold uppercase tracking-[0.18em] text-[#5B2EFF]">Visitor Login</p>
            <h1 class="max-w-[460px] text-[46px] font-extrabold leading-[1.04] tracking-[-0.03em] text-[#020617]">Manage your tickets, passes, visits and enquiries.</h1>
            <p class="mt-5 max-w-[390px] text-[15px] font-medium leading-7 text-[#52627A]">Sign in to continue your expo journey and keep every event touchpoint in one focused dashboard.</p>
        </div>

        <div class="rounded-[16px] border border-white bg-white/90 p-5 shadow-[0_18px_42px_rgba(91,46,255,0.10)]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-[#64748B]">Active Visitor Pass</p>
                    <h2 class="mt-2 text-[22px] font-bold text-[#020617]">Global Tech Expo</h2>
                </div>
                <span class="grid h-12 w-12 place-items-center rounded-[12px] bg-[#5B2EFF] text-white shadow-[0_10px_22px_rgba(91,46,255,0.22)]"><i class="fa-regular fa-id-card"></i></span>
            </div>
            <div class="mt-5 h-[7px] overflow-hidden rounded-full bg-[#EDE9FE]">
                <div class="h-full w-[85%] rounded-full bg-gradient-to-r from-[#5B2EFF] to-[#2563EB]"></div>
            </div>
        </div>
    </section>

    <section class="flex items-center justify-center px-5 py-10 sm:px-10">
        <div class="w-full max-w-[430px]">
            <div class="mb-9 lg:hidden">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="grid grid-cols-2 gap-[3px]">
                        <i class="h-[10px] w-[10px] rounded-[2px] bg-[#2563EB]"></i>
                        <i class="h-[10px] w-[10px] rounded-[2px] bg-sky-400"></i>
                        <i class="h-[10px] w-[10px] rounded-[2px] bg-sky-400"></i>
                        <i class="h-[10px] w-[10px] rounded-[2px] bg-[#2563EB]"></i>
                    </span>
                    <span class="text-[22px] font-bold text-[#020617]">EproExpo</span>
                </a>
            </div>

            <p class="text-[12px] font-bold uppercase tracking-[0.18em] text-[#5B2EFF]">Welcome Back</p>
            <h2 class="mt-3 text-[34px] font-extrabold tracking-[-0.03em] text-[#020617]">User Login</h2>
            <p class="mt-3 text-[14px] font-medium leading-6 text-[#64748B]">Access your visitor dashboard, booked tickets, saved booths and enquiries.</p>

            <form method="POST" action="{{ url('/user/login') }}" class="mt-8 space-y-5">
                @csrf
                <label class="block">
                    <span class="text-[13px] font-bold text-[#334155]">Email</span>
                    <input name="email" type="email" value="{{ old('email') }}" required class="mt-2 h-[52px] w-full rounded-[10px] border border-[#E2E8F0] bg-[#F8FAFC] px-4 text-[14px] font-semibold outline-none transition focus:border-[#5B2EFF] focus:bg-white focus:ring-4 focus:ring-[#5B2EFF]/10">
                </label>

                <label class="block">
                    <span class="text-[13px] font-bold text-[#334155]">Password</span>
                    <input name="password" type="password" required class="mt-2 h-[52px] w-full rounded-[10px] border border-[#E2E8F0] bg-[#F8FAFC] px-4 text-[14px] font-semibold outline-none transition focus:border-[#5B2EFF] focus:bg-white focus:ring-4 focus:ring-[#5B2EFF]/10">
                </label>

                <div class="flex items-center justify-between gap-4 text-[13px] font-semibold text-[#64748B]">
                    <label class="flex items-center gap-2"><input type="checkbox" name="remember" class="rounded border-[#CBD5E1] text-[#5B2EFF]"> Remember me</label>
                    <a href="#" class="text-[#5B2EFF]">Forgot password?</a>
                </div>

                @if ($errors->any())
                    <div class="rounded-[8px] bg-red-50 px-4 py-3 text-[13px] font-bold text-red-600">{{ $errors->first() }}</div>
                @endif

                <button type="submit" class="flex h-[52px] w-full items-center justify-center rounded-[10px] bg-gradient-to-r from-[#5B2EFF] to-[#4310D8] text-[15px] font-bold text-white shadow-[0_14px_30px_rgba(91,46,255,0.24)] transition hover:shadow-[0_16px_34px_rgba(91,46,255,0.30)]">
                    Login
                </button>
            </form>

            <p class="mt-7 text-center text-[14px] font-medium text-[#64748B]">New visitor? <a href="{{ url('/user/register') }}" class="font-bold text-[#5B2EFF]">Create account</a></p>
        </div>
    </section>
</main>
</body>
</html>