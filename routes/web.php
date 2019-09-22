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
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('votantes/getDashboard', 'VotantesController@getDashboard');
Route::post('votantes/getDashboard2', 'VotantesController@getDashboard2');
Route::post('votantes/puestos', 'VotantesController@getPuestos');
Route::post('votantes/barrios', 'VotantesController@getBarrios');
Route::post('votantes/mesas', 'VotantesController@getMesas');
Route::post('votantes/votacionpuesto', 'VotantesController@getVotacionPuesto');
Route::post('votantes/votantes', 'VotantesController@getListaVotantes');
Route::post('votantes/guardar', 'VotantesController@guardar');
Route::post('votantes/lideres', 'VotantesController@getLideres');
Route::post('votantes/listadoLideres', 'VotantesController@getListaLideres');
Route::post('votantes/votanesLider', 'VotantesController@getVotantesLider');
Route::post('votantes/votantessinpuesto', 'VotantesController@getVotantesSinPuesto');
Route::post('votantes/borrarvotante', 'VotantesController@deleteVotante');
Route::post('votantes/editarvotante', 'VotantesController@editarVotante');
Route::post('votantes/actualizar', 'VotantesController@actualizar');
Route::post('votantes/votconmesas', 'VotantesController@getVotantesconMesas');
