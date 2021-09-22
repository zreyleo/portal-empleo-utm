<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ResponsableController;

use Closure;

use Illuminate\Support\Facades\Session;

class CheckResponsableRoleForSession
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
        if (Session::get('role') != ResponsableController::get_role()) {
            Session::flush();
            return redirect()->route('login.responsables_get');
            // abort(302);
        }
        return $next($request);
    }
}
