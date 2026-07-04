<?php

namespace App\Support;

use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\TicketTier;
use App\Domain\Visitor\Models\ExhibitionTicketVisitorRegistration;
use App\Domain\Visitor\Models\Visitor;
use App\Support\UserVisitorPasses;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;

class ExhibitionTicketFlow
{
    public static function ticketTiers(Exhibition $exhibition): Collection
    {
        $tiers = TicketTier::query()
            ->where('exhibition_id', $exhibition->id)
            ->orderBy('price')
            ->orderBy('id')
            ->get()
            ->filter(fn ($tier) => filled($tier->name))
            ->values();

        if ($tiers->isNotEmpty()) {
            return $tiers;
        }

        return collect([
            new TicketTier(['id' => 1, 'name' => 'Free Visitor Pass', 'price' => 0.00, 'benefits' => 'Access to exhibition & booths, Standard sessions entry, Digital certificate']),
            new TicketTier(['id' => 2, 'name' => 'Business Pass', 'price' => 999.00, 'benefits' => 'Access to all pavilions, B2B matchmaking lounges, Standard speaker sessions, Catalogue book']),
            new TicketTier(['id' => 3, 'name' => 'VIP All-Access Pass', 'price' => 2499.00, 'benefits' => 'Priority check-in, VIP lounge access, Invite-only keynote, VIP networking dinner']),
        ]);
    }

    public static function visitorPassEntryUrl(string $slug): string
    {
        $exhibition = Exhibition::query()->where('slug', $slug)->first();
        if (! $exhibition) {
            return route('exhibitions.tickets.visitor-details', $slug);
        }

        $bookingId = session('selected_visitor_booking_id');
        if ($bookingId) {
            $normalizedBookingId = UserVisitorPasses::normalizeBookingId($bookingId) ?? $bookingId;
            $hasCompletedPass = Visitor::query()
                ->where('booking_id', $normalizedBookingId)
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'completed')
                ->exists();

            if ($hasCompletedPass) {
                return route('frontend.user.dashboard', ['slug' => $slug]);
            }
        }

        if (auth()->check()) {
            return self::passSelectionUrl($slug);
        }

