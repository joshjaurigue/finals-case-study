<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class DoctorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the authenticated user has the 'admin' role
            if (Auth::user()->role === 'doctor') {
                return $next($request);
            } else {
                return response()->json(['message' => 'Forbidden: You do not have doctor access.'], 403);
            }
        } else {
            return response()->json(['message' => 'Unauthorized: Please log in.'], 401);
        }
    }
}
