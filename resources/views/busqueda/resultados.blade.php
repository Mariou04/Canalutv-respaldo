<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de búsqueda - Canal UTV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    @include('components.nav')

    <div class="container mx-auto mt-20 px-4 py-8 min-h-screen">
        <div class="max-w-6xl mx-auto">
            
            <!-- Header con botón volver -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        Resultados de búsqueda
                    </h1>
                    <p class="text-gray-600 text-lg">
                        Para: "<span class="font-semibold text-[#336892]">{{ $termino }}</span>"
                    </p>
                </div>
                
                <!-- Botón Volver -->
                <a href="{{ url('/') }}" 
                   class="flex items-center gap-2 bg-[#336892] text-white px-6 py-3 rounded-full hover:bg-blue-700 transition duration-300 font-semibold">
                    <i class="bi bi-arrow-left"></i>
                    Volver al Inicio
                </a>
            </div>

            @if($noticias->count() > 0)
                <!-- Contador de resultados -->
                <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-8">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-check-circle-fill text-green-600 text-xl"></i>
                        <div>
                            <strong class="text-lg">{{ $noticias->count() }}</strong> resultado(s) encontrado(s)
                        </div>
                    </div>
                </div>
                
                <!-- Grid de noticias -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($noticias as $noticia)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                        <!-- Imagen -->
                        @if($noticia->imagen_portada)
                        <div class="h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $noticia->imagen_portada) }}" 
                                 alt="{{ $noticia->titulo }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        </div>
                        @else
                        <div class="h-48 bg-gradient-to-br from-[#336892] to-blue-600 flex items-center justify-center">
                            <i class="bi bi-newspaper text-white text-4xl"></i>
                        </div>
                        @endif
                        
                        <!-- Contenido -->
                        <div class="p-6">
                            <!-- Categoría -->
                            @if($noticia->categoria)
                            <span class="inline-block bg-[#336892] text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">
                                {{ $noticia->categoria->nombre }}
                            </span>
                            @endif
                            
                            <!-- Título -->
                            <h3 class="text-lg font-bold text-gray-800 mb-3 line-clamp-2 hover:text-[#336892] transition">
                                @if($noticia->ruta_slug)
                                    <a href="{{ route('noticia.show', $noticia->ruta_slug) }}">
                                        {{ $noticia->titulo }}
                                    </a>
                                @else
                                    <a href="/noticia/{{ $noticia->id_noticia }}">
                                        {{ $noticia->titulo }}
                                    </a>
                                @endif
                            </h3>
                            
                            <!-- Entradilla -->
                            @if($noticia->entradilla)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $noticia->entradilla }}
                            </p>
                            @endif
                            
                            <!-- Fecha y leer más -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span class="text-xs text-gray-500">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $noticia->fecha_publicacion->format('d/m/Y') }}
                                </span>
                                @if($noticia->ruta_slug)
                                    <a href="{{ route('noticia.show', $noticia->ruta_slug) }}"
                                       class="text-[#336892] hover:text-blue-700 text-sm font-semibold flex items-center gap-1 transition">
                                        Leer más <i class="bi bi-arrow-right"></i>
                                    </a>
                                @else
                                    <a href="/noticia/{{ $noticia->id_noticia }}"
                                       class="text-[#336892] hover:text-blue-700 text-sm font-semibold flex items-center gap-1 transition">
                                        Leer más <i class="bi bi-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            @else
                <!-- Estado vacío -->
                <div class="text-center py-16 bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="max-w-md mx-auto">
                        <i class="bi bi-search text-6xl text-gray-300 mb-6"></i>
                        <h3 class="text-2xl font-bold text-gray-600 mb-4">No se encontraron resultados</h3>
                        <p class="text-gray-500 mb-2">No hay noticias que coincidan con:</p>
                        <p class="text-lg font-semibold text-[#336892] mb-6">"{{ $termino }}"</p>
                        
                        <div class="space-y-4">
                            <p class="text-gray-600">Sugerencias:</p>
                            <ul class="text-gray-500 text-sm space-y-1">
                                <li>• Revisa la ortografía de las palabras</li>
                                <li>• Usa términos más generales</li>
                                <li>• Prueba con otras palabras clave</li>
                            </ul>
                        </div>
                        
                        <div class="mt-8 space-x-4">
                            <a href="{{ url('/') }}" 
                               class="bg-[#336892] text-white px-8 py-3 rounded-full hover:bg-blue-700 transition duration-300 font-semibold inline-flex items-center gap-2">
                                <i class="bi bi-house"></i> Volver al Inicio
                            </a>
                            <button onclick="history.back()" 
                                    class="border border-gray-300 text-gray-700 px-8 py-3 rounded-full hover:bg-gray-50 transition duration-300 font-semibold inline-flex items-center gap-2">
                                <i class="bi bi-arrow-left"></i> Regresar
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Botón volver abajo también -->
            @if($noticias->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ url('/') }}" 
                   class="inline-flex items-center gap-2 bg-gray-600 text-white px-8 py-3 rounded-full hover:bg-gray-700 transition duration-300 font-semibold">
                    <i class="bi bi-arrow-left"></i>
                    Volver al Inicio
                </a>
            </div>
            @endif

        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>
</html>