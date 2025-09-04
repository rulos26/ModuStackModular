<?php

use Illuminate\Support\Facades\Route;
use Modules\Reportes\app\Http\Controllers\ReporteController;

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

Route::group([], function () {
    Route::get('/', [ReporteController::class, 'index'])->name('index');
    Route::get('/ventas', [ReporteController::class, 'ventas'])->name('ventas');
    Route::get('/productos', [ReporteController::class, 'productos'])->name('productos');
    Route::get('/stock', [ReporteController::class, 'stock'])->name('stock');
});
