<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page['app_name'] }} - Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html, body {
            min-height: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .custom-checkbox {
            appearance: none;
            background-color: #fff;
            margin: 0;
            width: 1.15em;
            height: 1.15em;
            border: 1px solid #d1d5db;
            border-radius: 0.25em;
            display: grid;
            place-content: center;
            flex-shrink: 0;
        }

        .custom-checkbox::before {
            content: "";
            width: 0.65em;
            height: 0.65em;
            clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
            transform: scale(0);
            transform-origin: bottom left;
            transition: 120ms transform ease-in-out;
            background-color: white;
        }

        .custom-checkbox:checked {
            background-color: #10B981;
            border-color: #10B981;
        }

        .custom-checkbox:checked::before {
            transform: scale(1);
        }
    </style>
</head>
<body class="min-h-dvh bg-white text-[#1a1c29]">
    <div class="grid min-h-dvh w-full lg:grid-cols-2">
        <div class="relative hidden overflow-hidden bg-[#f8f7fc] lg:flex lg:min-h-dvh lg:items-center lg:justify-center lg:p-10 xl:p-14">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(55,35,219,0.08),transparent_42%),radial-gradient(circle_at_bottom_right,rgba(16,185,129,0.08),transparent_38%)]"></div>
            <img
                src="{{ $page['illustration_url'] }}"
                alt="Secure admin dashboard"
                class="relative z-10 h-auto w-full max-w-[min(92%,720px)] object-contain drop-shadow-2xl"
            >
        </div>

        <div class="flex min-h-dvh flex-col bg-white">
            <div class="border-b border-[#ece9f8] bg-[#f8f7fc] px-4 py-5 sm:px-6 lg:hidden">
                <div class="mx-auto flex max-w-md items-center gap-4">
                    <img
                        src="{{ $page['illustration_url'] }}"
                        alt="Secure admin dashboard"
                        class="h-20 w-20 shrink-0 rounded-2xl object-cover object-center shadow-sm sm:h-24 sm:w-24"
                    >
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-[#3723db]">Admin Portal</p>
                        <p class="mt-1 text-[15px] font-semibold leading-5 text-[#1a1c29]">Secure access to your exhibition control center</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-1 items-center justify-center px-4 py-8 sm:px-8 sm:py-10 lg:px-12 xl:px-20">
                <div class="w-full max-w-[440px]">
                    <div class="mb-8 sm:mb-10">
                        <x-shared.frontend-brand-logo
                            href="{{ route('admin.dashboard') }}"
                            subtitle="ADMIN PORTAL"
                            size="compact"
                        />
                    </div>

                    <h1 class="text-[28px] font-bold leading-tight text-[#1a1c29] sm:text-[32px] lg:text-[34px]">
                        {{ $page['title'] }}
                    </h1>
                    <p class="mt-2 text-[15px] font-medium text-[#64748B] sm:mt-3 sm:text-[17px]">
                        {{ $page['subtitle'] }}
                    </p>

                    <form action="{{ route('admin.login.store') }}" method="POST" class="mt-8 space-y-5 sm:mt-10 sm:space-y-6">
                        @csrf

                        @if ($errors->any())
                            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-[14px] font-medium text-red-700">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="space-y-2">
                            <label for="email" class="block text-[14px] font-semibold sm:text-[15px]">Email Address</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="Enter your email"
                                required
                                autocomplete="username"
                                class="w-full rounded-lg border border-gray-200 px-4 py-3.5 text-[15px] text-gray-800 transition-all focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#3723db]"
                            >
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-[14px] font-semibold sm:text-[15px]">Password</label>
                            <div class="relative">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="Enter your password"
                                    required
                                    autocomplete="current-password"
                                    class="w-full rounded-lg border border-gray-200 px-4 py-3.5 pr-12 text-[15px] text-gray-800 transition-all focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#3723db]"
                                >
                                <button
                                    type="button"
                                    id="toggle-password"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 transition-colors hover:text-gray-600"
                                    aria-label="Show password"
                                >
                                    <i class="ph ph-eye text-xl" id="toggle-password-icon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 pt-1 sm:flex-row sm:items-center sm:justify-between">
                            <label class="inline-flex cursor-pointer select-none items-center">
                                <input id="remember-me" name="remember" type="checkbox" class="custom-checkbox cursor-pointer" {{ old('remember') ? 'checked' : '' }}>
                                <span class="ml-2.5 text-[14px] font-medium text-[#475569] sm:text-[15px]">Remember me</span>
                            </label>

                            <a href="#" class="text-[14px] font-medium text-[#3723db] transition-colors hover:text-[#2515a6] sm:text-[15px]">
                                Forgot Password?
                            </a>
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-[10px] border border-transparent bg-[#3723db] px-4 py-4 text-[16px] font-semibold text-white shadow-md transition-all hover:bg-[#2515a6] focus:outline-none focus:ring-2 focus:ring-[#3723db] focus:ring-offset-2 active:scale-[0.98]"
                        >
                            Login
                        </button>
                    </form>

                    <p class="mt-8 text-center text-[13px] font-medium text-[#64748B] sm:mt-10 sm:text-left sm:text-[14px]">
                        {{ $page['footer_text'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        (() => {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('toggle-password');
            const toggleIcon = document.getElementById('toggle-password-icon');

            if (!passwordInput || !toggleButton || !toggleIcon) {
                return;
            }

            toggleButton.addEventListener('click', () => {
                const isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                toggleIcon.classList.toggle('ph-eye', !isHidden);
                toggleIcon.classList.toggle('ph-eye-slash', isHidden);
                toggleButton.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
            });
        })();
    </script>
</body>
</html>
