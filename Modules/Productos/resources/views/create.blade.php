@extends('productos::layouts.master')

@section('title', 'Crear Producto')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Crear Nuevo Producto</h2>
            </div>

            <form action="{{ route('productos.store') }}" method="POST" class="px-6 py-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre del Producto *
                        </label>
                        <input type="text"
                               id="nombre"
                               name="nombre"
                               value="{{ old('nombre') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nombre') border-red-500 @enderror"
                               required>
                        @error('nombre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                            SKU *
                        </label>
                        <input type="text"
                               id="sku"
                               name="sku"
                               value="{{ old('sku') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sku') border-red-500 @enderror"
                               required>
                        @error('sku')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="precio" class="block text-sm font-medium text-gray-700 mb-2">
                            Precio *
                        </label>
                        <input type="number"
                               id="precio"
                               name="precio"
                               step="0.01"
                               min="0"
                               value="{{ old('precio') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('precio') border-red-500 @enderror"
                               required>
                        @error('precio')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                            Stock Inicial *
                        </label>
                        <input type="number"
                               id="stock"
                               name="stock"
                               min="0"
                               value="{{ old('stock', 0) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock') border-red-500 @enderror"
                               required>
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="categoria" class="block text-sm font-medium text-gray-700 mb-2">
                            Categoría
                        </label>
                        <input type="text"
                               id="categoria"
                               name="categoria"
                               value="{{ old('categoria') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('categoria') border-red-500 @enderror">
                        @error('categoria')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción
                        </label>
                        <textarea id="descripcion"
                                  name="descripcion"
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-6">
                    <a href="{{ route('productos.index') }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                        Crear Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
