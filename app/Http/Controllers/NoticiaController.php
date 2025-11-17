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
            ->where('usuario_id', Auth::id()) // ← CAMBIADO: usuario_id
            ->latest()
            ->get();

        return view('noticias.index', compact('noticias'));
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

    return redirect()->route('noticias.mis-noticias')
        ->with('success', 'Noticia creada exitosamente');
}

    public function show(Noticia $noticia)
    {
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
        if ($noticia->usuario_id !== Auth::id() && Auth::user()->rol_id !== 1) { // ← CAMBIADO: usuario_id → autor_id
            abort(403);
        }

        $categorias = Categoria::where('activo', true)->get();
        return view('noticias.edit', compact('noticia', 'categorias'));
    }

    public function update(Request $request, Noticia $noticia)
    {
        // Verificar permisos
        if ($noticia->usuario_id !== Auth::id() && Auth::user()->rol_id !== 1) { // ← CAMBIADO: usuario_id → autor_id
            abort(403);
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'entradilla' => 'required|string|max:500',
            'cuerpo' => 'required|string',
            'seo' => 'nullable|string|max:160',
            'fecha_publicacion' => 'nullable|date',
            'categoria_id' => 'required|exists:categorias,id_categoria',
            'imagen_portada' => 'nullable|image|max:2048', // ← CAMBIADO: imagen_portada → imagen_destacada
        ]);

        $noticia->titulo = $request->titulo;
        $noticia->entradilla = $request->entradilla;
        $noticia->cuerpo = $request->cuerpo;
        $noticia->seo = $request->seo;
        $noticia->fecha_publicacion = $request->fecha_publicacion;
        $noticia->categoria_id = $request->categoria_id;

        if ($request->hasFile('imagen_portada')) { // ← CAMBIADO: imagen_portada → imagen_destacada
            $path = $request->file('imagen_portada')->store('noticias', 'public');
            $noticia->imagen_portada = $path; // ← CAMBIADO: imagen_portada → imagen_destacada
        }

        $noticia->save();

        return redirect()->route('noticias.mis-noticias')
            ->with('success', 'Noticia actualizada exitosamente');
    }

    
    public function destroy(Noticia $noticia)
    {
        // Verificar permisos
        if ($noticia->usuario_id !== Auth::id() && Auth::user()->rol_id !== 1) { // ← CAMBIADO: usuario_id → autor_id
            abort(403);
        }

        $noticia->delete();

        return redirect()->route('noticias.mis-noticias')
            ->with('success', 'Noticia eliminada exitosamente');
    }
}