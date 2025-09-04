<div class="space-y-6">
    <!-- Estadísticas principales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Productos</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalProductos }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Ventas</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalVentas }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ingresos Totales</p>
                    <p class="text-2xl font-semibold text-gray-900">${{ number_format($ingresosTotales, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Promedio Venta</p>
                    <p class="text-2xl font-semibold text-gray-900">${{ $totalVentas > 0 ? number_format($ingresosTotales / $totalVentas, 2) : '0.00' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de ventas por mes -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ventas por Mes (Últimos 12 meses)</h3>
        <div class="h-64">
            <canvas id="ventasChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Productos con stock bajo -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Productos con Stock Bajo</h3>
            @if($productosBajoStock->count() > 0)
                <div class="space-y-3">
                    @foreach($productosBajoStock as $producto)
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $producto->nombre }}</p>
                                <p class="text-sm text-gray-500">SKU: {{ $producto->sku }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $producto->stock }} unidades
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
                    <p class="text-gray-500">Todos los productos tienen stock suficiente</p>
                </div>
            @endif
        </div>

        <!-- Ventas recientes -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ventas Recientes</h3>
            @if($ventasRecientes->count() > 0)
                <div class="space-y-3">
                    @foreach($ventasRecientes as $venta)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $venta->producto->nombre }}</p>
                                <p class="text-sm text-gray-500">{{ $venta->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">${{ number_format($venta->total, 2) }}</p>
                                <p class="text-sm text-gray-500">{{ $venta->cantidad }} unidades</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-shopping-cart text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">No hay ventas recientes</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Insights automáticos -->
    @if(count($insights) > 0)
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Insights Automáticos</h3>
            <div class="space-y-3">
                @foreach($insights as $insight)
                    <div class="flex items-start p-4 rounded-lg
                        {{ $insight['type'] === 'success' ? 'bg-green-50 border border-green-200' :
                           ($insight['type'] === 'warning' ? 'bg-yellow-50 border border-yellow-200' : 'bg-blue-50 border border-blue-200') }}">
                        <div class="flex-shrink-0">
                            <i class="{{ $insight['icon'] }}
                                {{ $insight['type'] === 'success' ? 'text-green-600' :
                                   ($insight['type'] === 'warning' ? 'text-yellow-600' : 'text-blue-600') }}"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium
                                {{ $insight['type'] === 'success' ? 'text-green-800' :
                                   ($insight['type'] === 'warning' ? 'text-yellow-800' : 'text-blue-800') }}">
                                {{ $insight['message'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('ventasChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($ventasPorMes['labels']),
            datasets: [{
                label: 'Ventas ($)',
                data: @json($ventasPorMes['data']),
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
