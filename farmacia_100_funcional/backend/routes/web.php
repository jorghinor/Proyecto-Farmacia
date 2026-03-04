<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\Frontend\CatalogoController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ProveedorController;
use App\Http\Controllers\Frontend\ContactoController;
use App\Http\Controllers\Frontend\LoginController;
use Illuminate\Support\Facades\Auth;

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

// Ruta Principal (Home)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas del Catálogo
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');
Route::get('/catalogo/{id}', [CatalogoController::class, 'show'])->name('catalogo.show');

// Rutas del Carrito de Compras
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/añadir/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/carrito/actualizar/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/carrito/eliminar/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/carrito/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Ruta de Proveedores
Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');

// Rutas de Contacto
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto.index');
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');

// Ruta de Factura PDF
Route::get('/factura/{venta}/pdf', [FacturaController::class, 'generarPdf'])->name('factura.pdf');

// RUTAS DE AUTENTICACIÓN (FRONTEND)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// RUTA DE CIERRE DE SESIÓN (LOGOUT) - Ahora usa el controlador
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
