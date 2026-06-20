<?php

namespace App\Domain\Event\Repositories;

use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Pavilion;
use App\Domain\Event\Models\Hall;
use App\Domain\Event\Models\Sponsor;
use App\Domain\Event\Models\Speaker;
use App\Domain\Event\Models\Faq;
use App\Domain\Event\Models\AgendaSession;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;

class EventRepository
{
    public function getActiveExhibitions()
    {
        return Exhibition::where('status', 'active')->orderBy('start_date')->get();
    }

    public function findExhibition(int|string $id): ?Exhibition
    {
        return Exhibition::query()
            ->where('id', $id)
            ->orWhere('slug', $id)
            ->first();
    }

    public function getPavilions(int $exhibitionId)
    {
        return Pavilion::where('exhibition_id', $exhibitionId)->get();
    }

    public function getHalls(int $exhibitionId)
    {
        return Hall::where('exhibition_id', $exhibitionId)->get();
    }

    public function getSpeakers(int $exhibitionId)
    {
        return Speaker::where('exhibition_id', $exhibitionId)->get();
    }

    public function getSponsors(int $exhibitionId)
    {
        return Sponsor::where('exhibition_id', $exhibitionId)->get();
    }

    public function getFaqs(int $exhibitionId)
    {
        return Faq::where('exhibition_id', $exhibitionId)->get();
    }

    public function getAgenda(int $exhibitionId)
    {
        return AgendaSession::where('exhibition_id', $exhibitionId)->get();
    }

    public function getCompanyEvents()
    {
        return CompanyEvent::with('branding')
            ->whereIn('status', ['published', 'pending_review', 'submitted', 'draft'])
            ->get();
    }
}
