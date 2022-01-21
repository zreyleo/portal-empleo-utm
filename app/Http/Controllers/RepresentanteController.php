<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Http\Resources\RepresentanteResource;
use App\Personal;
use App\PersonalExterno;
use Illuminate\Http\Request;

class RepresentanteController extends Controller
{
    public function index()
    {

    }

    public function buscar($cedula)
    {
        $personalExterno = PersonalExterno::where('cedula', $cedula)->get()->first();

        $representante = new RepresentanteResource($personalExterno);

        return $representante;
    }

    public function buscar_personal($cedula)
    {
        $personal = Personal::where('cedula', $cedula)->get()->first();

        return $personal;
    }

    public function registrar(Request $request)
    {
        $empresa = get_session_empresa();

        $representante = PersonalExterno::create([
            'cedula' => $request->cedula,
            'nombres' => strtoupper($request->nombres),
            'apellido1' => strtoupper($request->apellido1),
            'apellido2' => strtoupper($request->apellido2),
            'titulo' => strtoupper($request->titulo),
            'genero' => strtoupper($request->genero)
        ]);

        $empresa_registro = Empresa::find($empresa['id_empresa']);

        $empresa_registro->id_representante = $representante->id_personal_externo;

        $empresa_registro->save();

        return response()->json();
    }

    public function actualizar(Request $request)
    {
        $empresa = get_session_empresa();

        $empresa_registro = Empresa::find($empresa['id_empresa']);

        $empresa_registro->id_representante = $request->id_personal_externo;

        $empresa_registro->save();

        return response()->json();
    }
}
