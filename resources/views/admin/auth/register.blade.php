<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register - EproExpo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#F8F9FD] font-sans text-navy antialiased">
    <main class="flex min-h-screen items-center justify-center px-5 py-10">
        <section class="w-full max-w-[560px] rounded-xl border border-borderColor bg-white p-6 shadow-sm sm:p-8">
            <x-shared.brand-logo href="{{ route('home') }}" mark-class="h-11 w-11 rounded-[16px] text-[20px]" title-class="text-[24px] text-[#071044]" subtitle-class="text-[11px] text-[#8A94AD]" />
            <h1 class="mt-8 text-[30px] font-semibold text-navy">Create Admin Account</h1>
            <p class="mt-3 text-[15px] font-medium leading-7 text-[#5A6480]">Create separate admin credentials for platform management.</p>

            <form method="POST" action="{{ url('/admin/register') }}" class="mt-8 grid gap-5 sm:grid-cols-2">
                @csrf
                <label class="block sm:col-span-2"><span class="text-[14px] font-semibold text-[#34405F]">Name</span><input name="name" value="{{ old('name') }}" class="mt-2 h-[52px] w-full rounded-md border border-borderColor px-4 outline-none focus:border-purple" required></label>
                <label class="block"><span class="text-[14px] font-semibold text-[#34405F]">Email</span><input name="email" type="email" value="{{ old('email') }}" class="mt-2 h-[52px] w-full rounded-md border border-borderColor px-4 outline-none focus:border-purple" required></label>
                <label class="block"><span class="text-[14px] font-semibold text-[#34405F]">Phone</span><input name="phone" value="{{ old('phone') }}" class="mt-2 h-[52px] w-full rounded-md border border-borderColor px-4 outline-none focus:border-purple"></label>
                <label class="block"><span class="text-[14px] font-semibold text-[#34405F]">Password</span><input name="password" type="password" class="mt-2 h-[52px] w-full rounded-md border border-borderColor px-4 outline-none focus:border-purple" required></label>
                <label class="block"><span class="text-[14px] font-semibold text-[#34405F]">Confirm Password</span><input name="password_confirmation" type="password" class="mt-2 h-[52px] w-full rounded-md border border-borderColor px-4 outline-none focus:border-purple" required></label>
                @if ($errors->any())<p class="rounded-md bg-[#FFE9E9] px-4 py-3 text-[14px] font-medium text-[#DC2626] sm:col-span-2">{{ $errors->first() }}</p>@endif
                <button type="submit" class="inline-flex h-[54px] items-center justify-center rounded-md bg-gradient-to-r from-[#5b2eff] to-[#4310d8] text-[16px] font-semibold text-white sm:col-span-2">Register</button>
            </form>

            <p class="mt-6 text-center text-[14px] font-medium text-[#5A6480]">Already registered? <a href="{{ url('/admin/login') }}" class="font-semibold text-purple">Login</a></p>
        </section>
    </main>
</body>
</html>
