<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Company Login - EproExpo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; font-family: Inter, sans-serif; color: #071044; background: #EEF3FF; }
        .page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 18px; background: linear-gradient(135deg, #EEF3FF 0%, #FFF5EE 100%); }
        .shell { width: min(1080px, 100%); display: grid; grid-template-columns: 1fr 430px; gap: 24px; }
        .story, .card { border-radius: 24px; background: #fff; border: 1px solid #E7EAF3; box-shadow: 0 24px 70px rgba(7,16,68,.12); }
        .story { min-height: 560px; padding: 38px 46px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; position: relative; }
        .story:after { content: ""; position: absolute; width: 360px; height: 360px; right: -90px; bottom: -110px; border-radius: 50%; background: linear-gradient(135deg, #5b2eff, #FF8A00); opacity: .14; }
        .story h1 { max-width: 560px; margin: 0; font-size: clamp(36px, 5vw, 54px); line-height: 1.04; font-weight: 650; }
        .story p { max-width: 520px; margin: 16px 0 0; color: #5A6480; font-size: 16px; line-height: 1.65; font-weight: 600; }
        .event-strip { position: relative; z-index: 1; display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
        .event-strip div { border-radius: 18px; background: #F8F9FD; border: 1px solid #E7EAF3; padding: 18px; }
        .event-strip strong { display: block; color: #071044; font-size: 20px; }
        .event-strip span { display: block; margin-top: 8px; color: #5A6480; font-size: 12px; font-weight: 700; }
        .card { padding: 30px 38px; display: flex; flex-direction: column; justify-content: center; }
        .card h2 { margin: 0; font-size: 34px; font-weight: 650; }
        .card p { margin: 10px 0 24px; color: #5A6480; font-size: 15px; line-height: 1.6; font-weight: 600; }
        .field { display: block; margin-bottom: 14px; }
        .field span { display: block; margin-bottom: 8px; color: #34405F; font-size: 13px; font-weight: 750; }
        .field input { width: 100%; height: 52px; border: 1px solid #E7EAF3; border-radius: 14px; background: #F8F9FD; padding: 0 18px; font-size: 15px; font-weight: 600; outline: none; }
        .field input:focus { border-color: #5b2eff; background: #fff; }
        .row { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 18px; color: #5A6480; font-size: 14px; font-weight: 650; }
        .row a { color: #5b2eff; text-decoration: none; }
        .error { border-radius: 12px; background: #FEF2F2; padding: 13px 16px; color: #DC2626; font-size: 14px; font-weight: 700; }
        .btn { width: 100%; height: 54px; border: 0; border-radius: 14px; background: linear-gradient(90deg, #5b2eff, #4310d8); color: #fff; font-size: 16px; font-weight: 750; cursor: pointer; }
        .signup { text-align: center; margin-top: 16px !important; font-size: 14px !important; }
        .signup a { color: #5b2eff; font-weight: 750; text-decoration: none; }
        @media (max-width: 940px) { 
            .shell { grid-template-columns: 1fr; gap: 20px; } 
            .story { min-height: auto; gap: 28px; padding: 30px; } 
        }
        @media (max-width: 620px) { 
            .event-strip { grid-template-columns: 1fr; gap: 10px; } 
            .story { padding: 24px 20px; gap: 20px; } 
            .card { padding: 24px 20px; } 
            .story h1 { font-size: 28px; } 
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="shell">
            <div class="story">
                <x-shared.brand-logo href="{{ route('home') }}" mark-class="h-11 w-11 rounded-[16px] text-[20px]" title-class="text-[24px] text-[#071044]" subtitle-class="text-[11px] text-[#8A94AD]" />
                <div>
                    <h1>Create and manage company-hosted events.</h1>
                    <p>Use your company credentials to open the event company workspace for event details, branding, ticket setup, preview and review submission.</p>
                </div>
                <div class="event-strip">
                    <div><strong>01</strong><span>Event Details</span></div>
                    <div><strong>02</strong><span>Tickets & Passes</span></div>
                    <div><strong>03</strong><span>Submit Review</span></div>
                </div>
            </div>

            <div class="card">
                <h2>Event Company Login</h2>
                <p>Sign in to continue your company event organizer flow.</p>
                <form method="POST" action="{{ route('company.event-company.login.store') }}">
                    @csrf
                    <label class="field"><span>Company Email</span><input name="email" type="email" value="{{ old('email') }}" required></label>
                    <label class="field"><span>Password</span><input name="password" type="password" required></label>
                    <div class="row"><label><input type="checkbox" name="remember"> Remember me</label><a href="#">Forgot password?</a></div>
                    @if ($errors->any())<p class="error">{{ $errors->first() }}</p>@endif
                    <button type="submit" class="btn">Open Event Dashboard</button>
                </form>
                <p class="signup">Need a company account? <a href="{{ route('company.event-company.register') }}">Register company</a></p>
                <p class="signup">Booking a booth? <a href="{{ route('company.login') }}">Use exhibition company login</a></p>
            </div>
        </section>
    </main>
</body>
</html>
