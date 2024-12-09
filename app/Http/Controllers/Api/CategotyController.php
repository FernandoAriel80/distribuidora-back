<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\TopCategory;
use Illuminate\Http\Request;

class CategotyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topCategories = TopCategory::with(['categories'])->get();
        return response()->json(['topCategories' => $topCategories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'sort' => 'nullable|string|in:rel,lPrice,hPrice',
            ]);
            
            $search = $request->input('search', '');
            $sort = $request->input('sort', 'rel');

            $query = Product::with(['type', 'category'])->where('category_id', '=', $id);
            
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            }
            
            if ($sort === 'rel') {
                $query->orderBy('updated_at', 'desc');
            } elseif ($sort === 'lPrice') {
                $query->orderBy('unit_price', 'asc');
            } elseif ($sort === 'hPrice') {
                $query->orderBy('unit_price', 'desc');
            }
            $products = $query->get();
           
            return response()->json([
                'products' => $products,
            ]);
        }  catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener producto.',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
