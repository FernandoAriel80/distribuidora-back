<?php
// app/Http/Controllers/Api/CartController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::with('cartItems.product')->where('user_id', $request->user()->id)->firstOrCreate();

        return response()->json([
            'items' => $cart->cartItems,
            'total' => $cart->total,
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
                $cartItem->total = $cartItem->quantity * $product->bulk_unit_price;
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
                    'total' => $request->quantity * $product->bulk_unit_price,
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
}
