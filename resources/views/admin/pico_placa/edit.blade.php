<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Editar Pico y Placa 🚗</h2>

        <form action="{{ route('admin.pico_placa.update') }}" method="POST">
            @csrf
            <textarea name="mensaje" 
                      class="w-full border border-gray-300 rounded-lg p-3 focus:ring focus:ring-blue-300"
                      rows="3"
                      placeholder="Ejemplo: Hoy 4 y 7, Mañana 2 y 6">{{ $picoPlaca->mensaje ?? '' }}</textarea>

            <button type="submit" 
                    class="mt-5 w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg transition">
                Guardar Cambios
            </button>
        </form>

        <a href="{{ url('/dashboard') }}" 
           class="inline-block mt-4 text-blue-600 hover:text-blue-800 font-medium">
            ← Volver al panel
        </a>
    </div>
</x-app-layout>
