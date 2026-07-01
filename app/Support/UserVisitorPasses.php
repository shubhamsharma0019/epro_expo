<?php

namespace App\Support;

use App\Domain\Shared\Models\User;
use App\Domain\Visitor\Models\Visitor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class UserVisitorPasses
{
    public static function normalizeBookingId(?string $bookingId): ?string
    {
        if (! filled($bookingId)) {
            return null;
        }

        return str_replace('_', '-', trim($bookingId));
    }

    /** @return list<string> */
    public static function linkedBookingIds(?string $bookingId = null): array
    {
        return collect([
            self::normalizeBookingId($bookingId),
            self::normalizeBookingId(session('selected_visitor_booking_id')),
            self::normalizeBookingId(request()->query('booking_id')),
        ])
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    public static function queryForUser(User $user, ?string $bookingId = null): Builder
    {
        $linkedBookingIds = self::linkedBookingIds($bookingId);

        return Visitor::query()->where(function (Builder $query) use ($user, $linkedBookingIds) {
            $query->whereRaw('LOWER(email) = ?', [strtolower($user->email)]);

            if (self::hasUserIdColumn()) {
                $query->orWhere('user_id', $user->id);
            }

            if ($linkedBookingIds !== []) {
                $query->orWhereIn('booking_id', $linkedBookingIds);
            }
        });
    }

    public static function forUser(User $user, ?string $bookingId = null): Collection
    {
        return self::queryForUser($user, $bookingId)
            ->with('exhibition')
            ->orderByDesc('created_at')
            ->get();
    }

    public static function linkPassesToUser(User $user, ?string $bookingId = null): void
    {
        $passes = self::queryForUser($user, $bookingId)->get();

        $relatedEmails = $passes->pluck('email')->filter()->map(fn (string $email) => strtolower($email))->unique();

        if ($relatedEmails->isNotEmpty()) {
            $relatedPasses = Visitor::query()
                ->where(function (Builder $query) use ($relatedEmails) {
                    foreach ($relatedEmails as $email) {
                        $query->orWhereRaw('LOWER(email) = ?', [$email]);
                    }
                })
                ->get();

            $passes = $passes->merge($relatedPasses)->unique('id')->values();
        }

        if (! self::hasUserIdColumn()) {
            return;
        }

        foreach ($passes as $pass) {
            if ((int) $pass->user_id !== (int) $user->id) {
                $pass->update(['user_id' => $user->id]);
            }
        }

        $completedPass = $passes->firstWhere('payment_status', 'completed') ?? $passes->first();

        if ($completedPass) {
            session([
                'selected_visitor_booking_id' => $completedPass->booking_id,
                'visitor_pass_active' => $completedPass->payment_status === 'completed',
            ]);
        }
    }

    public static function hasUserIdColumn(): bool
    {
        static $has = null;

        if ($has === null) {
            $has = Schema::hasColumn('visitors', 'user_id');
        }

        return $has;
    }
}
