<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user_id exists in session
        if (session()->has('user_id')) {
            return $next($request);
        }
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
}
