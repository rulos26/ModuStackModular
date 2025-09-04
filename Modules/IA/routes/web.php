<?php

use Illuminate\Support\Facades\Route;
use Modules\IA\app\Http\Controllers\IAController;

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
    Route::get('/', [IAController::class, 'index'])->name('index');
    Route::get('/chatbot', [IAController::class, 'chatbot'])->name('chatbot');
    Route::get('/predicciones', [IAController::class, 'predicciones'])->name('predicciones');
});
