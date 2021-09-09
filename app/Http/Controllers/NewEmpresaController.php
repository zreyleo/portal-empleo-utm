<?php

namespace App\Http\Controllers;

use App\NewEmpresa;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
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
