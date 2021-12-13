<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function forgot_password()
    {
        return view('login.forgot_password');
    }

    public function reset_password_without_token(Request $request)
    {
        $empresa = DB::connection('DB_ppp_sistema_SCHEMA_public')->table('tbl_empresa')->where('email', '=', $request->email)
            ->first();

        //Check if the empresa exists
        if (!$empresa) {
            return redirect()->back()->withErrors(['email' => 'El email no esta asociado a ninguna empresa']);
        }

        $tokenData  = DB::table('password_resets')->where('email', $request->email)->get()->first();

        if ($tokenData) {
            add_error('ya se ha enviado un email para resetear password a ese correo');
            return redirect()->route('login.empresas_get');
        }

        $token = Str::random(60);

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $enlace = config('app.url') . '/reset-password/' . $token;

        $mensaje = "El enlace para restear su password es " . $enlace . ", si no envio esta peticion haga caso omiso.";

        enviar_correo(
            $request->email,
            "Recuperar Password de Portal Empleo UTM",
            $mensaje
        );

        return redirect()->back()->with('status', 'Se ha enviado un enlace para resetear su password');
    }

    public function reset_password($token)
    {
        $tokenData  = DB::table('password_resets')->where('token', $token)->get()->first();

        if (!$tokenData) {
            add_error('Enlace no valido');

            return redirect()->route('login.empresas_get');
        }

        return view('login.reset_password')->with('token', $token);
    }

    public function update_password(Request $request, $token)
    {
        $tokenData  = DB::table('password_resets')->where('token', $token)->get()->first();

        if (!$tokenData) {
            add_error('Enlace no valido');
            return redirect()->route('login.empresas_get');
        }

        $request->validate([
            'password' => 'required',
            'confirm' => 'required'
        ]);

        if ($request->password != $request->confirm) {
            add_error('Se debe confirmar el password correctamente');
            return redirect()->back();
        }

        $empresa = Empresa::where('email', $tokenData->email)->get()->first();

        $empresa->password = Hash::make($request->password);

        $empresa->save();

        DB::table('password_resets')->where('token', '=', $token)->delete();

        return view('login.empresas')->with('status', 'Se ha cambiado el password exitosamente');
    }
}
