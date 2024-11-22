<?php
// app/Http/Controllers/Api/CartController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Listar los elementos en el carrito
    public function index(Request $request)
    {
        // Obtener el carrito del usuario (si está autenticado)
        $cart = Cart::with('cartItems.product')->where('user_id', $request->user()->id)->firstOrCreate();

        return response()->json([
            'items' => $cart->cartItems,
            'total' => $cart->total,
        ]);
    }

    // Agregar producto al carrito
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Verificar si el producto está en stock
       /*  if ($product->stock < $request->quantity) {
            return response()->json(['message' => 'Stock insuficiente'], 400);
        }*/

        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();
        //return response()->json(['message' => $cart]);
        if ($cartItem) {
            // Si el producto ya está en el carrito, incrementa la cantidad
            $cartItem->quantity += $request->quantity;
            $cartItem->total = $cartItem->quantity * $product->unit_price;
            $cartItem->save();
        } else {
            // Crear un nuevo CartItem
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'total' => $request->quantity * $product->unit_price,
            ]);
        }

        // Reducir el stock del producto
        $product->save();

        return response()->json(['message' => 'Producto agregado al carrito']);
    }

    // Eliminar un producto del carrito
    public function remove(Request $request, $id)
    {
        $cart = Cart::where('user_id', $request->user()->id)->first();
        $cartItem = $cart->cartItems()->where('id', $id)->first();

        if ($cartItem) {
            $product = $cartItem->product;
            $product->stock += $cartItem->quantity;
            $product->save();

            $cartItem->delete();
            return response()->json(['message' => 'Producto eliminado del carrito']);
        }

        return response()->json(['message' => 'Elemento no encontrado en el carrito'], 404);
    }
}
