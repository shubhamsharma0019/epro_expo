<?php

namespace App\Support;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Event\Models\Exhibition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class LegacyVisitorExhibitionRedirect
{
    public static function dashboard(?string $slug = null): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('frontend.user.dashboard', array_filter([
                'slug' => $slug,
                'booking_id' => request()->query('booking_id'),
            ]));
        }

        if ($slug) {
            return redirect()->route('exhibitions.show', $slug);
        }

        return redirect()->route('exhibitions.index');
    }

    public static function halls(string $slug): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('frontend.user.exhibitions.halls', $slug);
        }

        return redirect()->route('exhibitions.show', $slug);
    }

    public static function browse(): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('frontend.user.browse');
        }

        return redirect()->route('exhibitions.index');
    }

    public static function passes(): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('frontend.user.passes');
        }

        return redirect()->route('frontend.user.login');
    }

    public static function meetings(): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('frontend.user.meetings');
        }

        return redirect()->route('frontend.user.login');
    }

    public static function boothShow(string $slug, string $companySlug): RedirectResponse
    {
        $boothUrl = self::boothShowUrl($slug, $companySlug);

        if ($boothUrl) {
            return redirect()->to($boothUrl);
        }

        return self::halls($slug);
    }

    public static function boothShowUrl(string $slug, string $companySlug): ?string
    {
        if (! auth()->check()) {
            return null;
        }

        $exhibition = Exhibition::query()->where('slug', $slug)->first();

        if (! $exhibition) {
            return null;
        }

        $booking = BoothBooking::query()
            ->with(['hall', 'booth', 'boothProfile', 'company'])
            ->where('exhibition_id', $exhibition->id)
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->get()
            ->first(fn (BoothBooking $item) => self::companySlug($item) === $companySlug);

        if (! $booking?->hall || ! $booking->booth) {
            return null;
        }

        $hallSlug = $booking->hall->slug ?: Str::slug($booking->hall->title ?: $booking->hall->name ?: 'hall');

        return route('frontend.user.exhibitions.booths.show', [
            'slug' => $slug,
            'hallSlug' => $hallSlug,
            'boothId' => $booking->booth->id,
        ]);
    }

    private static function companySlug(BoothBooking $booking): string
    {
        $company = $booking->boothProfile?->company_name
            ?: $booking->company?->company_name
            ?: $booking->company?->name;

        return Str::slug((string) $company);
    }
}
