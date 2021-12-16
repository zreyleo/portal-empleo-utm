<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('provincias', 'UbicacionController@provincias')
    ->name('ubicacion.provincias');
Route::get('provincias/{provincia}', 'UbicacionController@cantones');
Route::get('provincias/{provincia}/{canton}', 'UbicacionController@parroquias');

Route::get('representantes', 'RepresentanteController@index')
    ->middleware('check.empresa.role.for.session')
    ->name('representantes.index');

Route::get('representantes/{cedula}', 'RepresentanteController@buscar')
    ->name('representantes.buscar');



