<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    // Constantes para los estados
    const ESTADO_BORRADOR = 'borrador';
    const ESTADO_REVISION = 'revisión';
    const ESTADO_PUBLICADO = 'publicado';
    const ESTADO_RECHAZADO = 'rechazado';

    protected $table = 'noticias';
    protected $primaryKey = 'id_noticia';

    protected $fillable = [
        'titulo',
        'ruta_slug',
        'entradilla',
        'cuerpo',
        'seo',
        'fecha_publicacion',
        'imagen_destacada',
        'estado',
        'categoria_id',
        'usuario_id',
        'motivo_rechazo', // Agregar este campo para el motivo de rechazo
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
    ];

    // Relación con categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_categoria');
    }

    // Relación con usuario (periodista/administrador)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id_usuario');
    }

    // Scope para noticias publicadas
    public function scopePublicadas($query)
    {
        return $query->where('estado', self::ESTADO_PUBLICADO)
                    ->where('fecha_publicacion', '<=', now());
    }

    // Scope para noticias pendientes
    public function scopePendientes($query)
    {
        return $query->where('estado', self::ESTADO_REVISION);
    }

    // Scope para noticias en borrador
    public function scopeBorradores($query)
    {
        return $query->where('estado', self::ESTADO_BORRADOR);
    }

    // Scope para noticias rechazadas
    public function scopeRechazadas($query)
    {
        return $query->where('estado', self::ESTADO_RECHAZADO);
    }

    // Verificar si la noticia está publicada
    public function estaPublicada()
    {
        return $this->estado === self::ESTADO_PUBLICADO && 
               $this->fecha_publicacion <= now();
    }

    // Verificar si la noticia está pendiente de revisión
    public function estaPendiente()
    {
        return $this->estado === self::ESTADO_REVISION;
    }

    // Verificar si la noticia está en borrador
    public function estaEnBorrador()
    {
        return $this->estado === self::ESTADO_BORRADOR;
    }

    // Verificar si la noticia está rechazada
    public function estaRechazada()
    {
        return $this->estado === self::ESTADO_RECHAZADO;
    }

    // Generar slug automáticamente desde el título
    public static function boot()
    {
        parent::boot();

        static::creating(function ($noticia) {
            $noticia->ruta_slug = \Illuminate\Support\Str::slug($noticia->titulo);
        });

        static::updating(function ($noticia) {
            $noticia->ruta_slug = \Illuminate\Support\Str::slug($noticia->titulo);
        });
    }
}