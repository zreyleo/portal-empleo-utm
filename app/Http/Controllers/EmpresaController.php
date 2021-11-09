<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class EmpresaController extends Controller
{
    private const ROLE = 'EMPRESA';

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

        return view('empresas.informacion')
            ->with('empresa', $empresa)
            ->with('empresa_informacion', $empresa_informacion);
    }
}
