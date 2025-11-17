<?php

namespace App\Http\Controllers;

use App\Models\PicoPlaca;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        $picoYPlaca = PicoPlaca::latest()->first();

        return view('inicio', compact('picoYPlaca'));
    }
}
