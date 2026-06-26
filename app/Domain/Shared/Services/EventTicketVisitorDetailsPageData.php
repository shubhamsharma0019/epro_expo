<?php

namespace App\Domain\Shared\Services;

use App\Support\LiveContent;

class EventTicketVisitorDetailsPageData
{
    public function build(?string $slug): ?array
    {
        if (! filled($slug)) {
            return null;
        }

        $dbEvent = LiveContent::companyEventQuery()
            ->with(['branding', 'ticketTypes'])
            ->where('slug', $slug)
            ->first();

        if (! $dbEvent) {
            return null;
        }

        $minTicket = $dbEvent->ticketTypes->sortBy('price')->first();
        $currency = strtoupper($minTicket?->currency ?: 'INR');
        $symbols = ['INR' => '₹', 'USD' => '$', 'EUR' => '€', 'GBP' => '£'];
        $symbol = $symbols[$currency] ?? ($currency . ' ');
        $priceLabel = $minTicket
            ? $symbol . number_format((float) $minTicket->price, 0)
            : 'Free';

        $dateStr = $dbEvent->starts_at
            ? $dbEvent->starts_at->format('M d') . ($dbEvent->ends_at ? ' - ' . $dbEvent->ends_at->format('M d, Y') : ', ' . $dbEvent->starts_at->format('Y'))
            : 'Date TBD';

        $location = collect([$dbEvent->venue_name, $dbEvent->city, $dbEvent->country])
            ->filter()
            ->join(', ') ?: 'Venue TBD';

        $bannerImage = $dbEvent->branding?->banner_path
            ? asset('storage/' . $dbEvent->branding->banner_path)
            : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&h=350&fit=crop';

        $user = auth()->user();

        return [
            'dbEvent' => $dbEvent,
            'slug' => $slug,
            'title' => $dbEvent->title,
            'bannerImage' => $bannerImage,
            'dateStr' => $dateStr,
            'location' => $location,
            'priceLabel' => $priceLabel,
            'prefill' => [
                'name' => old('name', $user?->name ?? ''),
                'email' => old('email', $user?->email ?? ''),
                'phone' => old('phone', $user?->phone ?? ''),
                'gender' => old('gender', $user?->gender ?? ''),
                'city' => old('city', $user?->city ?? ''),
            ],
        ];
    }
}
