<?php

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothMedia;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $defaultBanner = 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=1200&q=80';
        $defaultVideo = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';

        BoothBooking::query()
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereDoesntHave('boothMedia')
            ->with('exhibition')
            ->orderBy('id')
            ->get()
            ->each(function (BoothBooking $booking) use ($defaultBanner, $defaultVideo) {
                $banner = $booking->exhibition?->banner_url
                    ?: $booking->exhibition?->banner_image
                    ?: $defaultBanner;

                $now = now();

                BoothMedia::create([
                    'company_id' => $booking->company_id,
                    'booth_booking_id' => $booking->id,
                    'title' => ($booking->exhibition?->title ?: 'Booth') . ' Banner',
                    'type' => 'image',
                    'file_path' => '',
                    'video_url' => $banner,
                    'description' => 'seed:booth-media-banner',
                    'sort_order' => 1,
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                BoothMedia::create([
                    'company_id' => $booking->company_id,
                    'booth_booking_id' => $booking->id,
                    'title' => 'Product Walkthrough Video',
                    'type' => 'video',
                    'file_path' => '',
                    'video_url' => $defaultVideo,
                    'description' => 'seed:booth-media-video',
                    'sort_order' => 2,
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            });

        $documentTemplate = BoothMedia::query()
            ->where('type', 'document')
            ->whereNotNull('file_path')
            ->where('file_path', '!=', '')
            ->latest('id')
            ->first();

        if (! $documentTemplate) {
            return;
        }

        BoothBooking::query()
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->with('boothMedia')
            ->orderBy('id')
            ->get()
            ->each(function (BoothBooking $booking) use ($documentTemplate) {
                $hasDocument = $booking->boothMedia->contains(
                    fn (BoothMedia $media) => $media->resolvedType() === 'document'
                );

                if ($hasDocument) {
                    return;
                }

                BoothMedia::create([
                    'company_id' => $booking->company_id,
                    'booth_booking_id' => $booking->id,
                    'title' => 'Booth Information Sheet',
                    'type' => 'document',
                    'file_path' => $documentTemplate->file_path,
                    'video_url' => null,
                    'description' => 'seed:booth-media-document',
                    'file_size' => $documentTemplate->file_size,
                    'sort_order' => 3,
                    'status' => 'active',
                ]);
            });
    }

    public function down(): void
    {
        BoothMedia::query()
            ->whereIn('description', [
                'seed:booth-media-banner',
                'seed:booth-media-video',
                'seed:booth-media-document',
            ])
            ->delete();
    }
};
