<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Practica;

use App\Http\Requests\PracticaStoreRequest;
use App\Http\Requests\PracticaUpdateRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class PracticaController extends Controller
{
    public static function get_facultades()
    {
        $sql = 'select idfacultad, nombre
            from facultad
            where idfacultad <= 12';
        $facultades = DB::connection('DB_db_sga_SCHEMA_esq_inscripciones')->select($sql);
        return $facultades;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresa_data = get_session_empresa();
        $empresa = Empresa::find($empresa_data['id_empresa']);

        $practicas = $empresa->practicas;

        return view('practicas.index')
            ->with('empresa', $empresa_data)
            ->with('practicas', $practicas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresa = get_session_empresa();

        $facultades = self::get_facultades();

        return view('practicas.create')
            ->with('facultades', $facultades)
            ->with('empresa', $empresa);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PracticaStoreRequest $request)
    {
        $empresa = get_session_empresa();

        Practica::create([
            'titulo' => $request['titulo'],
            'facultad_id' => $request['area'],
            'requerimientos' => $request['requerimientos'],
            'empresa_id' => $empresa['id_empresa']
        ]);

        return redirect()->route('practicas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Practica  $practica
     * @return \Illuminate\Http\Response
     */
    public function show(Practica $practica)
    {
        $this->authorize('pass', $practica);

        $empresa = get_session_empresa();

        return view('practicas.show')
            ->with('practica', $practica)
            ->with('empresa', $empresa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Practica  $practica
     * @return \Illuminate\Http\Response
     */
    public function edit(Practica $practica)
    {
        $this->authorize('pass', $practica);

        $empresa = get_session_empresa();

        $facultades = self::get_facultades();

        return view('practicas.edit')
            ->with('practica', $practica)
            ->with('facultades', $facultades)
            ->with('empresa', $empresa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Practica  $practica
     * @return \Illuminate\Http\Response
     */
    public function update(PracticaUpdateRequest $request, Practica $practica)
    {
        $this->authorize('pass', $practica);

        $practica->titulo = $request->titulo;
        $practica->requerimientos = $request->requerimientos;
        $practica->facultad_id = $request->area;

        $practica->save();

        return redirect()->route('practicas.edit', $practica);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Practica  $practica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Practica $practica)
    {
        $this->authorize('pass', $practica);

        $practica->delete();

        return redirect()->route('practicas.index');
    }

    public function practicas_offers_for_estudiantes()
    {
        $estudiante = get_session_estudiante();

        $practicas = Practica::where('facultad_id', $estudiante['idfacultad'])->latest()->get();

        return view('estudiantes.practicas')
            ->with('practicas', $practicas)
            ->with('estudiante', $estudiante);
    }

    public function practica_details_for_estudiante(Practica $practica)
    {
        $estudiante = get_session_estudiante();

        return view('estudiantes.practica_details')
            ->with('practica', $practica)
            ->with('estudiante', $estudiante);
    }
}
