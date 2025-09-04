<div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Predicciones de Stock Inteligentes</h3>
        <p class="text-sm text-gray-600 mt-1">Análisis basado en ventas de los últimos 30 días</p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Producto
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stock Actual
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stock Recomendado
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Diferencia
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Días hasta Agotarse
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Estado
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($productos as $producto)
                    @php
                        $prediccion = $predicciones[$producto->id] ?? null;
                    @endphp
                    @if($prediccion)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</div>
                                <div class="text-sm text-gray-500">SKU: {{ $producto->sku }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $prediccion['stock_actual'] }} unidades
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $prediccion['stock_recomendado'] }} unidades
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($prediccion['diferencia'] > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        +{{ $prediccion['diferencia'] }} unidades
                                    </span>
                                @elseif($prediccion['diferencia'] < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $prediccion['diferencia'] }} unidades
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Óptimo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($prediccion['dias_hasta_agotarse'] < 999)
                                    {{ $prediccion['dias_hasta_agotarse'] }} días
                                @else
                                    Sin ventas recientes
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($prediccion['estado'])
                                    @case('necesita_reposicion')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Necesita Reposición
                                        </span>
                                        @break
                                    @case('stock_bajo')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-exclamation-circle mr-1"></i>Stock Bajo
                                        </span>
                                        @break
                                    @case('stock_medio')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-info-circle mr-1"></i>Stock Medio
                                        </span>
                                        @break
                                    @case('stock_ok')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Stock OK
                                        </span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
                <i class="fas fa-info-circle mr-1"></i>
                Las predicciones se basan en el promedio de ventas de los últimos 30 días
            </div>
            <button wire:click="loadPredictions"
                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                <i class="fas fa-sync-alt mr-1"></i>Actualizar Predicciones
            </button>
        </div>
    </div>
</div>
