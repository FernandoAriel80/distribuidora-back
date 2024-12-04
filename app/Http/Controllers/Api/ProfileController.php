<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;



class ProfileController extends Controller
{
    public function overview( Request $request)
    {
        $user = $request->user();
        $address = $user->address()->first();
        $orders = Order::with(['orderItems'])->where('user_id','=',$request->user()->id)->orderBy('id', 'desc')->get();
        
        return response()->json([
            'user' => $user,
            'orders' => $orders,
            'address' => $address,
        ]);
    }

      public function updateInfo(Request $request)
      {
          try {
            $user = $request->user();  
            if ($user->role != 'admin') {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email,' . Auth::id(),
                ]);
  
                $user->update($request->only('name', 'last_name', 'email'));
          
                return response()->json(['message' => 'Se actualizo la información exitosamente.', 'user' => $user]);
            }
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Error al actualizar información.',
                    'error' => $e->getMessage()
                ], 500);
            }
      }
  
      public function updatePassword(Request $request)
      {
          try {
            $user = $request->user();  
            if ($user->role != 'admin') {
                $request->validate([
                    'current_password' => 'required',
                    'new_password' => 'required|string|min:8',
                    'confirm_password' => 'required|string|same:new_password',
                ]);
                  
                if (!Hash::check($request->current_password, $user->password)) {
                    return response()->json(['message' => 'Current password is incorrect.'], 422);
                }
  
                $user->update(['password' => Hash::make($request->new_password)]);
      
                return response()->json(['message' => 'La contraseña a sigo actualizada exitosamente.']);
            }
             
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar contraseña.',
                'error' => $e->getMessage()
            ], 500);
        }
      }

      public function updateAddress(Request $request)
      {
         try {
            $user = $request->user();  
            if ($user->role != 'admin') {
                $request->validate([
                    'dni' => 'required|string|max:20',
                    'gender' => 'required|string|max:10',
                    'phone_number' =>'required|string|regex:/^[0-9]{10}$/',
                    'address' => 'required|string|max:255',
                    'department' =>'nullable|string|max:100',
                    'postal_code' => 'required|string|max:20',
                    'city' => 'required|string|max:100',
                ]);
                $address = $user->address()->first();
                if (!$address) {
                    $address = Address::create([
                        'user_id' => $user->id,
                        'dni' => $request->dni,
                        'phone_number' => $request->phone_number,
                        'gender' => $request->gender,
                        'address' => $request->address,
                        'department' => $request->department, 
                        'city' => $request->city,
                        'postal_code' => $request->postal_code,
                    ]);
                }
        
                $address->update($request->only('dni','phone_number', 'gender', 'address','department', 'postal_code', 'city'));
        
                return response()->json(['message' => 'Direccion actualizada exitosamente.', 'address' => $address]);
            }
         }  catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar direccion.',
                'error' => $e->getMessage()
            ], 500);
        }
      }

      public function deleteAccount(Request $request)
      {
        try {
            $user = $request->user();  
            if ($user->role != 'admin') {
                if ($user->address) {
                    $user->address->delete();
                }
                $cart = Cart::where('user_id', $user->id)->first();
                if ($cart) {
                    $cart->delete();
                }

                $user->address?->delete();
                $user->tokens()->delete();
                $user->delete();
    
                return response()->json(['message' => 'Usuario eliminado exitosamente.']);
            } 
       
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar usuario.',
                'error' => $e->getMessage()
            ], 500);
        }
           
      }
}
