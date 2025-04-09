<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        // First check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page');
        }

        // Then check if user has admin role
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('welcome')->with('error', 'Unauthorized access. Admin privileges required.');
        }

        return $next($request);
    }
}