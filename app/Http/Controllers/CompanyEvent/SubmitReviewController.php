<?php

namespace App\Http\Controllers\CompanyEvent;

use App\Http\Requests\CompanyEvent\CompanyEventSubmitReviewRequest;
use App\Models\CompanyEvent\CompanyEvent;
use App\Models\CompanyEvent\CompanyEventPublishRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubmitReviewController extends BaseCompanyEventController
{
    public function show(?CompanyEvent $companyEvent = null): View
    {
        $companyEvent = $this->setupEvent($companyEvent);

        return view('company.event-company-flow.submit-review', $this->commonData($companyEvent));
    }

    public function submit(CompanyEventSubmitReviewRequest $request, ?CompanyEvent $companyEvent = null): RedirectResponse
    {
        $companyEvent = $this->setupEvent($companyEvent);

        CompanyEventPublishRequest::create([
            'company_event_id' => $companyEvent->id,
            'company_id' => $this->companyId(),
            'status' => 'pending',
            'company_notes' => $request->validated()['company_notes'] ?? null,
            'submitted_at' => now(),
        ]);

        $companyEvent->update([
            'status' => 'pending_review',
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('company.event-company-flow.dashboard')
            ->with('status', 'Company event submitted for admin review. It will go live after approval.');
    }
}
