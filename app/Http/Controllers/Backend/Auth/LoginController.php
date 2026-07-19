<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // Add other fields like 'captcha' or 'image' if needed
        ]);

        $remember = $request->boolean('remember');

        // Attempt to authenticate (session guard); remember aligns with "Remember me"
        if (Auth::attempt($request->only('email', 'password'), $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Spatie role and/or legacy string column on users table
            $isSuperAdmin = $user->hasRole('superAdmin')
                || (($user->role ?? null) === 'superAdmin');

            if ($isSuperAdmin) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('admin.dashboard'),
                    'message' => 'You are logged in as Admin!',
                ]);
            }

            Auth::logout();

            return response()->json([
                'success' => false,
                'message' => 'Access restricted to administrators.',
            ]);
        }

        // If authentication fails, return an error message
        return response()->json([
            'success' => false,
            'message' => 'Incorrect email or password.'
        ]);
    }


    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()
            ->route('admin.auth.showLoginForm')
            ->with('status', 'User has been logged out!');
    }
}
