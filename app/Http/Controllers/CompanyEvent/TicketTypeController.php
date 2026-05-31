<?php

namespace App\Http\Controllers\CompanyEvent;

use App\Http\Requests\CompanyEvent\CompanyEventTicketTypeRequest;
use App\Models\CompanyEvent\CompanyEvent;
use App\Models\CompanyEvent\CompanyEventTicketType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketTypeController extends BaseCompanyEventController
{
    public function index(?CompanyEvent $companyEvent = null): View
    {
        $companyEvent = $this->setupEvent($companyEvent);

        return view('company.event-company-flow.ticket-setup', $this->commonData($companyEvent));
    }

    public function store(CompanyEventTicketTypeRequest $request, ?CompanyEvent $companyEvent = null): RedirectResponse
    {
        $companyEvent = $this->setupEvent($companyEvent);
        $data = $request->validated();
        $next = $data['next'] ?? 'stay';
        unset($data['next']);

        $data += [
            'company_id' => $this->companyId(),
            'company_event_id' => $companyEvent->id,
            'currency' => 'INR',
            'status' => 'active',
        ];

        CompanyEventTicketType::create($data);

        if ($next === 'preview') {
            return redirect()
                ->route('company.event-company-flow.preview', $companyEvent)
                ->with('status', 'Ticket type saved.');
        }

        return back()->with('status', 'Ticket type saved.');
    }

    public function update(CompanyEventTicketTypeRequest $request, CompanyEvent $companyEvent, CompanyEventTicketType $ticketType): RedirectResponse
    {
        $companyEvent = $this->setupEvent($companyEvent);
        abort_unless($ticketType->company_event_id === $companyEvent->id, 403);

        $data = $request->validated();
        unset($data['next']);

        $ticketType->update($data);

        return back()->with('status', 'Ticket type updated.');
    }

    public function updateSettings(Request $request, ?CompanyEvent $companyEvent = null): RedirectResponse
    {
        $companyEvent = $this->setupEvent($companyEvent);

        $data = $request->validate([
            'ticket_attendee_fields' => ['nullable', 'array'],
            'ticket_attendee_fields.*' => ['string', 'max:80'],
            'allow_group_registrations' => ['nullable', 'boolean'],
            'show_remaining_ticket_count' => ['nullable', 'boolean'],
            'enable_waiting_list' => ['nullable', 'boolean'],
        ]);

        $companyEvent->update([
            'ticket_attendee_fields' => $data['ticket_attendee_fields'] ?? [],
            'allow_group_registrations' => (bool) ($data['allow_group_registrations'] ?? false),
            'show_remaining_ticket_count' => (bool) ($data['show_remaining_ticket_count'] ?? false),
            'enable_waiting_list' => (bool) ($data['enable_waiting_list'] ?? false),
        ]);

        return redirect()
            ->route('company.event-company-flow.preview', $companyEvent)
            ->with('status', 'Ticket setup saved.');
    }

    public function destroy(CompanyEvent $companyEvent, CompanyEventTicketType $ticketType): RedirectResponse
    {
        $companyEvent = $this->setupEvent($companyEvent);
        abort_unless($ticketType->company_event_id === $companyEvent->id, 403);

        $ticketType->delete();

        return back()->with('status', 'Ticket type removed.');
    }
}
