<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\ClienteController;
Use App\Http\Controllers\PrestamosController;
Use App\Http\Controllers\MonedaController;
Use App\Http\Controllers\FormapagoController;
Use App\Http\Controllers\PrestamoDetalleController;
Use App\Http\Controllers\UsuariosController;
Use App\Http\Controllers\PerfilesController;




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
Route::post('/prestamos.simular',        [PrestamosController::class, 'simular'])->name('prestamos.simular');
Route::post('/prestamos.guardar',        [PrestamosController::class, 'guardar'])->name('prestamos.guardar');


//Detalle de prestamos
Route::get('/prestamos.detalle',         [PrestamoDetalleController::class, 'detalle'])->name('prestamos.detalle');
Route::get('/prestamos.listarDetalle',   [PrestamoDetalleController::class, 'listar'])->name('prestamos.listarDetalle');
Route::post('/prestamos.pagarCuotas',    [PrestamoDetalleController::class, 'pagarCuotas'])->name('prestamos.pagarCuotas');
Route::post('/prestamos.datos',          [PrestamoDetalleController::class, 'datos'])->name('prestamos.datos');
Route::post('/prestamos.efectuar_pago',  [PrestamoDetalleController::class, 'pagar'])->name('prestamos.efectuar_pago');
Route::get('/prestamos/{prestamo}/cuota/{cuota}/pdf', [PrestamoDetalleController::class, 'pdf'])->name('prestamos.pdf');
Route::get('cronograma/{prestamo}/pdf',  [PrestamoDetalleController::class, 'cronograma'])->name('cronograma.pdf');
Route::get('contrato/{prestamo}/pdf',    [PrestamoDetalleController::class, 'contrato'])->name('contrato.pdf');
Route::post('prestamo.send',             [PrestamoDetalleController::class, 'sendMail'])->name('prestamo.send');


//Monedas
Route::get('/monedas',                   [MonedaController::class, 'index'])->name('monedas.index');
Route::get('/monedas.listar',            [MonedaController::class, 'listar'])->name('monedas.listar');
Route::post('/monedas.store',            [MonedaController::class, 'store'])->name('monedas.store');
Route::put('/monedas.update',            [MonedaController::class, 'update'])->name('monedas.update');
Route::post('/monedas.edit',             [MonedaController::class, 'edit'])->name('monedas.edit');
Route::post('/monedas.destroy',          [MonedaController::class, 'destroy'])->name('monedas.destroy');




//Formas de pago

Route::get('/formaspago',               [FormapagoController::class, 'index'])->name('formaspago.index');
Route::post('/formaspago.store',        [FormapagoController::class, 'store'])->name('formapagos.store');
Route::post('/formaspago.update',       [FormapagoController::class, 'update'])->name('formaspago.update');
Route::post('/formaspago.edit',         [FormapagoController::class, 'edit'])->name('formaspago.edit');
Route::get('/formaspago.lista',         [FormapagoController::class, 'lista'])->name('formaspago.lista');
Route::post('/formaspago.delete',       [FormapagoController::class, 'delete'])->name('formaspago.delete');


// Usuarios

Route::get('/usuarios',                 [UsuariosController::class, 'index'])->name('usuario.index');
Route::get('usuarios.lista',            [UsuariosController::class, 'lista'])->name('usuarios.lista');
Route::post('usuarios.store',           [UsuariosController::class, 'store'])->name('usuarios.store');
Route::post('usuarios.details',         [UsuariosController::class, 'details'])->name('usuarios.details');
Route::post('usuarios.update',          [UsuariosController::class, 'update'])->name('usuarios.update');
Route::post('usuarios.delete',          [UsuariosController::class, 'delete'])->name('usuario.delete');
Route::post('usuarios.activar',         [UsuariosController::class, 'activar'])->name('usuario.activar');

//Perfiles

Route::get('/Perfiles',                 [PerfilesController::class, 'index'])->name('perfiles.index');
Route::post('/Perfiles.store',          [PerfilesController::class, 'store'])->name('perfiles.store');
Route::get('/Perfiles.lista',          [PerfilesController::class, 'lista'])->name('perfiles.lista');









