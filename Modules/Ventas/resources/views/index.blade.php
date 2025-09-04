@extends('ventas::layouts.master')

@section('title', 'Gestión de Ventas')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestión de Ventas</h1>
                <p class="text-gray-600 mt-2">Registra y administra las ventas de productos</p>
            </div>
            <a href="{{ route('ventas.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-plus mr-2"></i>Nueva Venta
            </a>
        </div>
    </div>

    <!-- Resumen de Ventas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Ventas</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $ventas->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ingresos Hoy</p>
                    <p class="text-2xl font-semibold text-gray-900">${{ number_format(\Modules\Ventas\app\Models\Venta::whereDate('created_at', today())->sum('total'), 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-calendar-day text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ventas Hoy</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ \Modules\Ventas\app\Models\Venta::whereDate('created_at', today())->count() }}</p>
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
                    <p class="text-2xl font-semibold text-gray-900">${{ number_format(\Modules\Ventas\app\Models\Venta::avg('total'), 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Ventas -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Historial de Ventas</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Producto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cantidad
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Precio Unit.
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($ventas as $venta)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $venta->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $venta->producto->nombre }}</div>
                                <div class="text-sm text-gray-500">SKU: {{ $venta->producto->sku }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $venta->cantidad }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ${{ number_format($venta->precio_unitario, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                ${{ number_format($venta->total, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $venta->cliente ?? 'Sin especificar' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('ventas.show', $venta) }}"
                                       class="text-blue-600 hover:text-blue-900 transition duration-150">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button onclick="confirmDelete({{ $venta->id }})"
                                            class="text-red-600 hover:text-red-900 transition duration-150">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">No hay ventas registradas</p>
                                    <p class="text-sm">Comienza registrando tu primera venta</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $ventas->links() }}
        </div>
    </div>
</div>

<!-- Formulario oculto para eliminar -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDelete(ventaId) {
    if (confirm('¿Estás seguro de eliminar esta venta?')) {
        const form = document.getElementById('delete-form');
        form.action = `/ventas/${ventaId}`;
        form.submit();
    }
}
</script>
@endsection
