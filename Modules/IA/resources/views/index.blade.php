@extends('ia::layouts.master')

@section('title', 'Inteligencia Artificial - Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Inteligencia Artificial</h1>
        <p class="text-gray-600 mt-2">Análisis inteligente y asistente virtual para tu inventario</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Chatbot -->
        <div>
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Asistente Virtual</h2>
            @livewire('ia::chatbot')
        </div>

        <!-- Predicciones de Stock -->
        <div>
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Predicciones de Stock</h2>
            @livewire('ia::stock-prediction')
        </div>
    </div>

    <!-- Características de IA -->
    <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Características de Inteligencia Artificial</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-brain text-blue-600 text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Análisis Predictivo</h4>
                    <p class="text-sm text-gray-600">Predice el stock necesario basado en patrones de ventas históricas</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-comments text-green-600 text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Chatbot Inteligente</h4>
                    <p class="text-sm text-gray-600">Responde preguntas sobre inventario en lenguaje natural</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Insights Automáticos</h4>
                    <p class="text-sm text-gray-600">Genera análisis automáticos y recomendaciones inteligentes</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
