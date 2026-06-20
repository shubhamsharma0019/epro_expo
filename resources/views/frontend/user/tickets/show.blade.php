@php
    $resolveAssetUrl = function (?string $path, ?string $fallback = null): ?string {
        if (! filled($path)) {
            return $fallback;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $normalized = ltrim($path, '/');

        if (str_starts_with($normalized, 'storage/')) {
            return asset($normalized);
        }

        if (str_starts_with($normalized, 'images/') || str_starts_with($normalized, 'assets/')) {
            return asset($normalized);
        }

        return asset('storage/' . $normalized);
    };
    $eventName = $ticket->companyEvent ? $ticket->companyEvent->title : 'Event';
    if (!$ticket->companyEvent && $ticket->event_slug == 'global-tech-summit-2024') {
        $eventName = 'Global Tech Summit 2024';
    }
    $dateInfo = $ticket->companyEvent ? ($ticket->companyEvent->starts_at?->format('M d, Y') ?? 'Date TBD') : 'May 15 - May 17, 2024';
    $timeInfo = $ticket->companyEvent?->starts_at
        ? $ticket->companyEvent->starts_at->format('h:i A') . ($ticket->companyEvent->ends_at ? ' - ' . $ticket->companyEvent->ends_at->format('h:i A') : '')
        : 'Time TBD';
    $venueInfo = $ticket->companyEvent
        ? collect([$ticket->companyEvent->venue_name, $ticket->companyEvent->city, $ticket->companyEvent->country])->filter()->join(', ')
        : 'Venue TBD';
    $heroImage = $resolveAssetUrl(
        $ticket->companyEvent?->branding?->banner_path ?: $ticket->companyEvent?->branding?->logo_path,
        asset('images/exhibitions/hero-pavilion-scene.png')
    );
@endphp
@include('frontend.user.partials.detail-page', [
    'title' => 'Ticket Details',
    'eyebrow' => 'Event ticket',
    'heading' => $eventName,
    'description' => $ticket->ticket_name . ' x ' . $ticket->quantity . ' for ' . $dateInfo . '. Use your e-ticket for access, agenda, and live sessions.',
    'primaryUrl' => url('/user/tickets/' . $ticket->id . '/e-ticket'),
    'primaryLabel' => 'View E-Ticket',
    'backUrl' => '/user/tickets',
    'heroImage' => $heroImage,
    'meta' => [
        ['Status', ucfirst($ticket->status)],
        ['Pass', $ticket->ticket_name],
        ['Attendees', $ticket->quantity],
        ['Order Number', $ticket->order_number],
        ['Attendee Name', $ticket->attendee_name ?: 'N/A'],
        ['Attendee Email', $ticket->attendee_email ?: 'N/A'],
        ['Date', $dateInfo],
        ['Time', $timeInfo],
        ['Venue', $venueInfo ?: 'Venue TBD'],
    ],
])
