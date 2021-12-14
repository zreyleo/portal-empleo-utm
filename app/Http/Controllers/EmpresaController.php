<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Http\Requests\UpdateEmpresaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class EmpresaController extends Controller
{
    private const ROLE = 'EMPRESA';

    public static function get_empresa_location($empresa_informacion)
    {
        $sql_location = '
            select provincia.nombre as "provincia", canton.nombre as "canton", parroquia.nombre as "parroquia"
            from view_provincia provincia inner join view_canton canton on canton.idprovincia = provincia.idprovincia
                inner join view_parroquia parroquia on parroquia.idcanton = canton.idcanton
            where provincia.idprovincia = :idprovincia
                and canton.idcanton = :idcanton
                and parroquia.idparroquia = :idparroquia
        ';

        $location = DB::connection('DB_ppp_sistema_SCHEMA_public')->select($sql_location, [
            'idprovincia' => $empresa_informacion->id_provincia,
            'idcanton' => $empresa_informacion->id_canton,
            'idparroquia' => $empresa_informacion->id_parroquia,
        ])[0];

        return $location;
    }

    public static function get_empresa_data()
    {
        $empresa = [
            'id_empresa' => Session::get('id_empresa'),
            'nombre_empresa' => Session::get('nombre_empresa'),
        ];

        return $empresa;
    }

    public static function get_role()
    {
        return self::ROLE;
    }

    public function passwordEdit()
    {
        $empresa = get_session_empresa();

        return view('empresas.password_edit')
            ->with('empresa', $empresa);
    }

    public function passwordUpdate(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required',
        ]);

        $empresa = Empresa::find(get_session_empresa()['id_empresa']);

        if (!Hash::check($data['current_password'], $empresa->password)) {
            add_error("El password actual incorrecto");
            return redirect()->back();
        }

        if ($data['new_password'] != $data['confirm_password']) {
            add_error("No se esta confirmando el nuevo password correctamente");
            return redirect()->back();
        }

        $empresa->password = Hash::make($data['new_password']);

        $empresa->save();

        return redirect()->route('empresas.password_edit')
            ->with('status', 'Exito al cambiar Password');
    }

    public function informacion()
    {
        $empresa = get_session_empresa();

        $empresa_informacion = Empresa::find($empresa['id_empresa']);

        $location = self::get_empresa_location($empresa_informacion);

        $representante = $empresa_informacion->representante;

        return view('empresas.informacion')
            ->with('empresa', $empresa)
            ->with('location', $location)
            ->with('representante', $representante)
            ->with('empresa_informacion', $empresa_informacion);
    }

    public function informacion_edit()
    {
        $empresa = get_session_empresa();

        $empresa_informacion = Empresa::find($empresa['id_empresa']);

        $representante = $empresa_informacion->representante;

        return view('empresas.informacion_edit')
            ->with('representante', $representante)
            ->with('empresa_informacion', $empresa_informacion)
            ->with('empresa', $empresa);
    }

    public function informacion_update(UpdateEmpresaRequest $request)
    {
        $empresa = Empresa::find(get_session_empresa()['id_empresa']);

        $representante = $empresa->representante;

        $representante->apellido1 = strtoupper($request->apellido_p);
        $representante->apellido2 = strtoupper($request->apellido_m);
        $representante->nombres = strtoupper($request->nombres);
        $representante->titulo = strtoupper($request->titulo);
        $representante->genero = strtoupper($request->genero);

        $representante->save();

        $empresa->direccion = strtoupper($request->direccion);
        $empresa->telefono = $request->telefono;
        $empresa->descripcion = $request->descripcion;
        $empresa->area = $request->area;
        $empresa->tipo = $request->tipo;

        $empresa->save();

        return redirect()->route('empresas.informacion_edit')->with('status', 'Informacion Actualizada');
    }

    public function cambiar_representante()
    {
        $empresa = get_session_empresa();

        $empresa_data = Empresa::find($empresa['id_empresa']);

        $representante = $empresa_data->representante;

        return view('empresas.change_representante', compact('representante'))
            ->with('empresa', $empresa);
    }
}
