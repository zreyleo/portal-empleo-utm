<?php

use Illuminate\Support\Facades\Route;

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

Route::get('forgot-password', 'PasswordController@forgot_password')
    ->name('password.forgot_get');

Route::post('reset_password_without_token', 'PasswordController@reset_password_without_token')
    ->name('password.forgot_post');

Route::get('reset-password/{token}', 'PasswordController@reset_password')->name('password.reset_get');

Route::post('reset-password/{token}', 'PasswordController@update_password')->name('password.reset_post');

/*********************************************
 * ******* Departamentos Internos UTM *******
 ********************************************/

Route::get('solicitar_registro', 'DepartamentoController@solicitar_registro')
    ->name('departamento.solicitar_registro');

Route::post('solicitar_registro_post', 'DepartamentoController@solicitar_registro_post')
    ->name('departamento.solicitar_registro_post');

Route::get('registro_departamento/{token}', 'DepartamentoController@registro_departamento_get')
    ->name('departamento.registro_departamento_get');

Route::post('registro_departamento/{token}', 'DepartamentoController@registro_departamento_post')
    ->name('departamento.registro_departamento_post');

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
    Route::post('reponsables', 'LoginController@responsables_post')->name('login.responsables_post');

    Route::get('departamentos', 'LoginController@departamentos_get')->name('login.departamentos_get');
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
    Route::get('', 'EmpresaController@dashboard')
        ->middleware('check.empresa.role.for.session')
        ->name('empresas.dashboard');

    // lista de carreras
    Route::get('carreras', 'EmpresaController@lista_carreras')
        ->middleware('check.empresa.role.for.session')
        ->name('empresas.carreras');

    // empleos
    Route::resource('empleos', 'EmpleoController')
        ->middleware('check.empresa.role.for.session');

    Route::get('empleos/{empleo}/toggleVisible', 'EmpleoController@toggleVisibleEmpleo')
        ->middleware('check.empresa.role.for.session')
        ->name('empleos.toggleVisible');

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

    // anular practica con estudiantes que han reservado
    Route::get('practicas/{practica}/anular', 'PracticaController@anular')
        ->middleware('check.empresa.role.for.session')
        ->name('practicas.anular');

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

    Route::get('representantes/cambiar', 'EmpresaController@cambiar_representante')
        ->middleware('check.empresa.role.for.session')
        ->name('empresas.cambiar_representante');

    Route::post('representantes', 'RepresentanteController@registrar')
        ->middleware('check.empresa.role.for.session')
        ->name('representantes.registrar');

    Route::put('representantes', 'RepresentanteController@actualizar')
        ->middleware('check.empresa.role.for.session')
        ->name('representantes.actualizar');
});

/*********************************************
 * *************** Estudiantes ***************
 ********************************************/

Route::prefix('dashboard/estudiantes')->middleware('check.estudiante.role.for.session')->group(function () {
    Route::get('', 'EstudianteController@dashboard')
        ->name('estudiantes.dashboard');

    // practicas for estudiantes
    Route::get('practicas', 'PracticaController@show_practicas_offers')
        ->name('practicas.show_practicas_offers');

    Route::get('practicas/{practica}', 'PracticaController@show_practica_details')
        ->name('practicas.show_practica_details');

    Route::post('practicas/{practica}', 'EstudiantePracticaController@store')
        ->name('estudiantes_practicas.store');

    Route::get('estudiantes_practicas', 'EstudiantePracticaController@index')
        ->name('estudiantes_practicas.index');

    Route::get(
        'estudiantes_practicas/{estudiante_practica}/empresa_contacto_info',
        'EstudiantePracticaController@show_empresa_contact_info'
    )
        ->name('estudiantes_practicas.show_empresa_contact_info');

    Route::delete('estudiantes_practicas/{estudiante_practica}', 'EstudiantePracticaController@destroy')
        ->name('estudiantes_practicas.destroy');

    Route::get('estudiantes_practicas/{estudiante_practica}', 'EstudiantePracticaController@show_practica_details')
        ->name('estudiantes_practicas.show_practica_details');

    // pasantias
    Route::get('pasantias', 'EstudiantePracticaController@get_pasantias')
        ->name('estudiantes_practicas.get_pasantias');

    // empleos for estudiantes
    Route::get('empleos', 'EmpleoController@show_empleos_offers')
        ->name('empleos.show_empleos_offers');

    Route::get('empleos/{empleo}', 'EmpleoController@show_empleo_details')
        ->name('empleos.show_empleo_details');

    Route::post('empleos/{empleo}', 'EstudianteEmpleoController@store')
        ->name('estudiantes_empleos.store');

    Route::get('estudiantes_empleos', 'EstudianteEmpleoController@index')
        ->name('estudiantes_empleos.index');

    Route::delete('estudiantes_empleos/{estudiante_empleo}', 'EstudianteEmpleoController@destroy')
        ->name('estudiantes_empleos.destroy');

    Route::get('estudiantes_empleos/{estudiante_empleo}', 'EstudianteEmpleoController@show_empleo_details')
        ->name('estudiantes_empleos.show_empleo_details');



    // perfil
    Route::get('perfil', 'PerfilController@show')
        ->name('perfil.show');

    Route::get('perfil/edit', 'PerfilController@edit')
        ->name('perfil.edit');

    Route::put('perfil', 'PerfilController@update')
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

    Route::get('estadisticas', 'EstadisticaController@all')
        ->middleware('check.responsable.role.for.session')
        ->name('estadisticas.all');

    Route::get('estadisticas/pdf', 'EstadisticaController@pdf')
        ->middleware('check.responsable.role.for.session')
        ->name('estadisticas.pdf');

    Route::get('estadisticas/tabla', 'EstadisticaController@get_practicas_en_tabla_pdf')
        ->middleware('check.responsable.role.for.session')
        ->name('estadisticas.tabla');

    Route::get('estadisticas/tabla-empleos', 'EstadisticaController@get_empleos_en_tabla_pdf')
        ->middleware('check.responsable.role.for.session')
        ->name('estadisticas.tabla-empleos');

    Route::get('departamentos/create', 'DepartamentoController@create')
        ->middleware('check.responsable.role.for.session')
        ->name('departamentos.create');

    Route::post('departamentos', 'DepartamentoController@store')
        ->middleware('check.responsable.role.for.session')
        ->name('departamentos.store');

    Route::get('practicas', 'PracticaController@responsables_practicas')
        ->middleware('check.responsable.role.for.session')
        ->name('responsables.practicas');

    Route::get('empleos', 'EmpleoController@responsables_empleo')
        ->middleware('check.responsable.role.for.session')
        ->name('responsables.empleos');


    Route::get('practicas/{practica}', 'PracticaController@responsables_practicas_ver_detalles')
        ->middleware('check.responsable.role.for.session')
        ->name('responsables.practicas_ver_detalles');
});
