<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ProfissionalSaude
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && Auth::user()->tipoUsuario == 'Profissional da Saúde' && Auth::user()->flagAdmin == false) {
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
