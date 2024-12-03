<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class PaymentController extends Controller
{
    public function createMercadoPagoPayment(Request $request)
    {
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
        
        $client = new PreferenceClient();

        $backUrls =[
            "success" => env('FROM_URL')."/pago-en-proceso",
            "failure" => env('FROM_URL')."/pago-en-proceso",
            "pending" => env('FROM_URL')."/pago-en-proceso",
        ];

        $items = [];
        foreach ($request->products as $product) {
            if ($product['stock'] == 1) {
                $items[] = [
                    "id" => $product['id'],
                    "title" => $product['title'],
                    "quantity" => (int) $product['quantity'], 
                    "unit_price" => (float) $product['unit_price'], 
                ];
            }
        }
        $user = $request->user();
        $address = $user->address()->first();

        $preference = $client->create([
            "items" => $items,
            "payment_methods" => [
                "installments" => 6,
            ],
            "payer" =>[
                "name" => $user->name,
                "surname" => $user->last_name,
                "email" => $user->email,
                "identification" => [
                    "type" => "DNI",  
                    "number" => $address->dni, 
                ],
            ],
            "back_urls" => $backUrls,
            "auto_return" => "approved",
            "statement_descriptor" => "Distribuidora",
        ]);

        return response()->json([
            'preference' => $preference,
        ]);
    } 
   
}