<?php

namespace App\Domain\Event\Controllers;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use Illuminate\View\View;

class PreviewController extends BaseCompanyEventController
{
    public function show(?CompanyEvent $companyEvent = null): View
    {
        $companyEvent = $this->setupEvent($companyEvent);

        return view('backend.company.event-company-flow.preview', $this->commonData($companyEvent));
    }
}
