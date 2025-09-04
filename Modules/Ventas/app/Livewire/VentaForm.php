<?php

namespace Modules\Ventas\app\Livewire;

use Livewire\Component;
use Modules\Productos\app\Models\Producto;
use Modules\Ventas\app\Models\Venta;

class VentaForm extends Component
{
    public $producto_id = '';
    public $cantidad = 1;
    public $precio_unitario = 0;
    public $cliente = '';
    public $observaciones = '';
    public $productos = [];

    protected $rules = [
        'producto_id' => 'required|exists:productos,id',
        'cantidad' => 'required|integer|min:1',
        'precio_unitario' => 'required|numeric|min:0',
        'cliente' => 'nullable|string|max:255',
        'observaciones' => 'nullable|string'
    ];

    public function mount()
    {
        $this->productos = Producto::all();
    }

    public function updatedProductoId($value)
    {
        if ($value) {
            $producto = Producto::find($value);
            if ($producto) {
                $this->precio_unitario = $producto->precio;
            }
        }
    }

    public function getTotalProperty()
    {
        return $this->cantidad * $this->precio_unitario;
    }

    public function getProductoSeleccionadoProperty()
    {
        if ($this->producto_id) {
            return Producto::find($this->producto_id);
        }
        return null;
    }

    public function store()
    {
        $this->validate();

        $producto = Producto::find($this->producto_id);

        if (!$producto->tieneStock($this->cantidad)) {
            $this->addError('cantidad', 'No hay suficiente stock disponible. Stock actual: ' . $producto->stock);
            return;
        }

        Venta::create([
            'producto_id' => $this->producto_id,
            'cantidad' => $this->cantidad,
            'precio_unitario' => $this->precio_unitario,
            'cliente' => $this->cliente,
            'observaciones' => $this->observaciones
        ]);

        $this->reset(['producto_id', 'cantidad', 'precio_unitario', 'cliente', 'observaciones']);

        session()->flash('success', 'Venta registrada exitosamente.');

        $this->emit('ventaCreada');
    }

    public function render()
    {
        return view('ventas::livewire.venta-form');
    }
}
