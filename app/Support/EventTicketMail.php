<?php

namespace App\Support;

use App\Domain\Visitor\Models\VisitorTicket;
use App\Mail\EventTicketConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

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
                && filled(config('mail.mailers.smtp.password'))
                && filled(self::fromAddress());
        }

        return true;
    }

    public static function fromAddress(): string
    {
        return trim((string) (config('mail.from.address') ?: config('mail.mailers.smtp.username') ?: ''));
    }

    /**
     * @return array{sent: bool, message: string, recipient: ?string}
     */
    public static function sendTicket(VisitorTicket $ticket): array
    {
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
            PlatformMailSettings::applyToConfig();

            Mail::to($recipient)->send(new EventTicketConfirmationMail($ticket));

            return [
                'sent' => true,
                'message' => 'Your ticket has been sent to ' . $recipient . '.',
                'admin_message' => '',
                'recipient' => $recipient,
            ];
        } catch (Throwable $exception) {
            return [
                'sent' => false,
                'message' => self::visitorSendFailureMessage($recipient),
                'admin_message' => 'Email could not be sent. ' . $exception->getMessage(),
                'recipient' => $recipient,
            ];
        }
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

        if (session($sessionKey)) {
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
            $hint = 'Platform sender SMTP not configured (MAIL_USERNAME, MAIL_PASSWORD in .env). Visitor emails are sent automatically to the email they enter at checkout.';
            if (app()->environment('local')) {
                $hint .= ' Setup: ' . url('/setup/mail');
            }

            return $hint;
        }

        return 'Email delivery is not configured.';
    }
}
