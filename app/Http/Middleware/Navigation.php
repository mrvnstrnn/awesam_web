<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Navigation
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
        if(\Auth::check()){
            if (is_null(\Auth::user()->profile_id)) {
                return redirect('/onboarding');
            } else if($request->path() && !\Auth::user()->can_do($request->path())){
                abort(404);
            } 
        }
        return $next($request);
    }
}
