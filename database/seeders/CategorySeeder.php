<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; 

class CategorySeeder extends Seeder
{
    public function run()
    {
        $area = Category::create(['name' => 'Área metropolitana']);

        Category::create(['name' => 'Girón', 'parent_id' => $area->id]);
        Category::create(['name' => 'Bucaramanga', 'parent_id' => $area->id]);
        Category::create(['name' => 'Piedecuesta', 'parent_id' => $area->id]);
        Category::create(['name' => 'Floridablanca', 'parent_id' => $area->id]);
    }
}
