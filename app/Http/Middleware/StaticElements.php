<?php

namespace App\Http\Middleware;

use Closure;
use StaticElements as StaticElementsFacade;

class StaticElements
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
        StaticElementsFacade::makeData();

        return $next($request);
    }
}
