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
        return view('new_empresas.create');
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
            'nombre_empresa' => $request->nombre_empresa,
            'id_provincia' => $request->provincia,
            'id_canton' => $request->canton,
            'id_parroquia' => $request->parroquia,
            'direccion' => $request->direccion,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'id_representante' => NewPersonalExterno::create([
                'cedula' => $request->cedula,
                'apellido_p' => $request->apellido_p,
                'apellido_m' => $request->apellido_m,
                'nombres' => $request->nombres,
                'titulo' => $request->titulo,
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
