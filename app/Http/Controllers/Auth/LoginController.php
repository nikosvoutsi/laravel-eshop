<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers; // Make sure this line is present
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Socialite;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function userNeedsOnboarding($user)
{
    // Example condition: check if important fields are missing (e.g., phone, address)
    if (empty($user->first_name) || empty($user->last_name) || empty($user->phone) || empty($user->address)) {
        return true; // User needs to complete onboarding
    }

    return false; // User has completed onboarding
}
public function login(Request $request)
{
    try {
        // Validate input (optional but good practice)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Log successful authentication
            \Log::info('User authenticated successfully.');

            // Check if user needs onboarding (if applicable)
            if ($this->userNeedsOnboarding(Auth::user())) {
                return redirect()->route('onboarding');
            }

            // Redirect to intended or default
            return redirect()->intended('/dashboard');
        }

        // Log failed authentication attempt
        \Log::info('Login failed: wrong credentials.');

        // Authentication failed, redirect back with an error
        return redirect()->route('login')->with('error', 'Invalid credentials.');
    } catch (Throwable $error) {
        \Log::error('Login failed with exception: ', ['message' => $error->getMessage()]);

        // Redirect back to login with an error
        return redirect()->route('login')->with('error', 'An error occurred during login.');
    }
}


    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login');
    }

    // Handle Facebook callback
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login with ' . ucfirst($provider) . ' failed');
        }

        // Check if the user exists in your database or create a new user as needed
        // ...

        Auth::login($user); // Log in the user

        return redirect('/dashboard'); // Redirect to the dashboard or profile page
    }
}
