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

        $now = now();

        $categories = [
            ['name' => 'Aceites', 'top_category_id' => $topCategories['Almacen'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Arroz', 'top_category_id' => $topCategories['Almacen'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Aguas', 'top_category_id' => $topCategories['Bebidas'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Azucar', 'top_category_id' => $topCategories['Almacen'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Budines', 'top_category_id' => $topCategories['Kiosco'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cafe', 'top_category_id' => $topCategories['Desayuno'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Endulzantes', 'top_category_id' => $topCategories['Almacen'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Fideos', 'top_category_id' => $topCategories['Almacen'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Galletitas', 'top_category_id' => $topCategories['Kiosco'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Gaseosas', 'top_category_id' => $topCategories['Bebidas'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Harinas', 'top_category_id' => $topCategories['Almacen'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Jugos', 'top_category_id' => $topCategories['Bebidas'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Mate Cocido', 'top_category_id' => $topCategories['Desayuno'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Miel', 'top_category_id' => $topCategories['Desayuno'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Yerba', 'top_category_id' => $topCategories['Desayuno'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Panes', 'top_category_id' => $topCategories['Panaderia'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sal', 'top_category_id' => $topCategories['Almacen'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Te', 'top_category_id' => $topCategories['Desayuno'], 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Vinos', 'top_category_id' => $topCategories['Bebidas'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Bizcochuelos', 'top_category_id' => $topCategories['Panaderia'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Alfajores', 'top_category_id' => $topCategories['Kiosco'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Cacao', 'top_category_id' => $topCategories['Desayuno'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Caramelos', 'top_category_id' => $topCategories['Kiosco'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Cereales', 'top_category_id' => $topCategories['Almacen'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Chicles', 'top_category_id' => $topCategories['Kiosco'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Chocolates', 'top_category_id' => $topCategories['Kiosco'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Enlatados', 'top_category_id' => $topCategories['Almacen'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Fernet', 'top_category_id' => $topCategories['Bebidas'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Legumbres', 'top_category_id' => $topCategories['Almacen'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Postres', 'top_category_id' => $topCategories['Almacen'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Sigras', 'top_category_id' => $topCategories['Bebidas'], 'created_at' => $now, 'updated_at' => $now],
            //['name' => 'Snacks', 'top_category_id' => $topCategories['Almacen'], 'created_at' => $now, 'updated_at' => $now],
        ];
        

        try {
            DB::table('categories')->insert($categories);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
