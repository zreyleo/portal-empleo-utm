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

// routes for empresas
Route::prefix('dashboard/empresas')->group(function () {
    Route::resource('empleos', 'EmpleoController')
        ->middleware('check.empresa.role.for.session');

    Route::resource('practicas', 'PracticaController')
        ->middleware('check.empresa.role.for.session');
});


// Route::get('dashboard/estudiantes', 'EstudianteController@dashboard')
//     ->middleware('check.estudiante.role.for.session')
//     ->name('estudiantes.dashboard');

// Route::get('dashboard/estudiantes/practicas', 'PracticaController@practicas_offers_for_estudiantes')
//     ->middleware('check.estudiante.role.for.session')
//     ->name('estudiantes.practicas_offers');

// Route::get('dashboard/estudiantes/practicas/{practica}', 'PracticaController@practica_details_for_estudiante')
//     ->middleware('check.estudiante.role.for.session')
//     ->name('estudiantes.practica_details_for_estudiante');

Route::prefix('dashboard/estudiantes')->group(function () {
    Route::get('', 'EstudianteController@dashboard')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes.dashboard');

    // practicas for estudiantes
    Route::get('practicas', 'PracticaController@practicas_offers_for_estudiantes')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes.practicas_offers');

    Route::get('practicas/{practica}', 'PracticaController@practica_details_for_estudiante')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes.practica_details_for_estudiante');

    Route::post('practicas/{practica}', 'EstudiantePracticaController@store')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_practicas.store');

    Route::get('estudiantes_practicas', 'EstudiantePracticaController@index')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_practicas.index');

    Route::get('estudiantes_practicas/{estudiante_practica}/empresa_contacto_info', 'EstudiantePracticaController@show_empresa_contact_info')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_practicas.show_empresa_contact_info');

    Route::delete('estudiantes_practicas/{estudiante_practica}', 'EstudiantePracticaController@destroy')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_practicas.destroy');

    // empleos for estudiantes
    Route::get('empleos', 'EmpleoController@empleos_offers_for_estudiantes')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes.empleos_offers');

    Route::get('empleos/{empleo}', 'EmpleoController@empleo_details_for_estudiante')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes.empleo_details_for_estudiante');

    Route::post('empleos/{empleo}', 'EstudianteEmpleoController@store')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_empleos.store');

});
