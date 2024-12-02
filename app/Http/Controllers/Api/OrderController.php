<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        //$orders = Order::all();
        $orders = Order::with(['orderItems'])->get();

        return response()->json(['orders' => $orders]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->delivery_status = $request->delivery_status;
        $order->save();

        return response()->json(['message' => 'Los estados de la orden se actualizaron correctamente ']);
    }

    public function createMercadoPagoOrder(Request $request)
    {

        $paymentId = $request->paymentId;
        $preferenceId = $request->preferenceId;
        if ($paymentId) {
            try {
                MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
                
                $payment = new PaymentClient();
                $preference = new PreferenceClient();
                
                $payment = $payment->get($paymentId);
                $preference = $preference->get($preferenceId);
  
                if ($payment && $payment->status == 'approved') {
                    $date = $payment->date_created;
                    $dateInArgentina = Carbon::parse($date)->setTimezone('America/Argentina/Buenos_Aires');
                    $dateInArgentina->format('H:i:s d/m/Y');


                     $order = Order::create([
                        'user_id' => $request->user()->id,
                        'payment_id' => $paymentId,
                        'total' => $payment->transaction_amount,
                        'name' =>  $preference->payer->name,
                        'last_name' => $preference->payer->surname,
                        'dni' => $preference->payer->identification->number,
                        'email' => $preference->payer->email,
                        'card_last_numb' => $payment->card->last_four_digits,
                        'type_card' => $payment->payment_method_id,    
                        'card_name_user' => $payment->card->cardholder->name,
                        'hour_and_date' => $dateInArgentina,
                        'status' => match ($payment->status) {
                                        'Pagado' => 'Pagado',
                                        'Pendiente' => 'Pendiente',
                                        default => 'Cancelado',
                                    },
                        'delivery_status' => 'Revision',
                    ]); 
                    $items = json_decode(json_encode($preference->items), true);
                    if (!empty($items)) {
                        foreach ($items as $item) {
                            if (isset($item['id'], $item['title'], $item['quantity'], $item['unit_price'])) {
                                $order->orderItems()->create([
                                    'item_id' => $item['id'],
                                    'name' => $item['title'],
                                    'quantity' => $item['quantity'],
                                    'unit_price' => $item['unit_price'],
                                    'sub_total' => $item['unit_price'] * $item['quantity'],
                                ]);
                            }
                        }
                    }
                    return response()->json(['status' => 'success'], 200);
                }
            } catch (\Exception $e) {

                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }

        return response()->json(['status' => 'no_action'], 200);
    }

    public function createInStoreOrder(Request $request){
        $preferenceItems = $request->preferenceItems;
        $preferenceTotal = $request->preferenceTotal;

        if ($preferenceItems) {
            $hash = hash('sha256', uniqid());
            $ID_order = substr(preg_replace('/[^0-9]/', '', $hash), 0, 10);
            $date = now();
            $dateInArgentina = Carbon::parse($date)->setTimezone('America/Argentina/Buenos_Aires');
            $dateInArgentina->format('H:i:s d/m/Y');
            
            try {
                     $order = Order::create([
                        'user_id' => $request->user()->id,
                        'payment_id' => $ID_order,
                        'total' => $preferenceTotal,
                        'name' =>  $request->user()->name,
                        'last_name' => $request->user()->last_name,
                        'dni' => null,
                        'email' => $request->user()->email,
                        'card_last_numb' => null,
                        'type_card' => "Efectivo",    
                        'card_name_user' => null,
                        'hour_and_date' => $dateInArgentina,
                        'status' => 'Pendiente',
                        'delivery_status' => 'Revision',
                    ]); 
                    $items = json_decode(json_encode($preferenceItems), true);
                    if (!empty($items)) {
                        foreach ($items as $item) {
                            if (isset($item['id'], $item['title'], $item['quantity'], $item['unit_price'])) {
                                $order->orderItems()->create([
                                    'item_id' => $item['id'],
                                    'name' => $item['title'],
                                    'quantity' => $item['quantity'],
                                    'unit_price' => $item['unit_price'],
                                    'sub_total' => $item['unit_price'] * $item['quantity'],
                                ]);
                            }
                        }
                    }
                    return response()->json(['status' => 'aprovated']);
            }catch (\Exception $e) {
    
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }
    }
}
