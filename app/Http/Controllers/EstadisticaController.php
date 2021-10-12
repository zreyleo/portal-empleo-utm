<?php

namespace App\Http\Controllers;

use App\Empleo;
use App\Facultad;
use Illuminate\Http\Request;

class EstadisticaController extends Controller
{
    public function empleos()
    {
        $docente = get_session_docente();

        $facultad = Facultad::find($docente['id_facultad']);

        // dd($facultad);

        $num_empleos_facultad = 0;

        $facultad_escuela_max_num_empleos = 0;

        $facultad_escuela_max_empleos = null;

        foreach($facultad->escuelas as $escuela) {
            $num_empleos_facultad += $escuela->empleos->count();
            if ($facultad_escuela_max_num_empleos < $escuela->empleos->count()) {
                $facultad_escuela_max_num_empleos = $escuela->empleos->count();
                $facultad_escuela_max_empleos = $escuela;
            }
        }

        // dd($num_empleos_facultad);

        $num_empleos_total = Empleo::all()->count();

        $universidad_escuela_max_empleos = Empleo::select('carrera_id')
            ->groupBy('carrera_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get()[0]->escuela;

        // dd($universidad_escuela_max_empleos);

        return view(
            'estadisticas.empleos', compact(
                'num_empleos_total',
                'num_empleos_facultad',
                'facultad_escuela_max_empleos',
                'universidad_escuela_max_empleos',
                'facultad'
            )
        )->with('docente', $docente);
    }
}
