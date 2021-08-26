<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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

    Route::delete('estudiantes_practicas/{estudiante_practica}', 'EstudiantePracticaController@destroy')
        ->middleware('check.estudiante.role.for.session')
        ->name('estudiantes_practicas.destroy');
});
