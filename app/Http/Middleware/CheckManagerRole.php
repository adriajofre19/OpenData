<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckManagerRole
{
public function handle(Request $request, Closure $next)
{
    if (auth()->check()) {
        $userRole = auth()->user()->id_role;
        if ($userRole == 2 || $userRole == 3) {
            return $next($request);
        }
    }

    return redirect('/');
}
}
