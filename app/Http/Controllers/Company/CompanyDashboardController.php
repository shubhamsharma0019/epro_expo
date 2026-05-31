<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CompanyDashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $companyId = session('company_id');

        if (! $companyId) {
            return redirect('/company/login');
        }

        $currentCompany = Company::query()
            ->withCount([
                'boothBookings',
                'products',
                'companyDocuments',
                'catalogues',
                'mediaGalleries',
                'businessCards',
                'companyMeetings',
                'enquiries',
                'visitorMeetingBookings',
                'boothViews',
            ])
            ->find($companyId);

        if (! $currentCompany) {
            session()->forget('company_id');

            return redirect('/company/login');
        }

        $latestBooking = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'boothProfile'])
            ->withCount([
                'boothProducts',
                'boothDocuments',
                'boothCatalogues',
                'boothMedia',
                'boothTeamMembers',
                'boothMeetingSlots',
            ])
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->latest()
            ->first();

        $pendingBooking = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize'])
            ->where('payment_status', 'paid')
            ->where('admin_status', 'pending')
            ->latest()
            ->first();

        $recentBookings = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'boothProfile'])
            ->withCount([
                'boothProducts',
                'boothDocuments',
                'boothCatalogues',
                'boothMedia',
                'boothTeamMembers',
                'boothMeetingSlots',
            ])
            ->latest()
            ->take(8)
            ->get();

        $recentEnquiries = $currentCompany->enquiries()
            ->with('visitor')
            ->latest()
            ->take(5)
            ->get();

        $recentMeetings = $currentCompany->visitorMeetingBookings()
            ->with(['companyMeeting', 'visitor'])
            ->latest()
            ->take(5)
            ->get();

        $confirmedBookings = $currentCompany->boothBookings()
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->count();

        $totalSpend = (float) $currentCompany->boothBookings()->sum('total_amount');

        $performanceStart = Carbon::today()->subDays(6);
        $viewsByDate = $currentCompany->boothViews()
            ->where(function ($query) use ($performanceStart) {
                $query->where('viewed_at', '>=', $performanceStart)
                    ->orWhere(function ($fallbackQuery) use ($performanceStart) {
                        $fallbackQuery->whereNull('viewed_at')
                            ->where('created_at', '>=', $performanceStart);
                    });
            })
            ->get()
            ->groupBy(fn ($view) => optional($view->viewed_at ?? $view->created_at)->format('Y-m-d'));

        $hasBoothProfile = (bool) $latestBooking?->boothProfile;
        $performanceValues = collect(range(0, 6))->map(function (int $offset) use ($performanceStart, $viewsByDate) {
            $date = $performanceStart->copy()->addDays($offset);

            return [
                'label' => $date->format('M j'),
                'value' => $viewsByDate->get($date->format('Y-m-d'), collect())->count(),
            ];
        });

        $maxPerformanceValue = max($performanceValues->max('value'), 1);
        $chartPoints = $performanceValues->values()->map(function (array $item, int $index) use ($maxPerformanceValue) {
            $x = 20 + ($index * 100);
            $y = 180 - (($item['value'] / $maxPerformanceValue) * 140);

            return [
                'x' => $x,
                'y' => round($y, 2),
                'label' => $item['label'],
                'value' => $item['value'],
            ];
        });

        $performanceData = [
            'values' => $performanceValues,
            'max_value' => $maxPerformanceValue,
            'axis_labels' => collect(range(5, 0))->map(fn (int $step) => (int) ceil($maxPerformanceValue * $step / 5)),
            'points' => $chartPoints,
            'polyline' => $chartPoints->map(fn (array $point) => $point['x'] . ',' . $point['y'])->implode(' '),
            'polygon' => $chartPoints->map(fn (array $point) => $point['x'] . ',' . $point['y'])->implode(' ') . ' 620,200 20,200',
        ];

        $hasCompanyProfile = $currentCompany->isProfileComplete();
        $bookingProductsCount = (int) ($latestBooking->booth_products_count ?? 0);
        $bookingDocumentsCount = (int) ($latestBooking->booth_documents_count ?? 0);
        $bookingCataloguesCount = (int) ($latestBooking->booth_catalogues_count ?? 0);
        $bookingMediaCount = (int) ($latestBooking->booth_media_count ?? 0);
        $bookingTeamCount = (int) ($latestBooking->booth_team_members_count ?? 0);
        $bookingMeetingSlotsCount = (int) ($latestBooking->booth_meeting_slots_count ?? 0);

        $previewReady = $hasCompanyProfile
            && $hasBoothProfile
            && $bookingProductsCount > 0
            && $bookingMediaCount > 0;

        $progressPercent = 0;
        $progressPercent += $hasCompanyProfile ? 15 : 0;
        $progressPercent += $hasBoothProfile ? 15 : 0;
        $progressPercent += $bookingProductsCount > 0 ? 15 : 0;
        $progressPercent += $bookingDocumentsCount > 0 ? 10 : 0;
        $progressPercent += $bookingCataloguesCount > 0 ? 10 : 0;
        $progressPercent += $bookingMediaCount > 0 ? 10 : 0;
        $progressPercent += $bookingTeamCount > 0 ? 10 : 0;
        $progressPercent += $bookingMeetingSlotsCount > 0 ? 10 : 0;
        $progressPercent += $previewReady ? 5 : 0;

        $stats = [
            'total_bookings' => $currentCompany->booth_bookings_count,
            'confirmed_bookings' => $confirmedBookings,
            'products_count' => $bookingProductsCount,
            'documents_count' => $bookingDocumentsCount,
            'catalogues_count' => $bookingCataloguesCount,
            'media_count' => $bookingMediaCount,
            'meetings_count' => $currentCompany->visitor_meeting_bookings_count,
            'enquiries_count' => $currentCompany->enquiries_count,
            'booth_views_count' => $currentCompany->booth_views_count,
            'total_spend' => $totalSpend,
        ];

        $boothSetup = [
            'has_profile' => $hasBoothProfile,
            'profile_status' => $hasBoothProfile ? 'Completed' : 'Pending',
            'products_count' => $bookingProductsCount,
            'documents_count' => $bookingDocumentsCount,
            'catalogues_count' => $bookingCataloguesCount,
            'media_count' => $bookingMediaCount,
            'team_count' => $bookingTeamCount,
            'meetings_count' => $bookingMeetingSlotsCount,
            'preview_status' => $previewReady ? 'Ready' : 'Not Ready',
            'progress_percent' => min($progressPercent, 100),
        ];

        $hasBookedBooth = (bool) $latestBooking;

        if ($latestBooking) {
            session(['company_booth_booked' => true]);
            session(['company_booking_id' => 'BOOK-' . str_pad((string) $latestBooking->id, 5, '0', STR_PAD_LEFT)]);
        } else {
            session()->forget(['company_booth_booked', 'company_booking_id']);
        }

        return view('company.dashboard', compact(
            'currentCompany',
            'stats',
            'latestBooking',
            'pendingBooking',
            'recentBookings',
            'recentEnquiries',
            'recentMeetings',
            'boothSetup',
            'hasBookedBooth',
            'performanceData',
        ));
    }

    public function data(): JsonResponse|RedirectResponse
    {
        $companyId = session('company_id');

        if (! $companyId) {
            return redirect('/company/login');
        }

        $currentCompany = Company::query()
            ->withCount(['boothBookings', 'enquiries', 'visitorMeetingBookings', 'boothViews'])
            ->find($companyId);

        if (! $currentCompany) {
            session()->forget('company_id');

            return redirect('/company/login');
        }

        $latestBooking = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'boothProfile'])
            ->withCount([
                'boothProducts',
                'boothDocuments',
                'boothCatalogues',
                'boothMedia',
                'boothTeamMembers',
                'boothSessions',
                'boothMeetingSlots',
            ])
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->latest()
            ->first();

        $pendingBooking = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize'])
            ->where('payment_status', 'paid')
            ->where('admin_status', 'pending')
            ->latest()
            ->first();

        $dashboardBookings = $currentCompany->boothBookings()
            ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'boothProfile'])
            ->withCount([
                'boothProducts',
                'boothDocuments',
                'boothCatalogues',
                'boothMedia',
                'boothTeamMembers',
                'boothSessions',
                'boothMeetingSlots',
            ])
            ->latest()
            ->take(8)
            ->get();

        $activeBooking = $latestBooking ?: $pendingBooking;
        $setupProgress = $latestBooking ? $this->setupProgressPercent($currentCompany, $latestBooking) : 0;
        $isBoothLive = $latestBooking && in_array($latestBooking->booth_setup_status, ['published', 'approved', 'live'], true);
        $publicBoothUrl = ($latestBooking && $latestBooking->exhibition)
            ? route('exhibitions.booths.show', [
                $latestBooking->exhibition->slug,
                \Illuminate\Support\Str::slug($latestBooking->boothProfile?->company_name ?: $currentCompany->company_name ?: $currentCompany->name),
            ])
            : null;

        return response()->json([
            'company' => [
                'name' => $currentCompany->company_name ?? $currentCompany->name ?? 'Company',
                'contact_name' => $currentCompany->contact_person_name ?? $currentCompany->owner_name ?? $currentCompany->company_name ?? $currentCompany->name ?? 'Company',
                'email' => $currentCompany->email,
                'status' => ucfirst($currentCompany->status ?? 'pending'),
            ],
            'stats' => [
                'active_bookings' => $currentCompany->boothBookings()->whereIn('booking_status', ['confirmed', 'active'])->count(),
                'setup_progress' => $setupProgress,
                'leads' => $currentCompany->enquiries_count,
                'meetings' => $currentCompany->visitor_meeting_bookings_count,
                'booth_views' => $currentCompany->booth_views_count,
                'total_spend' => (float) $currentCompany->boothBookings()->sum('total_amount'),
                'products' => (int) ($latestBooking->booth_products_count ?? 0),
                'documents' => (int) ($latestBooking->booth_documents_count ?? 0),
                'catalogues' => (int) ($latestBooking->booth_catalogues_count ?? 0),
                'media' => (int) ($latestBooking->booth_media_count ?? 0),
                'team' => (int) ($latestBooking->booth_team_members_count ?? 0),
                'sessions' => (int) ($latestBooking->booth_sessions_count ?? 0),
            ],
            'booking' => $activeBooking ? [
                'id' => 'BOOK-' . str_pad((string) $activeBooking->id, 5, '0', STR_PAD_LEFT),
                'status' => $latestBooking ? 'Approved' : 'Pending Approval',
                'exhibition' => $activeBooking->exhibition?->title,
                'pavilion' => $activeBooking->pavilion?->title,
                'hall' => $activeBooking->hall?->title,
                'booth' => $activeBooking->booth?->booth_number,
                'booth_size' => $activeBooking->boothSize?->title,
                'created_at' => optional($activeBooking->created_at)->format('M d, Y'),
                'setup_url' => $latestBooking ? route('company.booth-setup.index', $latestBooking) : null,
                'public_url' => $isBoothLive ? $publicBoothUrl : null,
                'booth_setup_status' => $latestBooking?->booth_setup_status,
                'is_live' => (bool) $isBoothLive,
            ] : null,
            'bookings' => $dashboardBookings->map(function ($booking) use ($currentCompany) {
                $isApproved = $booking->payment_status === 'paid'
                    && in_array($booking->booking_status, ['confirmed', 'active'], true)
                    && $booking->admin_status === 'approved';
                $isLive = $isApproved && in_array($booking->booth_setup_status, ['published', 'approved', 'live'], true);
                $companyName = $booking->boothProfile?->company_name ?: $currentCompany->company_name ?: $currentCompany->name;
                $publicUrl = ($isLive && $booking->exhibition)
                    ? route('exhibitions.booths.show', [
                        $booking->exhibition->slug,
                        \Illuminate\Support\Str::slug($companyName),
                    ])
                    : null;

                return [
                    'id' => $booking->id,
                    'booking_id' => 'BOOK-' . str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT),
                    'exhibition' => $booking->exhibition?->title,
                    'hall' => $booking->hall?->title,
                    'booth' => $booking->booth?->booth_number,
                    'booth_size' => $booking->boothSize?->title,
                    'status' => $isLive ? 'Live' : ($isApproved ? 'Setup Available' : ucfirst(str_replace('_', ' ', $booking->admin_status ?: $booking->booking_status ?: 'pending'))),
                    'setup_url' => $isApproved ? route('company.booth-setup.index', $booking) : null,
                    'public_url' => $publicUrl,
                    'is_live' => $isLive,
                    'setup_progress' => $isApproved ? $this->setupProgressPercent($currentCompany, $booking) : 0,
                ];
            })->values(),
            'setup_steps' => [
                ['label' => 'Company Profile', 'status' => $currentCompany->isProfileComplete() ? 'Completed' : 'Pending'],
                ['label' => 'Booth Branding', 'status' => $latestBooking?->boothProfile ? 'Completed' : 'Pending'],
                ['label' => 'Products', 'status' => ($latestBooking->booth_products_count ?? 0) > 0 ? 'Completed' : 'Pending'],
                ['label' => 'Documents & Catalogues', 'status' => (($latestBooking->booth_documents_count ?? 0) + ($latestBooking->booth_catalogues_count ?? 0)) > 0 ? 'Completed' : 'Pending'],
                ['label' => 'Preview & Publish', 'status' => in_array($latestBooking?->booth_setup_status, ['ready_to_publish', 'pending_review', 'published', 'approved', 'live'], true) ? 'Completed' : 'Pending'],
            ],
            'links' => [
                'book_booth' => url('/company/booth-booking/pavilions'),
                'bookings' => url('/company/bookings'),
                'enquiries' => url('/company/enquiries'),
                'analytics' => url('/company/analytics'),
                'profile' => url('/company/profile'),
                'products' => $latestBooking ? route('company.booth-setup.products.index', $latestBooking) : url('/company/booth-booking/pavilions'),
                'documents' => $latestBooking ? route('company.booth-setup.documents.index', $latestBooking) : url('/company/booth-booking/pavilions'),
                'meetings' => $latestBooking ? route('company.booth-setup.meetings.edit', $latestBooking) : url('/company/booth-booking/pavilions'),
                'setup' => $isBoothLive && $publicBoothUrl ? $publicBoothUrl : ($latestBooking ? route('company.booth-setup.index', $latestBooking) : url('/company/booth-booking/pavilions')),
                'public_booth' => $publicBoothUrl,
            ],
        ]);
    }

    private function setupProgressPercent(Company $company, $booking): int
    {
        $progress = 0;
        $progress += $company->isProfileComplete() ? 15 : 0;
        $progress += $booking->boothProfile ? 15 : 0;
        $progress += ($booking->booth_products_count ?? 0) > 0 ? 15 : 0;
        $progress += ($booking->booth_documents_count ?? 0) > 0 ? 10 : 0;
        $progress += ($booking->booth_catalogues_count ?? 0) > 0 ? 10 : 0;
        $progress += ($booking->booth_media_count ?? 0) > 0 ? 10 : 0;
        $progress += ($booking->booth_team_members_count ?? 0) > 0 ? 10 : 0;
        $progress += ($booking->booth_meeting_slots_count ?? 0) > 0 ? 10 : 0;
        $progress += in_array($booking->booth_setup_status, ['ready_to_publish', 'pending_review', 'published', 'approved', 'live'], true) ? 5 : 0;

        return min($progress, 100);
    }
}
