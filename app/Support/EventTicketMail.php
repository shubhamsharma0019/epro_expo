<?php

namespace App\Support;

use App\Domain\Visitor\Models\Ticket;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Mail\EventTicketConfirmationMail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class EventTicketMail
{
    public static function prepareMailer(): void
    {
        PlatformMailSettings::applyToConfig();
    }

    /**
     * Platform SMTP sender — set once in .env (MAIL_USERNAME / MAIL_FROM_ADDRESS).
     * Not the visitor email.
     */
    public static function isDeliverable(): bool
    {
        self::prepareMailer();

        $mailer = (string) config('mail.default');

        if (in_array($mailer, ['log', 'array'], true)) {
            return false;
        }

        if ($mailer === 'smtp') {
            return filled(config('mail.mailers.smtp.username'))
                && filled(config('mail.mailers.smtp.password'))
                && filled(self::fromAddress());
        }

        return true;
    }

    public static function fromAddress(): string
    {
        self::prepareMailer();

        return trim((string) (config('mail.from.address') ?: config('mail.mailers.smtp.username') ?: ''));
    }

    /**
     * @return array{sent: bool, message: string, recipient: ?string}
     */
    public static function sendTicket(VisitorTicket $ticket): array
    {
        TicketScanSettings::ensureLocalBaseUrl();
        TicketScanSettings::applyToConfig();
        self::ensureIssuedTicket($ticket);

        $recipient = self::resolveRecipient($ticket);

        if ($recipient === null) {
            return [
                'sent' => false,
                'message' => self::visitorSendFailureMessage(),
                'admin_message' => 'No valid visitor email on booking.',
                'recipient' => null,
            ];
        }

        if (! self::isDeliverable()) {
            return [
                'sent' => false,
                'message' => self::visitorSendFailureMessage($recipient),
                'admin_message' => self::configurationHint(),
                'recipient' => $recipient,
            ];
        }

        try {
            self::sendMailable($recipient, new EventTicketConfirmationMail($ticket));

            $ticket->update(['email_sent_at' => now()]);

            return [
                'sent' => true,
                'message' => 'Your ticket has been sent to ' . $recipient . '.',
                'admin_message' => '',
                'recipient' => $recipient,
            ];
        } catch (Throwable $exception) {
            $friendly = PlatformMailSettings::friendlySmtpError($exception->getMessage());

            return [
                'sent' => false,
                'message' => self::visitorSendFailureMessage($recipient),
                'admin_message' => $friendly,
                'recipient' => $recipient,
            ];
        }
    }

    public static function sendMailable(string $recipient, Mailable $mailable): void
    {
        self::prepareMailer();

        $attempts = [
            [
                'scheme' => (string) config('mail.mailers.smtp.scheme', 'smtp'),
                'port' => (int) config('mail.mailers.smtp.port', 587),
            ],
            ['scheme' => 'smtp', 'port' => 587],
            ['scheme' => 'smtps', 'port' => 465],
        ];

        $lastException = null;

        foreach ([1, 2] as $round) {
            $seen = [];

            foreach ($attempts as $attempt) {
                $key = $attempt['scheme'] . ':' . $attempt['port'];

                if (isset($seen[$key])) {
                    continue;
                }

                $seen[$key] = true;

                config([
                    'mail.mailers.smtp.scheme' => $attempt['scheme'],
                    'mail.mailers.smtp.port' => $attempt['port'],
                ]);
                Mail::purge('smtp');

                try {
                    Mail::to($recipient)->send($mailable);

                    return;
                } catch (Throwable $exception) {
                    $lastException = $exception;
                }
            }

            if ($round === 1) {
                usleep(250000);
            }
        }

        throw $lastException ?? new \RuntimeException('Email could not be sent.');
    }
    public static function visitorSendFailureMessage(?string $recipient = null): string
    {
        if ($recipient) {
            return 'We could not email your ticket right now. Please download it below or tap Resend Email.';
        }

        return 'We could not find an email for this booking. Please download your ticket below.';
    }

    public static function attemptAutoSend(VisitorTicket $ticket): array
    {
        $orderNumber = $ticket->order_number;
        $sessionKey = 'event_ticket_email_sent_' . $orderNumber;

        if (session($sessionKey) || $ticket->email_sent_at) {
            if ($ticket->email_sent_at) {
                session([$sessionKey => true]);
            }

            return [
                'sent' => true,
                'message' => '',
                'admin_message' => '',
                'recipient' => self::resolveRecipient($ticket),
                'skipped' => true,
            ];
        }

        $result = self::sendTicket($ticket);

        if ($result['sent']) {
            session([$sessionKey => true]);
        }

        if (! $result['sent'] && filled($result['admin_message'] ?? null)) {
            \Illuminate\Support\Facades\Log::info('Event ticket auto-email skipped.', [
                'order_number' => $orderNumber,
                'recipient' => $result['recipient'],
                'reason' => $result['admin_message'],
            ]);
        }

        $result['skipped'] = false;

        return $result;
    }

    /**
     * Visitor who bought the ticket — email entered during registration/checkout.
     */
    public static function resolveRecipient(VisitorTicket $ticket): ?string
    {
        $ticket->loadMissing('user');

        $candidates = [
            trim((string) $ticket->attendee_email),
            trim((string) $ticket->user?->email),
        ];

        foreach ($candidates as $email) {
            if ($email !== '' && self::isValidEmail($email)) {
                return strtolower($email);
            }
        }

        return null;
    }

    public static function isValidEmail(string $email): bool
    {
        return ! Validator::make(
            ['email' => $email],
            ['email' => ['required', 'email']]
        )->fails();
    }

    public static function configurationHint(): string
    {
        if (self::isDeliverable()) {
            return '';
        }

        $mailer = (string) config('mail.default');

        if ($mailer === 'log') {
            return 'Platform mail is in log mode. Set MAIL_MAILER=smtp and platform Gmail App Password in .env.';
        }

        if ($mailer === 'smtp') {
            $hint = 'Platform sender is not configured. Buyer emails are sent automatically to the email entered at checkout; buyer password is not used.';
            if (\Illuminate\Support\Facades\Route::has('admin.mail-setup.index')) {
                $hint .= ' Setup: ' . route('admin.mail-setup.index');
            } elseif (app()->environment('local')) {
                $hint .= ' Setup: ' . url('/setup/mail');
            }

            return $hint;
        }

        return 'Email delivery is not configured.';
    }

    public static function ensureIssuedTicket(VisitorTicket $ticket): void
    {
        if (! EventTicketSchema::isReady()) {
            return;
        }

        $ticket->loadMissing('user');

        if (! $ticket->user) {
            return;
        }

        $alreadyIssued = Ticket::query()
            ->whereHas('booking', fn ($query) => $query->where('visitor_ticket_id', $ticket->id))
            ->exists();

        if ($alreadyIssued) {
            return;
        }

        app(\App\Domain\Visitor\Services\EventTicketIssuanceService::class)
            ->issueFromVisitorTicket($ticket, $ticket->user);
    }
}
