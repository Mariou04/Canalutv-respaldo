// Fecha
document.addEventListener("DOMContentLoaded", () => {
  const fechaEl = document.getElementById('fecha');
  if (fechaEl) {
    const meses = [
      'ENERO','FEBRERO','MARZO','ABRIL','MAYO',
      'JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'
    ];
    const hoy = new Date();
    fechaEl.textContent = `${hoy.getDate()} / ${meses[hoy.getMonth()]} / ${hoy.getFullYear()}`;
  }

  // Menú lateral
  const menuBtn = document.getElementById('menuBtn');
  const closeMenu = document.getElementById('closeMenu');
  const offcanvas = document.getElementById('offcanvasMenu');

  if (menuBtn && closeMenu && offcanvas) {
    menuBtn.addEventListener('click', () => {
      offcanvas.classList.remove('translate-x-full');
      offcanvas.classList.add('translate-x-0');
    });

    closeMenu.addEventListener('click', () => {
      offcanvas.classList.add('translate-x-full');
      offcanvas.classList.remove('translate-x-0');
    });
  }

  // Categorías
  const toggleCategorias = document.getElementById('toggleCategorias');
  const categoriasLista = document.getElementById('categoriasLista');
  const catArrow = document.getElementById('catArrow');

  if (toggleCategorias && categoriasLista && catArrow) {
    toggleCategorias.addEventListener('click', () => {
      categoriasLista.classList.toggle('hidden');
      catArrow.classList.toggle('rotate-180');
    });
  }

  // Filtros
  const toggleFiltros = document.getElementById('toggleFiltros');
  const filtrosLista = document.getElementById('filtrosLista');
  const filtArrow = document.getElementById('filtArrow');

  if (toggleFiltros && filtrosLista && filtArrow) {
    toggleFiltros.addEventListener('click', () => {
      filtrosLista.classList.toggle('hidden');
      filtArrow.classList.toggle('rotate-180');
    });
  }
});

import '@fortawesome/fontawesome-free/css/all.min.css';
