<?php

namespace App\Domain\Company\Controllers;

use App\Http\Controllers\Controller;
use App\Support\LiveContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyExhibitionController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $search = trim((string) $request->query('search', ''));

        $exhibitions = LiveContent::databaseExhibitionsQuery()
            ->with([
                'pavilions',
                'boothBookings' => function ($query) use ($companyId) {
                    $query->where('company_id', $companyId)->where('payment_status', 'paid');
                },
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('venue', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhereHas('pavilions', function ($query) use ($search) {
                            $query->where('title', 'like', "%{$search}%")
                                ->orWhere('description', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->get()
            ->unique(fn ($exhibition) => strtolower(trim($exhibition->title ?: $exhibition->slug)))
            ->values();

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

        return view('company.exhibitions.exhibition-list', compact('exhibitions', 'search'));
    }

    public function show(string $slug): View|RedirectResponse
    {
        $companyId = session('company_id');
        if (! $companyId) {
            return redirect('/company/login');
        }

        $exhibition = LiveContent::databaseExhibitionsQuery()
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

        return view('company.exhibitions.exhibition-details', compact('exhibition', 'userBooking'));
    }
}
