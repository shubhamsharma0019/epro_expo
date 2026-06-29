<?php

namespace App\Domain\Shared\Controllers;

use App\Domain\Visitor\Models\VisitorTicket;
use App\Http\Controllers\Controller;
use App\Mail\EventTicketConfirmationMail;
use App\Support\EventTicketMail;
use App\Domain\Shared\Support\EnvFileUpdater;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
            'mailUsername' => env('MAIL_USERNAME', ''),
            'mailFrom' => env('MAIL_FROM_ADDRESS', ''),
            'hasPassword' => filled(env('MAIL_PASSWORD')),
            'isDeliverable' => EventTicketMail::isDeliverable(),
            'exampleVisitorEmail' => $latestTicket ? EventTicketMail::resolveRecipient($latestTicket) : null,
        ]);
    }

    public function save(Request $request): RedirectResponse
    {
        abort_unless(app()->environment('local'), 404);

        $validated = $request->validate([
            'mail_username' => ['required', 'email', 'max:255'],
            'mail_password' => ['required', 'string', 'max:255'],
            'mail_from_address' => ['required', 'email', 'max:255'],
        ]);

        EnvFileUpdater::set([
            'MAIL_MAILER' => 'smtp',
            'MAIL_SCHEME' => 'tls',
            'MAIL_HOST' => 'smtp.gmail.com',
            'MAIL_PORT' => '587',
            'MAIL_USERNAME' => $validated['mail_username'],
            'MAIL_PASSWORD' => $validated['mail_password'],
            'MAIL_FROM_ADDRESS' => $validated['mail_from_address'],
            'MAIL_FROM_NAME' => config('app.name', 'EproExpo'),
        ]);

        Artisan::call('config:clear');

        return redirect()
            ->route('setup.mail.index')
            ->with('status', 'Platform sender SMTP saved. Ticket emails will go to each visitor email entered at checkout.');
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
            Mail::to($recipient)->send(new EventTicketConfirmationMail($ticket));

            return redirect()
                ->route('setup.mail.index')
                ->with('status', 'Test ticket email sent to visitor address: ' . $recipient);
        } catch (Throwable $e) {
            return redirect()
                ->route('setup.mail.index')
                ->with('error', 'Send failed: ' . $e->getMessage());
        }
    }
}
