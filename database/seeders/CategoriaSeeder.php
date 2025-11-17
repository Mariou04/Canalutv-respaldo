<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Área Metropolitana',
                'slug' => 'area-metropolitana',
                'descripcion' => 'Noticias del Área Metropolitana de Bucaramanga',
                'orden' => 1,
                'activo' => true,
            ],
            [
                'nombre' => 'Santander',
                'slug' => 'santander',
                'descripcion' => 'Noticias de todo el departamento de Santander',
                'orden' => 2,
                'activo' => true,
            ],
            [
                'nombre' => 'Cultura',
                'slug' => 'cultura',
                'descripcion' => 'Eventos culturales, arte y tradiciones',
                'orden' => 3,
                'activo' => true,
            ],
            [
                'nombre' => 'Deportes',
                'slug' => 'deportes',
                'descripcion' => 'Noticias deportivas locales y nacionales',
                'orden' => 4,
                'activo' => true,
            ],
            [
                'nombre' => 'Nacional',
                'slug' => 'nacional',
                'descripcion' => 'Noticias de interés nacional',
                'orden' => 5,
                'activo' => true,
            ],
        ];

        foreach ($categorias as $categoria) {
            DB::table('categorias')->insert([
                'nombre' => $categoria['nombre'],
                'slug' => $categoria['slug'],
                'descripcion' => $categoria['descripcion'],
                'orden' => $categoria['orden'],
                'activo' => $categoria['activo'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}