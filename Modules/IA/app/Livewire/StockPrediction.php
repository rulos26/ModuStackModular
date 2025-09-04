<?php

namespace Modules\IA\app\Livewire;

use Livewire\Component;
use Modules\Productos\app\Models\Producto;
use Modules\Ventas\app\Models\Venta;
use Carbon\Carbon;

class StockPrediction extends Component
{
    public $productos = [];
    public $predicciones = [];

    public function mount()
    {
        $this->loadPredictions();
    }

    public function loadPredictions()
    {
        $this->productos = Producto::all();
        $this->predicciones = [];

        foreach ($this->productos as $producto) {
            $prediccion = $this->calcularPrediccionStock($producto);
            $this->predicciones[$producto->id] = $prediccion;
        }
    }

    private function calcularPrediccionStock($producto)
    {
        // Obtener ventas de los últimos 30 días
        $ventas30Dias = Venta::where('producto_id', $producto->id)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->sum('cantidad');

        // Calcular promedio diario de ventas
        $promedioDiario = $ventas30Dias / 30;

        // Stock recomendado: promedio diario * 15 días
        $stockRecomendado = ceil($promedioDiario * 15);

        // Diferencia entre stock actual y recomendado
        $diferencia = $stockRecomendado - $producto->stock;

        // Días hasta agotarse (si las ventas continúan al mismo ritmo)
        $diasHastaAgotarse = $promedioDiario > 0 ? floor($producto->stock / $promedioDiario) : 999;

        return [
            'stock_actual' => $producto->stock,
            'stock_recomendado' => $stockRecomendado,
            'diferencia' => $diferencia,
            'dias_hasta_agotarse' => $diasHastaAgotarse,
            'promedio_ventas_diarias' => round($promedioDiario, 2),
            'estado' => $this->determinarEstado($diferencia, $diasHastaAgotarse)
        ];
    }

    private function determinarEstado($diferencia, $diasHastaAgotarse)
    {
        if ($diferencia > 0) {
            return 'necesita_reposicion';
        } elseif ($diasHastaAgotarse <= 7) {
            return 'stock_bajo';
        } elseif ($diasHastaAgotarse <= 15) {
            return 'stock_medio';
        } else {
            return 'stock_ok';
        }
    }

    public function render()
    {
        return view('ia::livewire.stock-prediction');
    }
}
