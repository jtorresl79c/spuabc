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
    return view('welcome');
});


Auth::routes();

Route::get('/consultando', 'Buscador')->name('BuscarConsulta');

Route::get('/cambio', 'contra')->name('nuevaContra');

Route::get('/act', 'act')->name('actualizar');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/prodc', 'consul')->name('productos');
Route::get('/conf', 'confirm')->name('confirmar');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:AccesoAdmin')->group(function(){
    Route::resource('/users','UsersController',['except' => ['show', 'create']]);
});

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:AccesoAdmin')->group(function(){
    Route::resource('/almacenes','AlmacenController',['except' => ['show', 'create']]);

});

// Route::namespace('Almacenista')->prefix('Al')->name('Al.')->middleware('can:AccesoAlmacenista')->group(function(){
Route::namespace('Almacenista')->prefix('Al')->name('Al.')->middleware('can:AccesoAlmacenista')->group(function(){
    Route::resource('/productos','ProductoController',['except' => ['show', 'create']]);

});

Route::namespace('Pedido')->prefix('Ped')->name('Ped.')->middleware('auth')->group(function(){
    Route::resource('/Pedido','SolicitudController',['except' => ['show', 'create']]);

});

Route::namespace('Usuario')->prefix('Us')->name('Us.')->middleware('auth')->group(function(){
    Route::resource('/Usuario','PedidosController',['except' => ['show', 'create']]);

});
