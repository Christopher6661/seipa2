<?php

use App\Http\Controllers\AcuicultorFController;
use App\Http\Controllers\AcuicultorMController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PescadorFController;
use App\Http\Controllers\PescadorMController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Rutas para el pescador/fisico
Route::get('/pescador_fisico', [PescadorFController::class, 'index'])->middleware('auth.pf')->name('pescador_fisico.index');

//Rutas para el pescador/moral
Route::get('/pescador_moral', [PescadorMController::class, 'index'])->middleware('auth.pm')->name('pescador_moral.index');

Route::get('/', function () {
    return view('home');
})->middleware('auth');

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store'); 

Route::get('/login', [SessionsController::class, 'create'])->middleware('guest')->name('login.index');
Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
Route::get('/logout', [SessionsController::class, 'destroy'])->middleware('auth')->name('login.destroy');

//Rutas para el admin
Route::get('/admin', [AdminController::class, 'index'])->middleware('auth.admin')->name('admin.index');

//Rutas para el personal
Route::get('/personal', [PersonalController::class, 'index'])->middleware('auth.personal')->name('personal.index');

//Rutas para el pescador/fisico
Route::get('/pescador_fisico', [PescadorFController::class, 'index'])->middleware('auth.pf')->name('pescador_fisico.index');

//Rutas para el pescador/moral
Route::get('/pescador_moral', [PescadorMController::class, 'index'])->middleware('auth.pm')->name('pescador_moral.index');

//Rutas para el acuicultor/fisico
Route::get('/acuicultor_fisico', [AcuicultorFController::class, 'index'])->middleware('auth.af')->name('acuicultor_fisico.index');

//Rutas para el acuicultor/moral
Route::get('/acuicultor_moral', [AcuicultorMController::class, 'index'])->middleware('auth.am')->name('acuicultor_moral.index');


/**Route::view('/login', "login")->name('login');
Route::view('/registro', "register")->name('registro');
Route::view('/privada', "secret")->middleware('auth')->name('privada');

Route::post('/validar-registro',[LoginController::class,'register'])->name('validar-registro');
Route::post('/inicia-sesion',[LoginController::class,'login'])->name('inicia-sesion');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');**/