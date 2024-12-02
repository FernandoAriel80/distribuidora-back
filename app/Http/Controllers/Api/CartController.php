<?php
// app/Http/Controllers/Api/CartController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
  /*   public function index(Request $request)
    {
        $cart = Cart::with('cartItems.product')->where('user_id', $request->user()->id)->firstOrCreate();

        return response()->json([
            'items' => $cart->cartItems,
            'total' => $cart->total,
        ]);
    } */
    public function index(Request $request)
    {
        $cart = Cart::with('cartItems.product')->where('user_id', $request->user()->id)->firstOrCreate();
        
        $items = $cart->cartItems;
 
        $formattedItems = $cart->cartItems->map(function ($item) {
            $unitPrice = 0;
            $titleAux = '';
            if ($item->product->type_id === 1) {
                $unitPrice = $item->type_price === "unit" 
                    ? $item->product->unit_price 
                    : $item->product->bulk_unit_price * $item->product->bulk_unit;
                $titleAux = $item->type_price === "unit" 
                    ? $item->product->name . " x1 unidad" 
                    : $item->product->name . " x" . $item->product->bulk_unit . " unidades";
            } elseif ($item->product->type_id === 2) {
                $unitPrice = $item->product->unit_price;
                $titleAux = $item->product->name . " xkg";
            }
            return [
                'cart_id'=> $item->cart_id,
                'id' => $item->id,
                'title' => $titleAux,
                'quantity' => $item->quantity,
                'unit_price' => $unitPrice,
                'stock' => $item->product->stock,
                'total' => $item->total
            ];
        });
        // Calcular el total del carrito
        $total = $cart->cartItems->sum('total');
    
        // Calcular la cantidad total de productos en el carrito
        $quantity = $cart->cartItems->sum('quantity');
    
        return response()->json([
            'items' => $items,
            'total' => $total,
            'quantity' => $quantity,
            'formattedItems' => $formattedItems
        ]);
    }
    

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type_price' => 'required|string|max:5',
            'quantity' => 'required|integer|min:1',
        ]);
        $product = Product::findOrFail($request->product_id);
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);

        $cartItem = $cart->cartItems()
            ->where('product_id', $product->id)
            ->where('type_price', $request->type_price) 
            ->first();
        if ($cartItem) {
            if ($request->type_price == 'unit') {
                $cartItem->quantity = $request->quantity;
                $cartItem->total = $cartItem->quantity * $product->unit_price;
                $cartItem->save();
            } else {
                $cartItem->quantity = $request->quantity;
                $cartItem->total = $cartItem->quantity * $product->bulk_unit_price * $product->bulk_unit;
                $cartItem->save();
            }
            
        } else {
            if ($request->type_price == 'unit') {
                $cart->cartItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'total' => $request->quantity * $product->unit_price,
                    'type_price' => $request->type_price,
                ]);
            } else {
                $cart->cartItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'total' => $request->quantity * $product->bulk_unit_price * $product->bulk_unit,
                    'type_price' => $request->type_price,
                ]);
            }  
        }

        $product->save();

        return response()->json(['message' => 'Producto agregado al carrito']);
    }

    public function remove(Request $request, $id)
    {
        $cart = Cart::where('user_id', $request->user()->id)->first();
        $cartItem = $cart->cartItems()->where('id', $id)->first();

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['message' => 'Producto eliminado del carrito']);
        }

        return response()->json(['message' => 'Elemento no encontrado en el carrito'], 404);
    }

    public function removeCart($id){
        try {
            $cart = Cart::findOrFail($id);
            $cart->delete();
            return response()->json(['message' => 'Carrito eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar carrito.',
                'error' => $e->getMessage()
            ], 500);
        }      
    }
    public function removeCartOnline(Request $request){
        try {
            $cart = Cart::where('user_id', $request->user()->id)->first();
            $cart->delete();
            return response()->json(['message' => 'Carrito eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar carrito.',
                'error' => $e->getMessage()
            ], 500);
        }      
    }
}
