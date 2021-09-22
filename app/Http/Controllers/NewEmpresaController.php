<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewEmpresaRequest;
use App\NewEmpresa;
use App\NewPersonalExterno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewEmpresaController extends Controller
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
        $areas = PracticaController::get_facultades();

        return view('new_empresas.create')
            ->with('areas', $areas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewEmpresaRequest $request)
    {

        // $nuevo_personal_externo = new NewPersonalExterno([
        //     'cedula' => $request->cedula,
        //     'apellido_p' => $request->apellido_p,
        //     'apellido_m' => $request->apellido_m,
        //     'nombres' => $request->nombres,
        //     'titulo' => $request->titulo,
        //     'genero' => $request->genero
        // ]);

        // $nuevo_personal_externo->save();

        NewEmpresa::create([
            'ruc' => $request->ruc,
            'nombre_empresa' => strtoupper($request->nombre_empresa),
            'id_provincia' => $request->provincia,
            'id_canton' => $request->canton,
            'id_parroquia' => $request->parroquia,
            'direccion' => strtoupper($request->direccion),
            'email' => strtolower($request->email),
            'telefono' => $request->telefono,
            'descripcion' => $request->descripcion,
            'area' => $request->area,
            'tipo' => $request->tipo,
            'id_representante' => NewPersonalExterno::create([
                'cedula' => $request->cedula,
                'apellido_p' => strtoupper($request->apellido_p),
                'apellido_m' => strtoupper($request->apellido_m),
                'nombres' => strtoupper($request->nombres),
                'titulo' => strtoupper($request->titulo),
                'genero' => $request->genero
            ])->id
        ]);

        return redirect()->route('landing');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NewEmpresa  $newEmpresa
     * @return \Illuminate\Http\Response
     */
    public function show(NewEmpresa $newEmpresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NewEmpresa  $newEmpresa
     * @return \Illuminate\Http\Response
     */
    public function edit(NewEmpresa $newEmpresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NewEmpresa  $newEmpresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewEmpresa $newEmpresa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NewEmpresa  $newEmpresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewEmpresa $newEmpresa)
    {
        //
    }
}
