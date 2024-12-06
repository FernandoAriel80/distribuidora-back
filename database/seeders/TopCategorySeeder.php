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
        $topCategories = [
            ['name' => 'Almacén'],
            ['name' => 'Bebidas'],
            ['name' => 'Desayuno'],
            ['name' => 'Panadería'],
            ['name' => 'Kiosco'],
        ];

        DB::table('top_categories')->insert($topCategories);
    }
}
