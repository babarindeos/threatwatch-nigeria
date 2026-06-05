<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:100'],
            'surname'   => ['required', 'string', 'max:100'],
            'email'     => ['required', 'string', 'email', 'max:180', 'unique:users'],
            'phone'     => ['nullable', 'string', 'max:20'],
            'password'  => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'surname'   => $request->surname,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password),
            'role'      => 'user',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Welcome to ThreatWatch Nigeria, ' . $user->firstname . '!');
    }
}
