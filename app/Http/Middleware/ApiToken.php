<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;

class ApiToken
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
        $user = User::where('api_token', '=', $request->route('api_token'))->first();

        if ($user == null) {
            return response('Unauthorized', 401);
        }

        Auth::login($user); // Это не очень правильно. Лучше реализовать свой guard

        return $next($request);
    }
}
