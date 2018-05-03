<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        if (Auth::guard($guard)->check()) {
//            return redirect('/community');
//        } 
//  bij activatie wordt de user terug gestuurd als er al is ingelogd. 
//  dan zou er dus geen nieuwe gebruiker kunnen worden gemaakt wanneer er is ingelogd
        return $next($request);
    }
}
