<?php

use Illuminate\Support\Facades\Route;

// Ruta principal - redirigir al dashboard de reportes
Route::get('/', function () {
    return redirect()->route('reportes.index');
});

// Rutas de módulos (ya configuradas en cada módulo)
// - Productos: /productos
// - Ventas: /ventas
// - Reportes: /reportes
// - IA: /ia
