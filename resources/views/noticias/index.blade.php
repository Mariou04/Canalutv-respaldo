<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📰 Mis Noticias
        </h2>
    </x-slot>


        <br>
    <a href="{{ url()->previous() }}" class="bg-white text-blue-800 px-6 py-2 rounded-lg font-semibold hover:bg-blue-100 transition inline-flex items-center">
  <i class="bi bi-arrow-left me-2"></i> Volver
</a>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Encabezado -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Gestión de Noticias</h3>
                        <a href="{{ route('noticias.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 shadow-md">
                            ✏️ Crear Nueva Noticia
                        </a>
                    </div>

                    <!-- Mensajes de éxito -->
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                            <div class="flex items-center">
                                <span class="text-green-500 mr-2">✓</span>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    <!-- Lista de noticias -->
                    @if($noticias->count() > 0)
                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-200">
                                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Título</th>
                                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Categoría</th>
                                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Fecha Publicación</th>
                                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Estado</th>
                                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($noticias as $noticia)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                                        <!-- Título y entradilla -->
                                        <td class="py-4 px-6">
                                            <div class="font-semibold text-gray-900 text-lg mb-1">{{ $noticia->titulo }}</div>
                                            <div class="text-sm text-gray-600">{{ Str::limit($noticia->entradilla, 60) }}</div>
                                        </td>
                                        
                                        <!-- Categoría -->
                                        <td class="py-4 px-6">
                                            <span class="inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                                {{ $noticia->categoria->nombre }}
                                            </span>
                                        </td>
                                        
                                        <!-- Fecha de publicación -->
                                        <td class="py-4 px-6">
                                            @if($noticia->fecha_publicacion)
                                                <div class="text-gray-900 font-medium">{{ $noticia->fecha_publicacion->format('d/m/Y') }}</div>
                                                <div class="text-sm text-gray-500">{{ $noticia->fecha_publicacion->format('H:i') }}</div>
                                            @else
                                                <span class="text-gray-400 italic">No programada</span>
                                            @endif
                                        </td>
                                        
                                        <!-- Estado -->
                                        <td class="py-4 px-6">
                                            @if($noticia->estado == 'publicado')
                                                <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                                    ✅ Publicada
                                                </span>
                                            @elseif($noticia->estado == 'revisión')
                                                <span class="inline-flex items-center bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                                                    ⏳ En revisión
                                                </span>
                                            @else
                                                <span class="inline-flex items-center bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                                                    📝 Borrador
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <!-- Acciones -->
                                        <td class="py-4 px-6">
                                            <div class="flex space-x-2">
                                                <!-- Botón Editar -->
                                                <a href="{{ route('noticias.edit', $noticia) }}" 
                                                   class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200 shadow-sm">
                                                    <span class="mr-1">✏️</span>
                                                    Editar
                                                </a>
                                                
                                                <!-- Botón Eliminar -->
                                                <form action="{{ route('noticias.destroy', $noticia) }}" method="POST" 
                                                      onsubmit="return confirm('¿Estás seguro de eliminar esta noticia?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200 shadow-sm">
                                                        <span class="mr-1">🗑️</span>
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <!-- Estado vacío -->
                        <div class="text-center py-12">
                            <div class="mb-4">
                                <span class="text-6xl">📰</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No tienes noticias creadas</h3>
                            <p class="text-gray-500 mb-6">Comienza a crear contenido para tu sitio web</p>
                            <a href="{{ route('noticias.create') }}" 
                               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 shadow-md">
                                <span class="mr-2">✏️</span>
                                Crear mi primera noticia
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>