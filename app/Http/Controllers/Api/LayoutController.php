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
        $products = Product::where('name', 'LIKE', "%{$query}%")->get();

        return response()->json(['products'=>$products]);
    }
}
