<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }
    public function createOrder(Request $request)
    {

        // Obtener los datos del pago desde la notificación
        $paymentId = $request->input('data.id');

        if ($paymentId) {
            try {
                // Obtener detalles del pago desde Mercado Pago
                MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));

                $payment = new PaymentClient();

                $payment = $payment->get($paymentId);

                if ($payment && $payment->status == 'approved') {
                    // Guardar los detalles de la orden en la base de datos
                    // Aquí asumo que tienes un modelo Order y una tabla en tu base de datos
                    Order::create([
                        'user_id' => $payment->payer->id,
                        'payment_id' => $paymentId,
                        'status' => $payment->status,
                        'total' => $payment->transaction_amount,
                        //'items' => json_encode($payment->items), // Guardar los ítems como JSON
                    ]);

                    return response()->json(['status' => 'success'], 200);
                }
            } catch (\Exception $e) {
                // Manejar errores si el pago no se puede procesar
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }

        return response()->json(['status' => 'no_action'], 200);
    }

    /*  public function createOrder(Request $request)
    {
        // Validar y guardar los productos
        $products = $request->products;

        // Crear el pedido en la base de datos
        $order = Order::create([
            'user_id' => auth()->id(),
            'products' => json_encode($products),
            'status' => 'pending',
        ]);

        // Inicializar el SDK y crear una preferencia
        SDK::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));

        $preference = new Preference();
        $items = [];

        foreach ($products as $product) {
            $item = new Item();
            $item->title = $product['title'];
            $item->quantity = $product['quantity'];
            $item->unit_price = $product['unit_price'];
            $items[] = $item;
        }

        $preference->items = $items;

        // Configurar URLs de redirección y notificación
        $preference->back_urls = [
            'success' => route('payment.success', ['order_id' => $order->id]),
            'failure' => route('payment.failure', ['order_id' => $order->id]),
            'pending' => route('payment.pending', ['order_id' => $order->id]),
        ];
        $preference->notification_url = route('payment.webhook'); // Webhook
        $preference->auto_return = 'approved';

        // Guardar la preferencia y redirigir al usuario
        $preference->save();

        // Actualizar el pedido con el ID de la preferencia
        $order->payment_id = $preference->id;
        $order->save();

        return redirect($preference->init_point);
    }  */

/*     public function webhook(Request $request)
{
    // Obtén el ID del pago desde la notificación
    $paymentId = $request->input('data.id');

    // Inicializar el SDK y buscar el pago
    SDK::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
    $payment = \MercadoPago\Payment::find_by_id($paymentId);

    if ($payment) {
        // Encuentra el pedido por el ID de la preferencia
        $order = Order::where('payment_id', $payment->order->id)->first();

        if ($order) {
            // Actualiza el estado basado en el resultado del pago
            if ($payment->status == 'approved') {
                $order->status = 'paid';
            } else {
                $order->status = 'failed';
            }
            $order->save();
        }
    }

    return response()->json(['status' => 'success']);
}
 */
}
