<?php

namespace Modules\Productos\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Productos\app\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        return view('productos::index');
    }

    public function create()
    {
        return view('productos::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:productos,sku',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'categoria' => 'nullable|string|max:255'
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function show(Producto $producto)
    {
        return view('productos::show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        return view('productos::edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:productos,sku,' . $producto->id,
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'categoria' => 'nullable|string|max:255'
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
