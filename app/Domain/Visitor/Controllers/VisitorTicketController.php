<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Shared\Models\User;
use App\Domain\Shared\Services\ExhibitionTicketVisitorDetailsPageData;
use App\Domain\Visitor\Models\Visitor;
use App\Http\Requests\Visitor\ExhibitionVisitorRegistrationRequest;
use App\Support\ExhibitionTicketFlow;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class VisitorTicketController extends Controller
{
    public function visitorRegistration(string $slug, ExhibitionTicketVisitorDetailsPageData $pageData): View
    {
        session([
            'activeExhibitionSlug' => $slug,
            'exhibition_booking_path' => ExhibitionTicketFlow::visitorPassEntryUrl($slug),
            'user_flow_context' => 'exhibition_ticket',
        ]);

        $data = $pageData->buildRegistration($slug);
        abort_unless($data, 404);

        return view('frontend.exhibitions.tickets.visitor-details', $data);
    }

    public function storeVisitorRegistration(ExhibitionVisitorRegistrationRequest $request): RedirectResponse
    {
        $slug = $request->input('slug');
        $data = app(ExhibitionTicketVisitorDetailsPageData::class)->buildRegistration($slug);
        abort_if($data === null, 404);

        $existingUser = User::query()->where('email', $request->input('email'))->first();

        if ($existingUser) {
            if (! Hash::check($request->input('password'), $existingUser->password)) {
                return back()
                    ->withInput($request->except('password'))
                    ->withErrors(['email' => 'An account with this email already exists. Please enter the correct password.']);
            }

            $existingUser->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'gender' => $request->input('gender'),
                'city' => $request->input('city'),
            ]);

            $user = $existingUser;
        } else {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'gender' => $request->input('gender'),
                'city' => $request->input('city'),
                'password' => $request->input('password'),
                'role' => 'user',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        session([
            ExhibitionTicketFlow::sessionRegistrationKey($slug) => true,
            'activeExhibitionSlug' => $slug,
            'exhibition_booking_path' => ExhibitionTicketFlow::passSelectionUrl($slug),
            'user_flow_context' => 'exhibition_ticket',
        ]);

        return redirect()->route('exhibitions.tickets.pass-details', $slug)
            ->with('success', 'Visitor details saved. Select your pass to continue.');
    }

    public function passDetails(string $slug, ExhibitionTicketVisitorDetailsPageData $pageData): View|RedirectResponse
    {
        if (! ExhibitionTicketFlow::hasVisitorRegistration($slug)) {
            return redirect()->route('exhibitions.tickets.visitor-details', $slug);
        }

        session([
            'activeExhibitionSlug' => $slug,
            'exhibition_booking_path' => ExhibitionTicketFlow::passSelectionUrl($slug),
            'user_flow_context' => 'exhibition_ticket',
        ]);

        $data = $pageData->build($slug);
        abort_unless($data, 404);

        return view('frontend.exhibitions.tickets.pass-details', $data);
    }

    public function register(Request $request, string $slug): JsonResponse
    {
        $exhibition = Exhibition::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'max:50'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'company_size' => ['nullable', 'string', 'max:255'],
            'business_address' => ['nullable', 'string', 'max:2000'],
            'pavilion_id' => ['nullable', 'string', 'max:255'],
            'pass_type' => ['nullable', 'string', 'max:255'],
            'amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $amount = (float) ($validated['amount'] ?? $request->input('amount', 0));

        $visitor = Visitor::create([
            'exhibition_id' => $exhibition->id,
            'pavilion_id' => $validated['pavilion_id'] ?? null,
            'booking_id' => 'EXP-' . now()->format('ymd') . '-' . random_int(100000, 999999),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'job_title' => $validated['job_title'] ?? null,
            'company' => $validated['company'] ?? null,
            'country' => $validated['country'],
            'state' => $validated['state'] ?? null,
            'city' => $validated['city'] ?? null,
            'industry' => $validated['industry'] ?? null,
            'company_size' => $validated['company_size'] ?? null,
            'business_address' => $validated['business_address'] ?? null,
            'pass_type' => $validated['pass_type'] ?? $request->input('pass_type', 'Free Visitor Pass'),
            'amount' => $amount,
            'payment_status' => $amount > 0 ? 'pending' : 'completed',
        ]);

        session([
            'selected_visitor_booking_id' => $visitor->booking_id,
            'visitor_pass_active' => $visitor->payment_status === 'completed',
        ]);
        session()->forget('exhibition_booking_path');

        return response()->json([
            'visitor' => $visitor,
            'message' => 'Visitor registered successfully.',
        ]);
    }

    public function confirmPayment(Request $request, string $slug, string $bookingId): JsonResponse
    {
        $exhibition = Exhibition::where('slug', $slug)->firstOrFail();

        $visitor = Visitor::query()
            ->where('exhibition_id', $exhibition->id)
            ->where('booking_id', $bookingId)
            ->firstOrFail();

        $visitor->update(['payment_status' => 'completed']);

        session([
            'selected_visitor_booking_id' => $visitor->booking_id,
            'visitor_pass_active' => true,
        ]);
        session()->forget('exhibition_booking_path');

        return response()->json([
            'visitor' => $visitor->fresh(),
            'message' => 'Payment confirmed successfully.',
        ]);
    }
}
