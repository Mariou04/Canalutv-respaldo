<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Denuncia;

class DenunciaController extends Controller
{
    public function index(): View
    {
        $denuncias = Denuncia::latest()->get();
        return view('admin.denuncias.recibidas', compact('denuncias'));
    }

    public function formulario(): View
    {
        return view('denuncias.formulario');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required'
        ]);

        Denuncia::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'mensaje' => $request->descripcion // si lo necesitas
        ]);

        return back()->with('success', 'Denuncia enviada correctamente');
    }
}
