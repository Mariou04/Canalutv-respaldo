<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'orden',
        'activo',
    ];

    public function noticias()
    {
        return $this->hasMany(Noticia::class, 'categoria_id', 'id_categoria');
    }
}