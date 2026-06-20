<?php

namespace App\Domain\Company\Models;

use App\Domain\Booth\Models\BoothBooking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'icon',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public static function defaultCatalog(): array
    {
        return [
            [
                'title' => 'Featured Listing',
                'description' => 'Highlight your company at the top of exhibitor lists for better visitor visibility.',
                'price' => 99,
                'icon' => 'fa-regular fa-star',
            ],
            [
                'title' => 'Sponsored Home Placement',
                'description' => 'Show your booth promotion on high-visibility home and discovery sections.',
                'price' => 399,
                'icon' => 'fa-solid fa-bullhorn',
            ],
            [
                'title' => 'Email Campaign',
                'description' => 'Promote your booth to registered visitors through a targeted email campaign.',
                'price' => 149,
                'icon' => 'fa-regular fa-envelope',
            ],
            [
                'title' => 'Push Notification',
                'description' => 'Send a booth announcement to active exhibition visitors.',
                'price' => 99,
                'icon' => 'fa-regular fa-bell',
            ],
            [
                'title' => 'Product Demo Slot',
                'description' => 'Reserve a promoted product demo slot during exhibition hours.',
                'price' => 249,
                'icon' => 'fa-regular fa-circle-play',
            ],
            [
                'title' => 'Dedicated Meeting Room',
                'description' => 'Reserve a private meeting room for buyer conversations.',
                'price' => 199,
                'icon' => 'fa-solid fa-users',
            ],
            [
                'title' => 'Lead Scan Devices',
                'description' => 'Capture visitor leads quickly at your booth.',
                'price' => 149,
                'icon' => 'fa-solid fa-qrcode',
            ],
            [
                'title' => 'Visitor Analytics Report',
                'description' => 'Get a post-event report with booth visits, leads, and engagement insights.',
                'price' => 149,
                'icon' => 'fa-solid fa-chart-line',
            ],
            [
                'title' => 'Extra Booth Staff',
                'description' => 'Add trained booth support staff for visitor handling and assistance.',
                'price' => 129,
                'icon' => 'fa-solid fa-user-plus',
            ],
            [
                'title' => 'Extra Staff Badge',
                'description' => 'Add an additional exhibitor staff access badge.',
                'price' => 59,
                'icon' => 'fa-regular fa-id-badge',
            ],
            [
                'title' => 'Extra Power Supply',
                'description' => 'Add extra power support for demos, screens, and devices.',
                'price' => 79,
                'icon' => 'fa-solid fa-plug',
            ],
            [
                'title' => 'Video Wall / Screen',
                'description' => 'Add display support for brand videos, product demos, and presentations.',
                'price' => 299,
                'icon' => 'fa-solid fa-tv',
            ],
            [
                'title' => 'Booth Cleaning (Daily)',
                'description' => 'Daily cleaning support for your booth area.',
                'price' => 49,
                'icon' => 'fa-solid fa-broom',
            ],
            [
                'title' => 'Banner Design Support',
                'description' => 'Get support for preparing booth banners and event-ready promotional artwork.',
                'price' => 99,
                'icon' => 'fa-regular fa-image',
            ],
            [
                'title' => 'Brochure Upload Boost',
                'description' => 'Promote your brochure to visitor dashboards and downloads.',
                'price' => 59,
                'icon' => 'fa-regular fa-file-lines',
            ],
            [
                'title' => 'Priority Support',
                'description' => 'Get priority help from the event operations team during setup and event days.',
                'price' => 99,
                'icon' => 'fa-regular fa-life-ring',
            ],
        ];
    }

    public static function syncDefaultCatalog(): void
    {
        self::mergeLegacyServiceTitle('Lead Scan Device', 'Lead Scan Devices');

        foreach (self::defaultCatalog() as $service) {
            self::updateOrCreate(
                ['title' => $service['title']],
                $service + ['status' => 'active']
            );
        }
    }

    private static function mergeLegacyServiceTitle(string $legacyTitle, string $currentTitle): void
    {
        $legacy = self::where('title', $legacyTitle)->first();
        if (! $legacy) {
            return;
        }

        $current = self::where('title', $currentTitle)->first();
        if (! $current) {
            $legacy->update(['title' => $currentTitle]);

            return;
        }

        $legacyBookingServices = DB::table('booking_services')
            ->where('service_id', $legacy->id)
            ->get();

        foreach ($legacyBookingServices as $bookingService) {
            $currentBookingService = DB::table('booking_services')
                ->where('booth_booking_id', $bookingService->booth_booking_id)
                ->where('service_id', $current->id)
                ->first();

            if ($currentBookingService) {
                DB::table('booking_services')
                    ->where('id', $currentBookingService->id)
                    ->update([
                        'quantity' => max((int) $currentBookingService->quantity, (int) $bookingService->quantity),
                        'total' => max((float) $currentBookingService->total, (float) $bookingService->total),
                        'updated_at' => now(),
                    ]);

                DB::table('booking_services')->where('id', $bookingService->id)->delete();

                continue;
            }

            DB::table('booking_services')
                ->where('id', $bookingService->id)
                ->update([
                    'service_id' => $current->id,
                    'updated_at' => now(),
                ]);
        }

        $legacy->delete();
    }

    public function boothBookings(): BelongsToMany
    {
        return $this->belongsToMany(BoothBooking::class, 'booking_services')
            ->withPivot(['price', 'quantity', 'total'])
            ->withTimestamps();
    }
}
