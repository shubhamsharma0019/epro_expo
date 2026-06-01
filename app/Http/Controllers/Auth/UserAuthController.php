<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Visitor;
use App\Models\Exhibition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.user-login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $this->ensureVisitorPassesForUser($user);

            $activeSlug = session('activeExhibitionSlug') ?? 'global-tech-expo-2024';
            $exhibition = Exhibition::where('slug', $activeSlug)->first();
            
            $visitor = Visitor::where('email', $user->email)
                ->when($exhibition, fn($q) => $q->where('exhibition_id', $exhibition->id))
                ->first();

            if ($visitor) {
                session(['visitor_pass_active' => true]);
                session(['selected_visitor_booking_id' => $visitor->booking_id]);
            }

            return redirect()->intended('/user/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister(): View
    {
        return view('auth.user-register');
    }

    public function register(Request $request): RedirectResponse
    {
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
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $this->ensureVisitorPassesForUser($user);

        $activeSlug = session('activeExhibitionSlug') ?? 'global-tech-expo-2024';
        $exhibition = Exhibition::where('slug', $activeSlug)->first();
        
        $visitor = Visitor::where('email', $user->email)
            ->when($exhibition, fn($q) => $q->where('exhibition_id', $exhibition->id))
            ->first();

        if ($visitor) {
            session(['visitor_pass_active' => true]);
            session(['selected_visitor_booking_id' => $visitor->booking_id]);
        }

        return redirect('/user/dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/user/login');
    }

    private function ensureVisitorPassesForUser(User $user): void
    {
        $exhibitions = Exhibition::all();
        foreach ($exhibitions as $exhibition) {
            $exists = Visitor::where('email', $user->email)
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'completed')
                ->exists();

            if (!$exists) {
                // Split name into first and last name
                $parts = explode(' ', trim($user->name));
                $firstName = $parts[0] ?? '';
                $lastName = isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : '';

                // Generate booking_id
                $randomNum = rand(100000, 999999);
                $bookingId = 'EXP-' . date('ymd') . '-' . $randomNum;

                Visitor::create([
                    'exhibition_id' => $exhibition->id,
                    'booking_id' => $bookingId,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $user->email,
                    'mobile' => $user->phone ?? '',
                    'country' => '',
                    'pass_type' => 'VIP All-Access Pass',
                    'amount' => 0.00,
                    'payment_status' => 'completed',
                    'checkin_status' => false,
                ]);
            }
        }
    }
}

