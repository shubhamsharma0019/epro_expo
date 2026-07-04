<?php

namespace App\Domain\Shared\Services;

use App\Support\WebsiteContent;

class PricingPageData
{
    public function build(): array
    {
        $hero = WebsiteContent::pricingHero();

        return [
            'pricingHero' => $this->resolveHeroUrls($hero),
            'sectionHeadings' => WebsiteContent::pricingSectionHeadings(),
            'plans' => WebsiteContent::pricingPlans(),
            'benefits' => WebsiteContent::pricingBenefits(),
            'faqs' => WebsiteContent::pricingFaqs(),
            'contactEmail' => $hero['contact_email']
                ?? WebsiteContent::footer()['contact_email']
                ?? 'hello@eproexpo.com',
        ];
    }

    /** @param array<string, mixed> $hero */
    private function resolveHeroUrls(array $hero): array
    {
        $hero['button_1_url'] = $this->resolveUrl(
            $hero['button_1_url'] ?? null,
            'company.event-company.login'
        );
        $hero['button_2_url'] = $this->resolveUrl(
            $hero['button_2_url'] ?? null,
            'company.home'
        );

        if (empty($hero['contact_email'])) {
            $hero['contact_email'] = WebsiteContent::footer()['contact_email'] ?? 'hello@eproexpo.com';
        }

        return $hero;
    }

    private function resolveUrl(?string $url, ?string $fallbackRoute = null): string
    {
        if (filled($url)) {
            if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
                return $url;
            }

            if (str_starts_with($url, '/')) {
                return url($url);
            }

            try {
                return route($url);
            } catch (\Throwable) {
                return url($url);
            }
        }

        if ($fallbackRoute) {
            try {
                return route($fallbackRoute);
            } catch (\Throwable) {
                return url('/');
            }
        }

        return url('/');
    }
}
