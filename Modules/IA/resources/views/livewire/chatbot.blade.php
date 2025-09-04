<div class="bg-white shadow-lg rounded-lg overflow-hidden h-96 flex flex-col">
    <!-- Header del Chat -->
    <div class="px-6 py-4 border-b border-gray-200 bg-blue-600 text-white">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-robot text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-3">
                <h3 class="text-lg font-semibold">Asistente Virtual</h3>
                <p class="text-blue-100 text-sm">Inteligencia Artificial para Inventario</p>
            </div>
            <div class="ml-auto">
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-sm text-blue-100">En línea</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Área de Mensajes -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chat-messages">
        @foreach($mensajes as $mensaje)
            <div class="flex {{ $mensaje['tipo'] === 'usuario' ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs lg:max-w-md">
                    @if($mensaje['tipo'] === 'bot')
                        <div class="flex items-start space-x-2">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-robot text-white text-xs"></i>
                                </div>
                            </div>
                            <div class="bg-gray-100 rounded-lg px-4 py-2">
                                <p class="text-sm text-gray-800 whitespace-pre-line">{{ $mensaje['contenido'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $mensaje['timestamp']->format('H:i') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-blue-600 text-white rounded-lg px-4 py-2">
                            <p class="text-sm whitespace-pre-line">{{ $mensaje['contenido'] }}</p>
                            <p class="text-xs text-blue-100 mt-1">{{ $mensaje['timestamp']->format('H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        @if($isTyping)
            <div class="flex justify-start">
                <div class="max-w-xs lg:max-w-md">
                    <div class="flex items-start space-x-2">
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-robot text-white text-xs"></i>
                            </div>
                        </div>
                        <div class="bg-gray-100 rounded-lg px-4 py-2">
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Área de Input -->
    <div class="border-t border-gray-200 p-4">
        <form wire:submit.prevent="enviarMensaje" class="flex space-x-2">
            <input type="text"
                   wire:model="mensajeActual"
                   placeholder="Escribe tu pregunta aquí..."
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   autocomplete="off">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 disabled:opacity-50"
                    {{ trim($mensajeActual) === '' ? 'disabled' : '' }}>
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>

        <!-- Sugerencias rápidas -->
        <div class="mt-2 flex flex-wrap gap-2">
            <button wire:click="$set('mensajeActual', '¿Cuál es el producto más vendido?')"
                    class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded-full transition duration-150">
                Producto más vendido
            </button>
            <button wire:click="$set('mensajeActual', '¿Qué productos tienen stock bajo?')"
                    class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded-full transition duration-150">
                Stock bajo
            </button>
            <button wire:click="$set('mensajeActual', '¿Cuántas ventas hubo hoy?')"
                    class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded-full transition duration-150">
                Ventas hoy
            </button>
            <button wire:click="$set('mensajeActual', '¿Cuáles son los ingresos totales?')"
                    class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded-full transition duration-150">
                Ingresos
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('scrollToBottom', () => {
        setTimeout(() => {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 100);
    });
});
</script>
