<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SchoolIdentity
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
        if ($request->route('tenant')) {
            $request->route()->forgetParameter('school');
            return $next($request);
        }
//        return $next($request);
        throw new NotFoundHttpException;
    }
}
