<?php

namespace App\Domain\Shared\Services;

use App\Domain\Event\Models\TicketTier;

class ExhibitionTicketSummaryPageData
{
    /** @return array<string, mixed>|null */
    public function build(string $slug): ?array
    {
        $context = ExhibitionTicketFlowContext::resolve($slug);
        if (! $context) {
            return null;
        }

        $exhibition = $context['exhibition'];

        $ticketTiers = TicketTier::query()
            ->where('exhibition_id', $exhibition->id)
            ->orderBy('price')
            ->orderBy('id')
            ->get()
            ->filter(fn ($tier) => filled($tier->name))
            ->values()
            ->map(fn ($tier) => [
                'id' => $tier->id,
                'name' => $tier->name,
                'price' => (float) $tier->price,
                'benefits' => filled($tier->benefits)
                    ? trim((string) $tier->benefits)
                    : ($tier->price == 0 ? 'Access to exhibition & booths' : 'Enhanced access & features'),
                'summary' => filled($tier->benefits)
                    ? collect(explode(',', (string) $tier->benefits))->map(fn ($item) => trim($item))->filter()->first()
                    : ($tier->price == 0 ? 'Access to exhibition & booths' : 'Enhanced access & features'),
            ]);

        return array_merge($context, [
            'ticketTiers' => $ticketTiers,
            'pavilionMap' => $context['pavilions']->pluck('title', 'id'),
        ]);
    }
}
