<?php

namespace Modules\IA\app\Livewire;

use Livewire\Component;
use Modules\Productos\app\Models\Producto;
use Modules\Ventas\app\Models\Venta;
use Carbon\Carbon;

class Chatbot extends Component
{
    public $mensajes = [];
    public $mensajeActual = '';
    public $isTyping = false;

    protected $listeners = ['enviarMensaje'];

    public function mount()
    {
        $this->mensajes = [
            [
                'tipo' => 'bot',
                'contenido' => '¡Hola! Soy tu asistente virtual de inventario. Puedo ayudarte con información sobre productos, ventas y análisis. ¿En qué puedo ayudarte?',
                'timestamp' => now()
            ]
        ];
    }

    public function enviarMensaje()
    {
        if (trim($this->mensajeActual) === '') {
            return;
        }

        // Agregar mensaje del usuario
        $this->mensajes[] = [
            'tipo' => 'usuario',
            'contenido' => $this->mensajeActual,
            'timestamp' => now()
        ];

        $mensajeUsuario = $this->mensajeActual;
        $this->mensajeActual = '';
        $this->isTyping = true;

        // Simular delay de respuesta
        $this->dispatch('scrollToBottom');

        // Procesar mensaje y generar respuesta
        $respuesta = $this->procesarMensaje($mensajeUsuario);

        $this->isTyping = false;

        $this->mensajes[] = [
            'tipo' => 'bot',
            'contenido' => $respuesta,
            'timestamp' => now()
        ];

        $this->dispatch('scrollToBottom');
    }

    private function procesarMensaje($mensaje)
    {
        $mensaje = strtolower($mensaje);

        // Patrones de reconocimiento
        if (str_contains($mensaje, 'producto') && str_contains($mensaje, 'más vendido')) {
            return $this->getProductoMasVendido();
        }

        if (str_contains($mensaje, 'stock') && str_contains($mensaje, 'bajo')) {
            return $this->getProductosStockBajo();
        }

        if (str_contains($mensaje, 'ventas') && str_contains($mensaje, 'hoy')) {
            return $this->getVentasHoy();
        }

        if (str_contains($mensaje, 'ventas') && str_contains($mensaje, 'mes')) {
            return $this->getVentasMes();
        }

        if (str_contains($mensaje, 'ingresos') || str_contains($mensaje, 'dinero')) {
            return $this->getIngresos();
        }

        if (str_contains($mensaje, 'productos') && str_contains($mensaje, 'total')) {
            return $this->getTotalProductos();
        }

        if (str_contains($mensaje, 'ayuda') || str_contains($mensaje, 'comandos')) {
            return $this->getAyuda();
        }

        // Respuesta por defecto
        return $this->getRespuestaGenerica();
    }

    private function getProductoMasVendido()
    {
        $producto = Venta::selectRaw('producto_id, SUM(cantidad) as total_vendido')
            ->with('producto')
            ->groupBy('producto_id')
            ->orderBy('total_vendido', 'desc')
            ->first();

        if ($producto && $producto->producto) {
            return "El producto más vendido es '{$producto->producto->nombre}' con {$producto->total_vendido} unidades vendidas.";
        }

        return "No hay datos de ventas disponibles para determinar el producto más vendido.";
    }

    private function getProductosStockBajo()
    {
        $productos = Producto::where('stock', '<=', 10)->get();

        if ($productos->count() > 0) {
            $lista = $productos->take(5)->map(function ($producto) {
                return "• {$producto->nombre} (Stock: {$producto->stock})";
            })->join("\n");

            return "Productos con stock bajo (≤10 unidades):\n\n{$lista}";
        }

        return "¡Excelente! Todos los productos tienen stock suficiente.";
    }

    private function getVentasHoy()
    {
        $ventasHoy = Venta::whereDate('created_at', Carbon::today())->count();
        $ingresosHoy = Venta::whereDate('created_at', Carbon::today())->sum('total');

        return "Hoy se han realizado {$ventasHoy} ventas por un total de $" . number_format($ingresosHoy, 2) . ".";
    }

    private function getVentasMes()
    {
        $ventasMes = Venta::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $ingresosMes = Venta::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');

        return "Este mes se han realizado {$ventasMes} ventas por un total de $" . number_format($ingresosMes, 2) . ".";
    }

    private function getIngresos()
    {
        $ingresosTotales = Venta::sum('total');
        $ingresosHoy = Venta::whereDate('created_at', Carbon::today())->sum('total');

        return "Los ingresos totales son $" . number_format($ingresosTotales, 2) . " y los ingresos de hoy son $" . number_format($ingresosHoy, 2) . ".";
    }

    private function getTotalProductos()
    {
        $totalProductos = Producto::count();
        $productosConStock = Producto::where('stock', '>', 0)->count();
        $productosSinStock = Producto::where('stock', 0)->count();

        return "Tienes {$totalProductos} productos en total: {$productosConStock} con stock disponible y {$productosSinStock} sin stock.";
    }

    private function getAyuda()
    {
        return "Puedes preguntarme sobre:\n\n" .
               "• ¿Cuál es el producto más vendido?\n" .
               "• ¿Qué productos tienen stock bajo?\n" .
               "• ¿Cuántas ventas hubo hoy?\n" .
               "• ¿Cuántas ventas hubo este mes?\n" .
               "• ¿Cuáles son los ingresos totales?\n" .
               "• ¿Cuántos productos hay en total?\n\n" .
               "¡Solo escribe tu pregunta de forma natural!";
    }

    private function getRespuestaGenerica()
    {
        $respuestas = [
            "No estoy seguro de entender tu pregunta. ¿Podrías ser más específico?",
            "Puedo ayudarte con información sobre productos, ventas y análisis. ¿Qué te gustaría saber?",
            "No tengo información sobre eso. ¿Te gustaría preguntarme sobre productos o ventas?",
            "Lo siento, no entiendo esa pregunta. ¿Puedes reformularla?",
            "Puedo ayudarte con datos de inventario y ventas. ¿En qué específicamente te interesa?"
        ];

        return $respuestas[array_rand($respuestas)];
    }

    public function render()
    {
        return view('ia::livewire.chatbot');
    }
}
