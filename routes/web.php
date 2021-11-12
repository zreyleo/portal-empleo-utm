<?php

use App\Empresa;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('logout', function () {
    request()->session()->flush();
    return redirect()->route('landing');
})->name('logout');

/*********************************************
 * ************* Password Reset *************
 ********************************************/

Route::get('forgot-password', function () {
    return view('login.forgot_password');
})->name('password.forgot_get');

Route::post('reset_password_without_token', function (Request $request) {
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
})->name('password.forgot_post');

Route::get('reset-password/{token}', function ($token) {
    $tokenData  = DB::table('password_resets')->where('token', $token)->get()->first();

    if (!$tokenData) {
        add_error('Enlace no valido');
        return redirect()->route('login.empresas_get');
    }

    return view('login.reset_password')->with('token', $token);
})->name('password.reset_get');

Route::post('reset-password/{token}', function (Request $request, $token) {
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
})->name('password.reset_post');

/*********************************************
 * ****************** Login ******************
 ********************************************/

// Login
Route::prefix('login')->group(function () {
    Route::get('empresas', 'LoginController@empresas_get')->name('login.empresas_get');
    Route::post('empresas', 'LoginController@empresas_post')->name('login.empresas_post');

    Route::get('estudiantes', 'LoginController@estudiantes_get')->name('login.estudiantes_get');
    Route::post('estudiantes', 'LoginController@estudiantes_post')->name('login.estudiantes_post');

    Route::prefix('estudiantes')->group(function () {
        Route::get('carrera', 'LoginController@choose_carrera_get')->name('login.choose_carrera_get')
            ->middleware('check.estudiante.role.for.session');

        Route::post('carrera', 'LoginController@choose_carrera_post')->name('login.choose_carrera_post')
            ->middleware('check.estudiante.role.for.session');
    });

    Route::get('reponsables', 'LoginController@responsables_get')->name('login.responsables_get');
    Route::post('reponsable', 'LoginController@responsables_post')->name('login.responsables_post');
});

/*********************************************
 * **************** Registro ****************
 ********************************************/

Route::get('/registro', 'NewEmpresaController@create')->name('new_empresas.create');
Route::post('/registro', 'NewEmpresaController@store')->name('new_empresas.store');



/*********************************************
 * ***************** Empresa *****************
 ********************************************/

Route::prefix('dashboard/empresas')->group(function () {
    // empleos
    Route::resource('empleos', 'EmpleoController')
        ->middleware('check.empresa.role.for.session');

    Route::get('empleos/{empleo}/estudiantes_empleos', 'EmpleoController@show_estudiantes_empleos')
        ->middleware('check.empresa.role.for.session')
        ->name('empleos.show_estudiantes_empleos');

    Route::get('estudiantes_empleos/{estudiante_empleo}', 'EstudianteEmpleoController@show_estudiante_data')
        ->middleware('check.empresa.role.for.session')
        ->name('estudiantes_empleos.show_estudiante_data');

    Route::post('estudiantes_empleos/{estudiante_empleo}', 'EstudianteEmpleoController@accept')
        ->middleware('check.empresa.role.for.session')
        ->name('estudiantes_empleos.accept');

    Route::delete('estudiantes_empleos/{estudiante_empleo}', 'EstudianteEmpleoController@reject')
        ->middleware('check.empresa.role.for.session')
        ->name('estudiantes_empleos.reject');

    // practicas
    Route::resource('practicas', 'PracticaController')
        ->middleware('check.empresa.role.for.session');

    // informacion de la empresa
    Route::get('password/edit', 'EmpresaController@passwordEdit')
        ->middleware('check.empresa.role.for.session')
        ->name('empresas.password_edit');

    Route::put('password', 'EmpresaController@passwordUpdate')
        ->middleware('check.empresa.role.for.session')
        ->name('empresas.password_update');

    Route::get('informacion', 'EmpresaController@informacion')
        ->middleware('check.empresa.role.for.session')
        ->name('empresas.informacion');

    Route::get('informacion/edit', 'EmpresaController@informacion_edit')
        ->middleware('check.empresa.role.for.session')
        ->name('empresas.informacion_edit');

    Route::put('informacion', 'EmpresaController@informacion_update')
        ->middleware('check.empresa.role.for.session')
        ->name('empresas.informacion_update');
});

/*********************************************
 * *************** Estudiantes ***************
 ********************************************/

