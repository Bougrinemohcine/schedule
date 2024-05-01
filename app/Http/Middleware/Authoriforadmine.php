<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authoriforadmine
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
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the user has the required role
            $userRole = Auth::user()->role; // Assuming your user model has a 'role' property
            if ($userRole === 'admin') { // Adjust 'admin' to match your role criteria
                return $next($request);
            }
        }

        // If the user is not authenticated or doesn't have the required role, redirect them or return an error response
        return redirect()->back()->with('error', 'Unauthorized');
    }
}