@if($categorias->count() > 0)
<div class="bg-white shadow-sm py-6">
    <div class="container mx-auto px-2">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Categorías de Noticias</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($categorias as $categoria)
            <a href="/categoria/{{ $categoria->slug }}" 
               class="bg-white-500 hover:bg-blue-200 text-black p-2 rounded-lg text-center transition duration-300 transform hover:scale-105 shadow-md">
                <div class="text-lg font-semibold">{{ $categoria->nombre }}</div>
                <div class="text-sm opacity-90 mt-2">{{ $categoria->descripcion }}</div>
            </a>
            @endforeach
            <a href="{{ route('denuncia.formulario') }}"
   class="bg-white hover:bg-yellow-500 text-black p-2 rounded-lg text-center transition duration-300 transform hover:scale-105 shadow-md">
    <div class="text-lg font-semibold">Denuncia Ciudadana</div>
    <div class="text-sm opacity-90 mt-2">Reporta situaciones en tu comunidad</div>
</a>

    <!-- Botón de Pauta con Nosotros (WhatsApp) -->
    <a href="https://wa.me/573001234567" target="_blank"
       class="bg-white-500 hover:bg-yellow-500 text-black p-2 rounded-lg text-center transition duration-300 transform hover:scale-105 shadow-md">
        <div class="text-lg font-semibold">Pauta con Nosotros</div>
        <div class="text-sm opacity-90 mt-2">Realiza acuerdos publicitarios</div>
    </a>
        </div>
    </div>
</div>
@endif