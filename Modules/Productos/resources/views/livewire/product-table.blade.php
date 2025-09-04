<div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Gestión de Productos</h3>
            <a href="{{ route('productos.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-plus mr-2"></i>Nuevo Producto
            </a>
        </div>
    </div>

    <!-- Barra de búsqueda -->
    <div class="px-6 py-4 bg-gray-50">
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <input type="text"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Buscar productos por nombre o SKU..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex items-center space-x-2">
                <label class="text-sm text-gray-600">Mostrar:</label>
                <select wire:model.live="perPage" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                        wire:click="sortBy('nombre')">
                        <div class="flex items-center space-x-1">
                            <span>Nombre</span>
                            @if($sortField === 'nombre')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400"></i>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                        wire:click="sortBy('sku')">
                        <div class="flex items-center space-x-1">
                            <span>SKU</span>
                            @if($sortField === 'sku')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400"></i>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                        wire:click="sortBy('precio')">
                        <div class="flex items-center space-x-1">
                            <span>Precio</span>
                            @if($sortField === 'precio')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400"></i>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                        wire:click="sortBy('stock')">
                        <div class="flex items-center space-x-1">
                            <span>Stock</span>
                            @if($sortField === 'stock')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-blue-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400"></i>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Categoría
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($productos as $producto)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</div>
                            @if($producto->descripcion)
                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ $producto->descripcion }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $producto->sku }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($producto->precio, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $producto->stock > 10 ? 'bg-green-100 text-green-800' :
                                   ($producto->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $producto->stock }} unidades
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $producto->categoria ?? 'Sin categoría' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('productos.edit', $producto) }}"
                                   class="text-indigo-600 hover:text-indigo-900 transition duration-150">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click="deleteProduct({{ $producto->id }})"
                                        class="text-red-600 hover:text-red-900 transition duration-150"
                                        onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-box-open text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No se encontraron productos</p>
                                <p class="text-sm">Intenta ajustar los filtros de búsqueda</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $productos->links() }}
    </div>
</div>
