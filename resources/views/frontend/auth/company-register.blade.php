<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($flowContext ?? request('flow')) === 'event_company' ? 'Event Company Register' : 'Company Register' }} - EproExpo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; font-family: Inter, sans-serif; color: #071044; background: #EEF3FF; }
        .page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 18px; overflow: hidden; background: linear-gradient(135deg, #EEF3FF 0%, #F8F0FF 100%); }
        .shell { width: min(1220px, 100%); display: grid; grid-template-columns: .92fr 1.08fr; gap: 24px; }
        .story, .card { border-radius: 24px; background: #fff; border: 1px solid #E7EAF3; box-shadow: 0 24px 70px rgba(7,16,68,.12); }
        .story { height: calc(100vh - 36px); min-height: 560px; max-height: 760px; padding: 38px; display: flex; flex-direction: column; justify-content: center; gap: 56px; overflow: hidden; position: relative; }
        .story:after { content: ""; position: absolute; width: 360px; height: 360px; right: -90px; bottom: -110px; border-radius: 50%; background: linear-gradient(135deg, #5b2eff, #246BFF); opacity: .14; }
        .story h1 { max-width: 560px; margin: 0; font-size: clamp(36px, 4.6vw, 54px); line-height: 1.04; font-weight: 650; }
        .story p { max-width: 520px; margin: 18px 0 0; color: #5A6480; font-size: 16px; line-height: 1.75; font-weight: 600; }
        .booth-strip { display: none; }
        .booth-strip div { border-radius: 18px; background: #F8F9FD; border: 1px solid #E7EAF3; padding: 18px; }
        .booth-strip strong { display: block; color: #071044; font-size: 20px; }
        .booth-strip span { display: block; margin-top: 8px; color: #5A6480; font-size: 12px; font-weight: 700; }
        .card { height: calc(100vh - 36px); min-height: 560px; max-height: 760px; padding: 34px 38px; display: flex; flex-direction: column; justify-content: center; overflow: hidden; }
        .card h2 { margin: 0; font-size: 32px; font-weight: 650; }
        .card p.intro { margin: 10px 0 24px; color: #5A6480; font-size: 15px; line-height: 1.55; font-weight: 600; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px 18px; }
        .field { display: block; min-width: 0; }
        .field span { display: block; margin-bottom: 8px; color: #34405F; font-size: 13px; font-weight: 750; }
        .field input { width: 100%; height: 46px; border: 1px solid #E7EAF3; border-radius: 14px; background: #F8F9FD; padding: 0 16px; font-size: 15px; font-weight: 600; outline: none; }
        .field input:focus { border-color: #246BFF; background: #fff; }
        .error { grid-column: 1 / -1; margin: 0; border-radius: 12px; background: #FEF2F2; padding: 13px 16px; color: #DC2626; font-size: 14px; font-weight: 700; }
        .btn { grid-column: 1 / -1; width: 100%; height: 50px; border: 0; border-radius: 14px; background: linear-gradient(90deg, #5b2eff, #4310d8); color: #fff; font-size: 16px; font-weight: 750; cursor: pointer; }
        .signup { text-align: center; margin: 16px 0 0 !important; color: #5A6480; font-size: 14px !important; font-weight: 600; }
        .signup a { color: #5b2eff; font-weight: 750; text-decoration: none; }
        @media (max-width: 1040px) { .page { overflow: auto; } .shell { grid-template-columns: 1fr; } .story, .card { height: auto; max-height: none; } .story { min-height: 420px; } }
        @media (max-width: 620px) { .page { padding: 16px; } .story, .card { padding: 28px; } .story-brand { margin-bottom: 22px; } .booth-strip, .form-grid { grid-template-columns: 1fr; } .story h1 { font-size: 38px; } }
    </style>
</head>
<body>
    @php
        $flowContext = $flowContext ?? request('flow');
        $isEventCompanyFlow = $flowContext === 'event_company';
    @endphp

    <main class="page">
        <section class="shell">
            <div class="story">
                <x-shared.brand-logo href="{{ route('home') }}" class="story-brand" mark-class="h-11 w-11 rounded-[16px] text-[20px]" title-class="text-[24px] text-[#071044]" subtitle-class="text-[11px] text-[#8A94AD]" subtitle="{{ $isEventCompanyFlow ? 'ORGANIZER SUITE' : 'EXHIBITOR SUITE' }}" />
                <div>
                    <h1>{{ $isEventCompanyFlow ? 'Create and manage company-hosted events.' : 'Manage booth bookings like a modern exhibitor.' }}</h1>
                    <p>{{ $isEventCompanyFlow ? 'Register your company to create events, configure tickets, add branding, preview details, and submit for review.' : 'Access pavilions, halls, booth slots, products, catalogues, enquiries, and meetings from your company workspace.' }}</p>
                </div>
                <div class="booth-strip">
                    <div><strong>{{ $isEventCompanyFlow ? '01' : '2' }}</strong><span>{{ $isEventCompanyFlow ? 'Event Details' : 'Bookings' }}</span></div>
                    <div><strong>{{ $isEventCompanyFlow ? '02' : '128' }}</strong><span>{{ $isEventCompanyFlow ? 'Tickets & Passes' : 'Active Leads' }}</span></div>
                    <div><strong>{{ $isEventCompanyFlow ? '03' : '24' }}</strong><span>{{ $isEventCompanyFlow ? 'Submit Review' : 'Products' }}</span></div>
                </div>
            </div>

            <div class="card">
                <h2>{{ $isEventCompanyFlow ? 'Register Event Company' : 'Register Company' }}</h2>
                <p class="intro">{{ $isEventCompanyFlow ? 'Create company credentials to open your own event organizer dashboard and manage your company events.' : 'Create exhibitor credentials for booth booking and company profile management.' }}</p>

                <form method="POST" action="{{ $isEventCompanyFlow ? route('company.event-company.register.store') : url('/company/register') }}" class="form-grid">
                    @csrf
                    <input type="hidden" name="flow_context" value="{{ $flowContext }}">
                    <label class="field"><span>Company Name</span><input name="company_name" value="{{ old('company_name') }}" required></label>
                    <label class="field"><span>Contact Person</span><input name="contact_person_name" value="{{ old('contact_person_name') }}" required></label>
                    <label class="field"><span>Email</span><input name="email" type="email" value="{{ old('email') }}" required></label>
                    <label class="field"><span>Phone</span><input name="phone" value="{{ old('phone') }}"></label>
                    <label class="field"><span>Website</span><input name="website" value="{{ old('website') }}"></label>
                    <label class="field"><span>Industry</span><input name="industry" value="{{ old('industry') }}"></label>
                    <label class="field"><span>City</span><input name="city" value="{{ old('city') }}"></label>
                    <label class="field"><span>Country</span><input name="country" value="{{ old('country') }}"></label>
                    <label class="field"><span>Password</span><input name="password" type="password" required></label>
                    <label class="field"><span>Confirm Password</span><input name="password_confirmation" type="password" required></label>
                    @if (isset($errors) && $errors->any())<p class="error">{{ $errors->first() }}</p>@endif
                    <button type="submit" class="btn">{{ $isEventCompanyFlow ? 'Register Event Company' : 'Register Company' }}</button>
                </form>

                <p class="signup">Already have company credentials? <a href="{{ $isEventCompanyFlow ? route('company.event-company.login') : url('/company/login') }}">Login</a></p>
            </div>
        </section>
    </main>
</body>
</html>