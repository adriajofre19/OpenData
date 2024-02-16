<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if (auth()->user()->id_role == 3) {
                return $next($request);
            }
        }

        return redirect('/');
    }
}
