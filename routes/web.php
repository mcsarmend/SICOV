<?php

use App\Http\Controllers\adminsettingsController;
use App\Http\Controllers\clientesController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\reportController;
use App\Http\Controllers\ventasController;
use App\Http\Controllers\inventarioController;
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


//REMISIONES
Route::get('remisionar', [ventasController::class, 'remisionar'])->middleware(['auth']);
Route::get('remisionarlista', [ventasController::class, 'remisionarlista'])->middleware(['auth']);
Route::get('remisiones', [ventasController::class, 'remisiones'])->middleware(['auth']);
Route::get('ventasreportes', [ventasController::class, 'ventasreportes'])->middleware(['auth']);
Route::get('verproductosremision', [ventasController::class, 'verproductosremision'])->middleware(['auth']);
Route::get('cortedecaja', [ventasController::class, 'cortedecaja'])->middleware(['auth']);
Route::get('buscarremision', [ventasController::class, 'buscarremision'])->middleware(['auth']);

Route::post('enviarinfocortecaja', [ventasController::class, 'enviarinfocortecaja'])->middleware(['auth']);
Route::post('buscarprecio', [ventasController::class, 'buscarprecio'])->middleware(['auth']);
Route::post('buscaridprecio', [ventasController::class, 'buscaridprecio'])->middleware(['auth']);
Route::post('buscarexistencias', [ventasController::class, 'buscarexistencias'])->middleware(['auth']);
Route::post('validarremision', [ventasController::class, 'validarremision'])->middleware(['auth']);
Route::post('cancelarremision', [ventasController::class, 'cancelarremision'])->middleware(['auth']);


//CLIENTES
Route::get('clientes', [clientesController::class, 'clientes'])->middleware(['auth']);
Route::get('preregistro', [clientesController::class, 'preregistro'])->middleware(['auth']);
Route::get('altacliente', [clientesController::class, 'altacliente'])->middleware(['auth']);
Route::get('bajacliente', [clientesController::class, 'bajacliente'])->middleware(['auth']);
Route::get('edicioncliente', [clientesController::class, 'edicioncliente'])->middleware(['auth']);
Route::get('verdireccioncliente', [clientesController::class, 'verdireccioncliente'])->middleware(['auth']);

Route::post('crearcliente', [clientesController::class, 'crearcliente'])->middleware(['auth']);
Route::post('eliminarcliente', [clientesController::class, 'eliminarcliente'])->middleware(['auth']);
Route::post('editarcliente', [clientesController::class, 'editarcliente'])->middleware(['auth']);



// REPORTES
Route::get('existencias', [reportController::class, 'existencias'])->middleware(['auth']);
Route::get('reporteremisiones', [reportController::class, 'reporteremisiones'])->middleware(['auth']);
Route::get('reportecortecaja', [reportController::class, 'reportecortecaja'])->middleware(['auth']);


//OPCIONES
Route::get('admin/settings', [adminsettingsController::class, 'index'])->middleware(['auth']);
Route::get('recuperarcontrasena', [dashboardController::class, 'recuperarcontrasena']);

Route::get('profile/username', [usersController::class, 'usuarios']);
Route::post('crearusuario', [usersController::class, 'crearusuario']);
Route::post('actualizarusuario', [usersController::class, 'actualizarusuario']);
Route::post('actualizarext', [usersController::class, 'actualizarext']);
Route::post('eliminarusuario', [usersController::class, 'eliminarusuario']);
Route::get('obtener-tipo', [usersController::class, 'obtenerTipo']);


// Inventario
Route::get('altainventario', [inventarioController::class, 'altainventario'])->middleware(['auth']);
Route::get('bajainventario', [inventarioController::class, 'bajainventario'])->middleware(['auth']);
Route::get('edicioninventario', [inventarioController::class, 'edicioninventario'])->middleware(['auth']);
Route::get('ingresoinventario', [inventarioController::class, 'ingresoinventario'])->middleware(['auth']);
Route::get('salidainventario', [inventarioController::class, 'salidainventario'])->middleware(['auth']);


Route::get('usuarios', [usersController::class, 'usuarios']);
Route::get('listausuarios', [usersController::class, 'listausuarios']);
Route::post('crearusuario', [usersController::class, 'crearusuario']);
Route::post('actualizarusuario', [usersController::class, 'actualizarusuario']);
Route::post('actualizarext', [usersController::class, 'actualizarext']);
Route::post('eliminarusuario', [usersController::class, 'eliminarusuario']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
