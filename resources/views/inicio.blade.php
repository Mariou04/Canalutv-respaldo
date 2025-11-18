<!DOCTYPE html>
<html>
<head>
    <title>Canal UTV - Noticias</title>
    <script src="https://cdn.tailwindcss.com"></script>
<link 
  rel="stylesheet" 
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>
<body class="bg-gray-100">
    <!-- Header -->
<x-nav />



    <!-- Componente de categorías -->
    <x-categorias-nav />

    <!-- Información sección -->
<section class="border-b-4 border-gray-300 bg-white py-8">
  <div class="max-w-6xl mx-auto flex flex-col lg:flex-row justify-center gap-6 px-4">

    <!-- PICO Y PLACA -->
    <div class="flex-1 bg-[#00688B] rounded-2xl text-white p-6 text-center shadow-md">
      <div class="inline-block bg-[#FF7A00] text-white font-bold text-lg px-6 py-1 rounded-xl mb-4">
        PICO Y PLACA
      </div>
      @if(isset($picoYPlaca) && $picoYPlaca->mensaje)
        <div class="bg-[#fcff19] border-l-4 border-yellow-500 text-black p-4 mb-4 rounded">
          <strong>{{ $picoYPlaca->mensaje }}</strong>
        </div>
      @endif
    </div>

<!-- CLIMA -->
<div class="flex-1 bg-[#00688B] rounded-2xl text-white p-3 text-center shadow-md">
  <div class="inline-block bg-[#FF7A00] text-white font-bold text-lg px-6 py-1 rounded-xl mb-4">
    CLIMA
  </div>

  <!-- Contenedor del clima -->
  <div id="clima" class="text-lg leading-relaxed">
    <div id="weather-section" class="grid grid-cols-3 gap-2 justify-center"></div>
  </div>
</div>
    <!-- EN VIVO -->
    <a href="https://www.youtube.com/@redesutv2025" target="_blank"
       class="flex-1 bg-white border-4 border-black rounded-2xl p-6 flex flex-col items-center justify-center text-center shadow-md hover:scale-105 transition-transform">
      <div class="inline-block bg-red-600 text-white font-bold text-lg px-5 py-1 rounded-full mb-4">
        EN VIVO
      </div>
      <div class="text-6xl text-red-600 mb-2">▶</div>
      <p class="text-black font-semibold">Mira nuestro canal</p>
    </a>

  </div>
</section>
<br>
  <p class="text-gray-600 text-lg text-left max-w-7xl mx-auto">
            Canal UTV es el medio universitario de la UDES donde se producen contenidos informativos y culturales que conectan la vida académica con la comunidad. Es un espacio de aprendizaje, creatividad y servicio a través de proyectos audiovisuales.
        </p>
<script>
document.addEventListener("DOMContentLoaded", async () => {
  const climaContainer = document.getElementById("clima");
  try {
    const response = await fetch("/api/weather");
    const data = await response.json();

    if (data.length > 0) {
      climaContainer.innerHTML = data.map(city => `
        <div class="bg-white text-black rounded-xl p-3 mb-3 shadow-md">
          <div class="font-semibold">${city.city}</div>
          <div class="flex justify-center items-center gap-2 mt-1">
            <img src="https://openweathermap.org/img/wn/${city.icon}@2x.png" alt="${city.desc}" class="w-8 h-8">
            <span class="text-xl font-bold">${city.temp}°C</span>
          </div>
          <div class="text-sm opacity-80">${city.desc}</div>
        </div>
      `).join('');
    } else {
      climaContainer.textContent = "No se pudo obtener el clima.";
    }
  } catch (error) {
    console.error(error);
    climaContainer.textContent = "Error al cargar el clima.";
  }
});
</script>



    <!-- Noticias Recientes -->
    <main class="container mx-auto p-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Noticias Recientes</h2>
        
        @if($noticias->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($noticias as $noticia)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <!-- Imagen de la noticia -->
                    @if($noticia->imagen_portada)
<a href="{{ route('noticia.show', $noticia->ruta_slug) }}">
    <img src="{{ asset('storage/' . $noticia->imagen_portada) }}" 
         alt="{{ $noticia->titulo }}" 
         class="w-full h-48 object-cover">
</a>

                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400">📷 Sin imagen</span>
                        </div>
                    @endif
                    
                    <!-- Contenido de la noticia -->
                    <div class="p-6">
                        <!-- Categoría -->
                        <div class="mb-2">
                            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">
                                {{ $noticia->categoria->nombre }}
                            </span>
                        </div>
                        
                        <!-- Título -->
<h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">
    <a href="{{ route('noticia.show', $noticia->ruta_slug) }}" class="hover:text-blue-700 transition">
        {{ $noticia->titulo }}
    </a>
</h3>

                        
                        <!-- Entradilla -->
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ $noticia->entradilla }}
                        </p>
                        
                        <!-- Fecha y autor -->
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <div>
                                 {{ $noticia->fecha_publicacion->format('d/m/Y') }}
                            </div>
                            <div>
                                ✍️ {{ $noticia->usuario->nombre }}
                            </div>
                        </div>
                        
                        <!-- Botón leer más -->
                        <a href="{{ route('noticia.show', $noticia->ruta_slug) }}" 
                           class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200">
                            Leer más →
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
            
            <!-- Botón ver más noticias -->
            <div class="text-center mt-12">
                <a href="{{ route('noticias.publicas') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-200">
                    Ver todas las noticias
                </a>
            </div>
            
        @else
            <!-- Estado cuando no hay noticias -->
            <div class="text-center py-12">
                <div class="mb-4">
                    <span class="text-6xl">📰</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay noticias publicadas aún</h3>
                <p class="text-gray-500">Nuestro equipo está trabajando en nuevo contenido</p>
            </div>
        @endif
    </main>

<x-footer />


</body>
</html>