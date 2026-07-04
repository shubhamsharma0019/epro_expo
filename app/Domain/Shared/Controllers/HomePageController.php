<?php

namespace App\Domain\Shared\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Shared\Services\HomePageData;
use Illuminate\View\View;

class HomePageController extends Controller
{
    public function __invoke(HomePageData $homePageData): View
    {
        return view('frontend.home', [
            'home' => $homePageData->build(),
        ]);
    }
}
