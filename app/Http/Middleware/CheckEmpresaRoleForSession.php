<?php

namespace App\Http\Middleware;

use App\Http\Controllers\EmpresaController;

use Closure;

use Illuminate\Support\Facades\Session;

class CheckEmpresaRoleForSession
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
        if (Session::get('role') != EmpresaController::get_role()) {
            Session::flush();
            return redirect()->route('login.empresas_get');
            // abort(302);
        }
        return $next($request);
    }
}
