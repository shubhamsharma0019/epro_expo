<?php

namespace App\Domain\Company\Controllers;

use App\Http\Controllers\Controller;
use App\Support\LiveContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyExhibitionController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $exhibitions = LiveContent::exhibitionQuery()
            ->with(['boothBookings' => function ($query) use ($companyId) {
                $query->where('company_id', $companyId)->where('payment_status', 'paid');
            }])
            ->latest()
            ->get();

        $exhibitions->each(function ($exhibition) {
            $userBooking = $exhibition->boothBookings->first();
            if ($userBooking) {
                if ($userBooking->admin_status === 'approved') {
                    $exhibition->user_booking_status = 'booked';
                } elseif ($userBooking->admin_status === 'pending') {
                    $exhibition->user_booking_status = 'pending';
                } else {
                    $exhibition->user_booking_status = 'available';
                }
                $exhibition->user_booking = $userBooking;
            } else {
                $exhibition->user_booking_status = 'available';
                $exhibition->user_booking = null;
            }
        });

        return view('backend.company.exhibitions.index', compact('exhibitions'));
    }

    public function show(string $slug): View|RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $exhibition = LiveContent::exhibitionQuery()
            ->where('slug', $slug)
            ->with(['pavilions', 'boothBookings' => function ($query) use ($companyId) {
                $query->where('company_id', $companyId)->where('payment_status', 'paid');
            }])
            ->firstOrFail();

        $userBooking = $exhibition->boothBookings->first();
        if ($userBooking) {
            if ($userBooking->admin_status === 'approved') {
                $exhibition->user_booking_status = 'booked';
            } elseif ($userBooking->admin_status === 'pending') {
                $exhibition->user_booking_status = 'pending';
            } else {
                $exhibition->user_booking_status = 'available';
            }
        } else {
            $exhibition->user_booking_status = 'available';
        }

        return view('backend.company.exhibitions.show', compact('exhibition', 'userBooking'));
    }
}
