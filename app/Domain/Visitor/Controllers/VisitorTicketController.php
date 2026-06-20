<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Visitor\Models\Visitor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VisitorTicketController extends Controller
{
    public function register(Request $request, string $slug): JsonResponse
    {
        $exhibition = Exhibition::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'max:50'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'company_size' => ['nullable', 'string', 'max:255'],
            'business_address' => ['nullable', 'string', 'max:2000'],
            'pavilion_id' => ['nullable', 'string', 'max:255'],
            'pass_type' => ['nullable', 'string', 'max:255'],
            'amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $amount = (float) ($validated['amount'] ?? $request->input('amount', 0));

        $visitor = Visitor::create([
            'exhibition_id' => $exhibition->id,
            'pavilion_id' => $validated['pavilion_id'] ?? null,
            'booking_id' => 'EXP-' . now()->format('ymd') . '-' . random_int(100000, 999999),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'job_title' => $validated['job_title'] ?? null,
            'company' => $validated['company'] ?? null,
            'country' => $validated['country'],
            'state' => $validated['state'] ?? null,
            'city' => $validated['city'] ?? null,
            'industry' => $validated['industry'] ?? null,
            'company_size' => $validated['company_size'] ?? null,
            'business_address' => $validated['business_address'] ?? null,
            'pass_type' => $validated['pass_type'] ?? $request->input('pass_type', 'Free Visitor Pass'),
            'amount' => $amount,
            'payment_status' => $amount > 0 ? 'pending' : 'completed',
        ]);

        session([
            'selected_visitor_booking_id' => $visitor->booking_id,
            'visitor_pass_active' => $visitor->payment_status === 'completed',
        ]);
        session()->forget('exhibition_booking_path');

        return response()->json([
            'visitor' => $visitor,
            'message' => 'Visitor registered successfully.',
        ]);
    }

    public function confirmPayment(Request $request, string $slug, string $bookingId): JsonResponse
    {
        $exhibition = Exhibition::where('slug', $slug)->firstOrFail();

        $visitor = Visitor::query()
            ->where('exhibition_id', $exhibition->id)
            ->where('booking_id', $bookingId)
            ->firstOrFail();

        $visitor->update(['payment_status' => 'completed']);

        session([
            'selected_visitor_booking_id' => $visitor->booking_id,
            'visitor_pass_active' => true,
        ]);
        session()->forget('exhibition_booking_path');

        return response()->json([
            'visitor' => $visitor->fresh(),
            'message' => 'Payment confirmed successfully.',
        ]);
    }
}