        return route('exhibitions.tickets.visitor-details', $slug);
    }

    public static function redirectAuthenticatedVisitor(string $slug): ?RedirectResponse
    {
        if (! auth()->check()) {
            return null;
        }

        $exhibition = Exhibition::query()->where('slug', $slug)->first();
        if (! $exhibition) {
            return null;
        }

        $bookingId = UserVisitorPasses::normalizeBookingId(
            request()->query('booking_id') ?: session('selected_visitor_booking_id')
        );

        if ($bookingId) {
            $hasCompletedPass = Visitor::query()
                ->where('booking_id', $bookingId)
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'completed')
                ->exists();

            if ($hasCompletedPass) {
                return redirect()->route('frontend.user.dashboard', array_filter([
                    'slug' => $slug,
                    'booking_id' => $bookingId,
                ]));
            }
        }

        self::ensureAuthenticatedRegistration($slug, $exhibition);

        return redirect()->route('exhibitions.tickets.pass-details', $slug);
    }

    public static function ensureAuthenticatedRegistration(string $slug, ?Exhibition $exhibition = null): void
    {
        if (! auth()->check()) {
            return;
        }

        $user = auth()->user();
        $exhibition ??= Exhibition::query()->where('slug', $slug)->first();

        session([
            self::sessionRegistrationKey($slug) => true,
            'activeExhibitionSlug' => $slug,
            'exhibition_booking_path' => self::passSelectionUrl($slug),
            'user_flow_context' => 'exhibition_ticket',
        ]);

        self::storeVisitorRegistration(
            (int) $user->id,
            $slug,
            $exhibition?->id,
            [
                'name' => (string) ($user->name ?? ''),
                'email' => (string) ($user->email ?? ''),
                'phone' => $user->phone,
                'gender' => $user->gender,
                'city' => $user->city,
            ]
        );
    }

    public static function storeVisitorRegistration(
        int $userId,
        string $exhibitionSlug,
        ?int $exhibitionId,
        array $details
    ): void {
        if (! DbGuard::hasTable('exhibition_ticket_visitor_registrations')) {
            return;
        }

        ExhibitionTicketVisitorRegistration::query()->updateOrCreate(
            [
                'user_id' => $userId,
                'exhibition_slug' => $exhibitionSlug,
            ],
            [
                'exhibition_id' => $exhibitionId,
                'name' => $details['name'] ?? '',
                'email' => $details['email'] ?? '',
                'phone' => $details['phone'] ?? null,
                'gender' => $details['gender'] ?? null,
                'city' => $details['city'] ?? null,
            ]
        );
    }

    /** @return array{name: string, email: string, phone: string, gender: string, city: string}|null */
    public static function resolveVisitorPrefill(?string $slug): ?array
    {
        if (! filled($slug) || ! auth()->check()) {
            return null;
        }

        $user = auth()->user();

        if (DbGuard::hasTable('exhibition_ticket_visitor_registrations')) {
            $registration = ExhibitionTicketVisitorRegistration::query()
                ->where('user_id', $user->id)
                ->where('exhibition_slug', $slug)
                ->first();

            if ($registration) {
                return $registration->toVisitorPrefill();
            }
        }

        if (! $user->name && ! $user->email) {
            return null;
        }

        return [
            'name' => (string) ($user->name ?? ''),
            'email' => (string) ($user->email ?? ''),
            'phone' => (string) ($user->phone ?? ''),
            'gender' => (string) ($user->gender ?? ''),
            'city' => (string) ($user->city ?? ''),
        ];
    }

    public static function passSelectionUrl(string $slug): string
    {
        return route('exhibitions.tickets.pass-details', $slug);
    }

    public static function sessionRegistrationKey(?string $slug): string
    {
        return 'exhibition_visitor_registered_' . ($slug ?: 'unknown');
    }

    public static function hasVisitorRegistration(?string $slug): bool
    {
        if (! filled($slug)) {
            return false;
        }

        if (auth()->check()) {
            return true;
        }

        return (bool) session(self::sessionRegistrationKey($slug), false);
    }

    /**
     * Visitor dashboard sidebar should only appear after a completed pass exists.
     */
    public static function shouldShowVisitorSidebar(?string $slug): bool
    {
        if (! filled($slug)) {
            return false;
        }

        $exhibition = Exhibition::query()->where('slug', $slug)->first();
        if (! $exhibition) {
            return false;
        }

        $bookingId = UserVisitorPasses::normalizeBookingId(request()->query('booking_id') ?: session('selected_visitor_booking_id'));

        if ($bookingId) {
            $hasCompletedBooking = Visitor::query()
                ->where('booking_id', $bookingId)
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'completed')
                ->exists();

            if ($hasCompletedBooking) {
                session([
                    'visitor_pass_active' => true,
                    'selected_visitor_booking_id' => $bookingId,
                ]);

                return true;
            }
        }

        if (auth()->check()) {
            $visitor = UserVisitorPasses::queryForUser(auth()->user())
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'completed')
                ->first();

            if ($visitor) {
                session([
                    'visitor_pass_active' => true,
                    'selected_visitor_booking_id' => $visitor->booking_id,
                ]);

                return true;
            }
        }

        if (session('visitor_pass_active', false) && session('activeExhibitionSlug') === $slug) {
            return UserVisitorPasses::queryForUser(auth()->user())
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'completed')
                ->when(
                    session('selected_visitor_booking_id'),
                    fn ($query, $selectedBookingId) => $query->where(
                        'booking_id',
                        UserVisitorPasses::normalizeBookingId($selectedBookingId) ?? $selectedBookingId
                    )
                )
                ->exists();
        }

        return false;
    }
}
