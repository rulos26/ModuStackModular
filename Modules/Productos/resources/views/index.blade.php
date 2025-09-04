@extends('productos::layouts.master')

@section('title', 'Gestión de Productos')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Sistema de Inventario</h1>
        <p class="text-gray-600 mt-2">Gestiona tu inventario de productos de manera eficiente</p>
    </div>

    @livewire('productos::product-table')
</div>
@endsection
