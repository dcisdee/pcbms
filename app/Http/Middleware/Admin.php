<?php

namespace App\Http\Middleware;

// use Illuminate\Auth\Middleware\Admin as Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if (Auth::user() && Auth::user()->is_admin === 1) {
            return $next($request);
        } else {
            return redirect('/pos');
        }
    }
}
