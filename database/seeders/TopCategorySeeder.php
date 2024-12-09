<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $topCategories = [
            ['name' => 'Almacen', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bebidas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Desayuno', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Panaderia', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kiosco', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('top_categories')->insert($topCategories);
    }
}
