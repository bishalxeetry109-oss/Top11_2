<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access admin panel');
        }

        // Check if user is admin
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('userdashboard')->with('error', 'Unauthorized access');
        }

        // Check if user is active
        if (!auth()->user()->isActive()) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated');
        }

        return $next($request);
    }
}
