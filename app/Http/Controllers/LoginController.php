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

        $empresa = Empresa::find('email', $data['email']);

        // dd($empresa);

        Session::put('id_empresa', $empresa->id_empresa);
        Session::put('role', EmpresaController::get_role());

        return redirect('empresas.dashboard');
    }
}
