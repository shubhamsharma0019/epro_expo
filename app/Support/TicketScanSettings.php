<?php

namespace App\Support;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TicketScanSettings
{
    public static function scannerLoginRequired(): bool
    {
        self::applyToConfig();

        return (bool) config('ticket_scanner.login_required', false);
    }

    public static function autoCheckinOnScan(): bool
    {
        self::applyToConfig();

        return (bool) config('ticket_scanner.auto_checkin_on_scan', true);
    }

    public static function applyToConfig(): void
    {
        if (! self::usesDatabase()) {
            return;
        }

        $row = self::databaseRow();

        if ($row === null) {
            return;
        }

        if (filled($row->ticket_qr_base_url ?? null)) {
            config(['app.ticket_qr_base_url' => rtrim((string) $row->ticket_qr_base_url, '/')]);
        }

        if (filled($row->ticket_scanner_username ?? null)) {
            config(['ticket_scanner.username' => (string) $row->ticket_scanner_username]);
        }

        $password = self::decryptPassword((string) ($row->ticket_scanner_password ?? ''));

        if ($password !== '') {
            config(['ticket_scanner.password' => $password]);
        }

        config([
            'ticket_scanner.login_required' => (bool) ($row->scanner_login_required ?? false),
            'ticket_scanner.auto_checkin_on_scan' => (bool) ($row->auto_checkin_on_scan ?? true),
        ]);
    }

    public static function ensureLocalBaseUrl(): void
    {
        if (! app()->environment('local') || ! self::usesDatabase()) {
            return;
        }

        $row = self::databaseRow();
        $existing = filled($row->ticket_qr_base_url ?? null)
            ? rtrim((string) $row->ticket_qr_base_url, '/')
            : '';

        $detected = self::detectPreferredBaseUrl();

        if ($detected === null) {
            if ($existing !== '' && ! EventTicketQr::usesLoopbackUrl($existing)) {
                config(['app.ticket_qr_base_url' => $existing]);
            }

            return;
        }

        if ($existing !== '' && ! EventTicketQr::usesLoopbackUrl($existing) && $existing === $detected) {
            config(['app.ticket_qr_base_url' => $existing]);

            return;
        }

        self::persist([
            'ticket_qr_base_url' => $detected,
            'ticket_scanner_username' => (string) config('ticket_scanner.username'),
            'ticket_scanner_password' => (string) config('ticket_scanner.password'),
            'scanner_login_required' => false,
            'auto_checkin_on_scan' => true,
        ], $row);

        config(['app.ticket_qr_base_url' => $detected]);
    }

    private static function detectPreferredBaseUrl(): ?string
    {
        if (! app()->runningInConsole() && request()->hasHeader('Host')) {
            $host = request()->getHost();

            if (! EventTicketQr::usesLoopbackUrl('http://' . $host)) {
                return request()->getSchemeAndHttpHost();
            }
        }

        return EventTicketQr::detectLocalNetworkBaseUrl();
    }

    public static function ensureScannerCredentials(): void
    {
        if (! self::usesDatabase()) {
            return;
        }

        $row = self::databaseRow();

        if ($row !== null && filled($row->ticket_scanner_username ?? null)) {
            return;
        }

        self::persist([
            'ticket_qr_base_url' => filled($row->ticket_qr_base_url ?? null)
                ? (string) $row->ticket_qr_base_url
                : EventTicketQr::detectLocalNetworkBaseUrl(),
            'ticket_scanner_username' => (string) config('ticket_scanner.username', 'scanner'),
            'ticket_scanner_password' => (string) config('ticket_scanner.password', 'scanner@eproexpo'),
            'scanner_login_required' => false,
            'auto_checkin_on_scan' => true,
        ], $row);
    }

    public static function qrBaseUrl(): ?string
    {
        self::applyToConfig();

        $configured = config('app.ticket_qr_base_url');

        return filled($configured) ? rtrim((string) $configured, '/') : null;
    }

    public static function scannerUsername(): string
    {
        self::applyToConfig();

        return (string) config('ticket_scanner.username', 'scanner');
    }

    /**
     * @param  array{ticket_qr_base_url?: ?string, ticket_scanner_username?: ?string, ticket_scanner_password?: ?string, scanner_login_required?: bool, auto_checkin_on_scan?: bool}  $data
     */
    public static function persist(array $data, ?object $existing = null): void
    {
        if (! self::usesDatabase()) {
            return;
        }

        $existing ??= self::databaseRow();
        $now = now();

        $record = [
            'ticket_qr_base_url' => filled($data['ticket_qr_base_url'] ?? null)
                ? rtrim((string) $data['ticket_qr_base_url'], '/')
                : ($existing->ticket_qr_base_url ?? null),
            'ticket_scanner_username' => filled($data['ticket_scanner_username'] ?? null)
                ? trim((string) $data['ticket_scanner_username'])
                : ($existing->ticket_scanner_username ?? (string) config('ticket_scanner.username', 'scanner')),
            'ticket_scanner_password' => self::encryptPassword(
                filled($data['ticket_scanner_password'] ?? null)
                    ? (string) $data['ticket_scanner_password']
                    : (self::decryptPassword((string) ($existing->ticket_scanner_password ?? ''))
                        ?: (string) config('ticket_scanner.password', 'scanner@eproexpo'))
            ),
            'scanner_login_required' => array_key_exists('scanner_login_required', $data)
                ? (bool) $data['scanner_login_required']
                : (bool) ($existing->scanner_login_required ?? false),
            'auto_checkin_on_scan' => array_key_exists('auto_checkin_on_scan', $data)
                ? (bool) $data['auto_checkin_on_scan']
                : (bool) ($existing->auto_checkin_on_scan ?? true),
            'updated_at' => $now,
        ];

        if ($existing) {
            DB::table('platform_mail_settings')->where('id', $existing->id)->update($record);
        } else {
            DB::table('platform_mail_settings')->insert([
                'mail_mailer' => 'smtp',
                'mail_scheme' => 'smtp',
                'mail_host' => 'smtp.gmail.com',
                'mail_port' => 587,
                'mail_from_name' => (string) config('app.name', 'EproExpo'),
                'created_at' => $now,
            ] + $record);
        }

        self::applyToConfig();
    }

    private static function usesDatabase(): bool
    {
        try {
            return Schema::hasTable('platform_mail_settings')
                && Schema::hasColumn('platform_mail_settings', 'ticket_qr_base_url');
        } catch (\Throwable) {
            return false;
        }
    }

    private static function databaseRow(): ?object
    {
        return DB::table('platform_mail_settings')->orderByDesc('id')->first();
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
            return $value;
        }
    }
}
