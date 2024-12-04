<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use Illuminate\Http\Request;
use App\Models\Order;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);
        
        $search = (string) $request->input('search', '');
        try {
            $orders = Order::with(['orderItems'])
            ->search($search)
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        
            return response()->json(['orders' => $orders]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener producto.',
                'error' => $e->getMessage()
            ], 500);
        }
       
    }
    
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $user = $request->user();

        if ($order->status != $request->status) {
            $log = ActionLog::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'action' => $request->status,
                'description' => 'Cambio el estado del pedido de "'.$order->status.'" a "'.$request->status.'"',
                'orders_id' => $order->id,
                'payment_id' => $order->payment_id,
            ]);
        }
        if ($order->delivery_status != $request->delivery_status) {
            $log = ActionLog::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'action' => $request->delivery_status,
                'description' => 'Cambio el estado de entrega del pedido de "'.$order->delivery_status.'" a "'.$request->delivery_status.'"',
                'orders_id' => $order->id,
                'payment_id' => $order->payment_id,
            ]);
        }
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
                                        'approved' => 'Pagado',
                                        'pending' => 'Pendiente',
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
            $user = $request->user();
            $address = $user->address()->first();
    
            try {
                     $order = Order::create([
                        'user_id' => $user->id,
                        'payment_id' => $ID_order,
                        'total' => $preferenceTotal,
                        'name' =>  $user->name,
                        'last_name' => $user->last_name,
                        'dni' => $address->dni,
                        'email' => $user->email,
                        'card_last_numb' => null,
                        'type_card' => "Efectivo",    
                        'card_name_user' => null,
                        'hour_and_date' => $dateInArgentina,
                        'status' => 'Pendiente',
                        'delivery_status' => 'Revision',
                    ]); 
                    $items = json_decode(json_encode($preferenceItems), true);
                    $currentCartID = 0; 
                    if (!empty($items)) {
                        foreach ($items as $item) {
                            $currentCartID = $item['cart_id'];
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
                    return response()->json(['status' => 'aprovated', 'cart_id' => $currentCartID]);
            }catch (\Exception $e) {
    
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }
    }
}
