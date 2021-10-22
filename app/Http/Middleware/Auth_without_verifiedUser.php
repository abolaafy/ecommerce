<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Auth_without_verifiedUser
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
       if (Auth::guard('site') -> check() && !is_null(Auth::user() ->mobile_verified_at ))
       {
        return redirect()->back();
       }
       return $next($request);
    }
}
