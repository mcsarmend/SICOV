<?php

use App\Http\Controllers\adminsettingsController;
use App\Http\Controllers\clientesController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\reportController;
use App\Http\Controllers\ventasController;
use App\Http\Controllers\inventarioController;
use App\Http\Controllers\reportesController;
use App\Http\Controllers\pagosController;
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
Route::post('buscarexistencias', [ventasController::class, 'buscarexistencias'])->middleware(['auth']);
Route::post('buscaridprecio', [ventasController::class, 'buscaridprecio'])->middleware(['auth']);
Route::post('buscarexistencias', [ventasController::class, 'buscarexistencias'])->middleware(['auth']);
Route::post('validarremision', [ventasController::class, 'validarremision'])->middleware(['auth']);
Route::post('cancelarremision', [ventasController::class, 'cancelarremision'])->middleware(['auth']);


//CLIENTES
Route::get('clientes', [clientesController::class, 'clientes'])->middleware(['auth']);


Route::get('clientes', [ClientesController::class, 'clientes'])
->middleware(['auth'])
->name('clientes.index'); // Aquí asignamos el nombre a la ruta

Route::get('agenda', [clientesController::class, 'agenda'])->middleware(['auth']);
Route::get('reagendar', [clientesController::class, 'reagendar'])->middleware(['auth']);
Route::get('historicoasistencias', [clientesController::class, 'historicoasistencias'])->middleware(['auth']);
Route::get('preregistro', [clientesController::class, 'preregistro'])->middleware(['auth']);
Route::get('altacliente', [clientesController::class, 'altacliente'])->middleware(['auth']);
Route::get('bajacliente', [clientesController::class, 'bajacliente'])->middleware(['auth']);
Route::get('seguro', [clientesController::class, 'seguro'])->middleware(['auth']);
Route::get('edicioncliente', [clientesController::class, 'edicioncliente'])->middleware(['auth']);
Route::get('verdireccioncliente', [clientesController::class, 'verdireccioncliente'])->middleware(['auth']);
Route::get('actualizarasistencias', [clientesController::class, 'actualizarasistencias'])->middleware(['auth']);
Route::get('consultarpagos', [clientesController::class, 'consultarpagos'])->middleware(['auth']);
Route::get('asistenciagimnasio', [clientesController::class, 'asistenciagimnasio'])->middleware(['auth']);
Route::get('asistenciaalberca', [clientesController::class, 'asistenciaalberca'])->middleware(['auth']);



Route::post('actualizarseguro', [clientesController::class, 'actualizarseguro'])->middleware(['auth']);
Route::post('accionreagendar', [clientesController::class, 'accionreagendar'])->middleware(['auth']);
Route::post('registrarsalida', [clientesController::class, 'registrarsalida'])->middleware(['auth']);
Route::post('registrarasistencia', [clientesController::class, 'registrarasistencia'])->middleware(['auth']);
Route::post('infopreregistro', [clientesController::class, 'infopreregistro'])->middleware(['auth']);
Route::post('precrearcliente', [clientesController::class, 'precrearcliente'])->middleware(['auth']);
Route::post('crearcliente', [clientesController::class, 'crearcliente'])->middleware(['auth']);
Route::post('eliminarcliente', [clientesController::class, 'eliminarcliente'])->middleware(['auth']);
Route::post('editarcliente', [clientesController::class, 'editarcliente'])->middleware(['auth']);



// PAGOS
Route::get('registropagos', [pagosController::class, 'registropagos'])->middleware(['auth']);
Route::get('historicodepagos', [pagosController::class, 'historicodepagos'])->middleware(['auth']);

Route::post('registrarpago', [pagosController::class, 'registrarpago'])->middleware(['auth']);
Route::post('historialpagos', [pagosController::class, 'historialpagos'])->middleware(['auth']);

// REPORTES
Route::get('existencias', [reportController::class, 'existencias'])->middleware(['auth']);
Route::get('reporteremisiones', [reportController::class, 'reporteremisiones'])->middleware(['auth']);
Route::get('reportecortecaja', [reportController::class, 'reportecortecaja'])->middleware(['auth']);
Route::get('generarreporteremisiones', [reportController::class, 'generarreporteremisiones'])->middleware(['auth']);


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
Route::get('detalleamacenes', [inventarioController::class, 'detalleamacenes']);
Route::get('detalleprecios', [inventarioController::class, 'detalleprecios'])->middleware(['auth']);



Route::post('enviareditarprecio', [inventarioController::class, 'enviareditarprecio'])->middleware(['auth']);
Route::post('enviareditaralmacenes', [inventarioController::class, 'enviareditaralmacenes'])->middleware(['auth']);
Route::post('buscarpreciocompras', [inventarioController::class, 'buscarpreciocompras'])->middleware(['auth']);
Route::post('altaproducto', [inventarioController::class, 'altaproducto'])->middleware(['auth']);
Route::post('bajaproducto', [inventarioController::class, 'bajaproducto'])->middleware(['auth']);
Route::post('enviarentrada', [inventarioController::class, 'enviarentrada'])->middleware(['auth']);



// USUARIOS

Route::get('usuarios', [usersController::class, 'usuarios']);
Route::get('listausuarios', [usersController::class, 'listausuarios']);

Route::post('crearusuario', [usersController::class, 'crearusuario']);
Route::post('actualizarusuario', [usersController::class, 'actualizarusuario']);
Route::post('actualizarext', [usersController::class, 'actualizarext']);
Route::post('eliminarusuario', [usersController::class, 'eliminarusuario']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



