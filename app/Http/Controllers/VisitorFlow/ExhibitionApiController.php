<?php

namespace App\Http\Controllers\VisitorFlow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exhibition;
use App\Models\Exhibitor;
use App\Models\Visitor;
use App\Models\Meeting;
use App\Models\VisitorHall as Hall;
use App\Models\VisitorPavilion as Pavilion;
use App\Models\TicketTier;
use App\Models\VisitorProduct as Product;
use App\Models\Bookmark;
use App\Models\Announcement;
use App\Models\Faq;
use App\Models\AgendaSession;
use App\Models\Speaker;
use App\Models\Sponsor;

class ExhibitionApiController extends Controller
{
    // 1. Fetch all exhibitions
    public function getExhibitions()
    {
        $exhibitions = Exhibition::all();
        return response()->json($exhibitions);
    }

    // 2. Fetch specific exhibition details
    public function getExhibition($id)
    {
        $exhibition = Exhibition::find($id);
        if (!$exhibition) {
            // Find by name/slug if id is mock text/slug
            $exhibition = Exhibition::where('slug', $id)
                ->orWhere('name', 'like', '%' . $id . '%')
                ->first();
        }
        
        if ($exhibition) {
            return response()->json($exhibition);
        }

        return response()->json(['error' => 'Exhibition not found'], 404);
    }

    // 3. Fetch exhibitors for a specific exhibition
    public function getExhibitors($exhibitionId)
    {
        $exhibitors = Exhibitor::where('exhibition_id', $exhibitionId)->get();

        $bookings = \App\Models\BoothBooking::with(['company', 'hall', 'booth', 'boothProfile'])
            ->where('exhibition_id', $exhibitionId)
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->whereIn('booth_setup_status', ['draft', 'setup_in_progress', 'ready_to_publish', 'pending_review', 'published', 'in_progress', 'submitted_for_review', 'approved', 'live'])
            ->get()
            ->map(function ($booking) {
                $profile = $booking->boothProfile;
                $company = $booking->company;
                
                return [
                    'id' => 'booking-' . $booking->id,
                    'exhibition_id' => $booking->exhibition_id,
                    'name' => $profile?->company_name ?: $company?->company_name ?: $company?->name ?: 'Company Booth',
                    'category' => $profile?->industry ?: 'Technology',
                    'description' => $profile?->about_company ?: 'No description provided.',
                    'hall_name' => $booking->hall?->title ?: 'Hall ' . $booking->hall_id,
                    'booth_number' => $booking->booth?->booth_number ?: 'Booth ' . $booking->booth_id,
                    'website' => $profile?->website ?: '',
                    'email' => $profile?->email ?: '',
                    'country' => $profile?->country ?: 'India',
                    'rep_name' => $profile?->contact_person ?: '',
                    'rep_title' => 'Representative',
                    'rep_email' => $profile?->email ?: '',
                    'rep_phone' => $profile?->phone ?: '',
                    'rep_img_url' => 'https://randomuser.me/api/portraits/men/32.jpg',
                    'logo_color' => 'bg-indigo-600',
                    'logo_text' => strtoupper(substr($profile?->company_name ?: $company?->name ?: 'C', 0, 2)),
                    'is_dynamic_booking' => true,
                    'booth_booking_id' => $booking->id,
                ];
            });

        return response()->json($exhibitors->concat($bookings));
    }

    // 4. Fetch specific exhibitor details
    public function getExhibitor($exhibitorId)
    {
        if (strpos($exhibitorId, 'booking-') === 0) {
            $bookingId = str_replace('booking-', '', $exhibitorId);
            $booking = \App\Models\BoothBooking::with(['company', 'hall', 'booth', 'boothProfile'])->find($bookingId);
            if ($booking) {
                $profile = $booking->boothProfile;
                $company = $booking->company;
                return response()->json([
                    'id' => 'booking-' . $booking->id,
                    'exhibition_id' => $booking->exhibition_id,
                    'name' => $profile?->company_name ?: $company?->company_name ?: $company?->name ?: 'Company Booth',
                    'category' => $profile?->industry ?: 'Technology',
                    'description' => $profile?->about_company ?: 'No description provided.',
                    'hall_name' => $booking->hall?->title ?: 'Hall ' . $booking->hall_id,
                    'booth_number' => $booking->booth?->booth_number ?: 'Booth ' . $booking->booth_id,
                    'website' => $profile?->website ?: '',
                    'email' => $profile?->email ?: '',
                    'country' => $profile?->country ?: 'India',
                    'rep_name' => $profile?->contact_person ?: '',
                    'rep_title' => 'Representative',
                    'rep_email' => $profile?->email ?: '',
                    'rep_phone' => $profile?->phone ?: '',
                    'rep_img_url' => 'https://randomuser.me/api/portraits/men/32.jpg',
                    'logo_color' => 'bg-indigo-600',
                    'logo_text' => strtoupper(substr($profile?->company_name ?: $company?->name ?: 'C', 0, 2)),
                    'is_dynamic_booking' => true,
                    'booth_booking_id' => $booking->id,
                ]);
            }
        }

        $exhibitor = Exhibitor::find($exhibitorId);
        if (!$exhibitor) {
            return response()->json(['error' => 'Exhibitor not found'], 404);
        }
        return response()->json($exhibitor);
    }

