<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
          
            $request->validate([
                'category' => 'required|string|max:255',
            ]);
    
            $category = $request->input('category');
            $perPage = $request->get('per_page', 5); 
            $products = Product::with(['type', 'category'])->where('category_id','=',$category)->paginate($perPage);
            return response()->json(['products'=>$products]);
             
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener producto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllOffer(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 5); 
        
            $products = Product::with(['type', 'category'])->where('offer','=',1)->paginate($perPage);
            return response()->json(['products'=>$products]);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener producto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getAll(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:255',
                'sort' => 'nullable|string|in:rel,lPrice,hPrice',
            ]);
            
            $search = $request->input('search', '');
            $sort = $request->input('sort', 'rel');

            $query = Product::with(['type', 'category']);
            
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
            $products = $query->paginate(10)->withQueryString();
           
            return response()->json([
                'products' => $products,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener producto.',
                'error' => $e->getMessage()
            ], 500);
        }
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
    public function show(string $id)
    {
        //
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
