<?php
// app/Http/Middleware/UpdateLastActivity.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user instanceof \App\Models\User) {
                $user->last_activity = now();
                $user->save();
            }
        }

        return $next($request);
    }
}