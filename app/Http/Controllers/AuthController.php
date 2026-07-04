<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->input('email'))->first();

        if ($user && $user->status !== 'active') {
            $superAdminEmail = env('SUPER_ADMIN_EMAIL', 'admin@example.com');
            $superAdminPhone = env('SUPER_ADMIN_PHONE', '+2500000000');

            return redirect()->route('login')
                ->with('inactive_account', 'Your account is inactive. Please contact the admin via email ' . $superAdminEmail . ' or phone ' . $superAdminPhone . ' to activate your account.')
                ->withInput($request->only('email'));
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/main-dashboard')->with('success', 'Logged in successfully');
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('User logged out', ['by_user_id' => optional(Auth::user())->id, 'ip' => $request->ip()]);

        return redirect('/');
    }
}
