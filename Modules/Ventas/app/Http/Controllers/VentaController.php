<?php

namespace Modules\Ventas\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ventas\app\Models\Venta;
use Modules\Productos\app\Models\Producto;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('producto')->latest()->paginate(15);
        return view('ventas::index', compact('ventas'));
    }

    public function create()
    {
        $productos = Producto::where('stock', '>', 0)->get();
        return view('ventas::create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'cliente' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string'
        ]);

        $producto = Producto::find($request->producto_id);

        if (!$producto->tieneStock($request->cantidad)) {
            return back()->withErrors(['cantidad' => 'No hay suficiente stock disponible. Stock actual: ' . $producto->stock]);
        }

        Venta::create($request->all());

        return redirect()->route('ventas.index')
            ->with('success', 'Venta registrada exitosamente.');
    }

    public function show(Venta $venta)
    {
        $venta->load('producto');
        return view('ventas::show', compact('venta'));
    }

    public function destroy(Venta $venta)
    {
        $venta->delete();

        return redirect()->route('ventas.index')
            ->with('success', 'Venta eliminada exitosamente.');
    }
}
