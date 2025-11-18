<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function panel()
    {
        $estadisticas = [
            'total_noticias' => Noticia::count(),
            'noticias_pendientes' => Noticia::where('estado', 'revisión')->count(),
            'noticias_publicadas' => Noticia::where('estado', 'publicado')->count(),
            'total_usuarios' => User::count(),
            'total_categorias' => Categoria::count(),
        ];

        $noticiasPendientes = Noticia::with(['categoria', 'usuario'])
            ->where('estado', 'revisión')
            ->orderBy('created_at', 'desc')
            ->get();

        $noticiasRecientes = Noticia::with(['categoria', 'usuario'])
            ->where('estado', 'publicado')
            ->orderBy('fecha_publicacion', 'desc')
            ->take(5)
            ->get();

        return view('admin.panel', compact('estadisticas', 'noticiasPendientes', 'noticiasRecientes'));
    }

    // En App\Http\Controllers\AdminController.php
public function destroyUsuario(User $usuario)
{
    // Evitar que un admin se elimine a sí mismo
    if ($usuario->id === auth()->id()) {
        return redirect()->route('admin.gestion-usuarios')
            ->with('error', 'No puedes eliminar tu propio usuario');
    }

    
    $adminsCount = User::where('rol_id', 1)->count();
    if ($usuario->rol_id == 1 && $adminsCount <= 1) {
        return redirect()->route('admin.gestion-usuarios')
            ->with('error', 'No puedes eliminar el último administrador');
    }

    $usuario->delete();

    return redirect()->route('admin.gestion-usuarios')
        ->with('success', 'Usuario eliminado exitosamente');
}

    public function moderarNoticias()
    {
        $noticias = Noticia::with(['categoria', 'usuario'])
            ->whereIn('estado', ['revisión', 'borrador'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.moderar-noticias', compact('noticias'));
    }

    public function aprobarNoticia(Request $request, Noticia $noticia)
    {
        $noticia->estado = 'publicado';
        $noticia->fecha_publicacion = now();
        $noticia->save();

        return redirect()->back()->with('success', 'Noticia aprobada y publicada exitosamente.');
    }
    

    public function rechazarNoticia(Request $request, Noticia $noticia)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500'
        ]);

        $noticia->estado = 'rechazado';
        $noticia->motivo_rechazo = $request->motivo_rechazo;
        $noticia->save();

        return redirect()->back()->with('success', 'Noticia rechazada exitosamente.');
    }

    public function gestionUsuarios()
    {
        $usuarios = User::with('rol')->orderBy('created_at', 'desc')->get();
        return view('admin.gestion-usuarios', compact('usuarios'));
    }

    public function toggleUsuario(User $usuario)
    {
        $usuario->activo = !$usuario->activo;
        $usuario->save();

        $estado = $usuario->activo ? 'activada' : 'desactivada';
        return redirect()->back()->with('success', "Cuenta de usuario {$estado} exitosamente.");
    }
}