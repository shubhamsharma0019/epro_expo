<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use App\Support\UserVisitorPasses;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserPortalController extends Controller
{
    public function profile(): View
    {
        $user = auth()->user();
        $passCount = UserVisitorPasses::queryForUser($user)
            ->where('payment_status', 'completed')
            ->count();

        $eventTicketCount = \App\Domain\Visitor\Models\VisitorTicket::where('user_id', $user->id)->count();

        return view('frontend.user.profile', [
            'user' => $user,
            'passCount' => $passCount,
            'eventTicketCount' => $eventTicketCount,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        auth()->user()->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }
}
