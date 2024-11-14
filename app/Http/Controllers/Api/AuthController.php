<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
   
    public function register(Request $request)
    {
        try {
            sleep(1);
            $validated = $request->validate([
                'name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:8',
            ]);
            
            $user = User::create([
                'name' => $validated['name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => 'cliente',
            ]);
            
            return response()->json(['message' => 'Se registro exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar usuario.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            sleep(1);
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Las credenciales no coinciden.'],
                ]);
            }
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json(['token' => $token]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar usuario.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Sesión cerrada con éxito.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al cerrar sesión.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
