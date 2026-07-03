<?php

namespace App\Domain\Shared\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Shared\Services\EventsHomePageData;
use App\Domain\Shared\Services\HomePageData;
use Illuminate\View\View;

class HomePageController extends Controller
{
    public function __invoke(HomePageData $homePageData, EventsHomePageData $eventsHomePageData): View
    {
        $eventsPayload = $eventsHomePageData->build();

        return view('frontend.home', [
            'home' => $homePageData->build(),
            'events' => $eventsPayload['events'],
            'categories' => $eventsPayload['categories'],
            'countries' => $eventsPayload['countries'],
            'heroSlides' => $eventsPayload['hero_slides'],
            'heroMeta' => $eventsPayload['hero_meta'],
            'slots' => $eventsPayload['slots'],
        ]);
    }
}
