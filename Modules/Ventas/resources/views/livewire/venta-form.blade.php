<div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Registrar Nueva Venta</h3>
    </div>

    <form wire:submit.prevent="store" class="px-6 py-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Selección de Producto -->
            <div class="md:col-span-2">
                <label for="producto_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Producto *
                </label>
                <select wire:model.live="producto_id"
                        id="producto_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('producto_id') border-red-500 @enderror">
                    <option value="">Selecciona un producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}"
                                @if($producto->stock <= 0) disabled @endif>
                            {{ $producto->nombre }} - SKU: {{ $producto->sku }}
                            (Stock: {{ $producto->stock }})
                        </option>
                    @endforeach
                </select>
                @error('producto_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Información del Producto Seleccionado -->
            @if($this->productoSeleccionado)
                <div class="md:col-span-2 bg-blue-50 p-4 rounded-lg">
                    <h4 class="font-medium text-blue-900 mb-2">Información del Producto</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-blue-700 font-medium">Precio:</span>
                            <span class="text-blue-900">${{ number_format($this->productoSeleccionado->precio, 2) }}</span>
                        </div>
                        <div>
                            <span class="text-blue-700 font-medium">Stock:</span>
                            <span class="text-blue-900">{{ $this->productoSeleccionado->stock }} unidades</span>
                        </div>
                        <div>
                            <span class="text-blue-700 font-medium">Categoría:</span>
                            <span class="text-blue-900">{{ $this->productoSeleccionado->categoria ?? 'Sin categoría' }}</span>
                        </div>
                        <div>
                            <span class="text-blue-700 font-medium">SKU:</span>
                            <span class="text-blue-900">{{ $this->productoSeleccionado->sku }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Cantidad -->
            <div>
                <label for="cantidad" class="block text-sm font-medium text-gray-700 mb-2">
                    Cantidad *
                </label>
                <input type="number"
                       wire:model.live="cantidad"
                       id="cantidad"
                       min="1"
                       max="{{ $this->productoSeleccionado ? $this->productoSeleccionado->stock : '' }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cantidad') border-red-500 @enderror"
                       required>
                @error('cantidad')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Precio Unitario -->
            <div>
                <label for="precio_unitario" class="block text-sm font-medium text-gray-700 mb-2">
                    Precio Unitario *
                </label>
                <input type="number"
                       wire:model.live="precio_unitario"
                       id="precio_unitario"
                       step="0.01"
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('precio_unitario') border-red-500 @enderror"
                       required>
                @error('precio_unitario')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cliente -->
            <div>
                <label for="cliente" class="block text-sm font-medium text-gray-700 mb-2">
                    Cliente
                </label>
                <input type="text"
                       wire:model="cliente"
                       id="cliente"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cliente') border-red-500 @enderror">
                @error('cliente')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Total
                </label>
                <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-lg font-semibold text-gray-900">
                    ${{ number_format($this->total, 2) }}
                </div>
            </div>

            <!-- Observaciones -->
            <div class="md:col-span-2">
                <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                    Observaciones
                </label>
                <textarea wire:model="observaciones"
                          id="observaciones"
                          rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('observaciones') border-red-500 @enderror"></textarea>
                @error('observaciones')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <button type="button"
                    wire:click="$set('producto_id', '')"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                Limpiar
            </button>
            <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                <i class="fas fa-shopping-cart mr-2"></i>Registrar Venta
            </button>
        </div>
    </form>
</div>
