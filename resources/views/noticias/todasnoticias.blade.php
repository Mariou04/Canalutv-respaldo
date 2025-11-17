<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todas las Noticias</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Navbar personalizado --}}
    @include('components.nav')

    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Todas las Noticias</h1>

        @if($noticias->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($noticias as $noticia)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        <a href="{{ route('noticia.show', $noticia->ruta_slug) }}" class="block hover:opacity-95 transition">
                            @if($noticia->imagen_portada)
                                <img src="{{ asset('storage/' . $noticia->imagen_portada) }}" 
                                     alt="{{ $noticia->titulo }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">📷 Sin imagen</span>
                                </div>
                            @endif

                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-800 mb-2">
                                    {{ $noticia->titulo }}
                                </h2>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit($noticia->contenido, 120) }}
                                </p>
                                <span class="text-blue-600 hover:text-blue-800 font-semibold">
                                    Leer más →
                                </span>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>

            @if(method_exists($noticias, 'links'))
                <div class="mt-8">
                    {{ $noticias->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="mb-4">
                    <span class="text-6xl">📰</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay noticias publicadas aún</h3>
                <p class="text-gray-500">Nuestro equipo está trabajando en nuevo contenido.</p>
            </div>
        @endif

        <div class="text-center mt-10">
            <a href="{{ route('inicio') }}" 
               class="bg-white text-blue-800 px-6 py-2 rounded-lg font-semibold hover:bg-blue-100 transition inline-flex items-center">
                <i class="bi bi-arrow-left me-2"></i> Volver al inicio
            </a>
        </div>
    </div>

    {{-- Footer personalizado --}}
    @include('components.footer')

</body>
</html>
