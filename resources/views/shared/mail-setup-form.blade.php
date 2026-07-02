<div class="rounded-xl border border-blue-200 bg-blue-50 px-5 py-4 text-[15px] text-blue-900">
    <p class="font-semibold">One-time setup — then unlimited emails</p>
    <ul class="mt-2 list-disc space-y-1 pl-5">
        <li><strong>Platform Gmail (one time)</strong> = sender for all ticket emails.</li>
        <li><strong>Visitor email</strong> = each buyer receives the ticket at the email they entered at checkout.</li>
        <li>The App Password is stored in the MySQL database — you do not need to paste it again for every email.</li>
    </ul>
</div>

@if (session('status'))
    <div class="mt-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">{{ session('status') }}</div>
@endif
@if (session('error'))
    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">{{ session('error') }}</div>
@endif

@if ($isDeliverable)
    <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
        <p class="font-semibold">Email is ready</p>
        <p class="mt-1 text-sm">Use <strong>Send Email</strong> / <strong>Resend Email</strong> on the ticket page as often as you need — the App Password will not be requested again.</p>
    </div>
@endif

<section class="mt-8 rounded-xl border border-[#E4E7EF] bg-white p-6 shadow-sm">
    <h2 class="text-xl font-semibold">Platform Sender (Gmail SMTP)</h2>
    <p class="mt-2 text-sm text-[#5A6480]">This email is only used for sending — each visitor's own email is used automatically as the recipient.</p>

    <form method="POST" action="{{ $saveRoute }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label class="mb-1 block text-sm font-semibold">Platform Gmail (MAIL_USERNAME)</label>
            <input type="email" name="mail_username" value="{{ old('mail_username', $mailUsername) }}" required
                placeholder="tickets@yourcompany.com or your Gmail"
                class="w-full rounded-lg border border-[#DDE2F2] px-4 py-3">
        </div>
        <div>
            <label class="mb-1 block text-sm font-semibold">Gmail App Password (MAIL_PASSWORD)</label>
            <input type="password" name="mail_password" {{ $hasPassword ? '' : 'required' }} placeholder="16-character app password"
                class="w-full rounded-lg border border-[#DDE2F2] px-4 py-3">
            @if ($hasPassword)
                <p class="mt-1 text-xs text-emerald-700">Password is already saved — leave blank if you do not want to change it. Do not paste it again for every ticket email.</p>
            @else
                <ol class="mt-2 list-decimal space-y-1 pl-5 text-xs text-[#64748B]">
                    <li>Google Account → Security → turn on <strong>2-Step Verification</strong></li>
                    <li>App passwords → app name "EproExpo" → copy the <strong>16-character password</strong></li>
                    <li>Do not use your normal Gmail password — use an App Password only</li>
                    <li>Remove spaces when pasting (e.g. <code>abcd efgh ijkl mnop</code> → 16 chars)</li>
                </ol>
            @endif
        </div>
        <div>
            <label class="mb-1 block text-sm font-semibold">From address (optional)</label>
            <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $mailFrom ?: $mailUsername) }}"
                placeholder="Usually same as platform Gmail"
                class="w-full rounded-lg border border-[#DDE2F2] px-4 py-3">
        </div>
        <button type="submit" class="rounded-lg bg-[#4318FF] px-6 py-3 font-bold text-white">Save Platform SMTP (One Time)</button>
    </form>
</section>

<section class="mt-6 rounded-xl border border-[#E4E7EF] bg-white p-6 shadow-sm">
    <h2 class="text-xl font-semibold">Test — send to a visitor email</h2>
    <p class="mt-2 text-sm text-[#5A6480]">Status: {{ $isDeliverable ? 'Ready — unlimited ticket emails' : 'Save platform SMTP first' }}</p>
    @if ($exampleVisitorEmail)
        <p class="mt-1 text-xs text-[#64748B]">Latest booking visitor email example: {{ $exampleVisitorEmail }}</p>
    @endif
    <form method="POST" action="{{ $testRoute }}" class="mt-4 flex flex-col gap-3 sm:flex-row">
        @csrf
        <input type="email" name="test_recipient" value="{{ old('test_recipient', $exampleVisitorEmail) }}" required
            placeholder="Visitor email to test (e.g. buyer@gmail.com)"
            class="flex-1 rounded-lg border border-[#DDE2F2] px-4 py-3">
        <button type="submit" class="rounded-lg border border-[#4318FF] bg-white px-6 py-3 font-bold text-[#4318FF]">Send Test</button>
    </form>
</section>
