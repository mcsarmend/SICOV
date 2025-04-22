<?php

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return view('/welcome');
    }
});

Route::get('gimnasio', [ventasController::class, 'gimnasio']);
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/errortoken', [tokenController::class, 'errortoken'])->name('errortoken');
