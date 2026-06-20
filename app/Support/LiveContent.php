<?php

namespace App\Support;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\Exhibition;
use Illuminate\Database\Eloquent\Builder;

class LiveContent
{
    public static function exhibitionQuery(): Builder
    {
        return Exhibition::query()->liveForVisitors();
    }

    public static function exhibitionPageQuery(): Builder
    {
        return Exhibition::query()
            ->where(function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->liveForVisitors();
                })->orWhereHas('boothBookings', function (Builder $query) {
                    $query->where('payment_status', 'paid')
                        ->whereIn('booking_status', ['confirmed', 'active'])
                        ->whereIn('admin_status', ['approved', 'pending']);
                });
            });
    }

    public static function companyEventQuery(): Builder
    {
        return CompanyEvent::query()->liveForVisitors();
    }

    public static function companyEventPageQuery(): Builder
    {
        return CompanyEvent::query()
            ->where(function (Builder $query) {
                $query->where('title', '!=', 'Untitled Company Event')
                    ->orWhereNotNull('starts_at')
                    ->orWhereNotNull('summary')
                    ->orWhereNotNull('category')
                    ->orWhereHas('branding')
                    ->orWhereHas('ticketTypes')
                    ->orWhereHas('sessions')
                    ->orWhereHas('speakers')
                    ->orWhereIn('status', ['submitted', 'pending_review', 'approved', 'published']);
            });
    }

    public static function boothBookingQuery(): Builder
    {
        return BoothBooking::query()->publiclyVisible();
    }

    /** @return list<int> */
    public static function liveExhibitionIds(): array
    {
        return static::exhibitionQuery()->pluck('id')->all();
    }
}
