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
        $topCategories = DB::table('top_categories')->pluck('id', 'name');

        $categories = [
            ['name' => 'Aceites', 'top_category_id' => $topCategories['Almacén']],
            ['name' => 'Alfajores', 'top_category_id' => $topCategories['Kiosco']],
            ['name' => 'Arroz', 'top_category_id' => $topCategories['Almacén']],
            ['name' => 'Aguas', 'top_category_id' => $topCategories['Bebidas']],
            ['name' => 'Azúcar', 'top_category_id' => $topCategories['Almacén']],
            ['name' => 'Bizcochuelos', 'top_category_id' => $topCategories['Panadería']],
            ['name' => 'Budines', 'top_category_id' => $topCategories['Kiosco']],
            ['name' => 'Cacao', 'top_category_id' => $topCategories['Desayuno']],
            ['name' => 'Caramelos', 'top_category_id' => $topCategories['Kiosco']],
            ['name' => 'Café', 'top_category_id' => $topCategories['Desayuno']],
            ['name' => 'Cereales', 'top_category_id' => $topCategories['Almacén']],
            ['name' => 'Chicles', 'top_category_id' => $topCategories['Kiosco']],
            ['name' => 'Chocolates', 'top_category_id' => $topCategories['Kiosco']],
            ['name' => 'Enlatados', 'top_category_id' => $topCategories['Almacén']],
            ['name' => 'Endulzantes', 'top_category_id' => $topCategories['Almacén']],
            ['name' => 'Fernet', 'top_category_id' => $topCategories['Bebidas']],
            ['name' => 'Fideos', 'top_category_id' => $topCategories['Almacén']],
            ['name' => 'Galletitas', 'top_category_id' => $topCategories['Kiosco']],
            ['name' => 'Gaseosas', 'top_category_id' => $topCategories['Bebidas']],
            ['name' => 'Harinas', 'top_category_id' => $topCategories['Almacén']],
            ['name' => 'Jugos', 'top_category_id' => $topCategories['Bebidas']],
            ['name' => 'Legumbres', 'top_category_id' => $topCategories['Almacén']],
            ['name' => 'Mate Cocido', 'top_category_id' => $topCategories['Desayuno']],
            ['name' => 'Miel', 'top_category_id' => $topCategories['Desayuno']],
            ['name' => 'Panes', 'top_category_id' => $topCategories['Panadería']],
            ['name' => 'Postres', 'top_category_id' => $topCategories['Almacén']],
            ['name' => 'Sal', 'top_category_id' => $topCategories['Almacén']],
            ['name' => 'Sigras', 'top_category_id' => $topCategories['Bebidas']],
            ['name' => 'Snacks', 'top_category_id' => $topCategories['Almacén']],
            ['name' => 'Té', 'top_category_id' => $topCategories['Desayuno']],
            ['name' => 'Vinos', 'top_category_id' => $topCategories['Bebidas']],
            ['name' => 'Yerba', 'top_category_id' => $topCategories['Desayuno']],
        ];
        
        DB::table('categories')->insert($categories);
    }
}
