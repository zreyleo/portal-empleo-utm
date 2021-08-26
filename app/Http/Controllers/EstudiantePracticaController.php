<?php

namespace App\Http\Controllers;

use App\EstudiantePractica;
use App\Practica;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        return view('estudiantes.estudiantes_practicas')
            ->with('estudiantes_practicas', $estudiantes_practicas)
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
                return redirect()->route('estudiantes.practicas_offers');
            }
        }

        try {
            EstudiantePractica::create([
                'estudiante_id' => $estudiante['id_personal'],
                'practica_id' => $practica->id,
            ]);
        } catch (\Throwable $th) {
            add_error('No es posible reservar una misma oferta de practica mas de una vez');
            return redirect()->route('estudiantes.practicas_offers');
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\EstudiantePractica  $estudiantePractica
     * @return \Illuminate\Http\Response
     */
    public function edit(EstudiantePractica $estudiantePractica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EstudiantePractica  $estudiantePractica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EstudiantePractica $estudiantePractica)
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
}
