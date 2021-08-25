<?php

namespace App\Http\Middleware;

use App\Http\Controllers\EstudianteController;

use Closure;

use Illuminate\Support\Facades\Session;

class ChecEstudianteRoleForSession
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
        if (Session::get('role') != EstudianteController::get_role()) {
            Session::flush();
            return redirect()->route('login.estudiantes_get');
            // abort(302);
        }

        return $next($request);
    }
}
