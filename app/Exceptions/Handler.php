<?php

namespace App\Exceptions;

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ResponsableController;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Support\Facades\Session;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception) && $exception->getStatusCode() == 404)
        {
            $session_role = Session::get('role');

            switch ($session_role) {
                case EmpresaController::get_role():
                    return redirect()->route('empresas.dashboard');
                    break;

                case EstudianteController::get_role():
                    if (!Session::get('idescuela')) {
                        return redirect()->route('login.choose_carrera_get');
                    } else {
                        return redirect()->route('estudiantes.dashboard');
                    }
                    break;

                case ResponsableController::get_role():
                    return redirect()->route('responsables.dashboard');
                    break;

                default:
                    Session::flush();
                    return redirect()->route('landing');
                    break;
            }
        }

        return parent::render($request, $exception);
    }
}
