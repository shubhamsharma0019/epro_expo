<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Meet Setup</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F4F6FB] text-[#1B2559]">
    <main class="mx-auto max-w-3xl px-5 py-10">
        <h1 class="text-3xl font-bold">Google Meet Setup</h1>
        <p class="mt-2 text-[#5A6480]">For local development only. Credentials from this page are saved automatically to <code>.env</code>.</p>
        <p class="mt-2 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            Google does not accept <strong>192.168.x.x</strong> addresses. Use this URL for setup:
            <code class="mt-1 block break-all text-[13px]">{{ $setupUrl }}</code>
        </p>

        @if (session('status'))
            <div class="mt-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">{{ session('error') }}</div>
        @endif

        <section class="mt-8 rounded-xl border border-[#E4E7EF] bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold">Step 1 — Google Cloud Console</h2>
            <ol class="mt-4 list-decimal space-y-2 pl-5 text-[15px] text-[#34405F]">
                <li>Open <a class="text-[#0F9D58] underline" href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a> and create a new project.</li>
                <li><strong>APIs & Services → Library</strong> → enable <strong>Google Calendar API</strong>.</li>
                <li>Set up the <strong>OAuth consent screen</strong> (External) and add your Gmail as a test user.</li>
                <li><strong>Credentials → Create OAuth client ID → Web application</strong></li>
                <li>Add this exact URL under Authorized redirect URIs:
                    <code class="mt-2 block break-all rounded bg-[#F4F6FB] px-3 py-2 text-sm">{{ $redirectUri }}</code>
                </li>
            </ol>
        </section>

        <section class="mt-6 rounded-xl border border-[#E4E7EF] bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold">Step 2 — Paste Client ID & Secret here</h2>
            <form method="POST" action="{{ route('setup.google-meet.credentials') }}" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-semibold text-[#5A6480]">GOOGLE_CLIENT_ID</label>
                    <input type="text" name="google_client_id" value="{{ old('google_client_id', $clientId) }}" required class="mt-1 h-11 w-full rounded-md border border-[#D8DCE8] px-3 text-sm">
                </div>
                <div>
                    <label class="text-sm font-semibold text-[#5A6480]">GOOGLE_CLIENT_SECRET</label>
                    <input type="text" name="google_client_secret" required class="mt-1 h-11 w-full rounded-md border border-[#D8DCE8] px-3 text-sm" placeholder="{{ $clientSecret ? 'Already saved — paste a new secret to replace' : 'GOCSPX-...' }}">
                </div>
                <button type="submit" class="inline-flex h-11 items-center rounded-md bg-[#1B2559] px-5 text-sm font-semibold text-white">Save to .env</button>
            </form>
        </section>

        <section class="mt-6 rounded-xl border border-[#E4E7EF] bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold">Step 3 — Connect your Google account</h2>
            <p class="mt-2 text-[15px] text-[#5A6480]">This saves the refresh token automatically to <code>.env</code>.</p>

            <div class="mt-4 flex flex-wrap gap-3">
                <span class="inline-flex h-10 items-center rounded-md px-4 text-sm font-semibold {{ $clientId ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700' }}">
                    Client ID: {{ $clientId ? 'Saved' : 'Missing' }}
                </span>
                <span class="inline-flex h-10 items-center rounded-md px-4 text-sm font-semibold {{ $clientSecret ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700' }}">
                    Client Secret: {{ $clientSecret ? 'Saved' : 'Missing' }}
                </span>
                <span class="inline-flex h-10 items-center rounded-md px-4 text-sm font-semibold {{ $refreshToken ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700' }}">
                    Refresh Token: {{ $refreshToken ? 'Saved' : 'Missing' }}
                </span>
            </div>

            @if ($refreshToken)
                <div class="mt-4 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">
                    <p class="font-semibold">Setup complete!</p>
                    <p class="mt-1 text-sm">Refresh token is saved. Test a meeting now — do not click connect again.</p>
                    <a href="http://127.0.0.1:8000/company/login" class="mt-3 inline-flex h-10 items-center rounded-md bg-[#0F9D58] px-4 text-sm font-semibold text-white">Company login → Test meeting</a>
                </div>
            @else
                <form method="GET" action="{{ route('setup.google-meet.connect') }}" class="mt-5">
                    <button type="submit" class="inline-flex h-11 items-center gap-2 rounded-md bg-[#0F9D58] px-5 text-sm font-semibold text-white hover:bg-[#0B8043]" {{ ! $clientId || ! $clientSecret ? 'disabled' : '' }}>
                        Connect with Google
                    </button>
                </form>
            @endif
        </section>

        <section class="mt-6 rounded-xl border border-[#E4E7EF] bg-[#FAFBFF] p-6">
            <h2 class="text-lg font-semibold">Default values (already set)</h2>
            <ul class="mt-3 space-y-1 text-sm text-[#5A6480]">
                <li><code>GOOGLE_CALENDAR_ID=primary</code></li>
                <li><code>GOOGLE_CALENDAR_TIMEZONE=Asia/Kolkata</code></li>
                <li><code>GOOGLE_MEET_DEFAULT_DURATION=30</code></li>
            </ul>
            <p class="mt-4 text-sm text-[#5A6480]">After setup: company login → Meetings → pending meeting → <strong>Confirm Meeting</strong> → Google Meet link will be created.</p>
        </section>
    </main>
</body>
</html>
