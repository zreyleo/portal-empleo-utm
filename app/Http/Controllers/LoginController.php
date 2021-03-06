<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Escuela;
use App\Perfil;
use App\PersonalRol;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    private const SQL_FOR_LOGIN_SGA =
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

    private const SQL_FOR_GETTING_THE_ESTUDIANTE_CARRERAS_2 = '
        select
            fa.idfacultad,
            fa.nombre facultad,
            es.idescuela,
            es.nombre escuela,
            MAX(ma.idmalla) idmalla,
            MAX(ma.nombre) malla
        from
            esq_inscripciones.facultad fa
            inner join esq_inscripciones.escuela es on es.idfacultad=fa.idfacultad
            inner join esq_mallas.malla_estudiante_escuela may on may.idescuela=es.idescuela
            inner join esq_mallas.malla_escuela ma on ma.idmalla=may.idmalla and ma.idescuela=may.idescuela
        where may.idpersonal=:idestudiante and may.habilitada=\'S\' and (es.titulo_academico_m <> \'\' or es.nomenclatura <> \'\')
        group by es.idescuela, fa.idfacultad
    ';

    private const SQL_PERIODO_ACTUAL = '
        select
            p.idperiodo,
            p.nombre as periodo,
            p.actual
        from esq_periodos_academicos.periodo_academico p
        inner join esq_periodos_academicos.periodo_academico_tipo t on t.idtipo_periodo=p.idtipo_periodo
        inner join esq_periodos_academicos.periodo_escuela e on e.idperido=p.idperiodo
        inner join esq_mallas.malla_escuela me on me.idescuela=e.idescuela and me.idmodalidad_estudios=t.idtipo_modalidad
        where me.cerrada=\'N\' and p.habilitado=\'S\' and p.actual=\'S\' and me.idmalla=:idmalla
    ';

    private const SQL_VERIFICA_MALLA_REDESIGN = '
        SELECT count(*) from esq_mallas.malla_materia_nivel mmn
        where mmn.materia_practica in (\'P\',\'V\') and mmn.idmalla=:idmalla
    ';

    private const SQL_VERIFICA_SI_ESTA_MATRICULADO_PPP = '
        SELECT count(*)
        FROM
            esq_mallas.malla_materia_nivel mmn
            inner join esq_inscripciones.inscripcion_detalle det on det.idmalla=mmn.idmalla and det.idmateria=mmn.idmateria
        WHERE
            mmn.materia_practica in (\'P\')
            and det.idpersonal=:idpersonal
            and det.idperiodo=:idperiodo
            and det.idmalla=:idmalla
            and det.anulado = \'N\'
            and det.aprobado <> \'A\'
            and mmn.idnivel = (
                SELECT MIN(mmn.idnivel) idnivel
                from
                    esq_mallas.malla_materia_nivel mmn
                    inner join esq_inscripciones.inscripcion_detalle det on det.idmalla=mmn.idmalla
                    and det.idmateria=mmn.idmateria
                where
                    mmn.materia_practica in (\'P\')
                    and det.idpersonal=:idpersonal
                    and det.idperiodo=:idperiodo
                    and det.idmalla=:idmalla
                    and det.anulado = \'N\'
                    and det.aprobado <> \'A\'
            )
    ';

    private const SQL_HORAS_PPP_CARRERA = 'SELECT co.minimo_horas AS horas FROM tbl_coordinador co WHERE co.id_carrera=:idcarrera limit 1';

    private const SQL_HORAS_PPP_ESTUDIANTE = '
        SELECT SUM(p.horas) AS horas
        FROM tbl_pasantia p
        WHERE p.id_pasante = :idpasante AND p.id_carrera = :idcarrera AND p.estado = 2
        GROUP BY p.id_pasante, p.id_carrera, p.estado
    ';

    private const IDS_ROL_RESPONSABLE_PRACTICA = [
        38,
        108
    ]; // este numero sive para verificar si el usuario tiene el rol de responsable de practicas que se encuentra en la tabla tbl_rol

    private const IDS_FACULTADES_QUE_NO_PUEDEN_USAR_EL_SISTEMA = [
        3, // FILOSOFIA Y LETRAS
        9 // SALUD
    ];

    private static function login_sga_docentes($email, $password)
    {
        $result = DB::connection('DB_db_sga_actual')->select(self::SQL_FOR_LOGIN_SGA, [
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

        return $result;
    }

    public function empresas_get()
    {
        return view('login.empresas');
    }

    public function departamentos_get()
    {
        return view('login.departamentos');
    }

    public function empresas_post(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Empresa::where('email', $data['email'])->get()->count() == 0) {
            add_error("El usuario '{$data['email']}' no est?? registrado en el sistema");

            return redirect()->back();
        }

        $empresa = Empresa::where('email', $data['email'])->get()[0];

        if (!Hash::check($request->password, $empresa->password)) {
            add_error("Password Incorrecto");
            return redirect()->back();
        }


        Session::put('id_empresa', $empresa->id_empresa);
        Session::put('nombre_empresa', $empresa->nombre_empresa);
        Session::put('role', EmpresaController::get_role());

        return redirect()->route('empresas.dashboard');
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
        // DB_db_sga_actual

        $result = DB::connection('DB_db_sga_actual')->select(self::SQL_FOR_LOGIN_SGA, [
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

        if ($result->r_error != 'Ok.') {
            add_error("El usuario '{$data['email']}' no est?? registrado en el sistema");
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

        $carreras = DB::connection('DB_db_sga_actual')->select(self::SQL_FOR_GETTING_THE_ESTUDIANTE_CARRERAS_2, [
            'idestudiante' => $estudiante_id
        ]);

        return view('login.choose_carrera')->with('carreras', $carreras);
    }

    public function choose_carrera_post(Request $request)
    {
        $request->validate([
            'carrera' => 'required'
        ]);

        $idescuela = explode('|', $request->carrera)[0];
        $idmalla = explode('|', $request->carrera)[1];

        $escuela = Escuela::find($idescuela);

        $request->session()->put('idescuela', $idescuela);
        $request->session()->put('idmalla', $idmalla);

        $request->session()->put('idfacultad', $escuela->idfacultad);

        $estudiante_id = $request->session()->get('id_personal');

        $perfil = Perfil::where('personal_id', $estudiante_id)->first();

        if (!$perfil) {
            $perfil = Perfil::create([
                'personal_id' => $estudiante_id
            ]);
        }

        $is_redesign = DB::connection('DB_db_sga_actual')->select(self::SQL_VERIFICA_MALLA_REDESIGN, [
            'idmalla' => $idmalla
        ])[0]->count ? true : false;

        $total_horas_ppp_carrera = DB::connection('DB_ppp_sistema_SCHEMA_public')->select(self::SQL_HORAS_PPP_CARRERA, [
            'idcarrera' => $idescuela
        ])[0];

        $result_total_horas_ppp_estudiante = DB::connection('DB_ppp_sistema_SCHEMA_public')->select(self::SQL_HORAS_PPP_ESTUDIANTE, [
            'idpasante' => $estudiante_id,
            'idcarrera' => $idescuela
        ]);

        $total_horas_ppp_estudiante = count($result_total_horas_ppp_estudiante) ? $result_total_horas_ppp_estudiante[0]->horas : 0;

        Session::put('is_redesign', $is_redesign);

        $peridodo_actual = DB::connection('DB_db_sga_actual')->select(self::SQL_PERIODO_ACTUAL, [
            'idmalla' => $idmalla
        ])[0];

        Session::put('idperiodo', $peridodo_actual->idperiodo);

        $is_matriculado = DB::connection('DB_db_sga_actual')->select(self::SQL_VERIFICA_SI_ESTA_MATRICULADO_PPP, [
            'idpersonal' => $estudiante_id,
            'idperiodo' => $peridodo_actual->idperiodo,
            'idmalla' => $idmalla
        ])[0]->count ? true : false;

        Session::put('is_matriculado', $is_matriculado);

        if (($is_redesign && !$is_matriculado) ||
            (in_array($escuela->idfacultad, self::IDS_FACULTADES_QUE_NO_PUEDEN_USAR_EL_SISTEMA)) ||
            (($total_horas_ppp_carrera->horas - $total_horas_ppp_estudiante) <= 0)
        ) {
            Session::put('can_register_ppp', false);
        } else {
            Session::put('can_register_ppp', true);
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

        if ($result->r_error != 'Ok.') {
            add_error("El usuario '{$data['email']}' no est?? registrado en el sistema");

            return redirect()->back();
        }

        $personal_rol_array = PersonalRol::where([
            ['id_personal', '=', $result->r_idpersonal],
        ])->whereIn('id_rol', self::IDS_ROL_RESPONSABLE_PRACTICA)->get();

        if ($personal_rol_array->count() <= 0) {
            add_error("El usuario '{$data['email']}' no tiene acceso");

            return redirect()->back();
        } else {
            $personal_rol = $personal_rol_array[0];

            $idescuela = explode('|', $personal_rol->idescuela)[0];

            $escuela = Escuela::find($idescuela);

            Session::put('id_personal', $result->r_idpersonal);
            Session::put('nombres', $result->r_nombres);
            Session::put('id_escuela', $escuela->idescuela);
            Session::put('id_facultad', $escuela->idfacultad);
            Session::put('role', ResponsableController::get_role());

            return redirect()->route('responsables.dashboard');
        }
    }

    public function jefe_departamento_get()
    {

    }
}
