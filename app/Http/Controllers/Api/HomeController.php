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
                'category' => 'required|string|max:255', // Categoría es obligatoria
                'limit' => 'nullable|integer|min:1|max:50', // Límite de productos (por defecto: 5)
                'offset' => 'nullable|integer|min:0', // Desplazamiento inicial (por defecto: 0)
            ]);
    
            // Recoger parámetros de la solicitud
            $category = $request->input('category');
            $limit = $request->input('limit', 5); // Límite por defecto: 5
            $offset = $request->input('offset', 0); // Offset por defecto: 0
    
            // Consultar los productos según la categoría
            $products = Product::whereHas('category', function ($query) use ($category) {
                $query->where('name', $category); // Filtrar por nombre de categoría
            })
            ->with(['category'])
            ->offset($offset)
            ->limit($limit)
            ->get();
    
            // Devolver los datos en formato JSON
            return response()->json([
                'success' => true,
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
