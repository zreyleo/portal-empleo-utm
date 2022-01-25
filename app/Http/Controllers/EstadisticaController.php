<?php

namespace App\Http\Controllers;

use App\Empleo;
use App\EstudianteEmpleo;
use App\EstudiantePractica;
use App\Facultad;
use App\Practica;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticaController extends Controller
{
    private static function get_carrera_estudiantes_empleos_aceptados_count($idescuela)
    {
        $sql =
            "
                select estudiantes_empleos.*, empleos.carrera_id
                from estudiantes_empleos inner join empleos on empleos.id = estudiantes_empleos.empleo_id
                where empleos.carrera_id = $idescuela and estudiantes_empleos.estado = 'ACEPTADO'
            ";

        return count(DB::select($sql));
    }

    private static function get_carrera_estudiantes_empleos_rechazados_count($idescuela)
    {
        $sql =
            "
                select estudiantes_empleos.*, empleos.carrera_id
                from estudiantes_empleos inner join empleos on empleos.id = estudiantes_empleos.empleo_id
                where empleos.carrera_id = $idescuela and estudiantes_empleos.estado = 'RECHAZADO'
            ";

        return count(DB::select($sql));
    }

    private static function get_carrera_estudiantes_empleos_count($idescuela)
    {
        $sql =
            "
                select estudiantes_empleos.*, empleos.carrera_id
                from estudiantes_empleos inner join empleos on empleos.id = estudiantes_empleos.empleo_id
                where empleos.carrera_id = $idescuela
            ";

        return count(DB::select($sql));
    }

    private static function get_facultad_estudiantes_practicas_count($idfacultad)
    {
        $sql =
            "
                select estudiantes_practicas.*, practicas.facultad_id
                from estudiantes_practicas inner join practicas on practicas.id = estudiantes_practicas.practica_id
                where practicas.facultad_id = $idfacultad
            ";

        return count(DB::select($sql));
    }

    public function empleos()
    {
        $docente = get_session_docente();

        $facultad = Facultad::find($docente['id_facultad']);

        // dd($facultad);

        $num_empleos_facultad = 0;

        $facultad_escuela_max_num_empleos = 0;

        $facultad_escuela_max_empleos = null;

        // dd($num_empleos_facultad);

        $num_empleos_total = Empleo::all()->count();

        $universidad_escuela_max_empleos = null;

        if (Empleo::select('carrera_id')
            ->groupBy('carrera_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get()->count() > 0)
        {

            $universidad_escuela_max_empleos = Empleo::select('carrera_id')
            ->groupBy('carrera_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get()[0]->escuela;

        }

        // tener todas las postulaciones
        $all_estudiantes_empleos = EstudianteEmpleo::all()->count();

        // obtener todos los estudiantes que son considerados candidatos
        $all_estudiantes_empleos_aceptado = EstudianteEmpleo::where('estado', 'ACEPTADO')->get();
        $all_estudiantes_empleos_rechazado = EstudianteEmpleo::where('estado', 'RECHAZADO')->get();

        // obtener todos los estudiantes que son considerados candidatos
        $all_empleos = Empleo::all();

        $total_facultad_estudiantes_empleos = 0;
        $total_facultad_estudiantes_empleos_aceptado = 0;
        $total_facultad_estudiantes_empleos_rechazado = 0;

        foreach($facultad->escuelas as $escuela) {
            $total_facultad_estudiantes_empleos += self::get_carrera_estudiantes_empleos_count($escuela->idescuela);

            $total_facultad_estudiantes_empleos_aceptado += self::get_carrera_estudiantes_empleos_aceptados_count($escuela->idescuela);
            $total_facultad_estudiantes_empleos_rechazado += self::get_carrera_estudiantes_empleos_rechazados_count($escuela->idescuela);

            $num_empleos_facultad += $escuela->empleos->count();

            if ($facultad_escuela_max_num_empleos < $escuela->empleos->count()) {
                $facultad_escuela_max_num_empleos = $escuela->empleos->count();
                $facultad_escuela_max_empleos = $escuela;
            }

            // dd($escuela->idescuela);
        }

        // dd($total_facultad_estudiantes_empleos);

        return view(
            'estadisticas.empleos', compact(
                'num_empleos_total',
                'num_empleos_facultad',
                'facultad_escuela_max_empleos',
                'universidad_escuela_max_empleos',
                'facultad',
                'total_facultad_estudiantes_empleos',
                'total_facultad_estudiantes_empleos_aceptado',
                'total_facultad_estudiantes_empleos_rechazado',
                'all_estudiantes_empleos_aceptado',
                'all_estudiantes_empleos_rechazado',
                'all_estudiantes_empleos'
            )
        )->with('docente', $docente);
    }

    public function practicas()
    {
        $docente = get_session_docente();

        $facultad = Facultad::find($docente['id_facultad']);

        $all_practicas_universidad = Practica::all();

        $all_practicas_facultad = $facultad->practicas;

        $estudiantes_practicas_count = EstudiantePractica::all()->count();

        if
        (
            Practica::select('facultad_id')
                ->groupBy('facultad_id')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(1)
                ->get()->count() > 0
        )
        {

            $facultad_max_ppp = Practica::select('facultad_id')
                ->groupBy('facultad_id')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(1)
                ->get()[0]->facultad;

        }

        $facultad_estudiantes_practicas_count = self::get_facultad_estudiantes_practicas_count($facultad->idfacultad);

        return view(
            'estadisticas.practicas',
            compact(
                'facultad',
                'facultad_max_ppp',
                'all_practicas_universidad',
                'all_practicas_facultad',
                'estudiantes_practicas_count',
                'facultad_estudiantes_practicas_count'
            )
        )->with('docente', $docente);
    }

    public function all()
    {
        $docente = get_session_docente();

        $facultad = Facultad::find($docente['id_facultad']);

        $all_practicas_universidad = Practica::all();

        $all_practicas_facultad = $facultad->practicas;

        $estudiantes_practicas_count = EstudiantePractica::all()->count();

        $facultad_max_ppp = null;

        if
        (
            Practica::select('facultad_id')
                ->groupBy('facultad_id')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(1)
                ->get()->count() > 0
        )
        {

            $facultad_max_ppp = Practica::select('facultad_id')
                ->groupBy('facultad_id')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(1)
                ->get()[0]->facultad;

        }

        $facultad_estudiantes_practicas_count = self::get_facultad_estudiantes_practicas_count($facultad->idfacultad);

        // seccion de empleos

        $num_empleos_facultad = 0;

        $facultad_escuela_max_num_empleos = 0;

        $facultad_escuela_max_empleos = null;

        $num_empleos_total = Empleo::all()->count();

        $universidad_escuela_max_empleos = null;

        if (Empleo::select('carrera_id')
            ->groupBy('carrera_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get()->count() > 0)
        {

            $universidad_escuela_max_empleos = Empleo::select('carrera_id')
            ->groupBy('carrera_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get()[0]->escuela;

        }

        // tener todas las postulaciones
        $all_estudiantes_empleos = EstudianteEmpleo::all()->count();

        // obtener todos los estudiantes que son considerados candidatos
        $all_estudiantes_empleos_aceptado = EstudianteEmpleo::where('estado', 'ACEPTADO')->get();
        $all_estudiantes_empleos_rechazado = EstudianteEmpleo::where('estado', 'RECHAZADO')->get();

        // obtener todos los estudiantes que son considerados candidatos
        $all_empleos = Empleo::all();

        $total_facultad_estudiantes_empleos = 0;
        $total_facultad_estudiantes_empleos_aceptado = 0;
        $total_facultad_estudiantes_empleos_rechazado = 0;

        foreach($facultad->escuelas as $escuela) {
            $total_facultad_estudiantes_empleos += self::get_carrera_estudiantes_empleos_count($escuela->idescuela);

            $total_facultad_estudiantes_empleos_aceptado += self::get_carrera_estudiantes_empleos_aceptados_count($escuela->idescuela);
            $total_facultad_estudiantes_empleos_rechazado += self::get_carrera_estudiantes_empleos_rechazados_count($escuela->idescuela);

            $num_empleos_facultad += $escuela->empleos->count();

            if ($facultad_escuela_max_num_empleos < $escuela->empleos->count()) {
                $facultad_escuela_max_num_empleos = $escuela->empleos->count();
                $facultad_escuela_max_empleos = $escuela;
            }
        }

        return view(
            'estadisticas.all',
            compact(
                // practicas
                'facultad',
                'facultad_max_ppp',
                'all_practicas_universidad',
                'all_practicas_facultad',
                'estudiantes_practicas_count',
                'facultad_estudiantes_practicas_count',
                // empleos
                'num_empleos_total',
                'num_empleos_facultad',
                'facultad_escuela_max_empleos',
                'universidad_escuela_max_empleos',
                'total_facultad_estudiantes_empleos',
                'total_facultad_estudiantes_empleos_aceptado',
                'total_facultad_estudiantes_empleos_rechazado',
                'all_estudiantes_empleos_aceptado',
                'all_estudiantes_empleos_rechazado',
                'all_estudiantes_empleos'
            )
        )->with('docente', $docente);
    }

    public function pdf()
    {
        $docente = get_session_docente();

        $facultad = Facultad::find($docente['id_facultad']);

        $all_practicas_universidad = Practica::all();

        $all_practicas_facultad = $facultad->practicas;

        $estudiantes_practicas_count = EstudiantePractica::all()->count();

        $facultad_max_ppp = null;

        if
        (
            Practica::select('facultad_id')
                ->groupBy('facultad_id')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(1)
                ->get()->count() > 0
        )
        {

            $facultad_max_ppp = Practica::select('facultad_id')
                ->groupBy('facultad_id')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(1)
                ->get()[0]->facultad;

        }

        $facultad_estudiantes_practicas_count = self::get_facultad_estudiantes_practicas_count($facultad->idfacultad);

        // seccion de empleos

        $num_empleos_facultad = 0;

        $facultad_escuela_max_num_empleos = 0;

        $facultad_escuela_max_empleos = null;

        $num_empleos_total = Empleo::all()->count();

        $universidad_escuela_max_empleos = null;

        if (Empleo::select('carrera_id')
            ->groupBy('carrera_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get()->count() > 0)
        {

            $universidad_escuela_max_empleos = Empleo::select('carrera_id')
            ->groupBy('carrera_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get()[0]->escuela;

        }

        // tener todas las postulaciones
        $all_estudiantes_empleos = EstudianteEmpleo::all()->count();

        // obtener todos los estudiantes que son considerados candidatos
        $all_estudiantes_empleos_aceptado = EstudianteEmpleo::where('estado', 'ACEPTADO')->get();
        $all_estudiantes_empleos_rechazado = EstudianteEmpleo::where('estado', 'RECHAZADO')->get();

        // obtener todos los estudiantes que son considerados candidatos
        $all_empleos = Empleo::all();

        $total_facultad_estudiantes_empleos = 0;
        $total_facultad_estudiantes_empleos_aceptado = 0;
        $total_facultad_estudiantes_empleos_rechazado = 0;

        foreach($facultad->escuelas as $escuela) {
            $total_facultad_estudiantes_empleos += self::get_carrera_estudiantes_empleos_count($escuela->idescuela);

            $total_facultad_estudiantes_empleos_aceptado += self::get_carrera_estudiantes_empleos_aceptados_count($escuela->idescuela);
            $total_facultad_estudiantes_empleos_rechazado += self::get_carrera_estudiantes_empleos_rechazados_count($escuela->idescuela);

            $num_empleos_facultad += $escuela->empleos->count();

            if ($facultad_escuela_max_num_empleos < $escuela->empleos->count()) {
                $facultad_escuela_max_num_empleos = $escuela->empleos->count();
                $facultad_escuela_max_empleos = $escuela;
            }
        }

        /** @var PDF $pdf */
        $pdf = app('dompdf.wrapper');

        $pdf->loadView('estadisticas.pdf', compact(
            // practicas
            'facultad',
            'facultad_max_ppp',
            'all_practicas_universidad',
            'all_practicas_facultad',
            'estudiantes_practicas_count',
            'facultad_estudiantes_practicas_count',
            // empleos
            'num_empleos_total',
            'num_empleos_facultad',
            'facultad_escuela_max_empleos',
            'universidad_escuela_max_empleos',
            'total_facultad_estudiantes_empleos',
            'total_facultad_estudiantes_empleos_aceptado',
            'total_facultad_estudiantes_empleos_rechazado',
            'all_estudiantes_empleos_aceptado',
            'all_estudiantes_empleos_rechazado',
            'all_estudiantes_empleos'
        ));

        return $pdf->download('estadisticas.pdf');
    }

    public function get_practicas_en_tabla_pdf()
    {
        $docente = get_session_docente();

        $id_facultad = $docente['id_facultad'];

        $facultad = Facultad::find($id_facultad);

        $practicas = $facultad->practicas;

        $fecha_inicio = $practicas[0]->created_at;
        $fecha_fin = $practicas[count($practicas) - 1]->created_at;

        /** @var PDF $pdf */
        $pdf = app('dompdf.wrapper');

        $pdf->loadView('estadisticas.tabla', compact(
            'practicas',
            'fecha_inicio',
            'fecha_fin',
            'facultad'
        ));

        return $pdf->download('estadisticas.tabla');
    }
}
