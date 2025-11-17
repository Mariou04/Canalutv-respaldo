<nav class="bg-[#336892] fixed top-0 w-full shadow-md z-50">
  <div class="container mx-auto flex justify-between items-center px-4 py-2 relative">

    <!-- Logo -->
    <a href="#" class="flex items-center">
      <img 
        src="{{ asset('images/logo.png') }}" 
        alt="Logo" 
        class="h-10 md:h-14 transition-all duration-300"
      >
    </a>

    <!-- Fecha centrada -->
    <div class="absolute left-1/2 transform -translate-x-1/2 hidden sm:block">
      <span id="fecha" class="bg-white text-gray-900 px-3 py-1 rounded-full font-semibold text-xs"></span>
    </div>

    <!-- Botón del menú -->
    <button 
      id="menuBtn" 
      class="text-white text-3xl focus:outline-none"
    >
      <i class="bi bi-list"></i>
    </button>
  </div>

  <!-- MENÚ LATERAL -->
  <div 
    id="offcanvasMenu" 
    class="fixed top-0 right-0 h-full w-64 bg-[#336892] text-white transform translate-x-full transition-transform duration-300 ease-in-out z-50 p-5 overflow-y-auto"
  >
    <div class="flex justify-between items-center mb-4">
      <h5 class="text-lg font-bold">Menú</h5>
      <button id="closeMenu" class="text-white text-2xl">&times;</button>
    </div>

    <!-- Buscador -->
    <div class="mb-3">
      <input 
        type="text" 
        placeholder="Buscar" 
        class="w-full rounded-full px-4 py-2 border-0 text-gray-900 placeholder-gray-400"
      >
    </div>

    <!-- Categorías -->
    <div class="mb-3">
      <button id="toggleCategorias" class="flex justify-between w-full font-semibold text-left">
        Categorías <span id="catArrow" class="transition-transform duration-300">▼</span>
      </button>
      <ul id="categoriasLista" class="ml-3 mt-2 space-y-1 text-sm hidden">
        <li>Área Metropolitana</li>
        <li>Santander</li>
        <li>Cultura</li>
        <li>Deportes</li>
        <li>Nacional</li>
      </ul>
    </div>

    <!-- Filtros -->
    <div class="mb-4">
      <button id="toggleFiltros" class="flex justify-between w-full font-semibold text-left">
        Filtros <span id="filtArrow" class="transition-transform duration-300">▼</span>
      </button>
      <div id="filtrosLista" class="text-sm text-gray-200 mt-2 hidden ml-3">
        Próximamente...
      </div>
    </div>

    <!-- Redes sociales -->
    <div class="flex gap-4 mt-6">
      <a href="https://www.tiktok.com/@canal.utv" class="text-white text-2xl"><i class="bi bi-tiktok"></i></a>
      <a href="https://www.instagram.com/canal.utv/?fbclid=IwY2xjawN92z1leHRuA2FlbQIxMABicmlkETE4T1ZwOG02VXJBeUl3TFFOc3J0YwZhcHBfaWQQMjIyMDM5MTc4ODIwMDg5MgABHu0rb8PFi1n7hEsMZ3acBxqGjhhae27T4QHcAdmk00V2Uy1nET6PUZeBqX6b_aem_oLy1yhUUIHfQ1wGIZ0Pu5A" class="text-white text-2xl"><i class="bi bi-instagram"></i></a>
      <a href="https://www.youtube.com/@redesutv2025" class="text-white text-2xl"><i class="bi bi-youtube"></i></a>
     <a href="https://x.com/canal_utv" class="text-white text-2xl"><i class="bi bi-x"></i></a>
     <a href="{{ route('login') }}" class="text-white text-2xl hover:text-gray-300 transition">
    <i class="bi bi-person-circle"></i>
    </a>


    </div>
  </div>
</nav>

<!-- ====== SCRIPTS ====== -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Fecha
    const fechaEl = document.getElementById('fecha');
    if (fechaEl) {
      const meses = ['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
      const hoy = new Date();
      fechaEl.textContent = `${hoy.getDate()} / ${meses[hoy.getMonth()]} / ${hoy.getFullYear()}`;
    }

    // Menú lateral
    const menuBtn = document.getElementById('menuBtn');
    const closeMenu = document.getElementById('closeMenu');
    const offcanvas = document.getElementById('offcanvasMenu');

    if (menuBtn && closeMenu && offcanvas) {
      menuBtn.addEventListener('click', () => offcanvas.classList.remove('translate-x-full'));
      closeMenu.addEventListener('click', () => offcanvas.classList.add('translate-x-full'));
    }

    // Categorías desplegables
    const toggleCategorias = document.getElementById('toggleCategorias');
    const categoriasLista = document.getElementById('categoriasLista');
    const catArrow = document.getElementById('catArrow');

    if (toggleCategorias) {
      toggleCategorias.addEventListener('click', () => {
        categoriasLista.classList.toggle('hidden');
        catArrow.classList.toggle('rotate-180');
      });
    }


    

    // Filtros desplegables
    const toggleFiltros = document.getElementById('toggleFiltros');
    const filtrosLista = document.getElementById('filtrosLista');
    const filtArrow = document.getElementById('filtArrow');

    if (toggleFiltros) {
      toggleFiltros.addEventListener('click', () => {
        filtrosLista.classList.toggle('hidden');
        filtArrow.classList.toggle('rotate-180');
      });
    }
  });
</script>
