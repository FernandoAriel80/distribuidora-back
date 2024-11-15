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
                'email' => 'required|email|exists:users',
                'password' => 'required',
            ]);
            $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
               /*  throw ValidationException::withMessages([
                    'email' => ['Las credenciales no coinciden.'],
                ]); */
                return response()->json( ['message'=>'Las credenciales no coinciden.']);
            }
    
            $token = $user->createToken($user->name);
    
            return response()->json(['token' => $token->plainTextToken]);
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
            $request->user()->tokens()->delete();
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
