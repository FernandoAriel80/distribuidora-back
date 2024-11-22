<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Type;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);
    
        $search = (string) $request->input('search', '');

        try {
            $products = Product::with(['type', 'category'])
            ->search($search)
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString();
            
            return response()->json([
                'message' => 'Producto obtenido exitosamente',
                'products' => $products,
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener producto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        try {
            $categories = Category::all('id','name');
            $types = Type::all('id','name');

            return response()->json([
                'message' => 'Types y categories obtenidos exitosamente',
                'categories' => $categories,
                'types' => $types,
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener types y categories.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'bulk_unit' => $request->bulk_unit === '' ? null : $request->bulk_unit,
            'bulk_unit_price' => $request->bulk_unit_price === '' ? null : $request->bulk_unit_price,
            'percent_off' => $request->percent_off === '' ? null : $request->percent_off,
            'price_offer' => $request->price_offer === '' ? null : $request->price_offer,
            'offer' => filter_var($request->offer, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            'old_price' => $request->old_price === '' ? null : $request->old_price,
            'stock' => filter_var($request->stock, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);
        
        $fields = $request->validate([
            'catalog_id' => 'required|integer',
            'barcode' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit_price' => 'nullable|numeric|min:0',
            'bulk_unit_price' => 'nullable|numeric|min:0',
            'bulk_unit' => 'nullable|numeric|between:0,100',
            'percent_off' => 'nullable|numeric|between:0,100',
            'offer' => 'nullable|boolean',
            'price_offer' => 'nullable|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock' => 'required|boolean',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|integer',
            'type_id' => 'required|integer',
        ]);

        if ($fields['offer'] == true) {
            $fields['unit_price'] = $fields['price_offer'];
            $fields['old_price'] = $fields['unit_price'];
        }
        $fields['offer'] = $request->has('offer') ? $request->input('offer') : false;
        $fields['stock'] = $request->has('stock') ? $request->input('stock') : false; 
        if ($request->hasFile('image_url')) {
            
            $filename = time() . '_' . $request->file('image_url')->getClientOriginalName();
            $fields['image_url'] = Storage::disk('public')->putFileAs('image_url', $request->file('image_url'), $filename);
        } else {
            $fields['image_url'] = 'image_url/default.jpeg'; 
        }
        
        try {       
            Product::create($fields);
            return response()->json(['message' => 'El registro se ha guardado exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear producto.',
                'error' => $e->getMessage()
            ], 500);
        }

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
    public function edit(Request $request)
    {
        //
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->merge([
            'bulk_unit' => $request->bulk_unit === '' ? null : $request->bulk_unit,
            'bulk_unit_price' => $request->bulk_unit_price === '' ? null : $request->bulk_unit_price,
            'percent_off' => $request->percent_off === '' ? null : $request->percent_off,
            'price_offer' => $request->price_offer === '' ? null : $request->price_offer,
            'offer' => filter_var($request->offer, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            'old_price' => $request->old_price === '' ? null : $request->old_price,
            'stock' => filter_var($request->stock, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);

        $fields = $request->validate([
            'catalog_id' => 'required|integer',
            'barcode' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit_price' => 'nullable|numeric|min:0',
            'bulk_unit_price' => 'nullable|numeric|min:0',
            'bulk_unit' => 'nullable|numeric|between:0,100',
            'percent_off' => 'nullable|numeric|between:0,100',
            'offer' => 'nullable|boolean',
            'price_offer' => 'nullable|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock' => 'required|boolean',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image_aux' => 'nullable|string',
            'category_id' => 'required|integer',
            'type_id' => 'required|integer',
        ]);
        
        if ($fields['offer'] == true){
            $fields['old_price'] = $fields['unit_price'];
            $fields['unit_price'] = $fields['price_offer'];
        }
        $fields['offer'] = $request->has('offer') ? $request->input('offer') : false;
        $fields['stock'] = $request->has('stock') ? $request->input('stock') : false; 
        
        $product = Product::findOrFail($id);
 
        if($request->hasFile('image_url')){
            if($fields['image_aux'] != 'image_url/default.jpeg'){
                Storage::disk('public')->delete($fields['image_aux']);
            }  
            $filename = time() . '_' . $request->file('image_url')->getClientOriginalName();
            $fields['image_url'] = Storage::disk('public')->putFileAs('image_url', $request->file('image_url'), $filename);     
        }else {
            $fields['image_url'] = $fields['image_aux'];
        }

        try {
            $product->update($fields); 
            return response()->json(['message' => 'El registro se ha actualizado exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar producto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->image_url !== '/image_url/default.jpeg' && $product->image_url !== 'image_url/default.jpeg' ) {
                Storage::disk('public')->delete($product->image_url);
            }
            $product->delete();
            return response()->json(['message' => 'El producto '.$product->catalog_id.' ha sido eliminado exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar producto.',
                'error' => $e->getMessage()
            ], 500);
        }      
    }

    public function getCategoryAndType(){

    }
}
