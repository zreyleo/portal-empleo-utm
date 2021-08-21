<?php

namespace App\Http\Controllers;

use App\Empleo;

use App\Http\Requests\EmpleoStoreRequest;

use Illuminate\Http\Request;

class EmpleoController extends Controller
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
        //
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
            'carrera_id' => $request['carrera_id'],
            'empresa_id' => $empresa['id_empresa']
        ]);

        return redirect()->route('empleos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empleo  $empleo
     * @return \Illuminate\Http\Response
     */
    public function show(Empleo $empleo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empleo  $empleo
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleo $empleo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empleo  $empleo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleo $empleo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empleo  $empleo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleo $empleo)
    {
        //
    }
}
