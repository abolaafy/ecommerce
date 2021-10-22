<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class verifiedUser
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
        if ( Auth::guard('site') -> check() && is_null (auth::user('site') ->  mobile_verified_at ))
       {

           return redirect() -> route('mobile.verified');

        }

        return $next($request);
    }
}
