<?php

namespace App\Support;

class MediaUrl
{
    public static function url(?string $path, ?string $fallback = null): ?string
    {
        $path = trim((string) $path);

        if ($path !== '') {
            if (preg_match('/^https?:\/\//i', $path)) {
                return $path;
            }

            $normalized = ltrim($path, '/');
            $storageRelative = str_starts_with($normalized, 'storage/') ? substr($normalized, 8) : $normalized;

            if (str_starts_with($normalized, 'images/') || str_starts_with($normalized, 'assets/')) {
                if (file_exists(public_path($normalized))) {
                    return asset($normalized);
                }
            }

            if (str_starts_with($normalized, 'storage/') && file_exists(public_path($normalized))) {
                return asset($normalized);
            }

            if (file_exists(storage_path('app/public/' . $storageRelative))) {
                return asset('storage/' . $storageRelative);
            }

            if (file_exists(public_path('storage/' . $storageRelative))) {
                return asset('storage/' . $storageRelative);
            }
        }

        if ($fallback !== null && $fallback !== $path) {
            return self::url($fallback, null) ?: asset(ltrim($fallback, '/'));
        }

        return null;
    }
}
