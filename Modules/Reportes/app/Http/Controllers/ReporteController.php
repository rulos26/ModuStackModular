<?php

namespace Modules\Reportes\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Productos\app\Models\Producto;
use Modules\Ventas\app\Models\Venta;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes::index');
    }

    public function ventas(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', Carbon::now()->startOfMonth());
        $fechaFin = $request->get('fecha_fin', Carbon::now()->endOfMonth());

        $ventas = Venta::with('producto')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalVentas = $ventas->sum('total');
        $totalCantidad = $ventas->sum('cantidad');

        return view('reportes::ventas', compact('ventas', 'totalVentas', 'totalCantidad', 'fechaInicio', 'fechaFin'));
    }

    public function productos(Request $request)
    {
        $productos = Producto::withCount('ventas')
            ->withSum('ventas', 'cantidad')
            ->orderBy('ventas_sum_cantidad', 'desc')
            ->paginate(20);

        return view('reportes::productos', compact('productos'));
    }

    public function stock()
    {
        $productosBajoStock = Producto::where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->get();

        $productosSinStock = Producto::where('stock', 0)->get();
        $productosConStock = Producto::where('stock', '>', 0)->get();

        return view('reportes::stock', compact('productosBajoStock', 'productosSinStock', 'productosConStock'));
    }
}
