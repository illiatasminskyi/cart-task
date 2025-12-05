<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreGuestSessionId
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() && !$request->session()->has('guest_session_id')) {
            $request->session()->put('guest_session_id', $request->session()->getId());
        }
        return $next($request);
    }
}
