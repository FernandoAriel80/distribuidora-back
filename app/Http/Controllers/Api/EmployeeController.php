<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);
    
        $search = (string) $request->input('search', '');
        
        try {
            $employees = User::where('role', '=', 'admin')->search($search)->orderBy('id', 'desc')->get(); 
            return response()->json([
                'message' => 'Empleado obtenido exitosamente',
                'employees' => $employees,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener empleados.',
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
        $request->merge([
            'password' => $request->password === $request->password_confirmation ? $request->password : null
        ]);
      
        try {
            $fields = $request->validate([
                'name' => 'required|max:50',
                'last_name' => 'required|max:50',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:8', 
            ]);

            User::create([
                'name' => $fields['name'],
                'last_name' => $fields['last_name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password']),
                'role' => 'admin',
            ]);
             return response()->json([
                'message' => 'El empleado se a creado exitosamente'
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear empleado.',
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            $request->merge([
                'password' => $request->password === $request->password_confirmation ? $request->password : null
            ]);

            $fields = $request->validate([
                'name' => 'max:50',
                'last_name' => 'max:50',
                'email' => ['email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => 'nullable|confirmed|min:8',
            ]);
            
            $data = [
                'name' => $fields['name'],
                'last_name' => $fields['last_name'],
                'email' => $fields['email'],
                'role' => 'admin',
            ];
            
            if (!empty($fields['password'])) {
                $data['password'] = bcrypt($fields['password']);
            }
    
            $user->update($data);
    
            return response()->json([
                'message' => 'Los datos del empleado se han actualizado exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar los datos del empleado.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'message' => 'El empleado '.$user->name.' ha sido eliminado exitosamente.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar empleado.',
                'error' => $e->getMessage()
            ], 500);
        }      
    }
}
