<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $noticia->titulo }} - Canal UTV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    @include('components.nav')

    <div class="container mx-auto mt-20 px-4 py-8">
        <div class="max-w-4xl mx-auto">
            
            <!-- Noticia -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden">
                
                <!-- Imagen destacada -->
                @if($noticia->imagen_portada)
                <div class="w-full h-64 md:h-96 overflow-hidden">
                    <img src="{{ asset('storage/' . $noticia->imagen_portada) }}" 
                         alt="{{ $noticia->titulo }}" 
                         class="w-full h-full object-cover">
                </div>
                @endif

                <!-- Contenido -->
                <div class="p-6 md:p-8">
                    
                    <!-- Encabezado -->
                    <div class="mb-6">
                        <!-- Categoría -->
                        @if($noticia->categoria)
                        <div class="mb-4">
                            <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $noticia->categoria->nombre }}
                            </span>
                        </div>
                        @endif
                        
                        <!-- Título -->
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                            {{ $noticia->titulo }}
                        </h1>
                        
                        <!-- Metadatos -->
                        <div class="flex flex-wrap items-center text-gray-600 text-sm mb-6">
                            <div class="flex items-center mr-6 mb-2">
                                <i class="bi bi-calendar me-2"></i>
                                {{ $noticia->fecha_publicacion->format('d/m/Y') }}
                            </div>
                            @if($noticia->usuario)
                            <div class="flex items-center mr-6 mb-2">
                                <i class="bi bi-person me-2"></i>
                                {{ $noticia->usuario->nombre }} {{ $noticia->usuario->apellido }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Entradilla -->
                    @if($noticia->entradilla)
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
                        <p class="text-lg text-gray-700 font-semibold">
                            {{ $noticia->entradilla }}
                        </p>
                    </div>
                    @endif

                    <!-- Contenido principal -->
                    <div class="prose max-w-none text-gray-700 text-lg leading-relaxed">
                        {!! $noticia->cuerpo !!}
                    </div>

                </div>
            </article>

            <!-- Botones de acción -->
            <div class="flex justify-between items-center mt-8">
                <a href="{{ url()->previous() }}" 
                   class="flex items-center gap-2 text-[#336892] hover:text-blue-700 font-semibold">
                    <i class="bi bi-arrow-left"></i>
                    Volver atrás
                </a>
                
                <a href="{{ url('/') }}" 
                   class="flex items-center gap-2 bg-[#336892] text-white px-6 py-3 rounded-full hover:bg-blue-700 transition duration-300 font-semibold">
                    <i class="bi bi-house"></i>
                    Volver al Inicio
                </a>
            </div>

        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')

    <style>
        .prose {
            line-height: 1.8;
        }
        .prose p {
            margin-bottom: 1.5rem;
        }
        .prose img {
            border-radius: 0.5rem;
            margin: 2rem 0;
        }
    </style>
</body>
</html>