<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PicoPlaca;

class PicoPlacaController extends Controller
{
    public function edit()
    {
        $picoPlaca = PicoPlaca::first();
        return view('admin.pico_placa.edit', compact('picoPlaca'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:255',
        ]);

        $picoPlaca = PicoPlaca::first();
        if (!$picoPlaca) {
            $picoPlaca = new PicoPlaca();
        }

        $picoPlaca->mensaje = $request->mensaje;
        $picoPlaca->save();

        return redirect()->back()->with('success', 'Pico y Placa actualizado correctamente');
    }
}
