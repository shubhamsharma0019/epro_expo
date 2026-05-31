<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource (Dashboard data).
     */
    public function index()
    {
        $events = Event::with('tickets')->orderBy('created_at', 'desc')->get();
        
        // Calculate statistics
        $totalEvents = $events->count();
        $pendingApprovals = $events->where('status', 'pending')->count();
        
        // Calculate dummy/simulated registrations and revenue for the dashboard
        $totalRegistrations = 0;
        $totalRevenue = 0;
        
        foreach ($events as $event) {
            if ($event->status === 'approved') {
                $totalRegistrations += 150; // Mock registration metrics
                $totalRevenue += 12500;
            } else if ($event->status === 'pending') {
                $totalRegistrations += 10;
                $totalRevenue += 500;
            }
        }
        
        // Return structured dashboard data
        return response()->json([
            'events' => $events,
            'stats' => [
                'total_events' => $totalEvents,
                'pending_approvals' => $pendingApprovals,
                'total_registrations' => $totalRegistrations,
                'total_revenue' => $totalRevenue
            ]
        ]);
    }

    /**
     * Store a newly created event (Basic details page).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'sub_category' => 'nullable|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'timezone' => 'nullable|string',
            'venue' => 'required|string',
            'website' => 'nullable|string',
            'description' => 'required|string',
            'organizer_name' => 'nullable|string',
            'organizer_email' => 'nullable|email',
            'organizer_phone' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $event = Event::create([
            'name' => $request->name,
            'category' => $request->category,
            'sub_category' => $request->sub_category,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'timezone' => $request->timezone,
            'venue' => $request->venue,
            'website' => $request->website,
            'description' => $request->description,
            'organizer_name' => $request->organizer_name,
            'organizer_email' => $request->organizer_email,
            'organizer_phone' => $request->organizer_phone,
            'status' => 'draft'
        ]);

        return response()->json([
            'message' => 'Event created successfully',
            'event' => $event
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $event = Event::with('tickets')->find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event);
    }

    /**
     * Update branding details including logo and banner files.
     */
    public function updateBranding(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Validate branding attributes
        $validator = Validator::make($request->all(), [
            'primary_color' => 'nullable|string',
            'secondary_color' => 'nullable|string',
            'accent_color' => 'nullable|string',
            'text_color' => 'nullable|string',
            'logo' => 'nullable|image|max:2048', // Max 2MB
            'banner' => 'nullable|image|max:4096', // Max 4MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update colors
        if ($request->has('primary_color')) $event->primary_color = $request->primary_color;
        if ($request->has('secondary_color')) $event->secondary_color = $request->secondary_color;
        if ($request->has('accent_color')) $event->accent_color = $request->accent_color;
        if ($request->has('text_color')) $event->text_color = $request->text_color;

        // Process File Uploads (Logo)
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoName = 'logo_' . $event->id . '_' . time() . '.' . $logoFile->getClientOriginalExtension();
            $logoFile->move(public_path('uploads'), $logoName);
            $event->logo_path = '/uploads/' . $logoName;
        }

        // Process File Uploads (Banner)
        if ($request->hasFile('banner')) {
            $bannerFile = $request->file('banner');
            $bannerName = 'banner_' . $event->id . '_' . time() . '.' . $bannerFile->getClientOriginalExtension();
            $bannerFile->move(public_path('uploads'), $bannerName);
            $event->banner_path = '/uploads/' . $bannerName;
        }

        $event->save();

        return response()->json([
            'message' => 'Branding updated successfully',
            'event' => $event
        ]);
    }

    /**
     * Update tickets listing and ticket configurations.
     */
    public function updateTickets(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Validate configurations
        $validator = Validator::make($request->all(), [
            'tickets' => 'required|array',
            'tickets.*.type' => 'required|string',
            'tickets.*.price' => 'required|numeric',
            'tickets.*.quantity' => 'required',
            'tickets.*.sales_start' => 'nullable|string',
            'tickets.*.sales_end' => 'nullable|string',
            'allow_group_registrations' => 'nullable|boolean',
            'show_remaining_tickets' => 'nullable|boolean',
            'waiting_list' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Save additional ticketing settings
        if ($request->has('allow_group_registrations')) {
            $event->allow_group_registrations = filter_var($request->allow_group_registrations, FILTER_VALIDATE_BOOLEAN);
        }
        if ($request->has('show_remaining_tickets')) {
            $event->show_remaining_tickets = filter_var($request->show_remaining_tickets, FILTER_VALIDATE_BOOLEAN);
        }
        if ($request->has('waiting_list')) {
            $event->waiting_list = filter_var($request->waiting_list, FILTER_VALIDATE_BOOLEAN);
        }
        $event->save();

        // Delete existing tickets and insert new ones
        $event->tickets()->delete();

        foreach ($request->tickets as $ticketData) {
            Ticket::create([
                'event_id' => $event->id,
                'type' => $ticketData['type'],
                'price' => $ticketData['price'],
                'quantity' => $ticketData['quantity'],
                'sales_start' => $ticketData['sales_start'] ?? null,
                'sales_end' => $ticketData['sales_end'] ?? null,
            ]);
        }

        return response()->json([
            'message' => 'Tickets updated successfully',
            'event' => Event::with('tickets')->find($id)
        ]);
    }

    /**
     * Submit event for review and upload brochures.
     */
    public function submitReview(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'review_notes' => 'nullable|string',
            'brochure' => 'nullable|file|max:5120', // Max 5MB
            'sponsorship_guide' => 'nullable|file|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('review_notes')) {
            $event->review_notes = $request->review_notes;
        }

        // Upload Brochure PDF
        if ($request->hasFile('brochure')) {
            $brochureFile = $request->file('brochure');
            $brochureName = 'brochure_' . $event->id . '_' . time() . '.' . $brochureFile->getClientOriginalExtension();
            $brochureFile->move(public_path('uploads'), $brochureName);
            $event->brochure_path = '/uploads/' . $brochureName;
        }

        // Upload Sponsorship Guide PDF
        if ($request->hasFile('sponsorship_guide')) {
            $guideFile = $request->file('sponsorship_guide');
            $guideName = 'sponsorship_' . $event->id . '_' . time() . '.' . $guideFile->getClientOriginalExtension();
            $guideFile->move(public_path('uploads'), $guideName);
            $event->sponsorship_guide_path = '/uploads/' . $guideName;
        }

        // Update status to pending
        $event->status = 'pending';
        $event->save();

        return response()->json([
            'message' => 'Event submitted for review successfully',
            'event' => $event
        ]);
    }
}
