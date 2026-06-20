<?php

namespace App\Providers;

use App\Domain\Admin\Services\TopbarData;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $aliases = [
            'App\Models\CompanyEvent\CompanyEventPublishRequest' => 'App\Domain\Event\Models\CompanyEvent\CompanyEventPublishRequest',
            'App\Models\CompanyEvent\CompanyEventTicketType' => 'App\Domain\Event\Models\CompanyEvent\CompanyEventTicketType',
            'App\Models\CompanyEvent\CompanyEventBranding' => 'App\Domain\Event\Models\CompanyEvent\CompanyEventBranding',
            'App\Models\CompanyEvent\CompanyEventSession' => 'App\Domain\Event\Models\CompanyEvent\CompanyEventSession',
            'App\Models\CompanyEvent\CompanyEventSpeaker' => 'App\Domain\Event\Models\CompanyEvent\CompanyEventSpeaker',
            'App\Models\VisitorSessionRegistration' => 'App\Domain\Visitor\Models\VisitorSessionRegistration',
            'App\Models\CompanyEvent\CompanyEvent' => 'App\Domain\Event\Models\CompanyEvent\CompanyEvent',
            'App\Models\BoothMeetingAvailability' => 'App\Domain\Booth\Models\BoothMeetingAvailability',
            'App\Models\VisitorMeetingBooking' => 'App\Domain\Visitor\Models\VisitorMeetingBooking',
            'App\Models\BoothBookingSummary' => 'App\Domain\Booth\Models\BoothBookingSummary',
            'App\Models\BoothPublishRequest' => 'App\Domain\Booth\Models\BoothPublishRequest',
            'App\Models\VisitorBoothMessage' => 'App\Domain\Visitor\Models\VisitorBoothMessage',
            'App\Models\BoothMeetingSlot' => 'App\Domain\Booth\Models\BoothMeetingSlot',
            'App\Models\BoothBookingDay' => 'App\Domain\Booth\Models\BoothBookingDay',
            'App\Models\BoothTeamMember' => 'App\Domain\Booth\Models\BoothTeamMember',
            'App\Models\CompanyDocument' => 'App\Domain\Company\Models\CompanyDocument',
            'App\Models\VisitorPavilion' => 'App\Domain\Visitor\Models\VisitorPavilion',
            'App\Models\BoothAnalytics' => 'App\Domain\Booth\Models\BoothAnalytics',
            'App\Models\BoothCatalogue' => 'App\Domain\Booth\Models\BoothCatalogue',
            'App\Models\BoothSetupStep' => 'App\Domain\Booth\Models\BoothSetupStep',
            'App\Models\CompanyMeeting' => 'App\Domain\Company\Models\CompanyMeeting',
            'App\Models\VisitorProduct' => 'App\Domain\Visitor\Models\VisitorProduct',
            'App\Models\BoothBranding' => 'App\Domain\Booth\Models\BoothBranding',
            'App\Models\BoothDocument' => 'App\Domain\Booth\Models\BoothDocument',
            'App\Models\VisitorTicket' => 'App\Domain\Visitor\Models\VisitorTicket',
            'App\Models\AgendaSession' => 'App\Domain\Event\Models\AgendaSession',
            'App\Models\BoothBooking' => 'App\Domain\Booth\Models\BoothBooking',
            'App\Models\BoothProduct' => 'App\Domain\Booth\Models\BoothProduct',
            'App\Models\BoothProfile' => 'App\Domain\Booth\Models\BoothProfile',
            'App\Domain\CompanyEvent\CompanyEvent' => 'App\Domain\Event\Models\CompanyEvent\CompanyEvent',
            'App\Models\BoothSession' => 'App\Domain\Booth\Models\BoothSession',
            'App\Models\BusinessCard' => 'App\Domain\Visitor\Models\BusinessCard',
            'App\Models\MediaGallery' => 'App\Domain\Event\Models\MediaGallery',
            'App\Models\Announcement' => 'App\Domain\Event\Models\Announcement',
            'App\Models\VisitorHall' => 'App\Domain\Visitor\Models\VisitorHall',
            'App\Models\BoothMedia' => 'App\Domain\Booth\Models\BoothMedia',
            'App\Models\Exhibition' => 'App\Domain\Event\Models\Exhibition',
            'App\Models\TicketTier' => 'App\Domain\Event\Models\TicketTier',
            'App\Models\BoothSize' => 'App\Domain\Booth\Models\BoothSize',
            'App\Models\BoothView' => 'App\Domain\Booth\Models\BoothView',
            'App\Models\Catalogue' => 'App\Domain\Company\Models\Catalogue',
            'App\Models\DemoVideo' => 'App\Domain\Company\Models\DemoVideo',
            'App\Models\Exhibitor' => 'App\Domain\Company\Models\Exhibitor',
            'App\Models\Bookmark' => 'App\Domain\Visitor\Models\Bookmark',
            'App\Models\Pavilion' => 'App\Domain\Event\Models\Pavilion',
            'App\Models\Company' => 'App\Domain\Company\Models\Company',
            'App\Models\Enquiry' => 'App\Domain\Company\Models\Enquiry',
            'App\Models\Product' => 'App\Domain\Company\Models\Product',
            'App\Models\Service' => 'App\Domain\Company\Models\Service',
            'App\Models\Visitor' => 'App\Domain\Visitor\Models\Visitor',
            'App\Models\Sponsor' => 'App\Domain\Event\Models\Sponsor',
            'App\Models\Speaker' => 'App\Domain\Event\Models\Speaker',
            'App\Models\Admin' => 'App\Domain\Admin\Models\Admin',
            'App\Models\Booth' => 'App\Domain\Booth\Models\Booth',
            'App\Models\Hall' => 'App\Domain\Event\Models\Hall',
            'App\Models\User' => 'App\Domain\Shared\Models\User',
            'App\Models\Faq' => 'App\Domain\Event\Models\Faq',
            'App\Models\BookingService' => 'App\Domain\Booth\Models\BookingService',
            'App\Models\Meeting' => 'App\Domain\Visitor\Models\Meeting',
        ];

        foreach ($aliases as $old => $new) {
            if (!class_exists($old, false)) {
                class_alias($new, $old);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.admin.admin-topbar', function ($view) {
            $view->with('adminTopbar', app(TopbarData::class)->data());
        });
    }
}
