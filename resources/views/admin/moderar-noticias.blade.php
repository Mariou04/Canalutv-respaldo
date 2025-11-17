<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 Moderar Noticias
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Noticias Pendientes de Moderación</h3>
                        <a href="{{ route('admin.panel') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                            ← Volver al Panel
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($noticias->count() > 0)
                        <div class="space-y-6">
                            @foreach($noticias as $noticia)
                            <div class="border border-gray-200 rounded-lg p-6 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <h4 class="text-xl font-semibold text-gray-800 mr-4">{{ $noticia->titulo }}</h4>
                                            <span class="bg-{{ $noticia->estado == 'revisión' ? 'yellow' : 'blue' }}-100 text-{{ $noticia->estado == 'revisión' ? 'yellow' : 'blue' }}-800 px-2 py-1 rounded text-sm">
                                                {{ $noticia->estado == 'revisión' ? '⏳ En revisión' : '📝 Borrador' }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-gray-600 mb-3">{{ $noticia->entradilla }}</p>
                                        
                                        <div class="flex flex-wrap items-center text-sm text-gray-500 gap-4">
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                                {{ $noticia->categoria->nombre }}
                                            </span>
                                            <span>✍️ Por: {{ $noticia->usuario->nombre }}</span>
                                            <span>📅 {{ $noticia->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
<br>
                                        @if ($noticia->estado === 'borrador')
    <form action="{{ route('admin.noticias.aprobar', $noticia->id_noticia) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg">
            ✅ Aprobar
        </button>
    </form>
@endif


                                        @if($noticia->estado == 'rechazado' && $noticia->motivo_rechazo)
                                            <div class="mt-3 bg-red-50 border-l-4 border-red-500 p-3 rounded">
                                                <p class="text-red-700 text-sm">
                                                    <strong>Motivo de rechazo:</strong> {{ $noticia->motivo_rechazo }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex space-x-2 ml-6">
                                        @if($noticia->estado == 'revisión')
                                        <form action="{{ route('admin.noticias.aprobar', $noticia) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                                                ✅ Aprobar
                                            </button>
                                        </form>
                                        <button onclick="mostrarModalRechazo({{ $noticia->id_noticia }})" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                                            ❌ Rechazar
                                        </button>
                                        @endif
                                        
                                        <a href="{{ route('noticias.edit', $noticia) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                                            ✏️ Editar
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <span class="text-6xl mb-4">🎉</span>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay noticias pendientes</h3>
                            <p class="text-gray-500">Todas las noticias han sido moderadas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para rechazar noticia -->
    <div id="modalRechazo" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold mb-4">❌ Rechazar Noticia</h3>
            <form id="formRechazo" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="motivo_rechazo" class="block text-sm font-medium text-gray-700 mb-2">
                        Motivo del rechazo *
                    </label>
                    <textarea id="motivo_rechazo" name="motivo_rechazo" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                              required placeholder="Explica por qué se rechaza esta noticia..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="cerrarModal()" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                        Rechazar Noticia
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function mostrarModalRechazo(noticiaId) {
            const form = document.getElementById('formRechazo');
            form.action = `/admin/noticias/${noticiaId}/rechazar`;
            document.getElementById('modalRechazo').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modalRechazo').classList.add('hidden');
            document.getElementById('motivo_rechazo').value = '';
        }
    </script>
</x-app-layout>