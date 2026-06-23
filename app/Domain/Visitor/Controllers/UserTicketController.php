<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserTicketController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userEmail = $user->email;

        // 1. Fetch Event Tickets
        $eventTickets = VisitorTicket::where('user_id', $user->id)
            ->with(['companyEvent.branding', 'ticketType'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Fetch Exhibition Passes
        $exhibitionPasses = Visitor::whereRaw('LOWER(email) = ?', [strtolower($userEmail)])
            ->with('exhibition')
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Combine them into a unified list
        $passes = collect();

        foreach ($eventTickets as $ticket) {
            $passes->push([
                'type' => 'event',
                'id' => $ticket->id,
                'pass_type' => 'Event Ticket',
                'name' => $ticket->companyEvent->title ?? $ticket->ticket_name ?? 'Event',
                'date' => $ticket->companyEvent?->starts_at,
                'ends_at' => $ticket->companyEvent?->ends_at,
                'status' => $ticket->status,
                'number' => $ticket->order_number,
                'quantity' => $ticket->quantity,
                'ticket_name' => $ticket->ticket_name,
                'email' => $userEmail,
                'raw' => $ticket
            ]);
        }

        foreach ($exhibitionPasses as $pass) {
            $passes->push([
                'type' => 'exhibition',
                'id' => $pass->id,
                'pass_type' => 'Exhibition Pass',
                'name' => $pass->exhibition->title ?? $pass->exhibition->name ?? 'Exhibition',
                'date' => $pass->exhibition?->start_date,
                'ends_at' => $pass->exhibition?->end_date,
                'status' => $pass->payment_status === 'completed' ? 'confirmed' : $pass->payment_status,
                'number' => $pass->booking_id,
                'quantity' => 1,
                'ticket_name' => 'Visitor Pass',
                'email' => $pass->email,
                'slug' => $pass->exhibition->slug ?? '',
                'raw' => $pass
            ]);
        }

        // 4. Sort: Upcoming first (priority 1), then active/live (priority 2), then completed/expired (priority 3)
        $now = Carbon::now();
        $sortedPasses = $passes->map(function ($pass) use ($now) {
            $date = $pass['date'];
            $endsAt = $pass['ends_at'];
            
            if ($endsAt && $endsAt->lt($now)) {
                $category = 'completed';
                $priority = 3;
            } elseif ($date && $date->gt($now)) {
                $category = 'upcoming';
                $priority = 1;
            } else {
                $category = 'live';
                $priority = 2;
            }
            
            $pass['category'] = $category;
            $pass['priority'] = $priority;
            return $pass;
        })->sortBy(function ($pass) {
            return [
                $pass['priority'],
                $pass['date'] ? $pass['date']->timestamp : PHP_INT_MAX
            ];
        })->values();

        return view('frontend.user.tickets.index', [
            'passes' => $sortedPasses,
            'totalCount' => $sortedPasses->count()
        ]);
    }

    public function show($id)
    {
        $ticket = \App\Domain\Visitor\Models\VisitorTicket::where('user_id', auth()->id())
            ->with(['companyEvent', 'ticketType'])
            ->findOrFail($id);
            
        return view('frontend.user.tickets.show', compact('ticket'));
    }

    public function download($id)
    {
        $ticket = VisitorTicket::where('user_id', auth()->id())
            ->with(['companyEvent', 'ticketType'])
            ->findOrFail($id);
            
        return view('frontend.user.tickets.e-ticket', compact('ticket'));
    }

    public function showExhibitionPass(int $id)
    {
        $pass = Visitor::query()
            ->whereRaw('LOWER(email) = ?', [strtolower(auth()->user()->email)])
            ->with('exhibition')
            ->findOrFail($id);

        return view('frontend.user.tickets.exhibition-pass', compact('pass'));
    }

    public function downloadExhibitionPass(int $id)
    {
        $pass = Visitor::query()
            ->whereRaw('LOWER(email) = ?', [strtolower(auth()->user()->email)])
            ->with('exhibition')
            ->findOrFail($id);

        return view('frontend.user.tickets.exhibition-pass', compact('pass'));
    }
}
