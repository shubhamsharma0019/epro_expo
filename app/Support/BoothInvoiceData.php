<?php

namespace App\Support;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BoothInvoiceData
{
    public static function fromBooking(BoothBooking $booking, Collection $bookingDays, Collection $bookingServices): array
    {
        $booking->loadMissing(['company', 'exhibition', 'pavilion', 'hall', 'booth', 'boothSize']);

        $company = $booking->company;
        $exhibition = $booking->exhibition;
        $startDate = $exhibition?->start_date ? Carbon::parse($exhibition->start_date)->format('M d, Y') : null;
        $endDate = $exhibition?->end_date ? Carbon::parse($exhibition->end_date)->format('M d, Y') : null;
        $daysCount = $bookingDays->count();
        $gstRate = (float) config('invoice.gst_rate', 0);
        $spaceSubtotal = (float) $booking->amount;
        $servicesSubtotal = (float) $booking->services_amount;
        $taxableAmount = $spaceSubtotal + $servicesSubtotal;
        $gstAmount = round($taxableAmount * ($gstRate / 100), 2);
        $totalPaid = (float) $booking->total_amount;
        $paymentStatus = (string) ($booking->payment_status ?: 'pending');

        return [
            'reference' => 'EXPO-' . optional($booking->created_at)->format('Y') . '-' . str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT),
            'issued_at' => optional($booking->paid_at ?? $booking->updated_at)->format('F d, Y') ?: 'N/A',
            'payment_id' => $booking->razorpay_payment_id ?: $booking->razorpay_order_id,
            'payment_method' => $booking->razorpay_payment_id ? 'Razorpay' : ($paymentStatus === 'paid' ? 'Manual / Offline' : 'N/A'),
            'payment_status' => $paymentStatus,
            'payment_status_label' => ucfirst(str_replace('_', ' ', $paymentStatus)),
            'payment_status_tone' => match ($paymentStatus) {
                'paid' => 'green',
                'pending' => 'amber',
                'failed', 'refunded' => 'rose',
                default => 'slate',
            },
            'billed_to' => [
                'company_name' => $company?->company_name ?: $company?->name ?: 'Exhibitor Company',
                'contact_name' => $company?->contact_person_name ?: $company?->owner_name ?: 'Contact Person',
                'email' => $company?->email,
                'phone' => $company?->phone,
                'address' => collect([
                    $company?->address,
                    collect([$company?->city, $company?->country])->filter()->implode(', '),
                ])->filter()->implode(', ') ?: null,
            ],
            'billed_by' => self::issuerDetails(),
            'support_email' => config('invoice.support_email'),
            'brand_name' => config('app.name', 'eproexpo'),
            'exhibition' => [
                'title' => $exhibition?->title ?: $exhibition?->name ?: 'Exhibition',
                'date_range' => $startDate && $endDate
                    ? $startDate . ' - ' . $endDate . ($daysCount ? ' (' . $daysCount . ' Days)' : '')
                    : 'Dates not available',
                'hall' => $booking->hall?->title ?: 'N/A',
                'pavilion' => $booking->pavilion?->title ?: 'N/A',
                'booth_label' => self::boothLabel($booking),
                'booth_size' => $booking->boothSize?->title ?: 'N/A',
                'venue' => $exhibition?->venue ?: $exhibition?->location ?: $booking->hall?->title ?: 'Venue TBD',
                'location' => $exhibition?->location,
            ],
            'currency_symbol' => config('invoice.currency_symbol', '₹'),
            'line_items' => self::lineItems($booking, $bookingDays, $bookingServices),
            'totals' => [
                'space_subtotal' => $spaceSubtotal,
                'services_subtotal' => $servicesSubtotal,
                'gst_rate' => $gstRate,
                'gst_amount' => $gstAmount,
                'total_paid' => $totalPaid,
            ],
        ];
    }

    /** @return array<string, ?string> */
    private static function issuerDetails(): array
    {
        $defaults = config('invoice.issuer', []);
        $settings = self::platformSettings([
            'invoice_issuer_name' => 'name',
            'invoice_issuer_address_1' => 'address_line_1',
            'invoice_issuer_address_2' => 'address_line_2',
            'invoice_issuer_email' => 'email',
            'invoice_support_email' => 'support_email',
            'invoice_issuer_gst' => 'gst_number',
        ]);

        return [
            'name' => $settings['name'] ?? $defaults['name'] ?? 'EproExpo',
            'address_line_1' => $settings['address_line_1'] ?? $defaults['address_line_1'] ?? null,
            'address_line_2' => $settings['address_line_2'] ?? $defaults['address_line_2'] ?? null,
            'email' => $settings['email'] ?? $defaults['email'] ?? null,
            'gst_number' => $settings['gst_number'] ?? $defaults['gst_number'] ?? null,
        ];
    }

    /** @param  array<string, string>  $map */
    private static function platformSettings(array $map): array
    {
        if (! Schema::hasTable('admin_system_settings')) {
            return [];
        }

        $rows = DB::table('admin_system_settings')
            ->whereIn('key', array_keys($map))
            ->pluck('value', 'key');

        $resolved = [];
        foreach ($map as $dbKey => $field) {
            if (filled($rows[$dbKey] ?? null)) {
                $resolved[$field] = $rows[$dbKey];
            }
        }

        return $resolved;
    }

    private static function boothLabel(BoothBooking $booking): string
    {
        $boothIds = collect($booking->selected_booth_ids ?? [])
            ->filter()
            ->when($booking->booth_id, fn (Collection $ids) => $ids->push($booking->booth_id))
            ->unique()
            ->values();

        $numbers = $boothIds->isNotEmpty()
            ? Booth::query()->whereIn('id', $boothIds)->orderBy('booth_number')->pluck('booth_number')
            : collect([optional($booking->booth)->booth_number])->filter();

        if ($numbers->isEmpty()) {
            return 'N/A';
        }

        if ($numbers->count() === 1) {
            return 'Booth ' . $numbers->first();
        }

        return 'Booth ' . $numbers->first() . '–' . $numbers->last();
    }

    /** @return list<array{description: string, subtitle: ?string, quantity: string, unit_price: float, total: float, unit_price_label: string, total_label: string}> */
    private static function lineItems(BoothBooking $booking, Collection $bookingDays, Collection $bookingServices): array
    {
        $items = [];
        $symbol = config('invoice.currency_symbol', '₹');
        $format = fn (float $amount) => $symbol . number_format($amount, 2);
        $boothSizeTitle = $booking->boothSize?->title ?: 'selected size';
        $boothBasePrice = (float) ($booking->boothSize?->price ?? $booking->amount);

        $items[] = [
            'description' => 'Booth Rental Fee',
            'subtitle' => 'Base cost for booth size ' . $boothSizeTitle,
            'quantity' => '1',
            'unit_price' => $boothBasePrice,
            'total' => $boothBasePrice,
            'unit_price_label' => $format($boothBasePrice),
            'total_label' => $format($boothBasePrice),
        ];

        foreach ($bookingDays as $day) {
            $price = (float) $day->price;
            $items[] = [
                'description' => 'Daily Show Slot - ' . $day->booking_date->format('M d, Y'),
                'subtitle' => $day->label ?: 'Show duration access slot',
                'quantity' => '1 Day',
                'unit_price' => $price,
                'total' => $price,
                'unit_price_label' => $format($price),
                'total_label' => $format($price),
            ];
        }

        foreach ($bookingServices as $service) {
            $unit = (float) $service->pivot->price;
            $total = (float) $service->pivot->total;
            $items[] = [
                'description' => $service->title ?: 'Additional Service',
                'subtitle' => $service->description ?: 'Additional custom booth service',
                'quantity' => (string) ($service->pivot->quantity ?? 1),
                'unit_price' => $unit,
                'total' => $total,
                'unit_price_label' => $format($unit),
                'total_label' => $format($total),
            ];
        }

        return $items;
    }
}
