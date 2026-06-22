<?php

namespace App\Support;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use Illuminate\Support\Str;

class CompanyEventOptions
{
    public static function categories(?int $companyId = null): array
    {
        $defaults = self::defaultCategories();
        $knownNames = collect($defaults)->pluck('name');

        $query = CompanyEvent::query()
            ->whereNotNull('category')
            ->where('category', '!=', '');

        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        $extra = $query
            ->distinct()
            ->pluck('category')
            ->filter(fn (string $name) => $knownNames->doesntContain($name))
            ->map(fn (string $name) => [
                'name' => $name,
                'short' => self::shortLabel($name),
            ])
            ->values();

        return collect($defaults)->concat($extra)->values()->all();
    }

    public static function defaultCategories(): array
    {
        return [
            ['name' => 'Technology', 'short' => 'Tech'],
            ['name' => 'Healthcare', 'short' => 'Health'],
            ['name' => 'Education', 'short' => 'Edu'],
            ['name' => 'Finance', 'short' => 'Fin'],
            ['name' => 'Marketing', 'short' => 'Mkt'],
            ['name' => 'Manufacturing', 'short' => 'Mfg'],
            ['name' => 'Other', 'short' => 'Other'],
        ];
    }

    public static function subCategories(): array
    {
        return [
            'AI & Machine Learning',
            'Industrial Automation',
            'Product Design',
            'Venture Capital',
            'Other',
        ];
    }

    public static function timezones(): array
    {
        return [
            ['value' => 'Asia/Kolkata', 'label' => '(GMT +05:30) India Standard Time (IST)'],
        ];
    }

    private static function shortLabel(string $name): string
    {
        $known = collect(self::defaultCategories())->firstWhere('name', $name);

        if ($known) {
            return $known['short'];
        }

        $words = preg_split('/\s+/', trim($name)) ?: [];
        if (count($words) > 1) {
            return Str::upper(Str::substr($words[0], 0, 4));
        }

        return Str::limit($name, 4, '');
    }
}
