<?php

namespace App\Support;

use App\Domain\Visitor\Models\VisitorTicket;
use Illuminate\Support\Facades\Validator;

class EventTicketMail
{
    /**
     * Platform SMTP sender — set once in .env (MAIL_USERNAME / MAIL_FROM_ADDRESS).
     * Not the visitor email.
     */
    public static function isDeliverable(): bool
    {
        $mailer = (string) config('mail.default');

        if (in_array($mailer, ['log', 'array'], true)) {
            return false;
        }

        if ($mailer === 'smtp') {
            return filled(config('mail.mailers.smtp.username'))
                && filled(config('mail.mailers.smtp.password'));
        }

        return true;
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
            $hint = 'Platform sender SMTP not configured (MAIL_USERNAME, MAIL_PASSWORD in .env). Visitor emails are sent automatically to the email they enter at checkout.';
            if (app()->environment('local')) {
                $hint .= ' Setup: ' . url('/setup/mail');
            }

            return $hint;
        }

        return 'Email delivery is not configured.';
    }
}
