<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Login - EproExpo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; font-family: Inter, sans-serif; color: #071044; background: #EEF3FF; }
        .page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 34px 18px; background: linear-gradient(135deg, #EEF3FF 0%, #F8F0FF 100%); }
        .shell { width: min(1080px, 100%); display: grid; grid-template-columns: 1fr 430px; gap: 24px; }
        .story, .card { border-radius: 24px; background: #fff; border: 1px solid #E7EAF3; box-shadow: 0 24px 70px rgba(7,16,68,.12); }
        .story { min-height: 620px; padding: 46px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; position: relative; }
        .story:after { content: ""; position: absolute; width: 360px; height: 360px; right: -90px; bottom: -110px; border-radius: 50%; background: linear-gradient(135deg, #5b2eff, #246BFF); opacity: .14; }
        .brand { display: inline-flex; align-items: center; gap: 12px; color: #071044; text-decoration: none; font-size: 24px; font-weight: 750; }
        .brand-mark { width: 46px; height: 46px; border-radius: 14px; display: grid; place-items: center; background: linear-gradient(135deg, #5b2eff, #246BFF); color: #fff; }
        .story h1 { max-width: 560px; margin: 0; font-size: clamp(38px, 5vw, 58px); line-height: 1.04; font-weight: 650; }
        .story p { max-width: 520px; margin: 18px 0 0; color: #5A6480; font-size: 16px; line-height: 1.75; font-weight: 600; }
        .booth-strip { position: relative; z-index: 1; display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
        .booth-strip div { border-radius: 18px; background: #F8F9FD; border: 1px solid #E7EAF3; padding: 18px; }
        .booth-strip strong { display: block; color: #071044; font-size: 20px; }
        .booth-strip span { display: block; margin-top: 8px; color: #5A6480; font-size: 12px; font-weight: 700; }
        .card { padding: 38px; display: flex; flex-direction: column; justify-content: center; }
        .card h2 { margin: 0; font-size: 34px; font-weight: 650; }
        .card p { margin: 12px 0 30px; color: #5A6480; font-size: 15px; line-height: 1.7; font-weight: 600; }
        .field { display: block; margin-bottom: 18px; }
        .field span { display: block; margin-bottom: 8px; color: #34405F; font-size: 13px; font-weight: 750; }
        .field input { width: 100%; height: 56px; border: 1px solid #E7EAF3; border-radius: 14px; background: #F8F9FD; padding: 0 18px; font-size: 15px; font-weight: 600; outline: none; }
        .field input:focus { border-color: #246BFF; background: #fff; }
        .row { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 24px; color: #5A6480; font-size: 14px; font-weight: 650; }
        .row a { color: #5b2eff; text-decoration: none; }
        .error { border-radius: 12px; background: #FEF2F2; padding: 13px 16px; color: #DC2626; font-size: 14px; font-weight: 700; }
        .btn { width: 100%; height: 56px; border: 0; border-radius: 14px; background: linear-gradient(90deg, #5b2eff, #4310d8); color: #fff; font-size: 16px; font-weight: 750; cursor: pointer; }
        .signup { text-align: center; margin-top: 24px !important; font-size: 14px !important; }
        .signup a { color: #5b2eff; font-weight: 750; text-decoration: none; }
        @media (max-width: 940px) { .shell { grid-template-columns: 1fr; } .story { min-height: 440px; } }
        @media (max-width: 620px) { .booth-strip { grid-template-columns: 1fr; } .story, .card { padding: 28px; } }
    </style>
</head>
<body>
    <main class="page">
        <section class="shell">
            <div class="story">
                <x-shared.brand-logo href="{{ route('home') }}" mark-class="h-11 w-11 rounded-[16px] text-[20px]" title-class="text-[24px] text-[#071044]" subtitle-class="text-[11px] text-[#8A94AD]" />
                <div>
                    <h1>Manage booth bookings like a modern exhibitor.</h1>
                    <p>Access pavilions, halls, booth slots, products, catalogues, enquiries, and meetings from your company workspace.</p>
                </div>
                <div class="booth-strip">
                    <div><strong>2</strong><span>Bookings</span></div>
                    <div><strong>128</strong><span>Active Leads</span></div>
                    <div><strong>24</strong><span>Products</span></div>
                </div>
            </div>

            <div class="card">
                <h2>Company Login</h2>
                <p>Sign in to continue your exhibition booking flow.</p>
                <form method="POST" action="{{ url('/company/login') }}">
                    @csrf
                    <label class="field"><span>Company Email</span><input name="email" type="email" value="{{ old('email') }}" required></label>
                    <label class="field"><span>Password</span><input name="password" type="password" required></label>
                    <div class="row"><label><input type="checkbox" name="remember"> Remember me</label><a href="#">Forgot password?</a></div>
                    @if ($errors->any())<p class="error">{{ $errors->first() }}</p>@endif
                    <button type="submit" class="btn">Login</button>
                </form>
                <p class="signup">New exhibitor? <a href="{{ url('/company/register') }}">Register company</a></p>
            </div>
        </section>
    </main>
</body>
</html>
