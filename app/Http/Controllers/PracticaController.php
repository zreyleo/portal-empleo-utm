<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Facultad;
use App\Practica;

use App\Http\Requests\PracticaStoreRequest;
use App\Http\Requests\PracticaUpdateRequest;
use App\Jobs\AnularPasantiaJob;
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
            'cupo' => $request['cupo'],
            'requerimientos' => $request['requerimientos'],
            'empresa_id' => $empresa['id_empresa']
        ]);

        return redirect()->route('practicas.index')
            ->with('status', 'Se ha creado una oferta de practica pre profesional');
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
        $practica->cupo = $request->cupo;
        $practica->facultad_id = $request->area;

        $practica->save();

        return redirect()->route('practicas.edit', $practica)
            ->with('status', 'Se ha editado una oferta de practica pre profesional');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Practica  $practica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Practica $practica)
    {
        $this->authorize('pass', $practica);

        $empresa = get_session_empresa();

        if($practica->estudiantes_practicas->count()) {
            if ($practica->pasantias->contains('estado', '>', 0)) {
                add_error('Hay estudiantes realizando actividades en su institucion');

                return redirect()->route('practicas.index');
            } else {
                dispatch(
                    new AnularPasantiaJob(
                        $practica->pasantias,
                        $empresa['nombre_empresa'],
                        $practica->titulo,
                        $request->detalle
                    )
                )->afterResponse();
            }
        }

        $practica->delete();

        return redirect()->route('practicas.index')
            ->with('status', 'Se ha eliminado esta oferta de PPP');
    }

    public function anular(Practica $practica)
    {
        $this->authorize('pass', $practica);

        $empresa = get_session_empresa();

        return view('practicas.anular')
            ->with('practica', $practica)
            ->with('empresa', $empresa);
    }

    public function show_practicas_offers()
    {
        $estudiante = get_session_estudiante();

        $practicas = Practica::where([
            ['facultad_id', '=', $estudiante['idfacultad']],
            ['visible', '=', true]
        ])->latest()->get();

        // dd($practicas);

        return view('practicas.show_practicas_offers')
            ->with('practicas', $practicas)
            ->with('estudiante', $estudiante);
    }

    public function show_practica_details(Practica $practica)
    {
        $estudiante = get_session_estudiante();

        return view('practicas.show_practica_details')
            ->with('practica', $practica)
            ->with('estudiante', $estudiante);
    }

    public function responsables_practicas()
    {
        $docente = get_session_docente();

        $id_facultad = $docente['id_facultad'];

        $facultad = Facultad::find($id_facultad);

        $practicas = $facultad->practicas;

        return view('practicas.responsables')
            ->with('practicas', $practicas)
            ->with('docente', $docente);
    }

    public function responsables_practicas_ver_detalles(Practica $practica)
    {
        $docente = get_session_docente();

        return view('practicas.responsable_ver_detalles')
            ->with('practica', $practica)
            ->with('docente', $docente);
    }
}
