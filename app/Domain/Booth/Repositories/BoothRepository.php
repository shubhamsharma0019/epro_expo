<?php

namespace App\Domain\Booth\Repositories;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothProfile;
use App\Domain\Booth\Models\BoothProduct;
use App\Domain\Booth\Models\BoothMedia;
use App\Domain\Booth\Models\BoothTeamMember;
use App\Domain\Booth\Models\BoothSetupStep;

class BoothRepository
{
    public function findBooking(int $id): ?BoothBooking
    {
        return BoothBooking::find($id);
    }

    public function findBookingForCompany(int $companyId, int $exhibitionId): ?BoothBooking
    {
        return BoothBooking::where('company_id', $companyId)
            ->where('exhibition_id', $exhibitionId)
            ->first();
    }

    public function getBookingWithDetails(int $id): ?BoothBooking
    {
        return BoothBooking::with(['company', 'exhibition', 'hall', 'booth', 'boothProfile'])
            ->find($id);
    }

    public function getProfileForBooking(int $bookingId): ?BoothProfile
    {
        return BoothProfile::where('booth_booking_id', $bookingId)->first();
    }

    public function getSetupSteps(int $bookingId)
    {
        return BoothSetupStep::where('booth_booking_id', $bookingId)
            ->orderBy('step_number')
            ->get();
    }

    public function getProducts(int $bookingId)
    {
        return BoothProduct::where('booth_booking_id', $bookingId)->get();
    }

    public function getMedia(int $bookingId)
    {
        return BoothMedia::where('booth_booking_id', $bookingId)->get();
    }

    public function getTeamMembers(int $bookingId)
    {
        return BoothTeamMember::where('booth_booking_id', $bookingId)->get();
    }
}
