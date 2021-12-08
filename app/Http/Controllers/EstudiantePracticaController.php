<?php

namespace App\Http\Controllers;

use App\EstudiantePractica;
use App\Pasantia;
use App\Practica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstudiantePracticaController extends Controller
{
    private const SQL_OBTENER_MATERIA_UNICA = '
        SELECT idmateria_unica, creditos, idnivel
        from
            esq_mallas.malla_materia_nivel mmn
            inner join esq_inscripciones.inscripcion_detalle det on det.idmalla=mmn.idmalla and det.idmateria=mmn.idmateria
        where
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

    private const NUMERO_HORAS_X_CREDITO_MATERIA = 48;

    private const ESTADOS_QUE_IMPIDEN_QUE_UN_ESTUDIANTE_RESERVE_MAS_DE_UNA_PRACTICA = [0, 1];
    // 0 = pendiente
    // 1 = ejecutando
    // 2 = terminado
    // 3 = reprobado
    // 4 = anulado

    private static function set_fase($nivel)
    {
        $fase = '';
        switch ($nivel) {
            case 1:
                $fase = 'PRACTICAS DE PRIMER NIVEL';
                break;

            case 2:
                $fase = 'PRACTICAS DE SEGUNDO NIVEL';
                break;

            case 3:
                $fase = 'PRACTICAS DE TERCER NIVEL';
                break;

            case 4:
                $fase = 'PRACTICAS DE CUARTO NIVEL';
                break;

            case 5:
                $fase = 'PRACTICAS DE QUINTO NIVEL';
                break;

            case 6:
                $fase = 'PRACTICAS DE SEXTO NIVEL';
                break;

            case 7:
                $fase = 'PRACTICAS DE SEPTIMO NIVEL';
                break;

            case 8:
                $fase = 'PRACTICAS DE OCTAVO NIVEL';
                break;

            case 9:
                $fase = 'PRACTICAS DE NOVENO NIVEL';
                break;

            case 10:
                $fase = 'PRACTICAS DE DECIMO NIVEL';
                break;

            default:
                $fase = 'FASE POR DEFINIR';
                break;
        }
        return $fase;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estudiante = get_session_estudiante();

        // dd($estudiante);

        $estudiantes_practicas = EstudiantePractica::where('estudiante_id', $estudiante['id_personal'])
            ->latest()->get();

        return view('estudiantes_practicas.index')
            ->with('estudiantes_practicas', $estudiantes_practicas)
            ->with('estudiante', $estudiante);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Practica $practica)
    {
        $estudiante = get_session_estudiante();

        $estudiantes_practicas_count = $practica->estudiantes_practicas->count();

        if (!$estudiante['can_register_ppp']) { // si el estudiante no puede registrar practicas hay error
            add_error('Lo sentimos pero no puedes registrar horas de PPP');

            return redirect()->route('practicas.show_practicas_offers');
        }

        if ($estudiantes_practicas_count >= $practica->cupo) {
            add_error('Lo sentimos pero esta PPP tiene cupo lleno');

            $practica->visible = false;

            $practica->save();

            return redirect()->route('practicas.show_practicas_offers');
        }

        $pasantias_incompletas = Pasantia::where([
            ['id_pasante', '=', $estudiante['id_personal']]
        ])->whereIn('estado', self::ESTADOS_QUE_IMPIDEN_QUE_UN_ESTUDIANTE_RESERVE_MAS_DE_UNA_PRACTICA)->get();

        if ($pasantias_incompletas->count()) {
            add_error('No puedes agregar mas practicas porque tienes otras pendientes');

            return redirect()->route('estudiantes_practicas.index');
        }

        // if (EstudiantePractica::where('estudiante_id', $estudiante['id_personal'])->get()->count() > 0) {
        //     $last_estudiante_practica = EstudiantePractica::where('estudiante_id', $estudiante['id_personal'])
        //         ->latest()->get()[0];

        //     $date_last_estudiante_practica = Carbon::create($last_estudiante_practica->created_at->format('d.m.Y'));

        //     if ($date_last_estudiante_practica->addMonth()->greaterThan(now())) {
        //         add_error('No es posible reservar otro cupo de una practica hasta despues de un mes');

        //         return redirect()->route('estudiantes_practicas.index');
        //     }
        // }

        try {
            $estudiante_practica = EstudiantePractica::create([
                'estudiante_id' => $estudiante['id_personal'],
                'practica_id' => $practica->id,
            ]);

            if (($practica->estudiantes_practicas->count() + 1) >= $practica->cupo) {
                $practica->visible = false;
                $practica->save();
            }

            $pasantia = null;

            if ($estudiante['is_redesign']) {
                $datos_sql = DB::connection('DB_db_sga_actual')->select(self::SQL_OBTENER_MATERIA_UNICA, [
                    'idpersonal' => $estudiante['id_personal'],
                    'idperiodo' => $estudiante['idperiodo'],
                    'idmalla' => $estudiante['idmalla']
                ])[0];
                // dd($datos_sql);

                $fase = self::set_fase($datos_sql->idnivel);

                $pasantia = Pasantia::create([
                    'id_pasante' => $estudiante['id_personal'],
                    'id_empresa' => $practica->empresa_id,
                    'horas' => $datos_sql->creditos * self::NUMERO_HORAS_X_CREDITO_MATERIA,
                    'id_carrera' => $estudiante['idescuela'],
                    'titulo_pasantia' => $practica->titulo,
                    'id_periodo' => $estudiante['idperiodo'],
                    'id_materia_unica' => $datos_sql->idmateria_unica,
                    'id_malla' => $estudiante['idmalla'],
                    'fase' => $fase
                ]);
            } else {
                $pasantia = Pasantia::create([
                    'id_pasante' => $estudiante['id_personal'],
                    'id_empresa' => $practica->empresa_id,
                    'id_carrera' => $estudiante['idescuela'],
                    'id_periodo' => $estudiante['idperiodo'],
                    'id_malla' => $estudiante['idmalla'],
                    'titulo_pasantia' => $practica->titulo
                ]);
            }

            $estudiante_practica->pasantia_id = $pasantia->id_pasantia;

            $estudiante_practica->save();
        } catch (\Throwable $th) {
            add_error('No es posible reservar una misma oferta de practica mas de una vez');

            return redirect()->route('estudiantes_practicas.index');
        }


        return redirect()->route('estudiantes_practicas.index')
            ->with('status', 'Has reservado un cupo para esta oferta de PPP');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EstudiantePractica  $estudiantePractica
     * @return \Illuminate\Http\Response
     */
    public function show(EstudiantePractica $estudiantePractica)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EstudiantePractica  $estudiantePractica
     * @return \Illuminate\Http\Response
     */
    public function destroy(EstudiantePractica $estudiante_practica)
    {
        $this->authorize('pass', $estudiante_practica);

        $pasantia = $estudiante_practica->pasantia;

        if ($pasantia->estado != 0) {
            add_error('No es posible eliminar su solicitud no tiene estado de pendiente');

            return redirect()->route('estudiantes_practicas.index');
        }

        if ($pasantia->horarios->count() > 0) {
            $pasantia->horarios()->delete();
        }

        $estudiante_practica->pasantia_id = null;
        $estudiante_practica->save();

        $pasantia->delete();

        $practica = $estudiante_practica->practica;

        $estudiante_practica->delete();

        if ($practica->estudiantes_practicas->count() < $practica->cupo) {
            $practica->visible = true;
            $practica->save();
        }

        return redirect()->route('estudiantes_practicas.index')
            ->with('status', 'Has eliminado tu cupo para esta oferta de PPP');
    }


    public function show_practica_details(EstudiantePractica $estudiante_practica)
    {
        $this->authorize('pass', $estudiante_practica);

        $estudiante = get_session_estudiante();

        $practica = $estudiante_practica->practica;

        return view('estudiantes_practicas.show_practica_details')
            ->with('practica', $practica)
            ->with('estudiante', $estudiante);
    }

    public function show_empresa_contact_info(EstudiantePractica $estudiante_practica)
    {
        $this->authorize('pass', $estudiante_practica);

        $estudiante = get_session_estudiante();

        $empresa = $estudiante_practica->practica->empresa;

        $sql_location = '
            select provincia.nombre as "provincia", canton.nombre as "canton", parroquia.nombre as "parroquia"
            from view_provincia provincia inner join view_canton canton on canton.idprovincia = provincia.idprovincia
                inner join view_parroquia parroquia on parroquia.idcanton = canton.idcanton
            where provincia.idprovincia = :idprovincia
                and canton.idcanton = :idcanton
                and parroquia.idparroquia = :idparroquia
        ';

        // dd($empresa->id_provincia);

        $location = DB::connection('DB_ppp_sistema_SCHEMA_public')->select($sql_location, [
            'idprovincia' => $empresa->id_provincia,
            'idcanton' => $empresa->id_canton,
            'idparroquia' => $empresa->id_parroquia,
        ])[0];

        return view('estudiantes_practicas.show_empresa_contact_info')
            ->with('empresa', $empresa)
            ->with('estudiante', $estudiante)
            ->with('location', $location);
    }

    public function get_pasantias(Request $request)
    {
        $estudiante = get_session_estudiante();

        $pasantias = Pasantia::where('id_pasante', $estudiante['id_personal'])
            ->latest()->get();

        return view('estudiantes_practicas.pasantias')
            ->with('pasantias', $pasantias)
            ->with('estudiante', $estudiante);;

    }
}
