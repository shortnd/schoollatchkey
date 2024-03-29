<?php

namespace App\Http\Middleware;

use App\Services\SchoolManager;
use Closure;

class SchoolMiddleware
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
        if (isset(auth()->user()->school_id)) {
            if (auth()->user()->school_id == $this->schoolManager->getSchool()->id) {
                return $next($request);
            }
        }
        return redirect()->back()->withErrors(["school" => "You are not registered to that school"]);
    }
}