    // 5. Submit visitor details registration
    public function registerVisitor(Request $request, $exhibitionId)
    {
        $data = $request->all();

        // Check if exhibition exists
        $exhibition = Exhibition::find($exhibitionId);
        if (!$exhibition) {
            return response()->json(['error' => 'Exhibition not found'], 404);
        }

        // Generate unique booking_id
        $randomNum = rand(100000, 999999);
        $bookingId = 'EXP-' . date('ymd') . '-' . $randomNum;

        $amount = isset($data['amount']) ? (float)$data['amount'] : 0.00;
        $paymentStatus = $amount > 0 ? 'pending' : 'completed';

        $visitor = Visitor::create([
            'exhibition_id' => $exhibitionId,
            'pavilion_id' => $data['pavilion_id'] ?? null,
            'booking_id' => $bookingId,
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'email' => $data['email'] ?? '',
            'mobile' => $data['mobile'] ?? '',
            'job_title' => $data['job_title'] ?? null,
            'company' => $data['company'] ?? null,
            'country' => $data['country'] ?? '',
            'state' => $data['state'] ?? null,
            'city' => $data['city'] ?? null,
            'industry' => $data['industry'] ?? null,
            'company_size' => $data['company_size'] ?? null,
            'business_address' => $data['business_address'] ?? null,
            'pass_type' => $data['pass_type'] ?? 'Free Visitor Pass',
            'amount' => $amount,
            'payment_status' => $paymentStatus,
            'checkin_status' => false,
            'checkin_time' => null,
        ]);

        return response()->json(['visitor' => $visitor], 201);
    }

    // 6. Confirm payment status updates
    public function confirmPayment($bookingId)
    {
        $visitor = Visitor::where('booking_id', $bookingId)->first();
        if (!$visitor) {
            return response()->json(['error' => 'Visitor not found'], 404);
        }

        $visitor->update(['payment_status' => 'completed']);
        return response()->json(['visitor' => $visitor]);
    }

    // 6a. Get all registered tickets
    public function getTickets()
    {
        return response()->json(Visitor::all());
    }

