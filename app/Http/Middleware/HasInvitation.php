<?php

namespace App\Http\Middleware;

use App\Invitation;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HasInvitation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('get')) {
            if (! $request->has('invitation_token')) {
                return redirect(route('request-invitation'));
            }

            $invitation_token = $request->get('invitation_token');

            try {
                $invitation = Invitation::where('invitation_token', $invitation_token);
            } catch (ModelNotFoundException $e) {
                return redirect(route('request-invitation'))->with('error', 'Wrong invitation token! Please check your URL.');
            }
        }

        if (!is_null($invitation->registered_at)) {
            return redirect(route('login'))->with('error', 'The invitation link has already been used.');
        }
        return $next($request);
    }
}
