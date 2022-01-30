<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Empresa;
use App\Http\Requests\StoreDepartamentoRequest;
use App\Personal;
use App\PersonalExterno;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DepartamentoController extends Controller
{
    private const DEFAULT_PASSWORD = 'PortalEmpleo2021';

    public function solicitar_registro()
    {
        return view('departamentos.solicitar_registro');
    }

    public function solicitar_registro_post(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);

        if (!str_ends_with($request->email, '@utm.edu.ec')) {
            add_error('Este correo no pertenece a la UTM');

            return redirect()->route('login.departamentos_get');
        }

        $personal = Personal::where('correo_personal_institucional', $request->email)->get();

        if ($personal->count()) {
            add_error('Este correo pertenece a un personal de la UTM');

            return redirect()->route('login.departamentos_get');
        }

        $departamento = Empresa::where('email', $request->email)->get()->first();

        if ($departamento) {
            add_error('Este correo ya está habilitado, prosiga a recuperar password');

            return redirect()->route('login.departamentos_get');
        }

        $tokenData  = DB::table('departamento_registration')->where('email', $request->email)->get()->first();

        if ($tokenData) {
            if ($tokenData->creado) {
                add_error('Este correo ya está habilitado, prosiga a recuperar password');

                return redirect()->route('login.empresas_get');
            } else {
                DB::table('departamento_registration')
                    ->where('email', $request->email)->delete();
            }
        }

        $token = Str::random(60);

        DB::table('departamento_registration')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $enlace = env('APP_URL') . '/registro_departamento/' . $token;

        $mensaje = "El enlace para registrar el departamento es " . $enlace . ", si no envio esta peticion haga caso omiso.";

        enviar_correo(
            $request->email,
            "Habilitar Departamento Interno para el Portal Empleo UTM",
            $mensaje
        );

        return redirect()->route('login.departamentos_get')
            ->with('status', 'Se ha enviado un enlace para habilitar su departamento al correo que escribió');
    }

    public function registro_departamento_get($token)
    {
        $tokenData  = DB::table('departamento_registration')->where('token', $token)->get()->first();

        if (!$tokenData) {
            add_error('Enlace no valido');

            return redirect()->route('login.departamentos_get');
        }

        return view('departamentos.habilitar')
            ->with('email', $tokenData->email)
            ->with('token', $token);
    }

    public function registro_departamento_post(Request $request, $token)
    {
        // return $request->all();

        $personalExternoId = null;
        $personal = null;

        if (PersonalExterno::where('cedula', $request->cedula)->get()->count() > 0) {
            $personal = PersonalExterno::where('cedula', $request->cedula)->get()[0];

            $personalExternoId = $personal->id_personal_externo;
        } else {
            $personalExternoId = PersonalExterno::create([
                'cedula' => $request->cedula,
                'apellido1' => strtoupper($request->apellido1),
                'apellido2' => strtoupper($request->apellido2),
                'nombres' => strtoupper($request->nombres),
                'titulo' => 'FUNCIONARIO UTM',
                'genero' => $request->genero
            ])->id_personal_externo;
        }



        $departamento = new Departamento();

        $departamento->nombre_empresa = strtoupper($request->nombreDepartamento);
        $departamento->email = strtolower($request->email);
        $departamento->id_provincia = 13;
        $departamento->id_canton = 1;
        $departamento->id_parroquia = 1;
        $departamento->direccion = 'AVENIDA URBINA';
        $departamento->id_representante = $personalExternoId;
        $departamento->telefono = '053-701-695';


        $departamento->departamento_interno = true;

        $departamento->password = Hash::make(self::DEFAULT_PASSWORD);

        $departamento->save();

        DB::table('departamento_registration')
            ->where('token', $token)->delete();

        $mensaje = "
            El departamento {$request->nombreDepartamento} está habilitado para publicar ofertas de
            prácticas pre profesionales, recuerde que la clave para acceder por primera vez es PortalEmpleo2021
        ";

        enviar_correo($request->email, 'Departamento Habilitado para el Portal de Empleo UTM', $mensaje);

        return response()->json([], 201);
    }

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
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'cedula' => 'required',
            'apellido1' => 'required',
            'apellido2' => 'required',
            'nombres' => 'required',
            'genero' => 'required',
            'nombre_empresa' => 'required'
        ]);

        if (!str_ends_with($request->email, '@utm.edu.ec')) {
            add_error('Este correo no pertenece a la UTM');

            return redirect()->route('departamentos.create');
        }

        $personal = Personal::where('correo_personal_institucional', $request->email)->get();

        if ($personal->count()) {
            add_error('Este correo pertenece a un personal de la UTM');

            return redirect()->route('departamentos.create');
        }

        $departamento = Empresa::where('email', $request->email)->get()->first();

        if ($departamento) {
            add_error('Este correo ya está habilitado, prosiga a recuperar password');

            return redirect()->route('departamentos.create');
        }

        $personalExternoId = null;
        $personal = null;

        if (PersonalExterno::where('cedula', $request->cedula)->get()->count() > 0) {
            $personal = PersonalExterno::where('cedula', $request->cedula)->get()[0];

            $personalExternoId = $personal->id_personal_externo;
        } else {
            $personalExternoId = PersonalExterno::create([
                'cedula' => $request->cedula,
                'apellido1' => strtoupper($request->apellido1),
                'apellido2' => strtoupper($request->apellido2),
                'nombres' => strtoupper($request->nombres),
                'titulo' => 'FUNCIONARIO UTM',
                'genero' => $request->genero
            ])->id_personal_externo;
        }

        // dd($request->all());

        $departamento = new Departamento();

        $departamento->nombre_empresa = strtoupper($request->nombre_empresa);
        $departamento->email = strtolower($request->email);
        $departamento->id_provincia = 13;
        $departamento->id_canton = 1;
        $departamento->id_parroquia = 2;
        $departamento->direccion = 'AVENIDA URBINA Y CHE GUEVARA';
        $departamento->id_representante = $personalExternoId;

        $departamento->telefono = '053-701-695';

        $departamento->departamento_interno = true;

        $departamento->password = Hash::make(self::DEFAULT_PASSWORD);

        $departamento->save();

        $mensaje = "
            El departamento {$request->nombre_empresa} está habilitado para publicar ofertas de
            prácticas pre profesionales, recuerde que la clave para acceder por primera vez es PortalEmpleo2021
        ";

        enviar_correo($request->email, 'Departamento Habilitado para el Portal de Empleo UTM', $mensaje);

        return redirect()->route('responsables.dashboard')->with('status', 'Se ha registrado un nuevo departamento UTM');
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
