<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $products = Product::where('name', 'LIKE', "%{$query}%")->limit(5)->get();

        return response()->json(['products'=>$products]);
    }
    public function show($id)
    {
        $product = Product::with(['type', 'category'])->findOrFail($id);

        return response()->json(['product'=>$product]);
    }
}
