<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        // Add debugging before authentication
        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            Log::info('Found user during login attempt', [
                'user_id' => $user->id,
                'email' => $user->email,
                'password_hash_length' => strlen($user->password)
            ]);
            
            // Test password hash directly
            $passwordMatches = Hash::check($request->password, $user->password);
            Log::info('Password check result', ['matches' => $passwordMatches]);
        } else {
            Log::info('No user found with email', ['attempted_email' => $request->email]);
        }

        $request->authenticate();

        $request->session()->regenerate();
        
        // Redirect based on user role
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        
        return redirect('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
