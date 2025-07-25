<?php

use App\Http\Controllers\categoriaController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\compraController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\profileController;

use App\Http\Controllers\roleController;
use App\Http\Controllers\userController;
use App\Http\Controllers\ventaController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [homeController::class, 'index'])->name('panel');

Route::resources([
    'categorias' => categoriaController::class,
    'productos' => ProductoController::class,
    'clientes' => clienteController::class,
    'menus' => menuController::class,
    'compras' => compraController::class,
    'ventas' => ventaController::class,
    'users' => userController::class,
    'roles' => roleController::class,
    'profile' => profileController::class
]);

//Reportes

Route::get('/export-excel-vental-all', [ExportExcelController::class, 'exportExcelVentasAll'])
    ->name('export.excel-ventas-all');

Route::get('/login', [loginController::class, 'index'])->name('login');
Route::post('/login', [loginController::class, 'login'])->name('login.login');
Route::get('/logout', [logoutController::class, 'logout'])->name('logout');
Route::resource('menus', MenuController::class);
Route::get('/ventas/obtener-numero-comprobante/{idComprobante}', [VentaController::class, 'obtenerNumeroComprobante']);

Route::get('/401', function () {
    return view('pages.401');
});
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/500', function () {
    return view('pages.500');
});
