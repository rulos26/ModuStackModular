<?php

use Illuminate\Support\Facades\Route;

// Ruta principal
Route::get('/', function () {
    return 'Laravel funcionando correctamente!';
});

// Rutas de módulos (ya configuradas en cada módulo)
// - Productos: /productos
// - Ventas: /ventas
// - Reportes: /reportes
// - IA: /ia
