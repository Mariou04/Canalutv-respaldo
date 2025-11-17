<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id_rol' => 1,
                'nombre' => 'Administrador',
                'descripcion' => 'Administrador del sistema con todos los permisos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => 2,
                'nombre' => 'Periodista',
                'descripcion' => 'Periodista que escribe y gestiona noticias',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}