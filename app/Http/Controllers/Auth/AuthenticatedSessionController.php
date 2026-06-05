<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Check if account is active
        if (! Auth::user()->is_active) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Your account has been suspended. Please contact the administrator.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->isModerator()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home'))
            ->with('success', 'Welcome back, ' . $user->firstname . '!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
