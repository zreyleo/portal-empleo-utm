<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login_empresas_get()
    {
        return view('login.empresas');
    }

    public function login_empresas_post(Request $request)
    {
        $data = $request->validate([
            'email' => 'required'
        ]);

        if (Empresa::where('email', $data['email'])->get()->count() == 0) {
            // dd($request->all());
            add_error("El usuario '{$data['email']}' no está registrado en el sistema");
            return redirect()->back();
        }

        $empresa = Empresa::where('email', $data['email'])->get()[0];


        Session::put('id_empresa', $empresa->id_empresa);
        Session::put('nombre_empresa', $empresa->nombre_empresa);
        Session::put('role', EmpresaController::get_role());

        return redirect()->route('empleos.index');
    }
}
