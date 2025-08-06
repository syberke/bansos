<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('username')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
