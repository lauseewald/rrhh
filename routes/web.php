<?php

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
    return view('contenido/contenido');
});
//Empleado
Route::get('/empleado', 'EmpleadoController@index');
Route::post('/empleado/registrar', 'EmpleadoController@store');
Route::put('/empleado/actualizar', 'EmpleadoController@update');
Route::put('/empleado/desactivar', 'EmpleadoController@desactivar');
Route::put('/empleado/activar', 'EmpleadoController@activar');

//Incidencia
Route::get('/incidencia', 'IncidenciaController@index');
Route::post('/incidencia/registrar', 'IncidenciaController@store');
Route::put('/incidencia/actualizar', 'IncidenciaController@update');
Route::put('/incidencia/desactivar', 'IncidenciaController@desactivar');
Route::put('/incidencia/activar', 'IncidenciaController@activar');
Route::get('/incidencia/selectIncidencia', 'IncidenciaController@selectIncidencia');
