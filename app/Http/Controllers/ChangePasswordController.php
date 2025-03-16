<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        $user = auth()->user();
        $hasSecurityQuestion = !empty($user->security_question);
        
        return view('auth.change-password', [
            'hasSecurityQuestion' => $hasSecurityQuestion
        ]);
    }

    public function setupSecurityQuestion(Request $request)
    {
        $request->validate([
            'security_question' => [
                'required',
                'string',
                'max:255',
                'in:What was the name of your first pet?,In what city did your parents meet?,What was the name of your first teacher?,What was the model of your first car?,What is your maternal grandmother\'s first name?'
            ],
            'security_answer' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'not_regex:/^(password|123|abc|test)$/i'
            ],
        ], [
            'security_answer.not_regex' => 'Please provide a more secure answer.',
            'security_question.in' => 'Please select a valid security question.'
        ]);

        $pepper = config('app.pepper', env('PASSWORD_PEPPER', 'your-default-pepper-here'));
        $user = auth()->user();
        
        $user->update([
            'security_question' => $request->security_question,
            'security_answer' => Hash::make($request->security_answer . $pepper)
        ]);

        Session::flash('show_password_form', false);
        return back()->with('success', 'Security question has been set up successfully. You can now proceed with password change.');
    }

    public function validateSecurityQuestion(Request $request)
    {
        // Rate limiting: 5 attempts per minute
        $key = 'security_answer_attempts_' . auth()->id();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Too many attempts. Please try again in {$seconds} seconds.");
        }

        $request->validate([
            'security_answer' => 'required|string|min:3',
        ]);

        $user = auth()->user();
        $pepper = config('app.pepper', env('PASSWORD_PEPPER', 'your-default-pepper-here'));
        
        if (Hash::check($request->security_answer . $pepper, $user->security_answer)) {
            RateLimiter::clear($key);
            Session::put('show_password_form', true);
            Session::put('security_verified', true);
            Session::put('security_verified_at', now());
            return back()->with('success', 'Security answer verified. Please enter your new password.');
        }

        RateLimiter::hit($key);
        return back()->with('error', 'Invalid security answer. Please try again. ' . 
            sprintf('You have %d attempts remaining.', max(5 - RateLimiter::attempts($key), 0)));
    }

    public function generateOTP(Request $request)
    {
        if (!Session::get('security_verified') || 
            !Session::get('security_verified_at') || 
            now()->diffInMinutes(Session::get('security_verified_at')) > 30) {
            Session::forget(['show_password_form', 'security_verified', 'security_verified_at']);
            return back()->with('error', 'Security verification has expired. Please verify your security answer again.');
        }

        $request->validate([
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                'not_regex:/^(password|123|abc|test)$/i',
                function ($attribute, $value, $fail) {
                    // Check if password contains common patterns
                    if (preg_match('/(.)\1{2,}/', $value)) {
                        $fail('Password cannot contain repeating characters (e.g., "aaa").');
                    }
                    if (preg_match('/^(?=.*123|.*abc|.*qwe)/', $value)) {
                        $fail('Password cannot contain common sequences (e.g., "123", "abc").');
                    }
                },
            ],
        ], [
            'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.',
            'new_password.not_regex' => 'Please choose a more secure password.'
        ]);

        // Check if new password is similar to old password
        if (Hash::check($request->new_password, auth()->user()->password)) {
            return back()->withErrors([
                'new_password' => 'New password must be different from your current password.'
            ]);
        }

        Session::put('new_password', Hash::make($request->new_password));
        
        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        Session::put('otp', hash('sha256', $otp)); // Store hashed OTP
        Session::put('otp_expiry', Carbon::now()->addMinutes(2));
        Session::put('show_otp_form', true);

        return back()->with([
            'success' => 'Your OTP is: ' . $otp . '. It will expire in 2 minutes.',
            'show_otp_form' => true
        ]);
    }

    public function verifyOTP(Request $request)
    {
        // Rate limiting: 3 attempts per minute
        $key = 'otp_attempts_' . auth()->id();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Too many attempts. Please try again in {$seconds} seconds.");
        }

        if (!Session::get('security_verified')) {
            Session::forget(['otp', 'otp_expiry', 'new_password', 'show_password_form', 'show_otp_form']);
            return back()->with('error', 'Security verification required. Please start over.');
        }

        $request->validate([
            'otp' => 'required|string|size:6|regex:/^[0-9]+$/',
        ]);

        $storedOTP = Session::get('otp');
        $otpExpiry = Session::get('otp_expiry');
        $newPassword = Session::get('new_password');

        if (!$storedOTP || !$otpExpiry || !$newPassword) {
            return back()->with('error', 'Invalid request. Please start over.');
        }

        if (Carbon::now()->isAfter($otpExpiry)) {
            Session::forget(['otp', 'otp_expiry', 'new_password', 'show_otp_form']);
            return back()->with('error', 'OTP has expired. Please try again.');
        }

        if (!hash_equals($storedOTP, hash('sha256', $request->otp))) {
            RateLimiter::hit($key);
            return back()->with('error', 'Invalid OTP. ' . 
                sprintf('You have %d attempts remaining.', max(3 - RateLimiter::attempts($key), 0)));
        }

        auth()->user()->update([
            'password' => $newPassword
        ]);

        // Clear all session data
        Session::forget([
            'otp', 
            'otp_expiry', 
            'new_password', 
            'show_password_form', 
            'show_otp_form',
            'security_verified',
            'security_verified_at'
        ]);

        RateLimiter::clear($key);
        return redirect()->route('dashboard')->with('success', 'Password changed successfully. Please log in with your new password.');
    }
} 