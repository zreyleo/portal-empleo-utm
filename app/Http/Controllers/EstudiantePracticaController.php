<?php

namespace App\Http\Controllers;

use App\EstudiantePractica;
use App\Practica;
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

        EstudiantePractica::create([
            'estudiante_id' => $estudiante['id_personal'],
            'practica_id' => $practica->id,
        ]);

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
    public function destroy(EstudiantePractica $estudiantePractica)
    {
        //
    }
}
