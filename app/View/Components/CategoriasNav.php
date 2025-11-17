<?php

namespace App\View\Components;

use App\Models\Categoria;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoriasNav extends Component
{
    public $categorias;

    public function __construct()
    {
        $this->categorias = Categoria::orderBy('orden')->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.categorias-nav');
    }
}