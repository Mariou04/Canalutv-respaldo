<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsJournalist
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->rol_id, [1, 2])) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'No tienes permisos para esta sección');
    }
}
