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

Route::get('login/empresas', 'LoginController@login_empresas_get')->name('login.empresas_get');
Route::post('login/empresas', 'LoginController@login_empresas_post')->name('login.empresas_post');

// Route::get('dashboard/empresas', 'P');

Route::prefix('dashboard/empresas')->group(function () {
    Route::resource('empleos', 'EmpleoController')
        ->middleware('check.empresa.role.for.session');
});

// Route::resource('empleos', 'EmpleoController');
