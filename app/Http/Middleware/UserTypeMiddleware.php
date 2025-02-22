<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\log;

class UserTypeMiddleware
{
    public function handle(Request $request, Closure $next, ...$types)
    {

        // Allow guest users if "guest" is in the allowed types
        if (in_array('guest', $types) && !Auth::check()) {
            return $next($request);
        }

        // If user is not logged in and "guest" is not allowed, redirect to login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must log in to access this page.');
        }

        // Check if the logged-in user has the correct user type
        if (!in_array(Auth::user()->user_type, $types)) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'You must log in to access this page.');
        }

        return $next($request);
    }
}
