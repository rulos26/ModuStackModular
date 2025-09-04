<?php

namespace Modules\Reportes\app\Livewire;

use Livewire\Component;
use Modules\Productos\app\Models\Producto;
use Modules\Ventas\app\Models\Venta;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $totalProductos;
    public $totalVentas;
    public $ingresosTotales;
    public $ventasPorMes = [];
    public $productosBajoStock = [];
    public $ventasRecientes = [];
    public $insights = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Estadísticas básicas
        $this->totalProductos = Producto::count();
        $this->totalVentas = Venta::count();
        $this->ingresosTotales = Venta::sum('total');

        // Ventas por mes (últimos 12 meses)
        $this->ventasPorMes = $this->getVentasPorMes();

        // Productos con stock bajo
        $this->productosBajoStock = Producto::where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        // Ventas recientes
        $this->ventasRecientes = Venta::with('producto')
            ->latest()
            ->limit(5)
            ->get();

        // Insights automáticos
        $this->insights = $this->generateInsights();
    }

    private function getVentasPorMes()
    {
        $ventasPorMes = [];
        $meses = [];

        for ($i = 11; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $meses[] = $fecha->format('M Y');

            $total = Venta::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->sum('total');

            $ventasPorMes[] = $total;
        }

        return [
            'labels' => $meses,
            'data' => $ventasPorMes
        ];
    }

    private function generateInsights()
    {
        $insights = [];

        // Insight 1: Productos con stock bajo
        $productosBajoStock = Producto::where('stock', '<=', 5)->count();
        if ($productosBajoStock > 0) {
            $insights[] = [
                'type' => 'warning',
                'icon' => 'fas fa-exclamation-triangle',
                'message' => "Hay {$productosBajoStock} productos con stock bajo (≤5 unidades)."
            ];
        }

        // Insight 2: Ventas del mes actual vs mes anterior
        $ventasMesActual = Venta::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');

        $ventasMesAnterior = Venta::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('total');

        if ($ventasMesAnterior > 0) {
            $porcentaje = (($ventasMesActual - $ventasMesAnterior) / $ventasMesAnterior) * 100;
            $tipo = $porcentaje > 0 ? 'success' : 'info';
            $icono = $porcentaje > 0 ? 'fas fa-arrow-up' : 'fas fa-arrow-down';
            $mensaje = $porcentaje > 0 ? 'aumentaron' : 'disminuyeron';

            $insights[] = [
                'type' => $tipo,
                'icon' => $icono,
                'message' => "Las ventas {$mensaje} " . abs(round($porcentaje, 1)) . "% este mes comparado con el mes anterior."
            ];
        }

        // Insight 3: Producto más vendido
        $productoMasVendido = Venta::selectRaw('producto_id, SUM(cantidad) as total_vendido')
            ->with('producto')
            ->groupBy('producto_id')
            ->orderBy('total_vendido', 'desc')
            ->first();

        if ($productoMasVendido && $productoMasVendido->producto) {
            $insights[] = [
                'type' => 'info',
                'icon' => 'fas fa-star',
                'message' => "El producto más vendido es '{$productoMasVendido->producto->nombre}' con {$productoMasVendido->total_vendido} unidades."
            ];
        }

        // Insight 4: Ingresos del día
        $ingresosHoy = Venta::whereDate('created_at', Carbon::today())->sum('total');
        if ($ingresosHoy > 0) {
            $insights[] = [
                'type' => 'success',
                'icon' => 'fas fa-dollar-sign',
                'message' => "Los ingresos de hoy son $" . number_format($ingresosHoy, 2) . "."
            ];
        }

        return $insights;
    }

    public function render()
    {
        return view('reportes::livewire.dashboard');
    }
}
