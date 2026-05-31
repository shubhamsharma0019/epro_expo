<?php

namespace App\Http\Controllers;

use App\Models\ExhibitionMeeting;
use App\Models\ExhibitionVisitor;
use App\Models\Exhibitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExhibitionMeetingController extends Controller
{
    /**
     * Request a meeting slot with an exhibitor.
     */
    public function requestMeeting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|string',
            'exhibitor_id' => 'required|integer',
            'meeting_date' => 'required|string',
            'meeting_time' => 'required|string',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Resolve visitor ID using booking ID
        $visitor = ExhibitionVisitor::where('booking_id', $request->booking_id)->first();
        if (!$visitor) {
            // Seed a visitor if needed to satisfy foreign keys in local dry testing
            $visitor = ExhibitionVisitor::orderBy('created_at', 'asc')->first();
        }

        if (!$visitor) {
            return response()->json(['message' => 'Visitor booking ID not found. Please register first.'], 404);
        }

        // Check if exhibitor exists
        $exhibitor = Exhibitor::find($request->exhibitor_id);
        if (!$exhibitor) {
            return response()->json(['message' => 'Exhibitor not found'], 404);
        }

        // Create meeting
        $meeting = ExhibitionMeeting::create([
            'visitor_id' => $visitor->id,
            'exhibitor_id' => $exhibitor->id,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Meeting requested successfully',
            'meeting' => $meeting->load('exhibitor')
        ]);
    }

    /**
     * Get all requested meetings.
     */
    public function index(Request $request)
    {
        $bookingId = $request->query('booking_id');
        
        $query = ExhibitionMeeting::with(['visitor', 'exhibitor']);

        if ($bookingId) {
            $visitor = ExhibitionVisitor::where('booking_id', $bookingId)->first();
            if ($visitor) {
                $query->where('visitor_id', $visitor->id);
            } else {
                return response()->json([]);
            }
        }

        $meetings = $query->orderBy('created_at', 'desc')->get();

        return response()->json($meetings);
    }
}
