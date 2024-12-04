<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);
        
        $search = (string) $request->input('search', '');

        $clients = User::with('address')
        ->where('role','=', 'cliente')
        ->search($search)
        ->paginate(10)
        ->withQueryString();
        //->get(['id', 'name', 'last_name', 'email']);

      
        return response()->json(['clients' => $clients]);
    }
}
