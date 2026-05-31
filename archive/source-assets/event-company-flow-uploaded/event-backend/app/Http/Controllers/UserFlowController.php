<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserFlowController extends Controller
{
    /**
     * Retrieve the active event for the attendee flow (bridge with organizer flow).
     */
    public function getActiveEvent()
    {
        // Try to fetch the latest created event from the database
        $event = Event::with('tickets')->orderBy('created_at', 'desc')->first();

        if ($event) {
            return response()->json($event);
        }

        // Fallback default mockup event details if database is empty
        return response()->json([
            'id' => null,
            'name' => 'Global Tech Summit 2024',
            'start_date' => '2026-05-15',
            'end_date' => '2026-05-17',
            'timezone' => 'Asia/Kolkata',
            'venue' => 'Jio World Convention Centre, Mumbai, India',
            'description' => 'Global Tech Summit brings together technology leaders, developers, and investors to explore emerging trends in AI, Cloud Computing, and Next-Generation Business Architectures.',
            'primary_color' => '#1010b9',
            'secondary_color' => '#3111e8',
            'accent_color' => '#FF8A00',
            'text_color' => '#101828',
            'logo_path' => null,
            'banner_path' => null,
            'tickets' => [
                ['type' => 'Business Pass', 'price' => 1499.00, 'quantity' => 1000],
                ['type' => 'VIP Access Pass', 'price' => 4999.00, 'quantity' => 200]
            ]
        ]);
    }

    /**
     * Get bookings/tickets registered for the logged-in user.
     */
    public function getBookings()
    {
        $bookings = Booking::all();

        // Seed a default booking if the table is empty for instant previewing
        if ($bookings->isEmpty()) {
            $event = Event::orderBy('created_at', 'desc')->first();
            $eventId = $event ? $event->id : null;
            $eventName = $event ? $event->name : 'Global Tech Summit 2024';
            $eventVenue = $event ? $event->venue : 'Jio World Convention Centre, Mumbai, India';
            $eventDate = $event ? ($event->start_date . ' - ' . $event->end_date) : 'May 15 - 17, 2024';

            $defaultBooking = Booking::create([
                'event_id' => $eventId,
                'booking_id' => 'EVT-240515-000123',
                'ticket_type' => 'Business Pass',
                'amount' => 1499.00,
                'booking_date' => 'May 10, 2024',
                'attendee_name' => 'John Doe',
                'attendee_email' => 'john.doe@example.com',
                'checkin_status' => false,
                'checkin_time' => null
            ]);

            return response()->json([$defaultBooking]);
        }

        return response()->json($bookings);
    }

    /**
     * Get booking by booking ID.
     */
    public function getBookingById($booking_id)
    {
        $booking = Booking::where('booking_id', $booking_id)->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        return response()->json($booking);
    }

    /**
     * Check in attendee.
     */
    public function checkIn($booking_id)
    {
        $booking = Booking::where('booking_id', $booking_id)->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Set checkin status to true and save time
        $booking->checkin_status = true;
        $booking->checkin_time = Carbon::now('Asia/Kolkata')->format('M d, Y \a\t h:i A');
        $booking->save();

        return response()->json([
            'message' => 'Checked-in successfully',
            'booking' => $booking
        ]);
    }

    /**
     * Handle attendee feedback submission.
     */
    public function submitFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
            'attendee_email' => 'nullable|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // In a full application, you would save this to a feedback table.
        // We will return a successful mock response indicating certificate eligibility.
        return response()->json([
            'message' => 'Feedback submitted successfully',
            'certificate_eligible' => true,
            'certificate_url' => '/downloads/certificates/cert_john_doe.pdf'
        ]);
    }
}
