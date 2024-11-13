<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'catalog_id' => 111122223333,
                'barcode' => 7791234567890,
                'name' => 'otro arroz',
                'description' => 'es otro arroz prueba actualizado',
                'unit_price' => 2000.00,
                'bulk_unit_price' => 1900.00,
                'bulk_unit' => null,
                'percent_off' => null,
                'offer' => 0,
                'price_offer' => null,
                'old_price' => null,
                'stock' => 0,
                'image_url' => '/image_url/default.jpeg',
                'category_id' => 4,
                'type_id' => 1,
            ],
            [
                'catalog_id' => 33332222,
                'barcode' => 7791234567890,
                'name' => 'arroz ala 2',
                'description' => '33333333333',
                'unit_price' => 3000.00,
                'bulk_unit_price' => 2000.00,
                'bulk_unit' => null,
                'percent_off' => null,
                'offer' => 0,
                'price_offer' => null,
                'old_price' => null,
                'stock' => 1,
                'image_url' => 'image_url/1726175755_arroz.png',
                'category_id' => 4,
                'type_id' => 1,
            ],
            [
                'catalog_id' => 44422222,
                'barcode' => 7791234567890,
                'name' => 'milanesa',
                'description' => 'carnitaaa',
                'unit_price' => 12000.00,
                'bulk_unit_price' => null,
                'bulk_unit' => null,
                'percent_off' => null,
                'offer' => 0,
                'price_offer' => null,
                'old_price' => null,
                'stock' => 1,
                'image_url' => 'image_url/1726182894_milanesa-de-cuadrada.jpg',
                'category_id' => 10,
                'type_id' => 2,
            ],
            [
                'catalog_id' => 32221111,
                'barcode' => 7791234567890,
                'name' => 'trompetas',
                'description' => 'hhhhhhh',
                'unit_price' => 500.00,
                'bulk_unit_price' => null,
                'bulk_unit' => null,
                'percent_off' => null,
                'offer' => 0,
                'price_offer' => null,
                'old_price' => null,
                'stock' => 0,
                'image_url' => '/image_url/default.jpeg',
                'category_id' => 3,
                'type_id' => 2,
            ],
            [
                'catalog_id' => 23211,
                'barcode' => 7791234567890,
                'name' => 'azucar',
                'description' => 'azucaaaaaaaaaar',
                'unit_price' => 22222.00,
                'bulk_unit_price' => null,
                'bulk_unit' => null,
                'percent_off' => null,
                'offer' => 0,
                'price_offer' => null,
                'old_price' => null,
                'stock' => 0,
                'image_url' => '/image_url/default.jpeg',
                'category_id' => 6,
                'type_id' => 2,
            ],
        ]);
    }
}
