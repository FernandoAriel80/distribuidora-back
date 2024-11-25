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
            $items[] = [
                "id" => $product['id'],
                "title" => $product['title'],
                "quantity" => (int) $product['quantity'], 
                "unit_price" => (float) $product['unit_price'], 
            ];
        }
        $preference = $client->create([
            "items" => $items
        ]);

        return response()->json([
            'preference' => $preference
        ]);
    }
}
   /*  public function createPaymentPreference(Request $request)
    {
        SDK::setAccessToken(config('services.mercadopago.access_token'));

        // Obtener los productos enviados desde el frontend
        $cartItems = $request->input('products'); // Array de productos
        $items = [];

        foreach ($cartItems as $product) {
            // Crear un item de MercadoPago para cada producto en el carrito
            $item = new Item();
            $item->title = $product['title'];
            $item->quantity = $product['quantity'];
            $item->unit_price = $product['unit_price'];
            $items[] = $item;
        }

        // Crear la preferencia de pago
        $preference = new Preference();
        $preference->items = $items;
        $preference->back_urls = [
            'success' => 'https://tu-dominio.com/success',
            'failure' => 'https://tu-dominio.com/failure',
            'pending' => 'https://tu-dominio.com/pending',
        ];
        $preference->auto_return = 'approved';

        $preference->save();

        return response()->json([
            'init_point' => $preference->init_point,
        ]);
    } */


    /* public function createPaymentPreference(Request $request)
    {
        SDK::setAccessToken(config('services.mercadopago.access_token'));

        $cartItems = $request->input('products');
        $items = [];
        $total = 0;

        foreach ($cartItems as $product) {
            $item = new Item();
            $item->title = $product['title'];
            $item->quantity = $product['quantity'];
            $item->unit_price = $product['unit_price'];
            $items[] = $item;

            $total += $product['quantity'] * $product['unit_price'];
        }

        $preference = new Preference();
        $preference->items = $items;
        $preference->back_urls = [
            'success' => 'https://tu-dominio.com/payment/success',
            'failure' => 'https://tu-dominio.com/payment/failure',
            'pending' => 'https://tu-dominio.com/payment/pending',
        ];
        $preference->auto_return = 'approved';
        $preference->save();

        // Registrar la orden en la base de datos
        $order = Order::create([
            'order_id' => $preference->id,
            'user_id' => auth()->id(),
            'products' => json_encode($cartItems),
            'total' => $total,
            'status' => 'pending',
        ]);

        return response()->json([
            'init_point' => $preference->init_point,
        ]);
    } */

   /*  public function paymentWebhook(Request $request)
    {
        // Verificar la notificación
        $data = $request->all();
        $order_id = $data['data']['id'];

        // Consultar el estado de la transacción en Mercado Pago
        SDK::setAccessToken(config('services.mercadopago.access_token'));
        $payment = \MercadoPago\Payment::find_by_id($order_id);

        if ($payment) {
            // Encontrar la orden en tu base de datos
            $order = Order::where('order_id', $payment->id)->first();

            if ($order) {
                // Actualizar el estado de la orden según el estado del pago en Mercado Pago
                $order->status = $payment->status; // Ej.: approved, pending, etc.
                $order->save();
            }
        }

        return response()->json(['status' => 'success'], 200);
    } */

    


