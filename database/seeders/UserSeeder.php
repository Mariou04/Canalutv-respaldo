<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('usuarios')->insert([
            'nombre' => 'Administrador',
            'apellido' => 'Sistema',
            'email' => 'admin@canalutv.com',
            'password' => Hash::make('admin123'),
            'activo' => true,
            'rol_id' => 1, // Administrador
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('usuarios')->insert([
            'nombre' => 'Periodista',
            'apellido' => 'Noticias',
            'email' => 'periodista@canalutv.com',
            'password' => Hash::make('periodista123'),
            'activo' => true,
            'rol_id' => 2, // Periodista
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}