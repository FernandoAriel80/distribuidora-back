<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name'=>'Aceite'],
            ['name'=>'Arroz'],
            ['name'=>'Artículos de papel'],
            ['name'=>'Azúcar'],
            ['name'=>'Bebidas'],
            ['name'=>'Carne'],
            ['name'=>'Cervezas'],
            ['name'=>'Conservas'],
            ['name'=>'Cordero'],
            ['name'=>'Embutidos'],
            ['name'=>'Harinas'],
            ['name'=>'Leche'],
            ['name'=>'Legumbres'],
            ['name'=>'Licores'],
            ['name'=>'Panes y bollería'],
            ['name'=>'Pasta'],
            ['name'=>'Productos de higiene personal'],
            ['name'=>'Productos de limpieza'],
            ['name'=>'Sal'],
            ['name'=>'Snacks'],
            ['name'=>'Té'],
            ['name'=>'Vinos'],
            ['name'=>'Jugos']
        ]);
    }
}
