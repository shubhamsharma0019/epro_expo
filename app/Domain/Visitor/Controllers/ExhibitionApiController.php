<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Event\Models\AgendaSession;
use App\Domain\Event\Models\Announcement;
use App\Domain\Visitor\Models\Bookmark;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Company\Models\Exhibitor;
use App\Domain\Event\Models\Faq;
use App\Domain\Visitor\Models\Meeting;
use App\Domain\Event\Models\Speaker;
use App\Domain\Event\Models\Sponsor;
use App\Domain\Event\Models\TicketTier;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorHall as Hall;
use App\Domain\Visitor\Models\VisitorPavilion as Pavilion;
use App\Domain\Visitor\Models\VisitorProduct as Product;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExhibitionApiController extends Controller
{
    public function getExhibitions(): JsonResponse
    {
        return response()->json(Exhibition::query()->latest()->get());
    }

    public function getExhibition(string|int $id): JsonResponse
    {
        $exhibition = $this->findExhibition($id);

        return $exhibition
            ? response()->json($exhibition)
            : response()->json(['error' => 'Exhibition not found'], 404);
    }

    public function getExhibitors(string|int $exhibitionId): JsonResponse
    {
        $exhibition = $this->findExhibition($exhibitionId);
        $legacyExhibitors = Exhibitor::query()
            ->when($exhibition, fn ($query) => $query->where('exhibition_id', $exhibition->id))
            ->get();

        $bookingExhibitors = BoothBooking::query()
            ->with(['company', 'hall', 'booth', 'boothProfile'])
            ->when($exhibition, fn ($query) => $query->where('exhibition_id', $exhibition->id))
            ->publiclyVisible()
            ->get()
            ->map(fn (BoothBooking $booking) => $this->bookingPayload($booking));

        return response()->json($legacyExhibitors->concat($bookingExhibitors)->values());
    }

    public function getExhibitor(string|int $exhibitorId): JsonResponse
    {
        if (str_starts_with((string) $exhibitorId, 'booking-')) {
            $booking = BoothBooking::with(['company', 'hall', 'booth', 'boothProfile'])
                ->find((int) str_replace('booking-', '', (string) $exhibitorId));

            return $booking
                ? response()->json($this->bookingPayload($booking))
                : response()->json(['error' => 'Exhibitor not found'], 404);
        }

        $exhibitor = Exhibitor::find($exhibitorId);

        return $exhibitor
            ? response()->json($exhibitor)
            : response()->json(['error' => 'Exhibitor not found'], 404);
    }

    public function registerVisitor(Request $request, string|int $exhibitionId): JsonResponse
    {
        $exhibition = $this->findExhibition($exhibitionId);
        if (! $exhibition) {
            return response()->json(['error' => 'Exhibition not found'], 404);
        }

        $amount = (float) $request->input('amount', 0);
        $visitor = Visitor::create([
            'exhibition_id' => $exhibition->id,
            'pavilion_id' => $request->input('pavilion_id'),
            'booking_id' => 'EXP-' . now()->format('ymd') . '-' . random_int(100000, 999999),
            'first_name' => $request->input('first_name', ''),
            'last_name' => $request->input('last_name', ''),
            'email' => $request->input('email', ''),
            'mobile' => $request->input('mobile', ''),
            'job_title' => $request->input('job_title'),
            'company' => $request->input('company'),
            'country' => $request->input('country', ''),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'industry' => $request->input('industry'),
            'company_size' => $request->input('company_size'),
            'business_address' => $request->input('business_address'),
            'pass_type' => $request->input('pass_type', 'Free Visitor Pass'),
            'amount' => $amount,
            'payment_status' => $amount > 0 ? 'pending' : 'completed',
            'checkin_status' => false,
            'checkin_time' => null,
        ]);

        return response()->json(['visitor' => $visitor], 201);
    }

    public function confirmPayment(string $bookingId): JsonResponse
    {
        return $this->updateVisitor($bookingId, ['payment_status' => 'completed']);
    }

    public function getTickets(): JsonResponse
    {
        return response()->json(Visitor::query()->latest()->get());
    }

    public function getTicketDetails(string $bookingId): JsonResponse
    {
        $visitor = Visitor::where('booking_id', $bookingId)->first();

        return $visitor
            ? response()->json($visitor)
            : response()->json(['error' => 'Ticket not found'], 404);
    }

    public function checkIn(string $bookingId): JsonResponse
    {
        return $this->updateVisitor($bookingId, [
            'checkin_status' => true,
            'checkin_time' => now()->format('M j, Y \a\t h:i A'),
        ]);
    }

    public function requestMeeting(Request $request): JsonResponse
    {
        if (! $request->filled('booking_id') || ! $request->filled('exhibitor_id')) {
            return response()->json(['error' => 'Booking ID and exhibitor ID are required'], 400);
        }

        $meeting = Meeting::create([
            'exhibitor_id' => $request->input('exhibitor_id'),
            'booking_id' => $request->input('booking_id'),
            'meeting_date' => $request->input('meeting_date', ''),
            'meeting_time' => $request->input('meeting_time', ''),
            'purpose' => $request->input('purpose', 'Product Demonstration'),
            'notes' => $request->input('notes'),
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Meeting requested successfully!', 'meeting' => $meeting], 201);
    }

    public function getMeetings(Request $request): JsonResponse
    {
        if (! $request->filled('booking_id')) {
            return response()->json(['error' => 'Booking ID is required'], 400);
        }

        return response()->json(
            Meeting::where('booking_id', $request->query('booking_id'))->with('exhibitor')->get()
        );
    }

    public function getHalls(): JsonResponse
    {
        return response()->json(Hall::all());
    }

    public function getHall(string|int $id): JsonResponse
    {
        $hall = Hall::find($id);

        return $hall
            ? response()->json($hall)
            : response()->json(['error' => 'Hall not found'], 404);
    }

    public function getPavilions(): JsonResponse
    {
        return response()->json(Pavilion::all());
    }

    public function getPavilion(string|int $id): JsonResponse
    {
        $pavilion = Pavilion::find($id);

        return $pavilion
            ? response()->json($pavilion)
            : response()->json(['error' => 'Pavilion not found'], 404);
    }

    public function getExhibitorVideos(string|int $exhibitorId): JsonResponse
    {
        $exhibitor = Exhibitor::find($exhibitorId);

        return $exhibitor
            ? response()->json($exhibitor->demoVideos)
            : response()->json(['error' => 'Exhibitor not found'], 404);
    }

    public function getTicketTiers(string|int $id): JsonResponse
    {
        $exhibition = $this->findExhibition($id);

        return $exhibition
            ? response()->json(TicketTier::where('exhibition_id', $exhibition->id)->get())
            : response()->json(['error' => 'Exhibition not found'], 404);
    }

    public function getProducts(string|int $id): JsonResponse
    {
        return response()->json(Product::where('exhibitor_id', $id)->get());
    }

    public function getBookmarks(string $bookingId): JsonResponse
    {
        return response()->json(Bookmark::where('booking_id', $bookingId)->get());
    }

    public function toggleBookmark(Request $request, string $bookingId): JsonResponse
    {
        $type = strtolower((string) $request->input('bookmarkable_type'));
        $targetId = $request->input('bookmarkable_id');

        if ($type === '' || ! $targetId) {
            return response()->json(['error' => 'bookmarkable_type and bookmarkable_id are required'], 400);
        }

        $existing = Bookmark::where('booking_id', $bookingId)
            ->where('bookmarkable_type', $type)
            ->where('bookmarkable_id', $targetId)
            ->first();

        if ($existing) {
            $existing->delete();

            return response()->json(['status' => 'removed', 'message' => 'Bookmark removed successfully']);
        }

        $bookmark = Bookmark::create([
            'booking_id' => $bookingId,
            'bookmarkable_type' => $type,
            'bookmarkable_id' => $targetId,
        ]);

        return response()->json(['status' => 'added', 'bookmark' => $bookmark, 'message' => 'Bookmark added successfully']);
    }

    public function getAnnouncements(string|int $id): JsonResponse
    {
        $exhibition = $this->findExhibition($id);

        return $exhibition
            ? response()->json(Announcement::where('exhibition_id', $exhibition->id)->latest()->get())
            : response()->json(['error' => 'Exhibition not found'], 404);
    }

    public function getFaqs(string|int $id): JsonResponse
    {
        $exhibition = $this->findExhibition($id);

        return $exhibition
            ? response()->json(Faq::where('exhibition_id', $exhibition->id)->get())
            : response()->json(['error' => 'Exhibition not found'], 404);
    }

    public function getAgenda(string|int $id): JsonResponse
    {
        $exhibition = $this->findExhibition($id);
        if (! $exhibition) {
            return response()->json(['error' => 'Exhibition not found'], 404);
        }

        $boothSessions = \App\Domain\Booth\Models\BoothSession::whereHas('boothBooking', fn ($query) => $query
            ->where('exhibition_id', $exhibition->id)
            ->publiclyVisible())
            ->whereIn('status', ['live', 'upcoming', 'completed'])
            ->with('teamMember')
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'exhibition_id' => $session->boothBooking->exhibition_id,
                    'start_time' => $session->start_time ? Carbon::parse($session->start_time)->format('h:i A') : '',
                    'date' => $session->session_date ? Carbon::parse($session->session_date)->format('M d, Y') : 'Date TBD',
                    'title' => $session->title,
                    'description' => $session->description,
                    'speaker_name' => $session->teamMember?->name,
                ];
            });

        return response()->json($boothSessions->isNotEmpty()
            ? $boothSessions
            : AgendaSession::where('exhibition_id', $exhibition->id)->get());
    }

    public function getSpeakersList(string|int $id): JsonResponse
    {
        $exhibition = $this->findExhibition($id);
        if (! $exhibition) {
            return response()->json(['error' => 'Exhibition not found'], 404);
        }

        $boothSpeakers = \App\Domain\Booth\Models\BoothTeamMember::whereHas('boothBooking', fn ($query) => $query
            ->where('exhibition_id', $exhibition->id)
            ->publiclyVisible())
            ->where('status', 'active')
            ->with(['company', 'boothBooking.boothProfile'])
            ->get()
            ->map(function ($member) {
                $companyName = $member->company?->company_name
                    ?: $member->company?->name
                    ?: $member->boothBooking?->boothProfile?->company_name
                    ?: '';

                return [
                    'id' => $member->id,
                    'exhibition_id' => $member->boothBooking->exhibition_id,
                    'name' => $member->name,
                    'title' => $member->designation,
                    'company' => $companyName,
                    'avatar_url' => $member->photo ? asset('storage/' . ltrim($member->photo, '/')) : null,
                    'bio' => $member->expertise_tags ? 'Expertise: ' . implode(', ', $member->expertise_tags) : 'Representative of ' . $companyName,
                ];
            });

        return response()->json($boothSpeakers->isNotEmpty()
            ? $boothSpeakers
            : Speaker::where('exhibition_id', $exhibition->id)->get());
    }

    public function getSponsors(string|int $id): JsonResponse
    {
        $exhibition = $this->findExhibition($id);
        if (! $exhibition) {
            return response()->json(['error' => 'Exhibition not found'], 404);
        }

        $boothSponsors = BoothBooking::query()
            ->with(['company', 'boothProfile'])
            ->where('exhibition_id', $exhibition->id)
            ->publiclyVisible()
            ->get()
            ->map(function (BoothBooking $booking) {
                $companyName = $booking->boothProfile?->company_name
                    ?: $booking->company?->company_name
                    ?: $booking->company?->name
                    ?: '';
                $logo = $booking->boothProfile?->company_logo ?: ($booking->company?->logo ?: '');

                return [
                    'id' => $booking->id,
                    'exhibition_id' => $booking->exhibition_id,
                    'name' => $companyName,
                    'logo_url' => $logo ? $this->assetUrl($logo) : null,
                    'level' => ((float) $booking->amount) >= 2000 ? 'Platinum' : (((float) $booking->amount) >= 1000 ? 'Gold' : 'Silver'),
                ];
            });

        return response()->json($boothSponsors->isNotEmpty()
            ? $boothSponsors
            : Sponsor::where('exhibition_id', $exhibition->id)->get());
    }

    private function findExhibition(string|int $id): ?Exhibition
    {
        return Exhibition::query()
            ->where('id', $id)
            ->orWhere('slug', $id)
            ->orWhere('name', 'like', '%' . $id . '%')
            ->orWhere('title', 'like', '%' . $id . '%')
            ->first();
    }

    private function updateVisitor(string $bookingId, array $values): JsonResponse
    {
        $visitor = Visitor::where('booking_id', $bookingId)->first();
        if (! $visitor) {
            return response()->json(['error' => 'Visitor not found'], 404);
        }

        $visitor->update($values);

        return response()->json(['visitor' => $visitor]);
    }

    private function bookingPayload(BoothBooking $booking): array
    {
        $profile = $booking->boothProfile;
        $company = $booking->company;
        $companyName = $profile?->company_name ?: $company?->company_name ?: $company?->name ?: 'Company Booth';

        return [
            'id' => 'booking-' . $booking->id,
            'exhibition_id' => $booking->exhibition_id,
            'name' => $companyName,
            'category' => $profile?->industry ?: 'Technology',
            'description' => $profile?->about_company ?: 'No description provided.',
            'hall_name' => $booking->hall?->title ?: 'Hall ' . $booking->hall_id,
            'booth_number' => $booking->booth?->booth_number ?: 'Booth ' . $booking->booth_id,
            'website' => $profile?->website ?: $company?->website ?: '',
            'email' => $profile?->email ?: $company?->email ?: '',
            'country' => $profile?->country ?: $company?->country ?: 'India',
            'rep_name' => $profile?->contact_person ?: $company?->contact_person_name ?: '',
            'rep_title' => 'Representative',
            'rep_email' => $profile?->email ?: $company?->email ?: '',
            'rep_phone' => $profile?->phone ?: $company?->phone ?: '',
            'rep_img_url' => 'https://randomuser.me/api/portraits/men/32.jpg',
            'logo_color' => 'bg-indigo-600',
            'logo_text' => strtoupper(substr($companyName, 0, 2)),
            'is_dynamic_booking' => true,
            'booth_booking_id' => $booking->id,
        ];
    }

    private function assetUrl(string $path): string
    {
        return str_starts_with($path, 'http')
            ? $path
            : (str_starts_with($path, 'storage/') ? asset($path) : asset('storage/' . ltrim($path, '/')));
    }
}
