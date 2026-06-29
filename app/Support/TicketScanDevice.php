<?php

namespace App\Support;

use Illuminate\Http\Request;

class TicketScanDevice
{
    public static function fromRequest(?Request $request = null): array
    {
        $request ??= request();

        if (! $request) {
            return self::empty();
        }

        $userAgent = (string) $request->userAgent();

        return [
            'device_type' => self::resolveDeviceType($userAgent),
            'device_name' => self::resolveDeviceName($userAgent),
            'user_agent' => $userAgent !== '' ? $userAgent : null,
            'ip_address' => $request->ip(),
        ];
    }

    private static function empty(): array
    {
        return [
            'device_type' => null,
            'device_name' => null,
            'user_agent' => null,
            'ip_address' => null,
        ];
    }

    private static function resolveDeviceType(string $userAgent): string
    {
        $agent = strtolower($userAgent);

        if ($agent === '') {
            return 'unknown';
        }

        if (str_contains($agent, 'ipad') || str_contains($agent, 'tablet')) {
            return 'tablet';
        }

        if (str_contains($agent, 'mobile') || str_contains($agent, 'iphone') || str_contains($agent, 'android')) {
            return 'mobile';
        }

        return 'desktop';
    }

    private static function resolveDeviceName(string $userAgent): ?string
    {
        if ($userAgent === '') {
            return null;
        }

        $agent = strtolower($userAgent);

        if (str_contains($agent, 'iphone')) {
            return 'iPhone';
        }

        if (str_contains($agent, 'ipad')) {
            return 'iPad';
        }

        if (str_contains($agent, 'android')) {
            return str_contains($agent, 'mobile') ? 'Android Phone' : 'Android Device';
        }

        if (str_contains($agent, 'windows')) {
            return 'Windows';
        }

        if (str_contains($agent, 'macintosh') || str_contains($agent, 'mac os')) {
            return 'Mac';
        }

        if (str_contains($agent, 'linux')) {
            return 'Linux';
        }

        return 'Unknown Device';
    }
}
