<?php

namespace App\Http\Controllers;

use App\Empleo;
use App\EstudianteEmpleo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;

class EstudianteEmpleoController extends Controller
{
    private const RECHAZADO = 'RECHAZADO';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public static function get_rechazado()
    {
        return self::RECHAZADO;
    }

    public function index()
    {
        $estudiante = get_session_estudiante();

        $estudiantes_empleos = EstudianteEmpleo::where('estudiante_id', $estudiante['id_personal'])
            ->latest()->get();

        return view('estudiantes_empleos.index')
            ->with('estudiantes_empleos', $estudiantes_empleos)
            ->with('estudiante', $estudiante);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Empleo $empleo)
    {
        $estudiante = get_session_estudiante();

        // dd($empleo);
        try {
            EstudianteEmpleo::create([
                'estudiante_id' => $estudiante['id_personal'],
                'empleo_id' => $empleo->id
            ]);
        } catch (\Throwable $th) {
            add_error('Ya se concedió sus datos para esta oferta de empleo');
            return redirect()->route('empleos.show_empleos_offers');
        }

        // $notificacionExito = crear_notificacion('Registro con Exito', 'bg-success');

        return redirect()->route('estudiantes_empleos.index')
            ->with('status', 'Has concedido tus datos para esta oferta de trabajo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EstudianteEmpleo  $estudianteEmpleo
     * @return \Illuminate\Http\Response
     */
    public function show(EstudianteEmpleo $estudianteEmpleo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EstudianteEmpleo  $estudianteEmpleo
     * @return \Illuminate\Http\Response
     */
    public function destroy(EstudianteEmpleo $estudiante_empleo)
    {
        $this->authorize('pass', $estudiante_empleo);

        $estudiante_empleo->delete();

        return redirect()->route('estudiantes_empleos.index')
            ->with('status', 'Has restringido tus datos para esta oferta de trabajo');
    }

    public function show_empleo_details(EstudianteEmpleo $estudiante_empleo)
    {
        $this->authorize('pass', $estudiante_empleo);

        $estudiante = get_session_estudiante();

        $empleo = $estudiante_empleo->empleo;

        return view('estudiantes_empleos.show_empleo_details')
            ->with('estudiante', $estudiante)
            ->with('empleo', $empleo)
            ->with('estudiante_empleo', $estudiante_empleo);
    }

    public function show_estudiante_data(EstudianteEmpleo $estudiante_empleo)
    {
        $this->authorize('check_empresa_owner', $estudiante_empleo);

        $empresa = get_session_empresa();

        // dd($aspirante);

        $empleo = $estudiante_empleo->empleo;

        $cedula_aspirante = $estudiante_empleo->personal->cedula;

        $sql_datos_aspirante = "
            select *
            from f_obtiene_persona_str('$cedula_aspirante');
        ";

        $result = DB::connection('DB_ppp_sistema_SCHEMA_public')->select($sql_datos_aspirante)[0];

        // dd($result);

        $datos_aspirante = $result;

        return view('estudiantes_empleos.show_estudiante_data')
            ->with('empresa', $empresa)
            ->with('empleo', $empleo)
            ->with('estudiante_empleo', $estudiante_empleo)
            ->with('datos_aspirante', $datos_aspirante);
    }

    public function reject(EstudianteEmpleo $estudiante_empleo)
    {
        $this->authorize('check_empresa_owner', $estudiante_empleo);

        $empleo = $estudiante_empleo->empleo;

        $empresa = get_session_empresa();

        $nombre_empresa = $empresa['nombre_empresa'];

        $cedula_aspirante = $estudiante_empleo->personal->cedula;

        $sql_datos_aspirante = "
            select *
            from f_obtiene_persona_str('$cedula_aspirante');
        ";

        $result = DB::connection('DB_ppp_sistema_SCHEMA_public')->select($sql_datos_aspirante)[0];

        $datos_aspirante = $result;


        $body = "Se aprecia tu interes en la vacante $empleo->titulo de la empresa $nombre_empresa pero se ha decidido no seguir adelante con tu aplicacion.";

        enviar_correo("$datos_aspirante->email_utm", 'Aplicacion no seguira adelante', $body);

        $estudiante_empleo->estado = self::RECHAZADO;

        $estudiante_empleo->save();

        return redirect()->route('empleos.show_estudiantes_empleos', ['empleo' => $estudiante_empleo->empleo_id])
            ->with('status', 'Se ha decidido no seguir con esta aplicacion para esta oferta de trabajo');
    }
}
