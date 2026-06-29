<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Mail Setup</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F4F6FB] text-[#1B2559]">
    <main class="mx-auto max-w-3xl px-5 py-10">
        <h1 class="text-3xl font-bold">Platform Mail Setup</h1>

        <div class="mt-4 rounded-xl border border-blue-200 bg-blue-50 px-5 py-4 text-[15px] text-blue-900">
            <p class="font-semibold">How ticket emails work</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                <li><strong>.env (MAIL_USERNAME)</strong> = one platform sender Gmail (your company). Same for all tickets.</li>
                <li><strong>Visitor email at checkout</strong> = where each ticket is delivered. Jo email visitor form mein daalega, wahi par jayegi.</li>
            </ul>
        </div>

        @if (session('status'))
            <div class="mt-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">{{ session('error') }}</div>
        @endif

        <section class="mt-8 rounded-xl border border-[#E4E7EF] bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold">Platform Sender (Gmail SMTP)</h2>
            <p class="mt-2 text-sm text-[#5A6480]">Ye email sirf bhejne ke liye hai — har visitor ki apni email automatically recipient ban jati hai.</p>

            <form method="POST" action="{{ route('setup.mail.save') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="mb-1 block text-sm font-semibold">Platform Gmail (MAIL_USERNAME)</label>
                    <input type="email" name="mail_username" value="{{ old('mail_username', $mailUsername) }}" required
                        placeholder="tickets@yourcompany.com or your Gmail"
                        class="w-full rounded-lg border border-[#DDE2F2] px-4 py-3">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold">Gmail App Password (MAIL_PASSWORD)</label>
                    <input type="password" name="mail_password" required placeholder="16-character app password"
                        class="w-full rounded-lg border border-[#DDE2F2] px-4 py-3">
                    @if ($hasPassword)
                        <p class="mt-1 text-xs text-emerald-700">Password already in .env — enter again to update.</p>
                    @endif
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold">From address (MAIL_FROM_ADDRESS)</label>
                    <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $mailFrom) }}" required
                        placeholder="Usually same as platform Gmail"
                        class="w-full rounded-lg border border-[#DDE2F2] px-4 py-3">
                </div>
                <button type="submit" class="rounded-lg bg-[#4318FF] px-6 py-3 font-bold text-white">Save Platform SMTP</button>
            </form>
        </section>

        <section class="mt-6 rounded-xl border border-[#E4E7EF] bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold">Test — send to a visitor email</h2>
            <p class="mt-2 text-sm text-[#5A6480]">Status: {{ $isDeliverable ? 'Ready' : 'Configure platform SMTP first' }}</p>
            @if ($exampleVisitorEmail)
                <p class="mt-1 text-xs text-[#64748B]">Latest booking visitor email example: {{ $exampleVisitorEmail }}</p>
            @endif
            <form method="POST" action="{{ route('setup.mail.test') }}" class="mt-4 flex flex-col gap-3 sm:flex-row">
                @csrf
                <input type="email" name="test_recipient" value="{{ old('test_recipient', $exampleVisitorEmail) }}" required
                    placeholder="Visitor email to test (e.g. buyer@gmail.com)"
                    class="flex-1 rounded-lg border border-[#DDE2F2] px-4 py-3">
                <button type="submit" class="rounded-lg border border-[#4318FF] bg-white px-6 py-3 font-bold text-[#4318FF]">Send Test</button>
            </form>
        </section>
    </main>
</body>
</html>
