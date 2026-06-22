<?php

namespace App\Support;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use Illuminate\Support\Collection;

class CompanyEventFlowProgress
{
    public const TEMPLATE_SEED_TITLES = [
        'Global Innovation Summit 2026',
        'International Manufacturing & Trade Expo 2026',
        'Hands-on UI/UX Design Boot Camp',
        'Elite Founders & Investors Mixer',
    ];

    public static function shouldShowOnDashboard(CompanyEvent $event): bool
    {
        if (self::isAbandonedTemplateDraft($event)) {
            return false;
        }

        if ($event->title !== 'Untitled Company Event') {
            return true;
        }

        return filled($event->starts_at)
            || filled($event->summary)
            || filled($event->category)
            || (bool) $event->branding
            || (int) ($event->ticket_types_count ?? 0) > 0
            || (int) ($event->sessions_count ?? 0) > 0
            || (int) ($event->speakers_count ?? 0) > 0
            || in_array($event->status, ['submitted', 'pending_review', 'approved', 'published'], true);
    }

    public static function isAbandonedTemplateDraft(CompanyEvent $event): bool
    {
        if ($event->status !== 'draft') {
            return false;
        }

        if ((bool) $event->branding) {
            return false;
        }

        if ((int) ($event->ticket_types_count ?? 0) > 0) {
            return false;
        }

        if ($event->relationLoaded('latestPublishRequest') ? $event->latestPublishRequest : $event->latestPublishRequest()->exists()) {
            return false;
        }

        return in_array($event->title, self::TEMPLATE_SEED_TITLES, true);
    }

    public static function basicDetailsComplete(CompanyEvent $event): bool
    {
        $hasMeaningfulTitle = filled($event->title) && $event->title !== 'Untitled Company Event';

        return $hasMeaningfulTitle
            && filled($event->starts_at)
            && filled($event->ends_at)
            && self::hasLocationDetails($event);
    }

    public static function hasLocationDetails(CompanyEvent $event): bool
    {
        if (in_array($event->event_mode, ['virtual', 'online'], true)) {
            return true;
        }

        return filled($event->venue_address)
            || filled($event->venue_name)
            || filled($event->city)
            || filled($event->country);
    }

    public static function brandingComplete(CompanyEvent $event): bool
    {
        return (bool) $event->branding;
    }

    public static function ticketsComplete(CompanyEvent $event): bool
    {
        if ($event->relationLoaded('ticketTypes')) {
            return $event->ticketTypes->isNotEmpty();
        }

        return $event->ticketTypes()->exists();
    }

    public static function resourcesComplete(CompanyEvent $event): bool
    {
        return filled($event->website) || filled($event->branding?->brochure_path);
    }

    public static function checklist(CompanyEvent $event): Collection
    {
        return collect([
            ['label' => 'Basic Details', 'complete' => self::basicDetailsComplete($event), 'required' => true],
            ['label' => 'Branding', 'complete' => self::brandingComplete($event), 'required' => true],
            ['label' => 'Tickets / Passes', 'complete' => self::ticketsComplete($event), 'required' => true],
            ['label' => 'Resources', 'complete' => self::resourcesComplete($event), 'required' => false],
        ])->filter(fn ($item) => $item['required'] || $item['complete'])->values();
    }

    public static function completedSectionsCount(CompanyEvent $event): int
    {
        return self::checklist($event)->where('complete', true)->count();
    }

    public static function totalSectionsCount(CompanyEvent $event): int
    {
        return self::checklist($event)->count();
    }

    public static function requiredSectionsComplete(CompanyEvent $event): bool
    {
        return self::checklist($event)
            ->where('required', true)
            ->every(fn ($item) => $item['complete']);
    }

    public static function progressPercent(CompanyEvent $event): int
    {
        $total = self::totalSectionsCount($event);

        if ($total === 0) {
            return 0;
        }

        return (int) round((self::completedSectionsCount($event) / $total) * 100);
    }
}
