<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - EproExpo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #ffffff;
            background: linear-gradient(90deg, #8f5aa9 0%, #566bb7 52%, #1f87c4 100%);
        }
        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .auth-card {
            width: min(680px, 100%);
            min-height: 610px;
            padding: 56px clamp(28px, 7vw, 78px);
            border-top-left-radius: 150px;
            background: linear-gradient(90deg, #8bd7fb 0%, #28a4c0 100%);
            box-shadow: 0 28px 70px rgba(7, 16, 68, 0.28);
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
            text-decoration: none;
            font-size: 24px;
            font-weight: 600;
        }
        .brand-mark {
            display: inline-flex;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.22);
            font-size: 22px;
        }
        .auth-title {
            margin: 42px 0 36px;
            text-align: center;
            font-size: clamp(38px, 7vw, 52px);
            line-height: 1;
            font-weight: 500;
            letter-spacing: 0.04em;
            text-transform: lowercase;
        }
        .auth-form {
            width: min(460px, 100%);
            margin: 0 auto;
        }
        .auth-input {
            display: block;
            width: 100%;
            height: 58px;
            margin-bottom: 24px;
            border: 4px solid #2b2b2d;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            padding: 0 24px;
            color: #ffffff;
            font-size: 20px;
            font-weight: 500;
            outline: none;
        }
        .auth-input::placeholder { color: rgba(255, 255, 255, 0.78); }
        .auth-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin: 18px 8px 54px;
            color: #26334a;
            font-size: 16px;
            font-weight: 600;
        }
        .auth-row label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .auth-row input {
            width: 18px;
            height: 18px;
            accent-color: #2b2b2d;
        }
        .auth-row a {
            color: #26334a;
            text-decoration: none;
        }
        .auth-error {
            margin: -30px 0 24px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.92);
            padding: 14px 18px;
            color: #dc2626;
            font-size: 14px;
            font-weight: 700;
        }
        .auth-button {
            display: flex;
            width: min(360px, 100%);
            height: 76px;
            margin: 0 auto;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 999px;
            background: #2b2b2d;
            color: #4f87e9;
            cursor: pointer;
            font-size: clamp(32px, 7vw, 44px);
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .auth-register {
            margin: 42px 0 0;
            text-align: center;
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
        }
        .auth-register a {
            color: #ffffff;
            text-underline-offset: 4px;
        }
        @media (max-width: 640px) {
            .auth-card { min-height: auto; border-top-left-radius: 100px; }
            .auth-row { flex-direction: column; align-items: flex-start; margin-bottom: 36px; }
        }
    </style>
</head>
<body>
    <main class="auth-page">
        <section class="auth-card">
            <span class="inline-flex rounded-2xl bg-white px-3 py-2">
                <x-shared.brand-logo href="{{ route('home') }}" mark-class="h-10 w-10 rounded-[14px] text-[19px]" title-class="text-[23px] text-[#071044]" subtitle-class="text-[10px] text-[#8A94AD]" />
            </span>

            <h1 class="auth-title">sign in</h1>

            <form method="POST" action="{{ url('/admin/login') }}" class="auth-form">
                @csrf
                <input name="email" type="email" value="{{ old('email') }}" placeholder="Admin Email" class="auth-input" required>
                <input name="password" type="password" placeholder="Password" class="auth-input" required>

                <div class="auth-row">
                    <label><input type="checkbox" name="remember"> Remember me</label>
                    <a href="#">Forgot Password</a>
                </div>

                @if ($errors->any())
                    <p class="auth-error">{{ $errors->first() }}</p>
                @endif

                <button type="submit" class="auth-button">Login</button>
            </form>

            <p class="auth-register">Don't have an account? <a href="{{ url('/admin/register') }}">Register here</a></p>
        </section>
    </main>
</body>
</html>
