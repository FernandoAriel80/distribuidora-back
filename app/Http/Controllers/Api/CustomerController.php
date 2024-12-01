<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    public function getClients()
    {
        // Obtiene todos los usuarios con rol de 'cliente' y sus direcciones
 /*        $clients = User::where('role', 'cliente')
            ->with('address') // Relación con direcciones
            ->get(['id', 'name', 'last_name', 'email']); // Solo los campos necesarios
 */
        $clients = User::all();
        return response()->json(['clients' => $clients]);
    }
}
