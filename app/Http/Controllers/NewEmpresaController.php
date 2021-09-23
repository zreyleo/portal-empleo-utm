<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Http\Requests\StoreNewEmpresaRequest;
use App\NewEmpresa;
use App\NewPersonalExterno;
use App\PersonalExterno;
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
        $docente = get_session_docente();

        $nuevas_empresas = NewEmpresa::where([
            ['area', '=', $docente['id_facultad']],
            ['estado', '=', '1'],
        ])->latest()->get();

        return view('new_empresas.index')
            ->with('docente', $docente)
            ->with('nuevas_empresas', $nuevas_empresas);
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
    public function show(NewEmpresa $empresa)
    {
        $docente = get_session_docente();

        $sql_location = '
            select provincia.nombre as "provincia", canton.nombre as "canton", parroquia.nombre as "parroquia"
            from view_provincia provincia inner join view_canton canton on canton.idprovincia = provincia.idprovincia
                inner join view_parroquia parroquia on parroquia.idcanton = canton.idcanton
            where provincia.idprovincia = :idprovincia
                and canton.idcanton = :idcanton
                and parroquia.idparroquia = :idparroquia
        ';

        // dd($empresa->id_provincia);

        $location = DB::connection('DB_ppp_sistema_SCHEMA_public')->select($sql_location, [
            'idprovincia' => $empresa->id_provincia,
            'idcanton' => $empresa->id_canton,
            'idparroquia' => $empresa->id_parroquia,
        ])[0];

        return view('new_empresas.show')
            ->with('empresa', $empresa)
            ->with('location', $location)
            ->with('docente', $docente);
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

    public function register(NewEmpresa $nueva_empresa)
    {
        $docente = get_session_docente();

        // dd($nueva_empresa);

        $nuevo_personal_externo = $nueva_empresa->representante;

        $personal_externo = PersonalExterno::create([
            'cedula' => $nuevo_personal_externo->cedula,
            'nombres' => $nuevo_personal_externo->nombres,
            'apellido1' => $nuevo_personal_externo->apellido_p,
            'apellido2' => $nuevo_personal_externo->apellido_m,
            'titulo' => $nuevo_personal_externo->titulo,
            'genero' => $nuevo_personal_externo->genero
        ]);

        $password = bcrypt($nueva_empresa->ruc);

        Empresa::create([
            'nombre_empresa' => $nueva_empresa->nombre_empresa,
            'id_provincia' => $nueva_empresa->id_provincia,
            'id_canton' => $nueva_empresa->id_canton,
            'id_parroquia' => $nueva_empresa->id_parroquia,
            'direccion' => $nueva_empresa->direccion,
            'id_representante' => $personal_externo->id_personal_externo,
            'tipo' => $nueva_empresa->tipo,
            'telefono' => $nueva_empresa->telefono,
            'email' => $nueva_empresa->email,
            'password' => $password,
            'ruc' => $nueva_empresa->ruc,
            'descripcion' => $nueva_empresa->descripcion,
            'area' => $nueva_empresa->area,
            'registrado_por' => $docente['id_personal']
        ]);

        $nueva_empresa->estado = 0;

        $nueva_empresa->save();

        return redirect()->route('new_empresas.index');
    }
}
