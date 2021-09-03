<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EstudianteController;
use App\Perfil;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

if (!function_exists('add_error')) {
    /*
 * Add an error to Laravel session $errors
 * @author Pavel Lint
 * @param string $key
 * @param string $error_msg
 */
    function add_error($error_msg, $key = 'default')
    {
        $errors = Session::get('errors', new ViewErrorBag);

        if (!$errors instanceof ViewErrorBag) {
            $errors = new ViewErrorBag;
        }

        $bag = $errors->getBags()['default'] ?? new MessageBag();
        $bag->add($key, $error_msg);

        Session::flash(
            'errors',
            $errors->put('default', $bag)
        );
    }
}

if (!function_exists('get_session_empresa')) {
    function get_session_empresa()
    {
        return EmpresaController::get_empresa_data();
    }
}

if (!function_exists('get_session_estudiante')) {
    function get_session_estudiante()
    {
        return EstudianteController::get_estudiante_data();
    }
}

if (!function_exists('current_session_estudiante_has_perfil')) {
    function current_session_estudiante_has_perfil()
    {
        $estudiante = get_session_estudiante();

        return Perfil::where('personal_id', $estudiante['id_personal'])->first() ?: false;
    }
}
