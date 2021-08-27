<?php

namespace App\Http\Controllers;

use App\Empleo;
use App\EstudianteEmpleo;
use Illuminate\Http\Request;

class EstudianteEmpleoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estudiante = get_session_estudiante();

        $estudiantes_empleos = EstudianteEmpleo::where('estudiante_id', $estudiante['id_personal'])
            ->latest()->get();

        return view('estudiantes.estudiantes_empleos')
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
            return redirect()->route('estudiantes.empleos_offers');
        }

        return redirect()->route('estudiantes_empleos.index');
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

        return redirect()->route('estudiantes_empleos.index');
    }
}
