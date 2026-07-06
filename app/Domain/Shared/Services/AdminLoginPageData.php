<?php

namespace App\Domain\Shared\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminLoginPageData
{
    public function build(): array
    {
        $settings = $this->settings([
            'admin_login_title' => 'title',
            'admin_login_subtitle' => 'subtitle',
            'admin_login_illustration' => 'illustration',
            'admin_login_footer_text' => 'footer_suffix',
        ]);

        $appName = config('app.name', 'EproExpo');
        $illustration = $settings['illustration'] ?? 'admin_assets/illustration.png';
        $illustrationUrl = str_starts_with($illustration, 'http')
            ? $illustration
            : asset(ltrim($illustration, '/'));

        return [
            'title' => $settings['title'] ?? 'Welcome Back, Admin',
            'subtitle' => $settings['subtitle'] ?? 'Sign in to your admin dashboard',
            'illustration_url' => $illustrationUrl,
            'footer_text' => '© ' . now()->year . ' ' . $appName . '. ' . ($settings['footer_suffix'] ?? 'All rights reserved.'),
            'app_name' => $appName,
        ];
    }

    /** @param  array<string, string>  $map */
    private function settings(array $map): array
    {
        if (! Schema::hasTable('admin_system_settings')) {
            return [];
        }

        $rows = DB::table('admin_system_settings')
            ->whereIn('key', array_keys($map))
            ->pluck('value', 'key');

        $resolved = [];
        foreach ($map as $dbKey => $field) {
            if (filled($rows[$dbKey] ?? null)) {
                $resolved[$field] = $rows[$dbKey];
            }
        }

        return $resolved;
    }
}
