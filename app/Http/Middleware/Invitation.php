<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Invitation as InvitationModel;

class Invitation
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
        if(\Auth::check()) {
            abort(403, 'There is user already login.');
        } else {
        $invitations = InvitationModel::where('token', $request->route('token'))
                                        ->where('invitation_code', $request->route('invitation_code'))
                                        ->first();

            if (is_null($invitations)){
                abort(403, 'Link is no longer valid.');
            } else {
                if ($invitations->use) {
                    abort(403, 'Link is already used.');
                }
            }
        }
        return $next($request);
    }
}
