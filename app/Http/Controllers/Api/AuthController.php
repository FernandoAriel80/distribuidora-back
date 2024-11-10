<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
            
            Auth::login($user);
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
            
            if(Auth::attempt($validated, $request->remember)){
                $request->session()->regenerate();
                return response()->json(['message' => 'Se inicio sesión exitosamente.'], 200);
            }
            return response()->json(['message' => 'Los datos no coinciden.'], 400);
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
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return response()->json(['message' => 'Se cerro la sesión exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al cerrar sesión.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
