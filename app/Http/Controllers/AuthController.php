<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('equipment.index');
        }
        return view('auth.login');
    }

    /**
     * Handle authentication attempt using either Email OR Username.
     */
    public function login(Request $request)
    {
        // 1. Server-side validation
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Please enter your username or email address.',
            'password.required' => 'Password is required.',
        ]);

        $loginInput = $request->input('login');
        $password = $request->input('password');

        // 2. Determine whether login input is an email address or username
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $password,
        ];

        // 3. Attempt Authentication
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('equipment.index'))
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        // 4. Return with error if credentials invalid (preserves old input)
        return back()->withErrors([
            'login' => 'Invalid login credentials provided. Please check your username/email and password.',
        ])->onlyInput('login');
    }

    /**
     * Handle secure logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been securely logged out.');
    }
}