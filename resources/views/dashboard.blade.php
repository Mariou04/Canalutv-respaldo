<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('') }}
            
        </h2>

        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Cerrar sesión
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

    </x-slot>

        <br>
<a href="{{ url('/') }}" class="bg-white text-blue-800 px-6 py-2 rounded-lg font-semibold hover:bg-blue-100 transition inline-flex items-center">
  <i class="bi bi-arrow-left me-2"></i> Volver
</a>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Bienvenido al Sistema de Noticias</h2>
                    
                    @auth
                        <!-- Enlaces para administradores -->
                        @if(Auth::user()->rol_id == 1)
                            <div class="mb-8 p-4 border-l-4 border-blue-500 bg-blue-50">
                                <h3 class="text-xl font-semibold mb-3 text-blue-800">🔐 Panel de Administración</h3>
                                <div class="space-y-2">
                                    <a href="{{ route('admin.panel') }}" class="block bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg transition duration-200">
                                        📊 Panel de Control Admin
                                    </a>
                                    <a href="{{ route('admin.gestion-usuarios') }}" class="block bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg transition duration-200">
                                        👥 Gestionar Usuarios
                                    </a>
                                </div>
                            </div>
                        @endif

                        
<br>

                        <!-- Enlaces para periodistas y admin -->
                        @if(in_array(Auth::user()->rol_id, [1, 2]))
                            <div class="mb-8 p-4 border-l-4 border-purple-500 bg-purple-50">
                                <h3 class="text-xl font-semibold mb-3 text-purple-800">📰 Gestión de Noticias</h3>
                                <div class="space-y-2">
                                    <a href="{{ route('noticias.create') }}" class="block bg-purple-500 hover:bg-purple-600 text-white px-4 py-3 rounded-lg transition duration-200">
                                        ✏️ Crear Nueva Noticia
                                    </a>
                                    <a href="{{ route('noticias.mis-noticias') }}" class="block bg-orange-500 hover:bg-orange-600 text-white px-4 py-3 rounded-lg transition duration-200">
                                        📋 Mis Noticias
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- Información del usuario -->
                        <div class="mt-8 p-6 bg-gray-100 rounded-lg border">
                            <h3 class="text-lg font-semibold mb-3">👤 Información del Usuario</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Nombre completo</p>
                                    <p class="font-medium">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Email</p>
                                    <p class="font-medium">{{ Auth::user()->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Rol</p>
                                    <p class="font-medium">
                                        @if(Auth::user()->rol_id == 1)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Administrador</span>
                                        @elseif(Auth::user()->rol_id == 2)
                                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded">Periodista</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Estado</p>
                                    <p class="font-medium">
                                        @if(Auth::user()->activo)
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Activo</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Inactivo</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="text-center py-8">
                            <p class="text-lg mb-4">Por favor inicia sesión para acceder al sistema</p>
                            <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition duration-200">
                                Iniciar Sesión
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    

    <!-- Editar Pico y Placa -->
<a href="{{ route('admin.pico_placa.edit') }}" 
   class="flex flex-col items-center justify-center bg-gradient-to-r from-red-500 to-red-600 
          hover:from-red-600 hover:to-red-700 text-white p-6 rounded-2xl shadow-md 
          hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
    <div class="bg-white bg-opacity-20 rounded-full p-4 mb-3">
        <span class="text-4xl">🚗</span>
    </div>
    <span class="font-semibold text-lg tracking-wide">Editar Pico y Placa</span>
</a>

</x-app-layout>