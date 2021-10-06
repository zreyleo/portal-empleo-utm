<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ResponsableController;
use App\Perfil;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

use PHPMailer\PHPMailer\PHPMailer;

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

if (!function_exists('get_session_docente')) {
    function get_session_docente()
    {
        return ResponsableController::get_docente_data();
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

if (!function_exists('enviar_correo')) {
    function enviar_correo($correo, $asunto, $mensaje)
    {
        $mail = new PHPMailer(true);

        $mail->SMTPDebug    = 0; //SMTP::DEBUG_SERVER; //ver errores
        $mail->isSMTP();
        $mail->Host         = 'smtp.gmail.com';
        $mail->SMTPAuth     = true;
        $mail->Username     = env('MAIL_USERNAME');
        $mail->Password     = env('MAIL_PASSWORD');
        $mail->SMTPSecure   = 'tls';
        $mail->Port         = 587;
        $mail->addAddress($correo);
        $mail->setFrom('sga@utm.edu.ec', 'Sistema');

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;
        $mail->send();
    }
}
