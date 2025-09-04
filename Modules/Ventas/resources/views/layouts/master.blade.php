<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de Inventario')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Livewire Styles -->
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('productos.index') }}" class="text-xl font-bold text-gray-800">
                        <i class="fas fa-warehouse mr-2"></i>Sistema de Inventario
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('productos.index') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-box mr-1"></i>Productos
                    </a>
                    <a href="{{ route('ventas.index') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-shopping-cart mr-1"></i>Ventas
                    </a>
                    <a href="#" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-chart-bar mr-1"></i>Reportes
                    </a>
                    <a href="#" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-cog mr-1"></i>Configuración
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-4 mt-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-4 mt-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
