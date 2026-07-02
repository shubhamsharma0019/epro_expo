<?php

namespace App\Support;

use App\Domain\Shared\Support\EnvFileUpdater;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class PlatformMailSettings
{
    private const FILE = 'platform-mail-settings.json';

    public static function path(): string
    {
        return storage_path('app/' . self::FILE);
    }

    public static function get(): array
    {
        if (self::usesDatabase()) {
            $row = self::databaseRow();

            if ($row !== null) {
                return self::rowToArray($row);
            }
        }

        $legacy = self::legacyFileGet();

        if ($legacy !== [] && self::usesDatabase()) {
            self::persistToDatabase($legacy);
        }

        return $legacy;
    }

    /**
     * @param  array{mail_username?: string, mail_password?: string|null, mail_from_address?: string|null}  $data
     */
    public static function save(array $data): void
    {
        $existing = self::get();
        $password = self::sanitizeAppPassword(
            filled($data['mail_password'] ?? null)
                ? (string) $data['mail_password']
                : (string) ($existing['mail_password'] ?? '')
        );

        $username = trim((string) ($data['mail_username'] ?? ''));
        $fromAddress = trim((string) ($data['mail_from_address'] ?? '')) ?: $username;

        $port = 587;

        $payload = [
            'mail_mailer' => 'smtp',
            'mail_scheme' => 'smtp',
            'mail_host' => 'smtp.gmail.com',
            'mail_port' => (string) $port,
            'mail_username' => $username,
            'mail_password' => $password,
            'mail_from_address' => $fromAddress,
            'mail_from_name' => (string) config('app.name', 'EproExpo'),
            'updated_at' => now()->toIso8601String(),
        ];

        if (self::usesDatabase()) {
            self::persistToDatabase($payload);
        } else {
            file_put_contents(
                self::path(),
                json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );
        }

        self::syncEnvFromPayload($payload);
        self::applyToConfig();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private static function syncEnvFromPayload(array $payload): void
    {
        if (! app()->environment('local')) {
            return;
        }

        try {
            EnvFileUpdater::set([
                'MAIL_MAILER' => 'smtp',
                'MAIL_SCHEME' => (string) ($payload['mail_scheme'] ?? 'smtp'),
                'MAIL_HOST' => (string) ($payload['mail_host'] ?? 'smtp.gmail.com'),
                'MAIL_PORT' => (string) ($payload['mail_port'] ?? '587'),
                'MAIL_USERNAME' => (string) ($payload['mail_username'] ?? ''),
                'MAIL_PASSWORD' => (string) ($payload['mail_password'] ?? ''),
                'MAIL_FROM_ADDRESS' => (string) ($payload['mail_from_address'] ?? ''),
                'MAIL_FROM_NAME' => (string) ($payload['mail_from_name'] ?? config('app.name', 'EproExpo')),
            ]);
        } catch (\Throwable) {
            // .env sync is optional; runtime config still uses database settings
        }
    }

    /**
     * @return array{mail_username: string, mail_password: string, mail_from_address: string, mail_host: string, mail_port: int, mail_scheme: string}
     */
    public static function resolveCredentials(): array
    {
        $stored = self::get();
        $username = trim((string) ($stored['mail_username'] ?? env('MAIL_USERNAME', '')));
        $password = self::sanitizeAppPassword($stored['mail_password'] ?? env('MAIL_PASSWORD'));
        $fromAddress = trim((string) (
            $stored['mail_from_address']
            ?? env('MAIL_FROM_ADDRESS')
            ?? $username
        ));
        $port = (int) ($stored['mail_port'] ?? env('MAIL_PORT', 587));

        return [
            'mail_username' => $username,
            'mail_password' => $password,
            'mail_from_address' => $fromAddress ?: $username,
            'mail_host' => (string) ($stored['mail_host'] ?? env('MAIL_HOST', 'smtp.gmail.com')),
            'mail_port' => $port > 0 ? $port : 587,
            'mail_scheme' => self::normalizeScheme($stored['mail_scheme'] ?? env('MAIL_SCHEME'), $port),
        ];
    }

    public static function applyToConfig(): void
    {
        $credentials = self::resolveCredentials();

        if (! filled($credentials['mail_username']) || ! filled($credentials['mail_password'])) {
            return;
        }

        $stored = self::get();

        if (
            filled($stored['mail_password'] ?? null)
            && self::sanitizeAppPassword($stored['mail_password']) !== ($stored['mail_password'] ?? '')
        ) {
            self::save([
                'mail_username' => $credentials['mail_username'],
                'mail_password' => $stored['mail_password'],
                'mail_from_address' => $credentials['mail_from_address'],
            ]);
            $stored = self::get();
        }

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.scheme' => $credentials['mail_scheme'],
            'mail.mailers.smtp.host' => $credentials['mail_host'],
            'mail.mailers.smtp.port' => $credentials['mail_port'],
            'mail.mailers.smtp.username' => $credentials['mail_username'],
            'mail.mailers.smtp.password' => $credentials['mail_password'],
            'mail.from.address' => $credentials['mail_from_address'],
            'mail.from.name' => $stored['mail_from_name'] ?? config('mail.from.name'),
        ]);

        Mail::purge('smtp');
    }

    /**
     * @param  array{mail_username?: string, mail_password?: string, mail_from_address?: string|null}|null  $credentials
     */
    public static function verifyConnection(?array $credentials = null): void
    {
        if ($credentials !== null) {
            $existing = self::get();
            $password = filled($credentials['mail_password'] ?? null)
                ? self::sanitizeAppPassword((string) $credentials['mail_password'])
                : self::sanitizeAppPassword($existing['mail_password'] ?? env('MAIL_PASSWORD'));

            $username = trim((string) ($credentials['mail_username'] ?? $existing['mail_username'] ?? env('MAIL_USERNAME', '')));
            $fromAddress = trim((string) ($credentials['mail_from_address'] ?? $existing['mail_from_address'] ?? env('MAIL_FROM_ADDRESS') ?? $username));
            $port = (int) ($existing['mail_port'] ?? env('MAIL_PORT', 587));

            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.scheme' => self::normalizeScheme($existing['mail_scheme'] ?? env('MAIL_SCHEME'), $port),
                'mail.mailers.smtp.host' => (string) ($existing['mail_host'] ?? env('MAIL_HOST', 'smtp.gmail.com')),
                'mail.mailers.smtp.port' => $port > 0 ? $port : 587,
                'mail.mailers.smtp.username' => $username,
                'mail.mailers.smtp.password' => $password,
                'mail.from.address' => $fromAddress ?: $username,
                'mail.from.name' => $existing['mail_from_name'] ?? config('mail.from.name'),
            ]);

            Mail::purge('smtp');
        } else {
            self::applyToConfig();
        }

        $recipient = trim((string) config('mail.mailers.smtp.username'));

        Mail::raw(
            'EproExpo SMTP connection test at ' . now()->toDateTimeString(),
            static function ($message) use ($recipient): void {
                $message->to($recipient)->subject('EproExpo SMTP Test');
            }
        );
    }

    public static function username(): string
    {
        return (string) (self::get()['mail_username'] ?? env('MAIL_USERNAME', ''));
    }

    public static function fromAddress(): string
    {
        $stored = self::get();

        return trim((string) (
            $stored['mail_from_address']
            ?? $stored['mail_username']
            ?? env('MAIL_FROM_ADDRESS')
            ?? env('MAIL_USERNAME')
            ?? ''
        ));
    }

    public static function hasPassword(): bool
    {
        return filled(self::get()['mail_password'] ?? null) || filled(env('MAIL_PASSWORD'));
    }

    private static function usesDatabase(): bool
    {
        try {
            return Schema::hasTable('platform_mail_settings');
        } catch (\Throwable) {
            return false;
        }
    }

    private static function databaseRow(): ?object
    {
        return DB::table('platform_mail_settings')->orderByDesc('id')->first();
    }

    /**
     * @return array<string, mixed>
     */
    private static function legacyFileGet(): array
    {
        if (! is_file(self::path())) {
            return [];
        }

        $data = json_decode((string) file_get_contents(self::path()), true);

        return is_array($data) ? $data : [];
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private static function rowToArray(object $row): array
    {
        return [
            'mail_mailer' => (string) ($row->mail_mailer ?? 'smtp'),
            'mail_scheme' => (string) ($row->mail_scheme ?? 'smtp'),
            'mail_host' => (string) ($row->mail_host ?? 'smtp.gmail.com'),
            'mail_port' => (string) ($row->mail_port ?? '587'),
            'mail_username' => (string) ($row->mail_username ?? ''),
            'mail_password' => self::decryptPassword((string) ($row->mail_password ?? '')),
            'mail_from_address' => (string) ($row->mail_from_address ?? ''),
            'mail_from_name' => (string) ($row->mail_from_name ?? config('app.name', 'EproExpo')),
            'updated_at' => optional($row->updated_at)->toIso8601String() ?? now()->toIso8601String(),
        ];
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private static function persistToDatabase(array $payload): void
    {
        $existing = self::databaseRow();
        $now = now();

        $record = [
            'mail_mailer' => (string) ($payload['mail_mailer'] ?? 'smtp'),
            'mail_scheme' => self::normalizeScheme($payload['mail_scheme'] ?? null, (int) ($payload['mail_port'] ?? 587)),
            'mail_host' => (string) ($payload['mail_host'] ?? 'smtp.gmail.com'),
            'mail_port' => (int) ($payload['mail_port'] ?? 587),
            'mail_username' => trim((string) ($payload['mail_username'] ?? '')),
            'mail_password' => self::encryptPassword(self::sanitizeAppPassword((string) ($payload['mail_password'] ?? ''))),
            'mail_from_address' => trim((string) ($payload['mail_from_address'] ?? '')),
            'mail_from_name' => (string) ($payload['mail_from_name'] ?? config('app.name', 'EproExpo')),
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('platform_mail_settings')->where('id', $existing->id)->update($record);
        } else {
            DB::table('platform_mail_settings')->insert($record + ['created_at' => $now]);
        }
    }

    private static function encryptPassword(string $password): ?string
    {
        if ($password === '') {
            return null;
        }

        try {
            return Crypt::encryptString($password);
        } catch (\Throwable) {
            return $password;
        }
    }

    private static function decryptPassword(string $value): string
    {
        if ($value === '') {
            return '';
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Throwable) {
            return self::sanitizeAppPassword($value);
        }
    }

    private static function normalizeScheme(?string $scheme, int $port): string
    {
        $scheme = strtolower(trim((string) $scheme));

        if (in_array($scheme, ['smtps', 'ssl'], true) || $port === 465) {
            return 'smtps';
        }

        if (in_array($scheme, ['tls', 'starttls'], true)) {
            return 'smtp';
        }

        return 'smtp';
    }

    public static function sanitizeAppPassword(?string $password): string
    {
        if ($password === null || $password === '') {
            return '';
        }

        return preg_replace('/\s+/', '', trim($password)) ?? '';
    }

    public static function friendlySmtpError(string $rawMessage): string
    {
        if (
            str_contains($rawMessage, '535')
            || str_contains($rawMessage, 'BadCredentials')
            || str_contains($rawMessage, 'Username and Password not accepted')
        ) {
            return 'Gmail rejected the App Password. Turn on 2-Step Verification in your Google Account, create a new App Password (Mail), paste all 16 characters without spaces, then save and test again.';
        }

        if (str_contains($rawMessage, 'Connection could not be established')) {
            return 'Could not connect to the SMTP server. Check your internet connection and try again.';
        }

        return 'Email could not be sent. Check your Gmail App Password and try again.';
    }
}
