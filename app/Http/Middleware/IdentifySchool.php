<?php

namespace App\Http\Middleware;

use App\Services\SchoolManager;
use Closure;

class IdentifySchool
{
    protected $schoolManager;

    public function __construct(SchoolManager $schoolManager)
    {
        $this->schoolManager = $schoolManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->schoolManager->loadSchool($request->route('school'))) {
            $request->route()->forgetParameter('school');
            return $next($request);
        }

        // throw new NotFoundHttpException;
        abort(404);
    }
}
