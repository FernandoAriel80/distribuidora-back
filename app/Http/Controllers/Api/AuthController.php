<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
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
            $validated = $request->validate([
                'name' => 'required|max:50',
                'last_name' => 'required|max:50',
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
            $validated = $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required',
            ]);
            $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response()->json( ['message'=>'Las credenciales no coinciden.']);
            }
            
            $existingToken = $user->tokens()->first();
            
            if ($existingToken) {
                return response()->json([
                    'token' => $existingToken->plainTextToken,
                    'message' => 'Sesión iniciada con token existente',
                ]);
            }

            $token = $user->createToken($user->name);
    
            return response()->json([
                'token' => $token->plainTextToken,
            ]);
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

    public function hasAddress(Request $request){
        $user = $request->user();
        if ($user->role != 'admin') {
            $exists = Address::where('user_id', '=', $user->id)->exists();
            if ($exists) {
                return response()->json(['exist' => true]);
            }else{
                return response()->json(['exist' => false]);
            }
        }
        return response()->json(['exist' => false]);
    }

    public function createAddress(Request $request)
    {
     /*    return response()->json([
           'message' => 'acaaaa'
        ], 200);  */
        try {
            $validated = $request->validate([
                'dni' => 'required|string|max:20',
                'phone_number' => 'required|string|regex:/^[0-9]{10}$/',
                'gender' => 'required|string|in:hombre,mujer,otros',
                'address' => 'required|string|max:255',
                'department' =>'nullable|string|max:100',
                'city' => 'required|string|max:100',
                'postal_code' => 'required|string|max:20',
            ]);
           
 
            $address = Address::create([
                'user_id' => $request->user()->id,
                'dni' => $validated['dni'],
                'phone_number' => $validated['phone_number'],
                'gender' => $validated['gender'],
                'address' => $validated['address'],
                'department' => $validated['department'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
            ]);

            return response()->json([
                'message' => 'Dirección creada exitosamente.',
                'confirmed'=>true
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la dirección.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
