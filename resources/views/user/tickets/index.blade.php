@php
    $items = [];
    foreach ($tickets as $ticket) {
        $eventName = $ticket->companyEvent ? $ticket->companyEvent->title : 'Event';
        if (!$ticket->companyEvent && $ticket->event_slug == 'global-tech-summit-2024') {
            $eventName = 'Global Tech Summit 2024';
        }
        $dateInfo = $ticket->companyEvent ? ($ticket->companyEvent->starts_at?->format('M d, Y') ?? 'Date TBD') : 'May 15 - May 17, 2024';
        $items[] = [
            $eventName,
            $ticket->ticket_name . ' | ' . $dateInfo,
            ucfirst($ticket->status),
            url('/user/tickets/' . $ticket->id)
        ];
    }
@endphp
@include('user.partials.list-page', [
    'title' => 'My Event Tickets',
    'variant' => 'ticket',
    'eyebrow' => 'Event Access',
    'description' => 'View your event bookings, passes, schedules, and ticket status in one place.',
    'icon' => 'fa-solid fa-ticket',
    'items' => count($items) > 0 ? $items : [
        ['No tickets found', 'Book an event to see your tickets here.', '', '']
    ],
])
