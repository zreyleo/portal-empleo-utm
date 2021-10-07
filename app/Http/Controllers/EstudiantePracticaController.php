<?php

namespace App\Http\Controllers;

use App\EstudiantePractica;
use App\Practica;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstudiantePracticaController extends Controller
{
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
        // dd($practica);

        $estudiante = get_session_estudiante();

        // dd($practica);

        if (EstudiantePractica::where('estudiante_id', $estudiante['id_personal'])->get()->count() > 0) {
            $last_estudiante_practica = EstudiantePractica::where('estudiante_id', $estudiante['id_personal'])
                ->latest()->get()[0];

            $date_last_estudiante_practica = Carbon::create($last_estudiante_practica->created_at->format('d.m.Y'));

            if ($date_last_estudiante_practica->addMonth()->greaterThan(now())) {
                add_error('No es posible reservar otro cupo de una practica hasta despues de un mes');

                return redirect()->route('estudiantes_practicas.index');
            }
        }

        try {
            EstudiantePractica::create([
                'estudiante_id' => $estudiante['id_personal'],
                'practica_id' => $practica->id,
            ]);
        } catch (\Throwable $th) {
            add_error('No es posible reservar una misma oferta de practica mas de una vez');
        }


        return redirect()->route('estudiantes_practicas.index');
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

        $estudiante_practica->delete();

        return redirect()->route('estudiantes_practicas.index');
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
}
