<?php

namespace App\Support;

class HallMedia
{
    public static function imageUrl(?string $path, string $fallback = 'assets/images/pavilions/innovation-pavilion.png'): string
    {
        $path = filled($path) ? trim($path) : $fallback;

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'assets/')) {
            return asset($path);
        }

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}
