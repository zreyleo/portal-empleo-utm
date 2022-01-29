<?php

namespace App\Http\Controllers;

use App\Empleo;
use App\Empresa;
use App\Escuela;
use App\EstudianteEmpleo;
use App\Facultad;
use App\Http\Requests\EmpleoStoreRequest;
use App\Http\Requests\EmpleoUpdateRequest;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class EmpleoController extends Controller
{
    public static function get_carreras()
    {
        $sql = 'select idescuela, es.nombre as "nombre_carrera", titulo_academico_m, fa.nombre as "nombre_facultad", fa.idfacultad as "idfacultad"
        from esq_inscripciones.escuela es
        INNER JOIN esq_inscripciones.facultad fa on es.idfacultad = fa.idfacultad
        where titulo_academico_m is not null';

        // $sql = 'select facultad.idfacultad, facultad.nombre from esq_inscripciones.facultad where facultad.idfacultad < 11';

        $carreras = DB::connection('DB_db_sga_SCHEMA_esq_inscripciones')->select($sql);

        return $carreras;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresa_data = EmpresaController::get_empresa_data();

        $empresa = Empresa::find($empresa_data['id_empresa']);

        // dd($empresa);
        $empleos = $empresa->empleos;

        // dd($empleos);

        return view('empleos.index')
            ->with('empresa', $empresa_data)
            ->with('empleos', $empleos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carreras = self::get_carreras();

        return view('empleos.create')
            ->with('carreras', $carreras)
            ->with('empresa', EmpresaController::get_empresa_data());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpleoStoreRequest $request)
    {
        $empresa = EmpresaController::get_empresa_data();

        Empleo::create([
            'titulo' => $request['titulo'],
            'requerimientos' => $request['requerimientos'],
            'carrera_id' => $request['carrera'],
            'empresa_id' => $empresa['id_empresa']
        ]);

        return redirect()->route('empleos.index')
            ->with('status', 'Se ha creado una oferta de trabajo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empleo  $empleo
     * @return \Illuminate\Http\Response
     */
    public function show(Empleo $empleo)
    {
        $this->authorize('pass', $empleo);

        $empresa = get_session_empresa();

        $escuela = $empleo->escuela;

        $carrera = $escuela ? $escuela->nombre : '';


        return view('empleos.show')
            ->with('empleo', $empleo)
            ->with('carrera', $carrera)
            ->with('empresa', $empresa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empleo  $empleo
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleo $empleo)
    {
        $this->authorize('pass', $empleo);
        $empresa = get_session_empresa();

        // if ($empresa['id_empresa'] != $empleo->empresa_id) {
        //     abort(403);
        // }

        $carreras = self::get_carreras();

        return view('empleos.edit')
            ->with('empresa', $empresa)
            ->with('carreras', $carreras)
            ->with('empleo', $empleo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empleo  $empleo
     * @return \Illuminate\Http\Response
     */
    public function update(EmpleoUpdateRequest $request, Empleo $empleo)
    {
        $this->authorize('pass', $empleo);

        // $data = $request->validate([
        //     'titulo' => 'required|min:8',
        //     'requerimientos' => 'required',
        //     'carrera' => 'required'
        // ]);

        $empleo->titulo = $request['titulo'];
        $empleo->requerimientos = $request['requerimientos'];
        $empleo->carrera_id = $request['carrera'];

        $empleo->save();

        return redirect()->route('empleos.edit', $empleo->id)
            ->with('status', 'Se ha editado esta oferta de trabajo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empleo  $empleo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleo $empleo)
    {
        $this->authorize('pass', $empleo);

        $empleo->delete();

        return redirect()->route('empleos.index')
            ->with('status', 'Se ha eliminado esta oferta de trabajo');
    }

    public function show_empleos_offers()
    {
        $estudiante = get_session_estudiante();

        $escuela = Escuela::find($estudiante['idescuela']);

        // dd($escuela);

        $empleos = $escuela->empleos;

        return view('empleos.show_empleos_offers')
            ->with('estudiante', $estudiante)
            ->with('escuela', $escuela)
            ->with('empleos', $empleos);
    }

    public function show_empleo_details(Empleo $empleo)
    {
        $estudiante = get_session_estudiante();

        return view('empleos.show_empleo_details')
            ->with('empleo', $empleo)
            ->with('estudiante', $estudiante);
    }

    public function show_estudiantes_empleos(Empleo $empleo)
    {
        $this->authorize('pass', $empleo);

        $empresa = get_session_empresa();

        // dd($empleo->estudiantes_empleos->all());

        $estudiantes_empleos = array_filter($empleo->estudiantes_empleos->all(), function ($estudiante_empleo) {
            return $estudiante_empleo->estado != EstudianteEmpleoController::get_rechazado();
        });

        return view('empleos.show_estudiantes_empleos')
            ->with('empleo', $empleo)
            ->with('estudiantes_empleos', $estudiantes_empleos)
            ->with('empresa', $empresa);
    }

    public function responsables_empleo() {
        $docente = get_session_docente();

        $id_facultad = $docente['id_facultad'];

        $facultad = Facultad::find($id_facultad);

        $escuelas = $facultad->escuelas->filter(function ($escuela) {
            if ($escuela->nomenclatura && $escuela->titulo_academico_m) {
                return true;
            } else {
                return false;
            }
        });

        return view('empleos.responsables')
            ->with('docente', $docente)
            ->with('facultad', $facultad)
            ->with('escuelas', $escuelas);
    }
}
