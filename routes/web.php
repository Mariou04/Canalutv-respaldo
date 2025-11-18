<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DenunciaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

// ==================== RUTAS PÚBLICAS ====================

// Ruta principal - Página de inicio
Route::get('/', function () {
    $categorias = \App\Models\Categoria::orderBy('orden')->get();
    $noticias = \App\Models\Noticia::where('estado', 'publicado')
                ->where('fecha_publicacion', '<=', now())
                ->orderBy('fecha_publicacion', 'desc')
                ->take(6)
                ->get();


                

    $picoYPlaca = \App\Models\PicoPlaca::latest()->first();

    return view('inicio', compact('categorias', 'noticias', 'picoYPlaca'));
})->name('inicio');
// Ruta para ver una noticia individual (pública)
Route::get('/noticia/{slug}', function ($slug) {
    $noticia = \App\Models\Noticia::where('ruta_slug', $slug)
                ->where('estado', 'publicado')
                ->where('fecha_publicacion', '<=', now())
                ->firstOrFail();
    
    return view('noticias.show', compact('noticia'));
})->name('noticia.show');


// todas las noticias boton
Route::get('/noticias', function () {
    $noticias = \App\Models\Noticia::where('estado', 'publicado')
                ->orderBy('fecha_publicacion', 'desc')
                ->get();

    return view('noticias.todasnoticias', compact('noticias'));
})->name('noticias.publicas');


// ==================== RUTAS DE AUTENTICACIÓN ====================

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== RUTAS PROTEGIDAS POR ROLES ====================

// Solo administradores
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/panel', [AdminController::class, 'panel'])->name('admin.panel');
    Route::get('/admin/moderar-noticias', [AdminController::class, 'moderarNoticias'])->name('admin.moderar-noticias');
    Route::get('/admin/gestion-usuarios', [AdminController::class, 'gestionUsuarios'])->name('admin.gestion-usuarios');
    Route::post('/admin/noticias/{noticia}/aprobar', [AdminController::class, 'aprobarNoticia'])->name('admin.noticias.aprobar');
    Route::post('/admin/noticias/{noticia}/rechazar', [AdminController::class, 'rechazarNoticia'])->name('admin.noticias.rechazar');
    Route::post('/admin/usuarios/{usuario}/toggle', [AdminController::class, 'toggleUsuario'])->name('admin.usuarios.toggle');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    // Ruta para eliminar usuario
    Route::delete('/admin/usuarios/{usuario}', [AdminController::class, 'destroyUsuario'])
        ->name('admin.usuarios.destroy');
});

// Administradores y periodistas - GESTIÓN DE NOTICIAS
Route::middleware(['auth', 'journalist'])->group(function () {
    Route::get('/noticias/crear', [NoticiaController::class, 'create'])->name('noticias.create');
    Route::post('/noticias/crear', [NoticiaController::class, 'store'])->name('noticias.store');
    Route::get('/mis-noticias', [NoticiaController::class, 'index'])->name('noticias.mis-noticias');
    Route::get('/noticias/{noticia}/editar', [NoticiaController::class, 'edit'])->name('noticias.edit');
    Route::put('/noticias/{noticia}', [NoticiaController::class, 'update'])->name('noticias.update');
    Route::delete('/noticias/{noticia}', [NoticiaController::class, 'destroy'])->name('noticias.destroy');
});

use App\Http\Controllers\Admin\PicoPlacaController;

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/pico-placa/edit', [PicoPlacaController::class, 'edit'])->name('pico_placa.edit');
    Route::post('/pico-placa/update', [PicoPlacaController::class, 'update'])->name('pico_placa.update');
});

use App\Http\Controllers\WeatherController;
Route::get('/api/weather', [WeatherController::class, 'getWeather']);

Route::get('/categoria/{slug}', [NoticiaController::class, 'categoria'])->name('categoria.show');

// Ver formulario
Route::get('/denuncia-ciudadana', [DenunciaController::class, 'formulario'])
    ->name('denuncia.formulario');

// Enviar denuncia
Route::post('/denuncia-ciudadana', [DenunciaController::class, 'store'])
    ->name('denuncia.store');
require __DIR__.'/auth.php';

// Ver todas las denuncias EN ADMIN (pero tú decides quién puede entrar)
Route::get('/admin/denuncias', [DenunciaController::class, 'index'])
    ->name('denuncia.index');

// Ruta normal de búsqueda (para cuando presionan enter)
Route::get('/buscar', [NoticiaController::class, 'buscar'])->name('buscar');

// Ruta para búsqueda en tiempo real (AJAX)
Route::get('/buscar-live', [NoticiaController::class, 'buscarLive'])->name('buscar.live');

// Ruta para ver noticia individual - usa ruta_slug
Route::get('/noticia/{slug}', [NoticiaController::class, 'show'])->name('noticia.show');