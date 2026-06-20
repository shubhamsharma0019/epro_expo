<?php

namespace App\Domain\Event\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use Illuminate\Support\Str;

abstract class BaseCompanyEventController extends Controller
{
    protected function companyId(): int
    {
        return (int) session('company_id');
    }

    protected function setupEvent(?CompanyEvent $companyEvent = null): CompanyEvent
    {
        if ($companyEvent) {
            abort_unless($companyEvent->company_id === $this->companyId(), 403);

            session(['company_event_flow_event_id' => $companyEvent->id]);

            return $companyEvent;
        }

        $sessionEventId = (int) session('company_event_flow_event_id');

        if ($sessionEventId) {
            $event = CompanyEvent::query()
                ->where('company_id', $this->companyId())
                ->find($sessionEventId);

            if ($event) {
                return $event;
            }
        }

        $event = CompanyEvent::query()
            ->where('company_id', $this->companyId())
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (! $event) {
            $event = CompanyEvent::create([
                'company_id' => $this->companyId(),
                'title' => 'Untitled Company Event',
                'slug' => $this->uniqueSlug('untitled-company-event'),
                'event_type' => 'in_person',
                'event_mode' => 'in_person',
                'status' => 'draft',
                'timezone' => 'Asia/Kolkata',
                'visibility' => 'private',
            ]);
        }

        session(['company_event_flow_event_id' => $event->id]);

        return $event;
    }

    protected function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'company-event';
        $slug = $base;
        $counter = 2;

        while (CompanyEvent::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    protected function commonData(CompanyEvent $companyEvent): array
    {
        $companyEvent->loadMissing([
            'company',
            'branding',
            'ticketTypes',
            'sessions',
            'speakers',
            'latestPublishRequest',
        ]);

        return [
            'companyEvent' => $companyEvent,
            'eventBranding' => $companyEvent->branding,
            'ticketTypes' => $companyEvent->ticketTypes,
            'eventSessions' => $companyEvent->sessions,
            'eventSpeakers' => $companyEvent->speakers,
            'publishRequest' => $companyEvent->latestPublishRequest,
            'currentCompany' => $companyEvent->company,
        ];
    }
}
