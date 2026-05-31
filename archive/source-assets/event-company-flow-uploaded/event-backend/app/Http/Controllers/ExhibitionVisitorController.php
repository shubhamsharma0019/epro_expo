<?php

namespace App\Http\Controllers;

use App\Models\ExhibitionVisitor;
use App\Models\Exhibition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ExhibitionVisitorController extends Controller
{
    /**
     * Store visitor details and allocate pass.
     */
    public function register(Request $request, $exhibition_id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'mobile' => 'required|string|max:30',
            'job_title' => 'required|string|max:100',
            'company' => 'required|string|max:150',
            'country' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'industry' => 'required|string|max:100',
            'company_size' => 'required|string|max:100',
            'business_address' => 'required|string|max:255',
            'pass_type' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate unique booking code
        $randomNum = rand(100000, 999999);
        $datePart = Carbon::now()->format('ymd');
        $bookingId = 'EXP-' . $datePart . '-' . $randomNum;

        // Resolve exhibition primary key
        $exhibition = Exhibition::find($exhibition_id);
        $exhId = $exhibition ? $exhibition->id : null;

        // Create visitor
        $visitor = ExhibitionVisitor::create([
            'exhibition_id' => $exhId,
            'booking_id' => $bookingId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'job_title' => $request->job_title,
            'company' => $request->company,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'industry' => $request->industry,
            'company_size' => $request->company_size,
            'business_address' => $request->business_address,
            'pass_type' => $request->pass_type,
            'amount' => $request->amount,
            'payment_status' => $request->amount > 0 ? 'pending' : 'completed',
            'checkin_status' => false,
            'checkin_time' => null
        ]);

        return response()->json([
            'message' => 'Registration recorded successfully',
            'visitor' => $visitor
        ]);
    }

    /**
     * Simulate payment confirmation.
     */
    public function confirmPayment($booking_id)
    {
        $visitor = ExhibitionVisitor::where('booking_id', $booking_id)->first();

        if (!$visitor) {
            return response()->json(['message' => 'Registration not found'], 404);
        }

        $visitor->payment_status = 'completed';
        $visitor->save();

        return response()->json([
            'message' => 'Payment processed successfully',
            'visitor' => $visitor
        ]);
    }

    /**
     * Get all registered tickets.
     */
    public function getTickets()
    {
        $tickets = ExhibitionVisitor::orderBy('created_at', 'desc')->get();

        // Seed default ticket if empty to allow direct local previews
        if ($tickets->isEmpty()) {
            $exh = Exhibition::orderBy('created_at', 'asc')->first();
            $exhId = $exh ? $exh->id : null;

            $defaultTicket = ExhibitionVisitor::create([
                'exhibition_id' => $exhId,
                'booking_id' => 'EXP-240515-384912',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@email.com',
                'mobile' => '+91 98765 43210',
                'job_title' => 'Product Manager',
                'company' => 'TechNext Solutions Pvt. Ltd.',
                'country' => 'India',
                'state' => 'Maharashtra',
                'city' => 'Mumbai',
                'industry' => 'Technology',
                'company_size' => '51 - 200 Employees',
                'business_address' => '401, Infinity Tower, Mindspace, Malad West',
                'pass_type' => 'Free Visitor Pass',
                'amount' => 0.00,
                'payment_status' => 'completed',
                'checkin_status' => false,
                'checkin_time' => null
            ]);

            return response()->json([$defaultTicket]);
        }

        return response()->json($tickets);
    }

    /**
     * Get registration details by booking ID.
     */
    public function getTicketDetails($booking_id)
    {
        $visitor = ExhibitionVisitor::with('exhibition')->where('booking_id', $booking_id)->first();

        if (!$visitor) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        return response()->json($visitor);
    }

    /**
     * Perform QR check-in status update.
     */
    public function checkIn($booking_id)
    {
        $visitor = ExhibitionVisitor::where('booking_id', $booking_id)->first();

        if (!$visitor) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $visitor->checkin_status = true;
        $visitor->checkin_time = Carbon::now('Asia/Kolkata')->format('M d, Y \a\t h:i A');
        $visitor->save();

        return response()->json([
            'message' => 'Checked-in successfully',
            'visitor' => $visitor
        ]);
    }
}
