<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the authenticated user has the 'admin' role
            if (Auth::user()->role === 'admin') {
                return $next($request);
            } else {
                return response()->json(['message' => 'Forbidden: You do not have admin access.'], 403);
            }
        } else {
            return response()->json(['message' => 'Unauthorized: Please log in.'], 401);
        }
    }
}
