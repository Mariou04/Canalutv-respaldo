<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticiaController extends Controller
{
    public function index()
    {
        $noticias = Noticia::with('categoria')
            ->where('usuario_id', Auth::id())
            ->latest()
            ->get();

        return view('noticias.index', compact('noticias'));
    }

    public function buscar(Request $request)
    {
        $termino = $request->get('q');
        
        $noticias = Noticia::where('estado', 'publicado')
            ->where(function($query) use ($termino) {
                $query->where('titulo', 'LIKE', "%{$termino}%")
                      ->orWhere('cuerpo', 'LIKE', "%{$termino}%") // CAMBIADO: contenido → cuerpo
                      ->orWhere('entradilla', 'LIKE', "%{$termino}%"); // CAMBIADO: resumen → entradilla
            })
            ->orderBy('fecha_publicacion', 'desc')
            ->get();

        return view('busqueda.resultados', compact('noticias', 'termino'));
    }

    /**
     * Búsqueda en tiempo real (AJAX)
     */
    public function buscarLive(Request $request)
{
    $termino = $request->get('q');
    
    $noticias = Noticia::where('estado', 'publicado')
        ->where(function($query) use ($termino) {
            $query->where('titulo', 'LIKE', "%{$termino}%")
                  ->orWhere('cuerpo', 'LIKE', "%{$termino}%")
                  ->orWhere('entradilla', 'LIKE', "%{$termino}%");
        })
        ->orderBy('fecha_publicacion', 'desc')
        ->limit(5)
        ->get(['id_noticia', 'titulo', 'ruta_slug', 'entradilla', 'fecha_publicacion']); // CAMBIA 'slug' por 'ruta_slug'

    return response()->json(['noticias' => $noticias]);
}

    public function create()
    {
        $categorias = Categoria::where('activo', true)->get();
        return view('noticias.create', compact('categorias'));
    }

    public function store(Request $request)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'entradilla' => 'required|string|max:500',
        'cuerpo' => 'required|string',
        'seo' => 'nullable|string|max:160',
        'fecha_publicacion' => 'nullable|date',
        'categoria_id' => 'required|exists:categorias,id_categoria',
        'imagen_portada' => 'nullable|image|max:2048',
    ]);

    $noticia = new Noticia();
    $noticia->titulo = $request->titulo;
    $noticia->entradilla = $request->entradilla;
    $noticia->cuerpo = $request->cuerpo;
    $noticia->seo = $request->seo;
    $noticia->fecha_publicacion = $request->fecha_publicacion;
    $noticia->categoria_id = $request->categoria_id;
    $noticia->usuario_id = Auth::id();
    $noticia->estado = $request->input('estado', 'borrador');

    if ($request->hasFile('imagen_portada')) {
        $path = $request->file('imagen_portada')->store('noticias', 'public');
        $noticia->imagen_portada = $path;
    }

    $noticia->save();

    // 🔔 NOTIFICACIÓN SIMPLE - Guardar en session para mostrar a admins
    if (Auth::user()->rol_id != 1) { // Si NO es admin
        session()->flash('nueva_noticia_alert', [
            'titulo' => $noticia->titulo,
            'autor' => Auth::user()->nombre . ' ' . Auth::user()->apellido,
            'fecha' => now()->format('d/m/Y H:i'),
        ]);
    }

    return redirect()->route('noticias.mis-noticias')
        ->with('success', 'Noticia creada exitosamente.');
}

    public function show($slug)
{
    $noticia = Noticia::with(['categoria', 'usuario'])
        ->where('ruta_slug', $slug) // CAMBIA 'slug' por 'ruta_slug'
        ->where('estado', 'publicado')
        ->firstOrFail();
        
    return view('noticias.show', compact('noticia'));
}
    public function categoria($slug)
    {
        $categoria = \App\Models\Categoria::where('slug', $slug)->firstOrFail();

        $noticias = \App\Models\Noticia::where('categoria_id', $categoria->id_categoria)
            ->where('estado', 'publicado')
            ->where('fecha_publicacion', '<=', now())
            ->orderBy('fecha_publicacion', 'desc')
            ->paginate(6);

        $categorias = \App\Models\Categoria::orderBy('orden')->get();

        return view('noticias.categoria', compact('categoria', 'noticias', 'categorias'));
    }

    public function edit(Noticia $noticia)
    {
        // Verificar que el usuario es el dueño o es admin
        if ($noticia->usuario_id !== Auth::id() && Auth::user()->rol_id !== 1) {
            abort(403);
        }

        $categorias = Categoria::where('activo', true)->get();
        return view('noticias.edit', compact('noticia', 'categorias'));
    }

    public function update(Request $request, Noticia $noticia)
    {
        // Verificar permisos
        if ($noticia->usuario_id !== Auth::id() && Auth::user()->rol_id !== 1) {
            abort(403);
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'entradilla' => 'required|string|max:500',
            'cuerpo' => 'required|string',
            'seo' => 'nullable|string|max:160',
            'fecha_publicacion' => 'nullable|date',
            'categoria_id' => 'required|exists:categorias,id_categoria',
            'imagen_portada' => 'nullable|image|max:2048',
        ]);

        $noticia->titulo = $request->titulo;
        $noticia->entradilla = $request->entradilla;
        $noticia->cuerpo = $request->cuerpo;
        $noticia->seo = $request->seo;
        $noticia->fecha_publicacion = $request->fecha_publicacion;
        $noticia->categoria_id = $request->categoria_id;

        if ($request->hasFile('imagen_portada')) {
            $path = $request->file('imagen_portada')->store('noticias', 'public');
            $noticia->imagen_portada = $path;
        }

        $noticia->save();

        return redirect()->route('noticias.mis-noticias')
            ->with('success', 'Noticia actualizada exitosamente');
    }

    public function destroy(Noticia $noticia)
    {
        // Verificar permisos
        if ($noticia->usuario_id !== Auth::id() && Auth::user()->rol_id !== 1) {
            abort(403);
        }

        $noticia->delete();

        return redirect()->route('noticias.mis-noticias')
            ->with('success', 'Noticia eliminada exitosamente');
    }
}