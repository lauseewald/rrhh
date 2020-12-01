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

//Contrato
Route::get('/contrato', 'ContratoController@index');
Route::post('/contrato/registrar', 'ContratoController@store');
Route::put('/contrato/actualizar', 'ContratoController@update');
Route::put('/contrato/desactivar', 'ContratoController@desactivar');
Route::put('/contrato/activar', 'ContratoController@activar');

//Empresa
Route::get('/empresa', 'EmpresaController@index');
Route::post('/empresa/registrar', 'EmpresaController@store');
Route::put('/empresa/actualizar', 'EmpresaController@update');
Route::put('/empresa/desactivar', 'EmpresaController@desactivar');
Route::put('/empresa/activar', 'EmpresaController@activar');

//Area
Route::get('/area', 'AreaController@index');
Route::post('/area/registrar', 'AreaController@store');
Route::put('/area/actualizar', 'AreaController@update');
Route::put('/area/desactivar', 'AreaController@desactivar');
Route::put('/area/activar', 'AreaController@activar');

//Area
Route::get('/area', 'AreaController@index');
Route::post('/area/registrar', 'AreaController@store');
Route::put('/area/actualizar', 'AreaController@update');
Route::put('/area/desactivar', 'AreaController@desactivar');
Route::put('/area/activar', 'AreaController@activar');

//Incidencia
Route::get('/incidencia', 'IncidenciaController@index');
Route::post('/incidencia/registrar', 'IncidenciaController@store');
Route::put('/incidencia/actualizar', 'IncidenciaController@update');
Route::put('/incidencia/desactivar', 'IncidenciaController@desactivar');
Route::put('/incidencia/activar', 'IncidenciaController@activar');
Route::get('/incidencia/selectIncidencia', 'IncidenciaController@selectIncidencia');
