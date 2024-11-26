<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
        
        $client = new PreferenceClient();

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
        $preference = $client->create([
            "items" => $items,
            "payment_methods" => [
                "installments" => 6,
            ],
            "statement_descriptor" => "Distribuidora",
        ]);

        return response()->json([
            'preference' => $preference
        ]);
    }
}