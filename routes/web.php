<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('logout', function () {
    request()->session()->flush();
    return redirect()->route('landing');
})->name('logout');

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
});

// registro de nuevas empresas
Route::get('/registro', 'NewEmpresaController@create')->name('new_empresas.create');
Route::post('/registro', 'NewEmpresaController@store')->name('new_empresas.store');

// routes for empresas
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

    // practicas
    Route::resource('practicas', 'PracticaController')
        ->middleware('check.empresa.role.for.session');
});

// routes form estudiantes
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
