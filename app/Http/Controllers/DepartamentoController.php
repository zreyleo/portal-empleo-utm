<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Http\Requests\StoreDepartamentoRequest;
use App\PersonalExterno;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $docente = get_session_docente();

        return view('departamentos.create', compact(
            'docente'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartamentoRequest $request)
    {
        $PersonalExternoId = PersonalExterno::create([
            'cedula' => $request->cedula,
            'apellido_p' => strtoupper($request->apellido_p),
            'apellido_m' => strtoupper($request->apellido_m),
            'nombres' => strtoupper($request->nombres),
            'titulo' => strtoupper($request->titulo),
            'genero' => $request->genero
        ])->id;

        $departamento = new Departamento();

        $departamento->nombre_empresa = strtoupper($request->nombre_empresa);
        $departamento->email = strtoupper($request->email);
        $departamento->id_provincia = $request->provincia;
        $departamento->id_canton = $request->canton;
        $departamento->id_parroquia = $request->parroquia;
        $departamento->id_representante = $PersonalExternoId;

        if ($request->telefono) {
            $departamento->telefono = $request->telefono;
        }

        $departamento->save();

        return redirect()->route('responsables.dashboard');

        // NewEmpresa::create([
        //     'ruc' => $request->ruc,
        //     'nombre_empresa' => strtoupper($request->nombre_empresa),
        //     'id_provincia' => $request->provincia,
        //     'id_canton' => $request->canton,
        //     'id_parroquia' => $request->parroquia,
        //     'direccion' => strtoupper($request->direccion),
        //     'email' => strtolower($request->email),
        //     'telefono' => $request->telefono,
        //     'descripcion' => $request->descripcion,
        //     'area' => $request->area,
        //     'tipo' => $request->tipo,
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function show(Departamento $departamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Departamento $departamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departamento $departamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departamento $departamento)
    {
        //
    }
}