    // 7. Get ticket details
    public function getTicketDetails($bookingId)
    {
        $visitor = Visitor::where('booking_id', $bookingId)->first();
        if (!$visitor) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }
        return response()->json($visitor);
    }

    // 8. Submit Check-in
    public function checkIn($bookingId)
    {
        $visitor = Visitor::where('booking_id', $bookingId)->first();
        if (!$visitor) {
            return response()->json(['error' => 'Visitor not found'], 404);
        }

        $now = now();
        $timeStr = $now->format('M j, Y') . ' at ' . $now->format('h:i A');

        $visitor->update([
            'checkin_status' => true,
            'checkin_time' => $timeStr
        ]);

        return response()->json(['visitor' => $visitor]);
    }

    // 9. Request a business meeting slot
    public function requestMeeting(Request $request)
    {
        $data = $request->all();

        if (empty($data['booking_id'])) {
            return response()->json(['error' => 'Booking ID is required'], 400);
        }
        if (empty($data['exhibitor_id'])) {
            return response()->json(['error' => 'Exhibitor ID is required'], 400);
        }

        $meeting = Meeting::create([
            'exhibitor_id' => $data['exhibitor_id'],
            'booking_id' => $data['booking_id'],
            'meeting_date' => $data['meeting_date'] ?? '',
            'meeting_time' => $data['meeting_time'] ?? '',
            'purpose' => $data['purpose'] ?? 'Product Demonstration',
            'notes' => $data['notes'] ?? null,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Meeting requested successfully!',
            'meeting' => $meeting
        ], 201);
    }

    // 10. List meetings
    public function getMeetings(Request $request)
    {
        $bookingId = $request->query('booking_id');
        if (empty($bookingId)) {
            return response()->json(['error' => 'Booking ID is required'], 400);
        }

        $meetings = Meeting::where('booking_id', $bookingId)->with('exhibitor')->get();
        return response()->json($meetings);
    }

    // 11. Fetch all halls
    public function getHalls()
    {
        return response()->json(Hall::all());
    }

    // 12. Fetch specific hall details
    public function getHall($id)
    {
        $hall = Hall::find($id);
        if (!$hall) {
            return response()->json(['error' => 'Hall not found'], 404);
        }
        return response()->json($hall);
    }

    // 13. Fetch all pavilions
    public function getPavilions()
    {
        return response()->json(Pavilion::all());
    }

    // 14. Fetch specific pavilion details
    public function getPavilion($id)
    {
        $pavilion = Pavilion::find($id);
        if (!$pavilion) {
            return response()->json(['error' => 'Pavilion not found'], 404);
        }
        return response()->json($pavilion);
    }

    // 15. Fetch exhibitor videos
    public function getExhibitorVideos($exhibitorId)
    {
        $exhibitor = Exhibitor::find($exhibitorId);
        if (!$exhibitor) {
            return response()->json(['error' => 'Exhibitor not found'], 404);
        }
        return response()->json($exhibitor->demoVideos);
    }

    // 16. Fetch ticket tiers for an exhibition
    public function getTicketTiers($id)
    {
        $exhibition = Exhibition::find($id);
        if (!$exhibition) {
            $exhibition = Exhibition::where('name', 'like', '%' . $id . '%')->first();
        }
        if (!$exhibition) {
            return response()->json(['error' => 'Exhibition not found'], 404);
        }
        $tiers = TicketTier::where('exhibition_id', $exhibition->id)->get();
        return response()->json($tiers);
    }

    // 17. Fetch products/brochures for an exhibitor
    public function getProducts($id)
    {
        $products = Product::where('exhibitor_id', $id)->get();
        return response()->json($products);
    }

    // 18. Fetch bookmarks for a visitor/booking_id
    public function getBookmarks($bookingId)
    {
        $bookmarks = Bookmark::where('booking_id', $bookingId)->get();
        return response()->json($bookmarks);
    }

    // 19. Toggle bookmark for a visitor
    public function toggleBookmark(Request $request, $bookingId)
    {
        $type = $request->input('bookmarkable_type'); // e.g. 'exhibitor', 'pavilion', 'hall'
        $targetId = $request->input('bookmarkable_id');

        if (!$type || !$targetId) {
            return response()->json(['error' => 'bookmarkable_type and bookmarkable_id are required'], 400);
        }

        // Clean type name
        $type = strtolower($type);

        $existing = Bookmark::where('booking_id', $bookingId)
            ->where('bookmarkable_type', $type)
            ->where('bookmarkable_id', $targetId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'removed', 'message' => 'Bookmark removed successfully']);
        } else {
            $bookmark = Bookmark::create([
                'booking_id' => $bookingId,
                'bookmarkable_type' => $type,
                'bookmarkable_id' => $targetId
            ]);
            return response()->json(['status' => 'added', 'bookmark' => $bookmark, 'message' => 'Bookmark added successfully']);
        }
    }

    // 20. Fetch announcements for an exhibition
    public function getAnnouncements($id)
    {
        $exhibition = Exhibition::find($id);
        if (!$exhibition) {
            $exhibition = Exhibition::where('name', 'like', '%' . $id . '%')->first();
        }
        if (!$exhibition) {
            return response()->json(['error' => 'Exhibition not found'], 404);
        }
        $announcements = Announcement::where('exhibition_id', $exhibition->id)->orderBy('created_at', 'desc')->get();
        return response()->json($announcements);
    }

    // 21. Fetch FAQs for an exhibition
    public function getFaqs($id)
    {
        $exhibition = Exhibition::find($id);
        if (!$exhibition) {
            $exhibition = Exhibition::where('name', 'like', '%' . $id . '%')->first();
        }
        if (!$exhibition) {
            return response()->json(['error' => 'Exhibition not found'], 404);
        }
        $faqs = Faq::where('exhibition_id', $exhibition->id)->get();
        return response()->json($faqs);
    }

    // 22. Fetch Agenda Sessions for an exhibition
    public function getAgenda($id)
    {
        $exhibition = Exhibition::find($id);
        if (!$exhibition) {
            $exhibition = Exhibition::where('name', 'like', '%' . $id . '%')->first();
        }
        if (!$exhibition) {
            return response()->json(['error' => 'Exhibition not found'], 404);
        }
        $boothSessions = \App\Models\BoothSession::whereHas('boothBooking', function ($query) use ($exhibition) {
            $query->where('exhibition_id', $exhibition->id)
                  ->where('payment_status', 'paid')
                  ->whereIn('booking_status', ['confirmed', 'active'])
                  ->where('admin_status', 'approved')
                  ->whereIn('booth_setup_status', ['published', 'approved', 'live']);
        })->where('status', 'upcoming')->with(['teamMember'])->get();

        if ($boothSessions->isNotEmpty()) {
            $sessions = $boothSessions->map(function ($session) {
                $startTime = $session->start_time 
                    ? \Carbon\Carbon::parse($session->start_time)->format('h:i A') 
                    : '';

                $dateStr = $session->session_date 
                    ? ($session->session_date instanceof \DateTimeInterface 
                        ? $session->session_date->format('M d, Y') 
                        : \Carbon\Carbon::parse($session->session_date)->format('M d, Y')) 
                    : 'Date TBD';

                return [
                    'id' => $session->id,
                    'exhibition_id' => $session->boothBooking->exhibition_id,
                    'start_time' => $startTime,
                    'date' => $dateStr,
                    'title' => $session->title,
                    'description' => $session->description,
                    'speaker_name' => $session->teamMember?->name,
                    'created_at' => $session->created_at,
                    'updated_at' => $session->updated_at,
                ];
            });
        } else {
            $sessions = AgendaSession::where('exhibition_id', $exhibition->id)->get();
        }

        return response()->json($sessions);
    }

    // 23. Fetch Speakers for an exhibition
    public function getSpeakersList($id)
    {
        $exhibition = Exhibition::find($id);
        if (!$exhibition) {
            $exhibition = Exhibition::where('name', 'like', '%' . $id . '%')->first();
        }
        if (!$exhibition) {
            return response()->json(['error' => 'Exhibition not found'], 404);
        }
        $boothTeamMembers = \App\Models\BoothTeamMember::whereHas('boothBooking', function ($query) use ($exhibition) {
            $query->where('exhibition_id', $exhibition->id)
                  ->where('payment_status', 'paid')
                  ->whereIn('booking_status', ['confirmed', 'active'])
                  ->where('admin_status', 'approved')
                  ->whereIn('booth_setup_status', ['published', 'approved', 'live']);
        })->where('status', 'active')->with(['company', 'boothBooking.boothProfile'])->get();

        if ($boothTeamMembers->isNotEmpty()) {
            $speakers = $boothTeamMembers->map(function ($member) {
                $companyName = $member->company?->company_name 
                    ?: ($member->company?->name 
                    ?: ($member->boothBooking?->boothProfile?->company_name 
                    ?: ''));

                $avatarUrl = $member->photo 
                    ? asset('storage/' . $member->photo) 
                    : null;

                $bio = $member->expertise_tags 
                    ? 'Expertise: ' . implode(', ', $member->expertise_tags)
                    : 'Representative of ' . $companyName;

                return [
                    'id' => $member->id,
                    'exhibition_id' => $member->boothBooking->exhibition_id,
                    'name' => $member->name,
                    'title' => $member->designation,
                    'company' => $companyName,
                    'avatar_url' => $avatarUrl,
                    'bio' => $bio,
                    'created_at' => $member->created_at,
                    'updated_at' => $member->updated_at,
                ];
            });
        } else {
            $speakers = Speaker::where('exhibition_id', $exhibition->id)->get();
        }

        return response()->json($speakers);
    }

    // 24. Fetch Sponsors for an exhibition
    public function getSponsors($id)
    {
        $exhibition = Exhibition::find($id);
        if (!$exhibition) {
            $exhibition = Exhibition::where('name', 'like', '%' . $id . '%')->first();
        }
        if (!$exhibition) {
            return response()->json(['error' => 'Exhibition not found'], 404);
        }
        $boothSponsors = \App\Models\BoothBooking::query()
            ->with(['company', 'boothProfile', 'boothSize'])
            ->where('exhibition_id', $exhibition->id)
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->whereIn('booth_setup_status', ['published', 'approved', 'live'])
            ->get();

        if ($boothSponsors->isNotEmpty()) {
            $sponsors = $boothSponsors->map(function ($booking) {
                $companyName = $booking->boothProfile?->company_name 
                    ?: ($booking->company?->company_name 
                    ?: ($booking->company?->name 
                    ?: ''));

                $logo = $booking->boothProfile?->company_logo ?: ($booking->company?->logo ?: '');
                $logoUrl = $logo ? (str_starts_with($logo, 'http') ? $logo : (str_starts_with($logo, 'storage/') ? asset($logo) : asset('storage/' . $logo))) : null;

                $price = (float) $booking->amount;
                if ($price >= 2000) {
                    $level = 'Platinum';
                } elseif ($price >= 1000) {
                    $level = 'Gold';
                } else {
                    $level = 'Silver';
                }

                return [
                    'id' => $booking->id,
                    'exhibition_id' => $booking->exhibition_id,
                    'name' => $companyName,
                    'logo_url' => $logoUrl,
                    'level' => $level,
                    'created_at' => $booking->created_at,
                    'updated_at' => $booking->updated_at,
                ];
            });
        } else {
            $sponsors = Sponsor::where('exhibition_id', $exhibition->id)->get();
        }

        return response()->json($sponsors);
    }
}
