<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Escuela;
use App\Perfil;
use App\PersonalRol;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    private const SQL_FOR_LOGIN_SGA_24 =
        "
            select
                'LOGIN OK' r_tipo,
                r_error,
                r_idpersonal,
                r_cedula,r_nombres,
                r_idfichero_hoja_vida_foto as r_idfoto
            from
                esq_roles.fnc_login_2_desarrollo(
                    :user,
                    esq_roles.fnc_encripta_clave(:pass),
                    :term,
                    :so,
                    :port,
                    :ip,
                    :browser,
                    :sistem,
                    :pass_moodle
                )
        "
    ;

    private const SQL_FOR_GETTING_THE_ESTUDIANTE_CARRERAS = '
        select
            fa.idfacultad,
            fa.nombre facultad,
            es.idescuela,
            es.nombre escuela,
            ma.idmalla,
            ma.nombre malla,
            may.habilitada
        from
            esq_inscripciones.facultad fa
            inner join esq_inscripciones.escuela es on es.idfacultad=fa.idfacultad
            inner join esq_mallas.malla_estudiante_escuela may on may.idescuela=es.idescuela
            inner join esq_mallas.malla_escuela ma on ma.idmalla=may.idmalla and ma.idescuela=may.idescuela
        where may.idpersonal=:idestudiante
    ';

    private const ID_ROL_RESPONSABLE_PRACTICA = 38; // este numero sive para verificar si el usuario tiene el rol de responsable de practicas que se encuentra en la tabla tbl_rol

    private static function login_sga_docentes($email, $password)
    {
        // acordar cambiar para acceder con password
        $result = DB::connection('DB_db_sga_24')->select(self::SQL_FOR_LOGIN_SGA_24, [
            'user'          => $email,
            'pass'          => $password,
            'term'          => 'term',
            'so'            => 'so',
            'port'          => 'port',
            'ip'            => 'ip',
            'browser'       => 'browser',
            'sistem'        => 10,
            'pass_moodle'   => '',
        ])[0];

        // dd($result);

        return $result;
    }

    public function empresas_get()
    {
        return view('login.empresas');
    }

    public function empresas_post(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            // 'password' => 'requerid'
        ]);

        if (Empresa::where('email', $data['email'])->get()->count() == 0) {
            // dd($request->all());
            add_error("El usuario '{$data['email']}' no está registrado en el sistema");
            return redirect()->back();
        }

        $empresa = Empresa::where('email', $data['email'])->get()[0];


        Session::put('id_empresa', $empresa->id_empresa);
        Session::put('nombre_empresa', $empresa->nombre_empresa);
        Session::put('role', EmpresaController::get_role());

        return redirect()->route('empleos.index');
    }

    public function estudiantes_get()
    {
        return view('login.estudiantes');
    }

    public function estudiantes_post(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // DB_db_sga_spca
        // DB_db_sga_24

        // acordar cambiar para acceder con password
        $result = DB::connection('DB_db_sga_24')->select(self::SQL_FOR_LOGIN_SGA_24, [
            'user'          => $request->get('email'),
            'pass'          => $request->get('password'),
            'term'          => 'term',
            'so'            => 'so',
            'port'          => 'port',
            'ip'            => 'ip',
            'browser'       => 'browser',
            'sistem'        => 10,
            'pass_moodle'   => '',
        ])[0];
        // dd($result);

        if ($result->r_error != 'Ok.') {
            // dd('hola');
            add_error("El usuario '{$data['email']}' no está registrado en el sistema");
            return redirect()->back();
        }

        $request->session()->put('id_personal', $result->r_idpersonal);
        $request->session()->put('nombres', $result->r_nombres);
        $request->session()->put('role', EstudianteController::get_role());

        return redirect()->action('LoginController@choose_carrera_get');
    }

    public function choose_carrera_get()
    {
        $estudiante_id = request()->session()->get('id_personal');

        $carreras = DB::connection('DB_db_sga')->select(self::SQL_FOR_GETTING_THE_ESTUDIANTE_CARRERAS, [
            'idestudiante' => $estudiante_id
        ]);

        // dd($carreras);

        return view('login.choose_carrera')->with('carreras', $carreras);
    }

    public function choose_carrera_post(Request $request)
    {
        $request->validate([
            'carrera' => 'required'
        ]);

        $request->session()->put('idescuela', $request['carrera']);

        $estudiante_id = $request->session()->get('id_personal');

        $carreras = DB::connection('DB_db_sga')->select(self::SQL_FOR_GETTING_THE_ESTUDIANTE_CARRERAS, [
            'idestudiante' => $estudiante_id
        ]);

        $perfil = Perfil::where('personal_id', $estudiante_id)->first();

        if (!$perfil) {
            $perfil = Perfil::create([
                'personal_id' => $estudiante_id
            ]);
        }

        foreach ($carreras as $carrera) {
            # code...
            if ($carrera->idescuela == $request['carrera']) {
                $request->session()->put('idfacultad', $carrera->idfacultad);
            }
        }

        return redirect()->action('EstudianteController@dashboard');
    }

    public function responsables_get()
    {
        return view('login.responsables');
    }

    public function responsables_post(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        $result = self::login_sga_docentes($data['email'], $data['password']);

        // dd($result);

        if ($result->r_error != 'Ok.') {
            // dd('hola');
            add_error("El usuario '{$data['email']}' no está registrado en el sistema");
            return redirect()->back();
        }

        $personal_rol_array = PersonalRol::where([
            ['id_personal', '=', $result->r_idpersonal],
            ['id_rol', '=', self::ID_ROL_RESPONSABLE_PRACTICA]
        ])->get();

        if ($personal_rol_array->count() <= 0) {
            add_error("El usuario '{$data['email']}' no tiene acceso");
            return redirect()->back();
        } else {
            $personal_rol = $personal_rol_array[0];

            // dd($personal_rol);

            $idescuela = explode('|', $personal_rol->idescuela)[0];

            $escuela = Escuela::find($idescuela);

            Session::put('id_personal', $result->r_idpersonal);
            Session::put('nombres', $result->r_nombres);
            Session::put('id_escuela', $escuela->idescuela);
            Session::put('id_facultad', $escuela->idfacultad);
            Session::put('role', ResponsableController::get_role());

            // dd($escuela->facultad);

            return redirect()->route('responsables.dashboard');
        }
    }
}
