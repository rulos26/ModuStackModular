@extends('reportes::layouts.master')

@section('title', 'Dashboard - Reportes')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard de Reportes</h1>
        <p class="text-gray-600 mt-2">Análisis completo de tu inventario y ventas</p>
    </div>

    @livewire('reportes::dashboard')
</div>
@endsection
