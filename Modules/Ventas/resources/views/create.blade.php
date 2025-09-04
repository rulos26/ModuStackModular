@extends('ventas::layouts.master')

@section('title', 'Nueva Venta')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Registrar Nueva Venta</h1>
            <p class="text-gray-600 mt-2">Completa la información para registrar una nueva venta</p>
        </div>

        @livewire('ventas::venta-form')
    </div>
</div>
@endsection
