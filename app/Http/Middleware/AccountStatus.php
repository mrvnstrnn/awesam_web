<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(\Auth::check()){
            if (\Auth::user()->is_active == 1) {
                abort(403, "Your Account has been disabled");
            }
        }
        return $next($request);
    }
}
