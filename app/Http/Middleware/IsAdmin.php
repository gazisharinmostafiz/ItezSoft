<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and if their 'is_admin' flag is true
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request); // User is admin, allow access
        }

        // If not an admin, redirect them or show an error
        // You can customize this redirection
        return redirect('/')->with('error', 'You do not have administrative access.');
        // Alternatively, you could abort with a 403 Forbidden error:
        // abort(403, 'Unauthorized action.');
    }
}