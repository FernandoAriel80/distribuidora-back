<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
  /**
     * Run the database seeds.
     */ 
    class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Cunnington Cola', 'description' => 'Light 2,25Lt.', 'unit_price' => 1500, 'bulk_unit_price' => 1300, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Cunnington Cola', 'description' => '2,25Lt.', 'unit_price' => 1450, 'bulk_unit_price' => 1350, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Cunnington Naranja', 'description' => 'Light 2,25Lt.', 'unit_price' => 1500, 'bulk_unit_price' => 1300, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Crush Naranja', 'description' => '2,25Lt.', 'unit_price' => 1500, 'bulk_unit_price' => 1300, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Fanta Naranja', 'description' => '2,25Lt.', 'unit_price' => 3800, 'bulk_unit_price' => 3600, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Coca Cola', 'description' => '2,25Lt.', 'unit_price' => 3800, 'bulk_unit_price' => 3600, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Coca Cola', 'description' => 'Zero 2,25Lt.', 'unit_price' => 3800, 'bulk_unit_price' => 3600, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Coca Cola', 'description' => 'Zero 237Ml.', 'unit_price' => 700, 'bulk_unit_price' => 600, 'bulk_unit' => 24, 'category_id' => 10],
            ['name' => 'Coca Cola', 'description' => '254Ml.', 'unit_price' => 1600, 'bulk_unit_price' => 1500, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Coca Cola', 'description' => 'Light 2,25Lt', 'unit_price' => 3800, 'bulk_unit_price' => 3600, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Pepsi', 'description' => 'Cola 354Ml.', 'unit_price' => 1140, 'bulk_unit_price' => 1000, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Pepsi', 'description' => 'Cola Sin Azucar 1,5Lt.', 'unit_price' => 1990, 'bulk_unit_price' => 1900, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Pepsi', 'description' => 'Cola 2Lt.', 'unit_price' => 2660, 'bulk_unit_price' => 2500, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => '7up', 'description' => 'Lima Limon 354Ml.', 'unit_price' => 1140, 'bulk_unit_price' => 1000, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => '7up', 'description' => '2,25Lt.', 'unit_price' => 3320, 'bulk_unit_price' => 3200, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Sprite', 'description' => '1,5Lt.', 'unit_price' => 3100, 'bulk_unit_price' => 3000, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Sprite', 'description' => '354Ml.', 'unit_price' => 1600, 'bulk_unit_price' => 1500, 'bulk_unit' => 6, 'category_id' => 10],
            ['name' => 'Sprite', 'description' => '500Ml.', 'unit_price' => 1600, 'bulk_unit_price' => 1500, 'bulk_unit' => 6, 'category_id' => 10],
            
            ['name' => 'bonativa', 'description' => 'Spaghetti 500Gr.', 'unit_price' => 1450, 'bulk_unit_price' => 1300, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'bonativa', 'description' => 'Mostachol 500Gr.', 'unit_price' => 1380, 'bulk_unit_price' => 1200, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'bonativa', 'description' => 'Tirabuzon 500Gr.', 'unit_price' => 1460, 'bulk_unit_price' => 1300, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Lucchetti', 'description' => 'Spaghetti Al Huevo 500Gr.', 'unit_price' => 1600, 'bulk_unit_price' => 1400, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Lucchetti', 'description' => 'Spaghetti 500Gr.', 'unit_price' => 1300, 'bulk_unit_price' => 1200, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Lucchetti', 'description' => 'Tirabuzon 500Gr.', 'unit_price' => 1300, 'bulk_unit_price' => 1200, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Lucchetti', 'description' => 'Mostachol 500Gr.', 'unit_price' => 1300, 'bulk_unit_price' => 1200, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Matarazzo', 'description' => 'Spaghetti 500Gr.', 'unit_price' => 1500, 'bulk_unit_price' => 1400, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Matarazzo', 'description' => 'Tirabuzon 500Gr.', 'unit_price' => 1500, 'bulk_unit_price' => 1400, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Matarazzo', 'description' => 'Mostachol 500Gr.', 'unit_price' => 1500, 'bulk_unit_price' => 1400, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Matarazzo', 'description' => 'Cabello de Angel 500Gr.', 'unit_price' => 2410, 'bulk_unit_price' => 2300, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Favorita', 'description' => 'Tirabuzon 500Gr.', 'unit_price' => 850, 'bulk_unit_price' => 700, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Favorita', 'description' => 'Mostachol 500Gr.', 'unit_price' => 850, 'bulk_unit_price' => 700, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Favorita', 'description' => 'Codito 500Gr.', 'unit_price' => 850, 'bulk_unit_price' => 700, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Don Bernabeu', 'description' => 'Spaghetti 500Gr.', 'unit_price' => 775, 'bulk_unit_price' => 600, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Don Bernabeu', 'description' => 'Codito 500Gr.', 'unit_price' => 775, 'bulk_unit_price' => 600, 'bulk_unit' => 6, 'category_id' => 8],
            ['name' => 'Don Bernabeu', 'description' => 'Mostachol 500Gr.', 'unit_price' => 775, 'bulk_unit_price' => 600, 'bulk_unit' => 6, 'category_id' => 8],

            ['name' => 'Cañuelas', 'description' => 'Galletita Huevo 10Pack.', 'unit_price' => 550, 'bulk_unit_price' => 500, 'bulk_unit' => 6, 'category_id' => 3],
            ['name' => 'Cañuelas', 'description' => 'Galletita Huevo 15Pack.', 'unit_price' => 1100, 'bulk_unit_price' => 1000, 'bulk_unit' => 6, 'category_id' => 3],
            ['name' => 'Cañuelas', 'description' => 'Galletita Sabor Jamón 15Pack.', 'unit_price' => 1300, 'bulk_unit_price' => 1200, 'bulk_unit' => 6, 'category_id' => 3],
            ['name' => 'Don Ignacio', 'description' => 'Mermelada de Frutilla 900Gr.', 'unit_price' => 2200, 'bulk_unit_price' => 2000, 'bulk_unit' => 6, 'category_id' => 3],
            ['name' => 'Don Ignacio', 'description' => 'Mermelada de Durazno 900Gr.', 'unit_price' => 2200, 'bulk_unit_price' => 2000, 'bulk_unit' => 6, 'category_id' => 3],
            ['name' => 'Don Ignacio', 'description' => 'Mermelada de Ciruela 900Gr.', 'unit_price' => 2200, 'bulk_unit_price' => 2000, 'bulk_unit' => 6, 'category_id' => 3],
            ['name' => 'Don Ignacio', 'description' => 'Mermelada de Frutilla 500Gr.', 'unit_price' => 1600, 'bulk_unit_price' => 1500, 'bulk_unit' => 6, 'category_id' => 3],
            ['name' => 'Don Ignacio', 'description' => 'Mermelada de Durazno 500Gr.', 'unit_price' => 1600, 'bulk_unit_price' => 1500, 'bulk_unit' => 6, 'category_id' => 3],
            ['name' => 'Don Ignacio', 'description' => 'Mermelada de Ciruela 500Gr.', 'unit_price' => 1600, 'bulk_unit_price' => 1500, 'bulk_unit' => 6, 'category_id' => 3]
        ];

        foreach ($products as $product) {
            // Generar datos adicionales
            $product['catalog_id'] = rand(100000000000, 999999999999);
            $product['barcode'] = rand(1000000000000, 9999999999999);
            $product['type_id'] = 1;
            $product['stock'] = 1;
            $product['image_url'] = 'image_url/default.jpeg';
            $product['offer'] = 0;
            $product['percent_off'] = null;
            $product['price_offer'] = null;
            $product['old_price'] = null;

            // Generar aleatoriamente descuentos y ofertas
            if (rand(1, 10) <= 3) { // Probabilidad del 30% de estar en oferta
                $percent_off = [5, 10, 15, 20, 25, 30][array_rand([5, 10, 15, 20, 25, 30])];
                $product['offer'] = 1;
                $product['percent_off'] = $percent_off;
                $product['price_offer'] = $product['unit_price'];
                $product['old_price'] = $product['unit_price'];
            }

            // Agregar timestamps
            $product['created_at'] = now();
            $product['updated_at'] = now();

            // Insertar en la base de datos
            DB::table('products')->insert($product);
        }
    }
}
