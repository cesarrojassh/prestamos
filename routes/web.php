<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\ClienteController;
Use App\Http\Controllers\PrestamosController;
Use App\Http\Controllers\MonedaController;
Use App\Http\Controllers\FormapagoController;

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


Route::get('/',                     [HomeController::class, 'home'])->name('admin');
Route::post('/login',               [LoginController::class, 'login'])->name('login');
Route::get('/logout',               [LoginController::class, 'logout'])->name('logout');


//Rutas caja

Route::get('/caja',                 [CajaController::class, 'index'])->name('caja.index');
Route::post('/caja.store',          [CajaController::class, 'store'])->name('caja.store');



//Clientes

Route::get('/clientes',                  [ClienteController::class, 'index'])->name('clientes.index');
Route::get('/clientes.listar',           [ClienteController::class, 'listar'])->name('clientes.listar');
Route::post('/clientes.store',           [ClienteController::class, 'store'])->name('clientes.store');
Route::put('/clientes.update',           [ClienteController::class, 'update'])->name('clientes.update');
Route::get('/clientes.edit',             [ClienteController::class, 'edit'])->name('clientes.edit');
Route::post('/clientes.reniec',          [ClienteController::class, 'reniec'])->name('clientes.reniec');
Route::post('/clientes.delete',          [ClienteController::class, 'delete'])->name('clientes.delete');
Route::post('/clientes.activar',         [ClienteController::class, 'activar'])->name('clientes.activar');


//Prestamos
Route::get('/prestamos',                 [PrestamosController::class, 'index'])->name('prestamos.index');
Route::get('/prestamos.listar',          [PrestamosController::class, 'listar'])->name('prestamos.listar');
Route::post('/prestamos.store',          [PrestamosController::class, 'store'])->name('prestamos.store');
Route::put('/prestamos.update',          [PrestamosController::class, 'update'])->name('prestamos.update');
Route::get('/prestamos.simular',         [PrestamosController::class, 'simular'])->name('prestamos.simular');

//Monedas
Route::get('/monedas',                   [MonedaController::class, 'index'])->name('monedas.index');
Route::get('/monedas.listar',            [MonedaController::class, 'listar'])->name('monedas.listar');
Route::post('/monedas.store',            [MonedaController::class, 'store'])->name('monedas.store');
Route::put('/monedas.update',            [MonedaController::class, 'update'])->name('monedas.update');
Route::get('/monedas.edit',              [MonedaController::class, 'edit'])->name('monedas.edit');



//Formas de pago

Route::get('/formaspago',               [FormapagoController::class, 'index'])->name('formaspago.index');