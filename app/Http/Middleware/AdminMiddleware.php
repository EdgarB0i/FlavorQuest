<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in and has admin value set to 1
        if (auth()->check() && auth()->user()->admin == 1) {
            return $next($request);
        }

        // If the user is not an admin, log the user out and set the error message in the session
        Auth::logout();
        $errorMessage = 'You are not authorized to access this page. You have been logged out.';
        return redirect()->route('login.form')->with('error', $errorMessage);
    }
}
