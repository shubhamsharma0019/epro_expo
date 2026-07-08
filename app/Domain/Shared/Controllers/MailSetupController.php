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
        $this->authorizeMailSetup();

        $latestTicket = VisitorTicket::query()->latest('id')->first();

        return view($this->mailSetupView(), $this->mailSetupViewData($latestTicket));
    }

    public function save(Request $request): RedirectResponse
    {
        $this->authorizeMailSetup();

        $validated = $request->validate([
            'mail_username' => ['required', 'email', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_from_address' => ['nullable', 'email', 'max:255'],
        ]);

        if (filled($validated['mail_password'] ?? null)) {
            $cleanPassword = PlatformMailSettings::sanitizeAppPassword($validated['mail_password']);

            if (strlen($cleanPassword) !== 16) {
                return redirect()
                    ->route($this->mailSetupRoute('index'))
                    ->withInput()
                    ->with('error', 'Gmail App Password must be 16 characters. Remove spaces before pasting.');
            }

            $validated['mail_password'] = $cleanPassword;
        }

        if (! filled($validated['mail_password']) && ! PlatformMailSettings::hasPassword()) {
            return redirect()
                ->route($this->mailSetupRoute('index'))
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
                ->route($this->mailSetupRoute('index'))
                ->withInput()
                ->with('error', PlatformMailSettings::friendlySmtpError($e->getMessage()));
        }

        PlatformMailSettings::save([
            'mail_username' => $validated['mail_username'],
            'mail_password' => $validated['mail_password'] ?? null,
            'mail_from_address' => $validated['mail_from_address'] ?? null,
        ]);

        $resentCount = $this->sendPendingTicketEmails();
        $message = 'Sender saved successfully. New ticket emails will go automatically to the buyer email entered at checkout.';

        if ($resentCount > 0) {
            $message .= ' Also sent ' . $resentCount . ' pending ticket ' . str('email')->plural($resentCount) . '.';
        }

        return redirect()
            ->route($this->mailSetupRoute('index'))
            ->with('status', $message);
    }

    public function test(Request $request): RedirectResponse
    {
        $this->authorizeMailSetup();

        if (! EventTicketMail::isDeliverable()) {
            return redirect()
                ->route($this->mailSetupRoute('index'))
                ->with('error', 'Save platform Gmail SMTP credentials first.');
        }

        $recipient = trim((string) $request->input('test_recipient', ''));

        if ($recipient === '' || ! EventTicketMail::isValidEmail($recipient)) {
            return redirect()
                ->route($this->mailSetupRoute('index'))
                ->with('error', 'Enter a valid test visitor email address.');
        }

        $ticket = VisitorTicket::query()->latest('id')->first();

        if (! $ticket) {
            return redirect()
                ->route($this->mailSetupRoute('index'))
                ->with('error', 'No visitor ticket found to use as email template.');
        }

        try {
            EventTicketMail::sendMailable($recipient, new EventTicketConfirmationMail($ticket));

            return redirect()
                ->route($this->mailSetupRoute('index'))
                ->with('status', 'Test ticket email sent to visitor address: ' . $recipient);
        } catch (Throwable $e) {
            return redirect()
                ->route($this->mailSetupRoute('index'))
                ->with('error', PlatformMailSettings::friendlySmtpError($e->getMessage()));
        }
    }

    private function sendPendingTicketEmails(): int
    {
        $sent = 0;

        VisitorTicket::query()
            ->whereNull('email_sent_at')
            ->whereNotNull('attendee_email')
            ->latest('id')
            ->take(25)
            ->get()
            ->each(function (VisitorTicket $ticket) use (&$sent): void {
                $result = EventTicketMail::sendTicket($ticket);

                if ($result['sent'] ?? false) {
                    $sent++;
                }
            });

        return $sent;
    }
    private function authorizeMailSetup(): void
    {
        if (app()->environment('local')) {
            return;
        }

        abort_unless(session()->has('admin_id'), 403);
    }

    private function mailSetupRoute(string $action): string
    {
        if (request()->routeIs('admin.mail-setup.*')) {
            return 'admin.mail-setup.' . $action;
        }

        return 'setup.mail.' . $action;
    }

    private function mailSetupView(): string
    {
        return request()->routeIs('admin.mail-setup.*')
            ? 'admin.mail-setup.index'
            : 'setup.mail';
    }

    /**
     * @return array<string, mixed>
     */
    private function mailSetupViewData(?VisitorTicket $latestTicket): array
    {
        return [
            'mailUsername' => PlatformMailSettings::username(),
            'mailFrom' => PlatformMailSettings::fromAddress(),
            'hasPassword' => PlatformMailSettings::hasPassword(),
            'isDeliverable' => EventTicketMail::isDeliverable(),
            'exampleVisitorEmail' => $latestTicket ? EventTicketMail::resolveRecipient($latestTicket) : null,
            'saveRoute' => route($this->mailSetupRoute('save')),
            'testRoute' => route($this->mailSetupRoute('test')),
        ];
    }
}
