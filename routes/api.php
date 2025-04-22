<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\interfacescxcController;
use App\Http\Controllers\respuestapreetiquetadoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\apisetiquetadosController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/interfaces', [interfacescxcController::class, 'generaInterfaces']);
Route::post('/loginToken', [AuthenticatedSessionController::class, 'loginToken']);
Route::group(['middleware' => ['authToken:sanctum']], function (){
    Route::post('/preetiquetado', [respuestapreetiquetadoController::class,'RecibePreEtiquetado']);
});


Route::get('/BajaPromecapMambu', [apisetiquetadosController::class, 'BajaPromecapMambu']);
Route::get('/AltaPromecapJV', [apisetiquetadosController::class, 'AltaPromecapJV']);

