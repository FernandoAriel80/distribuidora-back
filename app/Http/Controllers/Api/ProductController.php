<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'message' => 'Producto creado exitosamente si',
            'products' => $products
        ], 200);
    }

    public function store(Request $request)
    {
        // Validación de los datos de entrada
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
    ]);

    // Creación del producto
    $product = Product::create($validatedData);

    // Devolución de la respuesta en formato JSON
    return response()->json([
        'message' => 'Producto creado exitosamente',
        'product' => $product
    ], 201);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
        ]);

        $product->update($request->all());

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response(null, 204);
    }
}
