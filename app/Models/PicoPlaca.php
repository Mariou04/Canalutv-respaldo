<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PicoPlaca extends Model
{
    protected $table = 'pico_placas';
    protected $fillable = ['mensaje']; // cambia "mensaje" si tu columna se llama diferente
}
