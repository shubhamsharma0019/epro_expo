<?php

namespace App\Domain\Shared\Controllers;

use App\Domain\Visitor\Models\VisitorTicket;
use App\Http\Controllers\Controller;
use App\Mail\EventTicketConfirmationMail;
use App\Support\EventTicketMail;
use App\Support\PlatformMailSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class MailSetupController extends Controller
{
    public function index(): View
    {
        abort_unless(app()->environment('local'), 404);

        $latestTicket = VisitorTicket::query()->latest('id')->first();

        return view('setup.mail', [
            'mailUsername' => PlatformMailSettings::username(),
            'mailFrom' => PlatformMailSettings::fromAddress(),
            'hasPassword' => PlatformMailSettings::hasPassword(),
            'isDeliverable' => EventTicketMail::isDeliverable(),
            'exampleVisitorEmail' => $latestTicket ? EventTicketMail::resolveRecipient($latestTicket) : null,
        ]);
    }

    public function save(Request $request): RedirectResponse
    {
        abort_unless(app()->environment('local'), 404);

        $validated = $request->validate([
            'mail_username' => ['required', 'email', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_from_address' => ['nullable', 'email', 'max:255'],
        ]);

        if (filled($validated['mail_password'] ?? null)) {
            $cleanPassword = PlatformMailSettings::sanitizeAppPassword($validated['mail_password']);

            if (strlen($cleanPassword) !== 16) {
                return redirect()
                    ->route('setup.mail.index')
                    ->withInput()
                    ->with('error', 'Gmail App Password 16 characters ka hona chahiye. Spaces hata kar paste karo.');
            }

            $validated['mail_password'] = $cleanPassword;
        }

        if (! filled($validated['mail_password']) && ! PlatformMailSettings::hasPassword()) {
            return redirect()
                ->route('setup.mail.index')
                ->withInput()
                ->with('error', 'Gmail App Password is required for the first setup.');
        }

        try {
            PlatformMailSettings::verifyConnection([
                'mail_username' => $validated['mail_username'],
                'mail_password' => $validated['mail_password'] ?? null,
                'mail_from_address' => $validated['mail_from_address'] ?? null,
            ]);
        } catch (Throwable $e) {
            return redirect()
                ->route('setup.mail.index')
                ->withInput()
                ->with('error', PlatformMailSettings::friendlySmtpError($e->getMessage()));
        }

        PlatformMailSettings::save([
            'mail_username' => $validated['mail_username'],
            'mail_password' => $validated['mail_password'] ?? null,
            'mail_from_address' => $validated['mail_from_address'] ?? null,
        ]);

        return redirect()
            ->route('setup.mail.index')
            ->with('status', 'Platform sender SMTP saved and verified. Ticket emails will go to each visitor email entered at checkout.');
    }

    public function test(Request $request): RedirectResponse
    {
        abort_unless(app()->environment('local'), 404);

        if (! EventTicketMail::isDeliverable()) {
            return redirect()
                ->route('setup.mail.index')
                ->with('error', 'Save platform Gmail SMTP credentials first.');
        }

        $recipient = trim((string) $request->input('test_recipient', ''));

        if ($recipient === '' || ! EventTicketMail::isValidEmail($recipient)) {
            return redirect()
                ->route('setup.mail.index')
                ->with('error', 'Enter a valid test visitor email address.');
        }

        $ticket = VisitorTicket::query()->latest('id')->first();

        if (! $ticket) {
            return redirect()
                ->route('setup.mail.index')
                ->with('error', 'No visitor ticket found to use as email template.');
        }

        try {
            EventTicketMail::sendMailable($recipient, new EventTicketConfirmationMail($ticket));

            return redirect()
                ->route('setup.mail.index')
                ->with('status', 'Test ticket email sent to visitor address: ' . $recipient);
        } catch (Throwable $e) {
            return redirect()
                ->route('setup.mail.index')
                ->with('error', PlatformMailSettings::friendlySmtpError($e->getMessage()));
        }
    }
}
