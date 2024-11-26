<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Resources\Preference\Item;
use MercadoPago\Resources\Preference;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Common\RequestOptions;
class PaymentController extends Controller
{
  /*   public function createPayment(Request $request)
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
    }  */

    public function createPayment(Request $request)
    {
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
        
        $client = new PreferenceClient();

        $backUrls =[
            "success" => "http://localhost:5173/vista-pedidos",
            "failure" => "http://localhost:5173",
            "pending" => "",
        ];

        //$notificationUrl = route('payment.createOrder');
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
            "back_urls" => $backUrls,
            "auto_return" => "approved",
            //"notification_url" => $notificationUrl,
            "statement_descriptor" => "Distribuidora",
        ]);

        return response()->json([
            'preference' => $preference
        ]);
    } 
   

    public function capturePayment(Request $request)
    {
        // Configura el token de acceso
      /*   MercadoPagoConfig::setAccessToken("YOUR_ACCESS_TOKEN");

        $payment_id = $request->input('payment_id');

        $client = new PaymentClient();
        $request_options = new RequestOptions();
        $request_options->setCustomHeaders(["X-Idempotency-Key" => uniqid()]);

        try {
            // Captura el pago
            $response =  $client->capture($payment_id, $request_options->);
            return response()->json(['status' => 'success', 'data' => $response]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        } */
    }
}