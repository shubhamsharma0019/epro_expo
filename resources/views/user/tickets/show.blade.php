@php
    $eventName = $ticket->companyEvent ? $ticket->companyEvent->title : 'Event';
    if (!$ticket->companyEvent && $ticket->event_slug == 'global-tech-summit-2024') {
        $eventName = 'Global Tech Summit 2024';
    }
    $dateInfo = $ticket->companyEvent ? ($ticket->companyEvent->starts_at?->format('M d, Y') ?? 'Date TBD') : 'May 15 - May 17, 2024';
@endphp
@include('user.partials.detail-page', [
    'title' => 'Ticket Details',
    'eyebrow' => 'Event ticket',
    'heading' => $eventName,
    'description' => $ticket->ticket_name . ' x ' . $ticket->quantity . ' for ' . $dateInfo . '. Use your e-ticket for access, agenda, and live sessions.',
    'primaryUrl' => url('/user/tickets/' . $ticket->id . '/e-ticket'),
    'primaryLabel' => 'View E-Ticket',
    'backUrl' => '/user/tickets',
    'meta' => [['Status', ucfirst($ticket->status)], ['Pass', $ticket->ticket_name], ['Attendees', $ticket->quantity], ['Order Number', $ticket->order_number]],
])