Route::prefix('dashboard/estudiantes')->group(function () {
    Route::get('', 'EstudianteController@dashboard')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes.dashboard');

    // practicas for estudiantes
    Route::get('practicas', 'PracticaController@show_practicas_offers')
        ->middleware('check.estudiante.role.for.session')
        ->name('practicas.show_practicas_offers');

    Route::get('practicas/{practica}', 'PracticaController@show_practica_details')
        ->middleware('check.estudiante.role.for.session')
        ->name('practicas.show_practica_details');

    Route::post('practicas/{practica}', 'EstudiantePracticaController@store')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_practicas.store');

    Route::get('estudiantes_practicas', 'EstudiantePracticaController@index')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_practicas.index');

    Route::get(
        'estudiantes_practicas/{estudiante_practica}/empresa_contacto_info',
        'EstudiantePracticaController@show_empresa_contact_info'
    )
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_practicas.show_empresa_contact_info');

    Route::delete('estudiantes_practicas/{estudiante_practica}', 'EstudiantePracticaController@destroy')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_practicas.destroy');

    Route::get('estudiantes_practicas/{estudiante_practica}', 'EstudiantePracticaController@show_practica_details')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_practicas.show_practica_details');

    // empleos for estudiantes
    Route::get('empleos', 'EmpleoController@show_empleos_offers')
        ->middleware('check.estudiante.role.for.session')
        ->name('empleos.show_empleos_offers');

    Route::get('empleos/{empleo}', 'EmpleoController@show_empleo_details')
        ->middleware('check.estudiante.role.for.session')
        ->name('empleos.show_empleo_details');

    Route::post('empleos/{empleo}', 'EstudianteEmpleoController@store')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_empleos.store');

    Route::get('estudiantes_empleos', 'EstudianteEmpleoController@index')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_empleos.index');

    Route::delete('estudiantes_empleos/{estudiante_empleo}', 'EstudianteEmpleoController@destroy')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_empleos.destroy');

    Route::get('estudiantes_empleos/{estudiante_empleo}', 'EstudianteEmpleoController@show_empleo_details')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_empleos.show_empleo_details');

    // perfil
    Route::get('perfil', 'PerfilController@show')
        ->middleware('check.estudiante.role.for.session')
        ->name('perfil.show');

    Route::get('perfil/edit', 'PerfilController@edit')
        ->middleware('check.estudiante.role.for.session')
        ->name('perfil.edit');

    Route::put('perfil', 'PerfilController@update')
        ->middleware('check.estudiante.role.for.session')
        ->name('perfil.update');
});

/*********************************************
 * *************** Responsable ***************
 ********************************************/

Route::prefix('dashboard/responsables')->group(function () {
    Route::get('', 'ResponsableController@dashboard')
        ->middleware('check.responsable.role.for.session')
        ->name('responsables.dashboard');

    Route::get('new_empresas', 'NewEmpresaController@index')
        ->middleware('check.responsable.role.for.session')
        ->name('new_empresas.index');

    Route::get('new_empresas/{empresa}', 'NewEmpresaController@show')
        ->middleware('check.responsable.role.for.session')
        ->name('new_empresas.show');

    Route::get('new_empresas/{empresa}/edit', 'NewEmpresaController@edit')
        ->middleware('check.responsable.role.for.session')
        ->name('new_empresas.edit');

    Route::put('new_empresas/{empresa}', 'NewEmpresaController@update')
        ->middleware('check.responsable.role.for.session')
        ->name('new_empresas.update');

    Route::post('new_empresas/{nueva_empresa}', 'NewEmpresaController@register')
        ->middleware('check.responsable.role.for.session')
        ->name('new_empresas.register');

    Route::get('new_empresas/{empresa}/reject', 'NewEmpresaController@reject')
        ->middleware('check.responsable.role.for.session')
        ->name('new_empresas.reject');

    Route::delete('new_empresas/{empresa}', 'NewEmpresaController@destroy')
        ->middleware('check.responsable.role.for.session')
        ->name('new_empresas.destroy');

    Route::get('estadisticas/empleos', 'EstadisticaController@empleos')
        ->middleware('check.responsable.role.for.session')
        ->name('estadisticas.empleos');

    Route::get('estadisticas/practicas', 'EstadisticaController@practicas')
        ->middleware('check.responsable.role.for.session')
        ->name('estadisticas.practicas');

    Route::get('departamentos/create', 'DepartamentoController@create')
        ->middleware('check.responsable.role.for.session')
        ->name('departamentos.create');

    Route::post('departamentos', 'DepartamentoController@store')
        ->middleware('check.responsable.role.for.session')
        ->name('departamentos.store');
});
