<?php

use App\Http\Controllers\adminsettingsController;
use App\Http\Controllers\asistenciasController;
use App\Http\Controllers\clientesController;
use App\Http\Controllers\comprasController;
use App\Http\Controllers\cuentasController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\inventarioController;
use App\Http\Controllers\multialmacenController;
use App\Http\Controllers\pedidosController;
use App\Http\Controllers\preciosController;
use App\Http\Controllers\proveedoresController;
use App\Http\Controllers\reconocimientosController;
use App\Http\Controllers\reportesController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\vendedorController;
use App\Http\Controllers\ventasController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
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

Route::get('/', [dashboardController::class, 'showDashboard']);
Route::get('/dashboard', [dashboardController::class, 'checkDashboard']);
Route::get('/preguntasfrecuentes', [dashboardController::class, 'preguntasfrecuentes']);
Route::get('/politicadeusodirigido', [dashboardController::class, 'politicadeusodirigido']);
Route::get('/politicaenvio', [dashboardController::class, 'politicaenvio']);
Route::get('/politicaprivacidad', [dashboardController::class, 'politicaprivacidad']);

//Rutas

//CLIENTES
Route::get('clientes', [clientesController::class, 'clientes'])->middleware(['auth']);
Route::get('altacliente', [clientesController::class, 'altacliente'])->middleware(['auth']);
Route::get('bajacliente', [clientesController::class, 'bajacliente'])->middleware(['auth']);
Route::get('edicioncliente', [clientesController::class, 'edicioncliente'])->middleware(['auth']);
Route::get('verdireccioncliente', [clientesController::class, 'verdireccioncliente'])->middleware(['auth']);

Route::post('crearcliente', [clientesController::class, 'crearcliente'])->middleware(['auth']);
Route::post('eliminarcliente', [clientesController::class, 'eliminarcliente'])->middleware(['auth']);
Route::post('editarcliente', [clientesController::class, 'editarcliente'])->middleware(['auth']);




//OPCIONES
Route::get('admin/settings', [adminsettingsController::class, 'index'])->middleware(['auth']);
Route::get('recuperarcontrasena', [dashboardController::class, 'recuperarcontrasena']);

Route::get('profile/username', [usersController::class, 'usuarios']);
Route::post('crearusuario', [usersController::class, 'crearusuario']);
Route::post('actualizarusuario', [usersController::class, 'actualizarusuario']);
Route::post('actualizarext', [usersController::class, 'actualizarext']);
Route::post('eliminarusuario', [usersController::class, 'eliminarusuario']);
Route::get('obtener-tipo', [usersController::class, 'obtenerTipo']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
