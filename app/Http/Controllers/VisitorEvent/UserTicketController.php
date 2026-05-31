<?php

namespace App\Http\Controllers\VisitorEvent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserTicketController extends Controller
{
    public function index()
    {
        $tickets = \App\Models\VisitorTicket::where('user_id', auth()->id())
            ->with(['companyEvent', 'ticketType'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('user.tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = \App\Models\VisitorTicket::where('user_id', auth()->id())
            ->with(['companyEvent', 'ticketType'])
            ->findOrFail($id);
            
        return view('user.tickets.show', compact('ticket'));
    }

    public function download($id)
    {
        $ticket = \App\Models\VisitorTicket::where('user_id', auth()->id())
            ->with(['companyEvent', 'ticketType'])
            ->findOrFail($id);
            
        // For now, return a view that acts as the printable e-ticket
        return view('user.tickets.e-ticket', compact('ticket'));
    }
}
