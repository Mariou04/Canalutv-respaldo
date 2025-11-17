<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🛠️ Panel de Administración
        </h2>
    </x-slot>
        <br>
<a href="{{ route('dashboard') }}" class="bg-white text-blue-800 px-6 py-2 rounded-lg font-semibold hover:bg-blue-100 transition inline-flex items-center">
    <i class="bi bi-arrow-left me-2"></i> Volver
</a>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <span class="text-blue-600 text-2xl">📰</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Noticias</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $estadisticas['total_noticias'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <span class="text-yellow-600 text-2xl">⏳</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Pendientes</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $estadisticas['noticias_pendientes'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-full">
                            <span class="text-green-600 text-2xl">✅</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Publicadas</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $estadisticas['noticias_publicadas'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-full">
                            <span class="text-purple-600 text-2xl">👥</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Usuarios</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $estadisticas['total_usuarios'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-indigo-500">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 p-3 rounded-full">
                            <span class="text-indigo-600 text-2xl">📂</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Categorías</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $estadisticas['total_categorias'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Noticias Pendientes de Revisión -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">📋 Noticias Pendientes de Revisión</h3>
                        
                        @if($noticiasPendientes->count() > 0)
                            <div class="space-y-4">
                                @foreach($noticiasPendientes as $noticia)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-800">{{ $noticia->titulo }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($noticia->entradilla, 80) }}</p>
                                            <div class="flex items-center mt-2 text-xs text-gray-500">
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded mr-2">
                                                    {{ $noticia->categoria->nombre }}
                                                </span>
                                                <span>Por: {{ $noticia->usuario->nombre }}</span>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2 ml-4">
                                            <form action="{{ route('admin.noticias.aprobar', $noticia) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                                    ✅ Aprobar
                                                </button>
                                            </form>
                                            <button onclick="mostrarModalRechazo({{ $noticia->id_noticia }})" 
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                                ❌ Rechazar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No hay noticias pendientes de revisión.</p>
                        @endif
                    </div>
                </div>

                <!-- Noticias Recientes Publicadas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">📰 Noticias Recientes Publicadas</h3>
                        
                        @if($noticiasRecientes->count() > 0)
                            <div class="space-y-4">
                                @foreach($noticiasRecientes as $noticia)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                    <h4 class="font-semibold text-gray-800">{{ $noticia->titulo }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($noticia->entradilla, 60) }}</p>
                                    <div class="flex items-center mt-2 text-xs text-gray-500">
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded mr-2">
                                            {{ $noticia->categoria->nombre }}
                                        </span>
                                        <span>{{ $noticia->fecha_publicacion->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No hay noticias publicadas recientemente.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">⚡ Acciones Rápidas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.moderar-noticias') }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white p-4 rounded-lg text-center transition duration-200">
                            <div class="text-2xl mb-2">📋</div>
                            <div class="font-semibold">Moderar Noticias</div>
                        </a>
                        <a href="{{ route('admin.gestion-usuarios') }}" 
                           class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg text-center transition duration-200">
                            <div class="text-2xl mb-2">👥</div>
                            <div class="font-semibold">Gestionar Usuarios</div>
                        </a>
                        <a href="{{ route('noticias.create') }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center transition duration-200">
                            <div class="text-2xl mb-2">✏️</div>
                            <div class="font-semibold">Crear Noticia</div>
                        </a>
                    </div>
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