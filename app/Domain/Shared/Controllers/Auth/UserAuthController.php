<?php

namespace App\Domain\Shared\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Domain\Shared\Models\User;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\Exhibition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserAuthController extends Controller
{
    public function showLogin(Request $request): View
    {
        $flowContext = $request->query('flow');

        if (filled($flowContext)) {
            $request->session()->put('user_flow_context', $flowContext);
        } else {
            $request->session()->forget('user_flow_context');
            $request->session()->forget('url.intended');
        }

        return view('frontend.auth.user-login', compact('flowContext'));
    }

    public function showEventTicketLogin(Request $request): View
    {
        $request->session()->put('user_flow_context', 'event_ticket');
        $eventSlug = $request->query('event') ?: $this->eventSlugFromSession($request);

        if ($eventSlug) {
            $request->session()->put('url.intended', url('/events/tickets/select?event=' . $eventSlug));
            $request->session()->put('event_booking_path', url('/events/tickets/select?event=' . $eventSlug));
        }

        return view('frontend.auth.user-login', [
            'flowContext' => 'event_ticket',
            'eventSlug' => $eventSlug,
            'contextCard' => $this->buildEventContextCard($eventSlug),
        ]);
    }

    public function showExhibitionTicketLogin(Request $request): View
    {
        $request->session()->put('user_flow_context', 'exhibition_ticket');
        $exhibitionSlug = $request->query('exhibition') ?: $request->session()->get('activeExhibitionSlug');

        if ($exhibitionSlug) {
            $request->session()->put('activeExhibitionSlug', $exhibitionSlug);
            $request->session()->put('url.intended', route('exhibitions.tickets.select', $exhibitionSlug));
            $request->session()->put('exhibition_booking_path', route('exhibitions.tickets.select', $exhibitionSlug));
        }

        return view('frontend.auth.user-login', [
            'flowContext' => 'exhibition_ticket',
            'exhibitionSlug' => $exhibitionSlug,
            'contextCard' => $this->buildExhibitionContextCard($exhibitionSlug),
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        if (! \App\Support\DbGuard::available()) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['email' => 'Database is unavailable. Start MySQL80, then try again.']);
        }

        if (in_array($request->input('flow_context'), ['event_ticket', 'exhibition_ticket'], true)) {
            $request->session()->put('user_flow_context', $request->input('flow_context'));
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            $activeSlug = session('activeExhibitionSlug') ?? 'global-tech-expo-2024';
            $exhibition = Exhibition::where('slug', $activeSlug)->first();
            
            $visitor = Visitor::where('email', $user->email)
                ->when($exhibition, fn($q) => $q->where('exhibition_id', $exhibition->id))
                ->first();

            if ($visitor) {
                session(['visitor_pass_active' => true]);
                session(['selected_visitor_booking_id' => $visitor->booking_id]);
            }

            if ($request->session()->get('user_flow_context') === 'event_ticket') {
                $request->session()->forget(['url.intended', 'user_flow_context']);

                return redirect('/events/profile');
            }

            if ($request->session()->get('user_flow_context') === 'exhibition_ticket') {
                $request->session()->forget(['url.intended', 'user_flow_context']);
                return redirect()->route('frontend.user.dashboard', ['slug' => $activeSlug]);
            }

            return $this->redirectAfterAuthentication($request, $exhibition);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister(Request $request): View
    {
        $flowContext = $request->query('flow');

        if (filled($flowContext)) {
            $request->session()->put('user_flow_context', $flowContext);
        } else {
            $request->session()->forget('user_flow_context');
            $request->session()->forget('url.intended');
        }

        return view('frontend.auth.user-register', compact('flowContext'));
    }

    public function showEventTicketRegister(Request $request): View
    {
        $request->session()->put('user_flow_context', 'event_ticket');
        $eventSlug = $request->query('event');

        if ($eventSlug) {
            $request->session()->put('url.intended', url('/events/tickets/select?event=' . $eventSlug));
            $request->session()->put('event_booking_path', url('/events/tickets/select?event=' . $eventSlug));
        }

        return view('frontend.auth.user-register', ['flowContext' => 'event_ticket', 'eventSlug' => $eventSlug]);
    }

    public function showExhibitionTicketRegister(Request $request): View
    {
        $request->session()->put('user_flow_context', 'exhibition_ticket');
        $exhibitionSlug = $request->query('exhibition');

        if ($exhibitionSlug) {
            $request->session()->put('activeExhibitionSlug', $exhibitionSlug);
            $request->session()->put('url.intended', route('exhibitions.tickets.select', $exhibitionSlug));
            $request->session()->put('exhibition_booking_path', route('exhibitions.tickets.select', $exhibitionSlug));
        }

        return view('frontend.auth.user-register', ['flowContext' => 'exhibition_ticket', 'exhibitionSlug' => $exhibitionSlug]);
    }

    public function register(Request $request): RedirectResponse
    {
        if (! \App\Support\DbGuard::available()) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['email' => 'Database is unavailable. Start MySQL80, then try again.']);
        }

        if (in_array($request->input('flow_context'), ['event_ticket', 'exhibition_ticket'], true)) {
            $request->session()->put('user_flow_context', $request->input('flow_context'));
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $flowContext = $request->session()->get('user_flow_context');

        if ($flowContext === 'exhibition_ticket') {
            $activeSlug = session('activeExhibitionSlug');
            $intended = $request->session()->get('url.intended')
                ?: ($request->session()->get('exhibition_booking_path')
                ?: ($activeSlug ? route('exhibitions.tickets.select', $activeSlug) : route('exhibitions.index')));
            $request->session()->forget(['url.intended', 'user_flow_context']);

            return redirect($intended);
        }

        if ($flowContext === 'event_ticket') {
            $intended = $request->session()->get('url.intended')
                ?: ($request->session()->get('event_booking_path') ?: url('/events/tickets/select'));
            $request->session()->forget(['url.intended', 'user_flow_context']);

            return redirect($intended);
        }

        $activeSlug = session('activeExhibitionSlug') ?? 'global-tech-expo-2024';
        $exhibition = Exhibition::where('slug', $activeSlug)->first();

        $visitor = Visitor::where('email', $user->email)
            ->when($exhibition, fn ($q) => $q->where('exhibition_id', $exhibition->id))
            ->first();

        if ($visitor) {
            session(['visitor_pass_active' => true]);
            session(['selected_visitor_booking_id' => $visitor->booking_id]);
        }

        return $this->redirectAfterAuthentication($request, $exhibition);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/user/login');
    }

    private function redirectAfterAuthentication(Request $request, ?Exhibition $exhibition): RedirectResponse
    {
        if ($request->session()->get('user_flow_context') === 'event_ticket') {
            $request->session()->forget(['url.intended', 'user_flow_context']);

            return redirect()->intended('/events/profile');
        }

        if ($exhibition && $request->session()->has('activeExhibitionSlug')) {
            $request->session()->forget(['url.intended', 'user_flow_context']);

            return redirect()->intended(route('frontend.user.dashboard', ['slug' => $exhibition->slug]));
        }

        $request->session()->forget(['url.intended', 'user_flow_context']);

        return redirect()->intended('/user/dashboard');
    }

    private function eventSlugFromSession(Request $request): ?string
    {
        $bookingPath = $request->session()->get('event_booking_path');

        if (! filled($bookingPath)) {
            return null;
        }

        parse_str(parse_url($bookingPath, PHP_URL_QUERY) ?? '', $params);

        return filled($params['event'] ?? null) ? $params['event'] : null;
    }

    private function buildEventContextCard(?string $eventSlug): array
    {
        $event = filled($eventSlug)
            ? CompanyEvent::query()->with('branding')->where('slug', $eventSlug)->first()
            : null;

        $dateLabel = $event?->starts_at
            ? $event->starts_at->format('M d') . ($event->ends_at ? ' - ' . $event->ends_at->format('M d, Y') : ', ' . $event->starts_at->format('Y'))
            : 'Date TBD';

        $location = collect([$event?->city, $event?->country])->filter()->join(', ') ?: 'Location TBD';

        return [
            'label' => 'Event Ticket Booking',
            'title' => $event?->title ?: 'Continue Your Event Booking',
            'meta' => $dateLabel . ' · ' . $location,
            'step' => 'Step 1 of 4',
            'progress' => 25,
            'icon' => 'fa-ticket',
        ];
    }

    private function buildExhibitionContextCard(?string $exhibitionSlug): array
    {
        $exhibition = filled($exhibitionSlug)
            ? Exhibition::query()->where('slug', $exhibitionSlug)->first()
            : null;

        return [
            'label' => 'Visitor Pass Booking',
            'title' => $exhibition?->title ?: 'Continue Your Visitor Pass',
            'meta' => $exhibition?->start_date
                ? $exhibition->start_date->format('M d, Y') . ($exhibition->end_date ? ' - ' . $exhibition->end_date->format('M d, Y') : '')
                : 'Exhibition schedule TBD',
            'step' => 'Step 1 of 4',
            'progress' => 25,
            'icon' => 'fa-id-card',
        ];
    }
}
