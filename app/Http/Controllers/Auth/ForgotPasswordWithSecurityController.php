<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\View\View;

class ForgotPasswordWithSecurityController extends Controller
{
    /**
     * Display the forgot password with security question form.
     */
    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password-security');
    }

    /**
     * Handle the first step of the forgot password process - finding the user.
     */
    public function findUser(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'We could not find a user with that email address.',
            ]);
        }

        if (empty($user->security_question)) {
            return back()->withErrors([
                'email' => 'This account does not have a security question set up. Please use the email reset option.',
            ]);
        }

        // Store user ID in session for the next step
        Session::put('reset_user_id', $user->id);
        Session::put('show_security_question', true);

        return back()->with([
            'success' => 'User found. Please answer your security question.',
            'security_question' => $user->security_question,
        ]);
    }

    /**
     * Validate the security question answer.
     */
    public function validateSecurityAnswer(Request $request): RedirectResponse
    {
        // Rate limiting: 5 attempts per minute
        $userId = Session::get('reset_user_id');
        if (!$userId) {
            return redirect()->route('password.security.request')
                ->with('error', 'Session expired. Please start over.');
        }

        $key = 'security_answer_attempts_' . $userId;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Too many attempts. Please try again in {$seconds} seconds.");
        }

        $request->validate([
            'security_answer' => 'required|string|min:3',
        ]);

        $user = User::find($userId);
        if (!$user) {
            Session::forget(['reset_user_id', 'show_security_question']);
            return redirect()->route('password.security.request')
                ->with('error', 'User not found. Please start over.');
        }

        $pepper = config('app.pepper', env('PASSWORD_PEPPER', 'your-default-pepper-here'));
        
        if (Hash::check($request->security_answer . $pepper, $user->security_answer)) {
            RateLimiter::clear($key);
            Session::put('show_reset_form', true);
            Session::put('security_verified', true);
            Session::put('security_verified_at', now());
            return back()->with('success', 'Security answer verified. Please enter your new password.');
        }

        RateLimiter::hit($key);
        return back()->with('error', 'Invalid security answer. Please try again. ' . 
            sprintf('You have %d attempts remaining.', max(5 - RateLimiter::attempts($key), 0)));
    }

    /**
     * Reset the user's password.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $userId = Session::get('reset_user_id');
        if (!$userId || !Session::get('security_verified')) {
            Session::forget(['reset_user_id', 'show_security_question', 'show_reset_form', 'security_verified', 'security_verified_at']);
            return redirect()->route('password.security.request')
                ->with('error', 'Session expired or security not verified. Please start over.');
        }

        // Check if security verification is still valid (30 minutes)
        if (!Session::get('security_verified_at') || 
            now()->diffInMinutes(Session::get('security_verified_at')) > 30) {
            Session::forget(['reset_user_id', 'show_security_question', 'show_reset_form', 'security_verified', 'security_verified_at']);
            return redirect()->route('password.security.request')
                ->with('error', 'Security verification has expired. Please start over.');
        }

        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                'not_regex:/^(password|123|abc|test)$/i',
                function ($attribute, $value, $fail) {
                    // Check if password contains common patterns
                    if (preg_match('/(.)1{2,}/', $value)) {
                        $fail('Password cannot contain repeating characters (e.g., "aaa").');
                    }
                    if (preg_match('/^(?=.*123|.*abc|.*qwe)/', $value)) {
                        $fail('Password cannot contain common sequences (e.g., "123", "abc").');
                    }
                },
            ],
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.',
            'password.not_regex' => 'Please choose a more secure password.'
        ]);

        $user = User::find($userId);
        if (!$user) {
            Session::forget(['reset_user_id', 'show_security_question', 'show_reset_form', 'security_verified', 'security_verified_at']);
            return redirect()->route('password.security.request')
                ->with('error', 'User not found. Please start over.');
        }

        $user->update([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ]);

        // Clear all session data
        Session::forget([
            'reset_user_id', 
            'show_security_question', 
            'show_reset_form',
            'security_verified',
            'security_verified_at'
        ]);

        return redirect()->route('login')
            ->with('status', 'Password has been reset successfully. You can now log in with your new password.');
    }
}