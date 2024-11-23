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
                'name' => 'Arroz',
                'description' => 'Arroz comun de 1kg',
                'unit_price' => 2000.00,
                'bulk_unit_price' => 1900.00,
                'bulk_unit' => 10,
                'percent_off' => null,
                'offer' => 0,
                'price_offer' => null,
                'old_price' => null,
                'stock' => 0,
                'image_url' => 'image_url/default.jpeg',
                'category_id' => 2,
                'type_id' => 1,
            ],
            [
                'catalog_id' => 33332222,
                'barcode' => 7791234567890,
                'name' => 'Azucar',
                'description' => 'Azucar comun de 1kg',
                'unit_price' => 2500.00,
                'bulk_unit_price' => 2000.00,
                'bulk_unit' => 10,
                'percent_off' => 5,
                'offer' => 1,
                'price_offer' => 2500.00,
                'old_price' => 3000.00,
                'stock' => 1,
                'image_url' => 'image_url/default.jpeg',
                'category_id' => 4,
                'type_id' => 1,
            ],
            [
                'catalog_id' => 44422222,
                'barcode' => 7791234567890,
                'name' => 'Milanesa',
                'description' => 'Milanesas el kg',
                'unit_price' => 8000.00,
                'bulk_unit_price' => null,
                'bulk_unit' => null,
                'percent_off' => null,
                'offer' => 0,
                'price_offer' => null,
                'old_price' => null,
                'stock' => 1,
                'image_url' => 'image_url/default.jpeg',
                'category_id' => 6,
                'type_id' => 2,
            ],
            [
                'catalog_id' => 32221111,
                'barcode' => 7791234567890,
                'name' => 'Pan',
                'description' => 'Pan por kg',
                'unit_price' => 1200.00,
                'bulk_unit_price' => null,
                'bulk_unit' => null,
                'percent_off' => 5,
                'offer' => 1,
                'price_offer' => 1200.00,
                'old_price' => 1500.00,
                'stock' => 0,
                'image_url' => 'image_url/default.jpeg',
                'category_id' => 15,
                'type_id' => 2,
            ],
            [
                'catalog_id' => 23211,
                'barcode' => 7791234567890,
                'name' => 'Agua',
                'description' => 'Agua 1lt',
                'unit_price' => 2000.00,
                'bulk_unit_price' => 1800.00,
                'bulk_unit' => 6,
                'percent_off' => null,
                'offer' => 0,
                'price_offer' => null,
                'old_price' => null,
                'stock' => 1,
                'image_url' => 'image_url/default.jpeg',
                'category_id' => 5,
                'type_id' => 1,
            ],
        ]);
    }
}
