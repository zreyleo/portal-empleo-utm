<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Escuela;
use App\Facultad;
use App\Http\Requests\StoreNewEmpresaRequest;
use App\Http\Requests\UpdateNewEmpresaRequest;
use App\Jobs\SendNewEmpresaRegistrationEmail;
use App\NewEmpresa;
use App\NewPersonalExterno;
use App\Personal;
use App\PersonalExterno;
use App\PersonalRol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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

        $nombre_empresa = strtoupper($request->nombre_empresa);

        dispatch(new SendNewEmpresaRegistrationEmail($nombre_empresa, (int) $request->area))
            ->afterResponse();

        return redirect()->route('landing')->with('status', 'Se han enviado sus datos, sera notificado pronto');
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

        // prevenir que un docente edite una empresa que no le compete a su facultad
        if ($empresa->area != $docente['id_facultad']) {
            Session::flush();
            return redirect()->route('login.responsables_get');
        }

        if ($empresa->estado != 1) {
            return redirect()->route('new_empresas.index');
        }

        $sql_location = '
            select provincia.nombre as "provincia", canton.nombre as "canton", parroquia.nombre as "parroquia"
            from view_provincia provincia inner join view_canton canton on canton.idprovincia = provincia.idprovincia
                inner join view_parroquia parroquia on parroquia.idcanton = canton.idcanton
            where provincia.idprovincia = :idprovincia
                and canton.idcanton = :idcanton
                and parroquia.idparroquia = :idparroquia
        ';

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
    public function edit(NewEmpresa $empresa)
    {
        $docente = get_session_docente();

        // prevenir que un docente edite una empresa que no le compete a su facultad
        if ($empresa->area != $docente['id_facultad']) {
            Session::flush();
            return redirect()->route('login.responsables_get');
        }

        $representante = $empresa->representante;

        $areas = PracticaController::get_facultades();

        return view('new_empresas.edit')
            ->with('docente', $docente)
            ->with('representante', $representante)
            ->with('areas', $areas)
            ->with('empresa', $empresa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NewEmpresa  $newEmpresa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewEmpresaRequest $request, NewEmpresa $empresa)
    {
        $docente = get_session_docente();

        // prevenir que un docente edite una empresa que no le compete a su facultad
        if ($empresa->area != $docente['id_facultad']) {
            Session::flush();
            return redirect()->route('login.responsables_get');
        }

        // actualizar informacion del representante
        $representante = $empresa->representante;

        $representante->cedula = $request['cedula'];
        $representante->apellido_p = $request['apellido_p'];
        $representante->apellido_m = $request['apellido_m'];
        $representante->nombres = $request['nombres'];
        $representante->titulo = $request['titulo'];
        $representante->genero = $request['genero'];

        // dd($representante);
        $representante->save();

        $empresa->ruc = $request['ruc'];
        $empresa->nombre_empresa = $request['nombre_empresa'];
        $empresa->id_provincia = $request['provincia'];
        $empresa->id_canton = $request['canton'];
        $empresa->id_parroquia = $request['parroquia'];
        $empresa->direccion = $request['direccion'];
        $empresa->email = $request['email'];
        $empresa->telefono = $request['telefono'];
        $empresa->descripcion = $request['descripcion'];
        $empresa->area = $request['area'];
        $empresa->tipo = $request['tipo'];

        $empresa->save();

        return redirect()->route('new_empresas.edit', ['empresa' => $empresa->id_empresa])
            ->with('status', 'Se ha editado informacion con exito');
    }

    public function reject(NewEmpresa $empresa)
    {
        $docente = get_session_docente();

        // prevenir que un docente edite una empresa que no le compete a su facultad
        if ($empresa->area != $docente['id_facultad']) {
            Session::flush();
            return redirect()->route('login.responsables_get');
        }

        return view('new_empresas.reject')
            ->with('docente', $docente)
            ->with('empresa', $empresa);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NewEmpresa  $newEmpresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, NewEmpresa $empresa)
    {
        $request->validate([
            'comentario' => 'required'
        ]);

        $docente = get_session_docente();


        // prevenir que un docente edite una empresa que no le compete a su facultad
        if ($empresa->area != $docente['id_facultad']) {
            Session::flush();
            return redirect()->route('login.responsables_get');
        }

        $empresa->comentario = "La empresa registrada $empresa->nombre_empresa es rechazada por: $request->comentario";
        $empresa->actulizacion_por = $docente['id_personal'];
        $empresa->email = null;
        $empresa->telefono = null;
        $empresa->nombre_empresa = null;
        $empresa->estado = 0;

        $empresa->save();

        return redirect()->route('new_empresas.index')->with('status', 'Se ha rechazado una empresa');
    }

    public function register(NewEmpresa $nueva_empresa)
    {
        $docente = get_session_docente();

        // prevenir que un docente registre una empresa que no le compete a su facultad
        if ($nueva_empresa->area != $docente['id_facultad']) {
            Session::flush();
            return redirect()->route('login.responsables_get');
        }

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

        if (Empresa::where([
            ['email', '=', strtolower($nueva_empresa->email)],
            ['registrado_por', '=', null]
        ])->get()->count() > 0) {
            $empresas = Empresa::where('email', strtolower($nueva_empresa->email))->get();

            foreach ($empresas as $empresa) {
                $empresa->email = $empresa->email . '@sinuso';
                $empresa->save();
            }
        }

        Empresa::create([
            'nombre_empresa' => $nueva_empresa->nombre_empresa,
            'id_provincia' => $nueva_empresa->id_provincia,
            'id_canton' => $nueva_empresa->id_canton,
            'id_parroquia' => $nueva_empresa->id_parroquia,
            'direccion' => $nueva_empresa->direccion,
            'id_representante' => $personal_externo->id_personal_externo,
            'tipo' => $nueva_empresa->tipo,
            'telefono' => $nueva_empresa->telefono,
            'email' => strtolower($nueva_empresa->email),
            'password' => $password,
            'ruc' => $nueva_empresa->ruc,
            'descripcion' => $nueva_empresa->descripcion,
            'area' => $nueva_empresa->area,
            'registrado_por' => $docente['id_personal']
        ]);

        $nueva_empresa->estado = 0;

        $nueva_empresa->save();

        enviar_correo(
            "$nueva_empresa->email",
            "Registro exitoso en la UTM",
            "
                $nueva_empresa->nombre_empresa ha sido registrado exitosamente en la UTM y puede comenzar a publicar empleos
                USUARIO es el EMAIL que registro el PASSWORD es el RUC que registro, recuerde cambiar el password.
            "
        );

        return redirect()->route('new_empresas.index')
            ->with('status', 'Se ha registrado una nueva empresa');
    }
}
