<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;



class ProfileController extends Controller
{
    public function overview( Request $request)
    {
        $user = $request->user();

        //$address = $user->address()->first();
        $orders = Order::with(['orderItems'])->where('user_id','=',$request->user()->id)->orderBy('id', 'desc')->get();
        
        return response()->json([
            'user' => $user,
            'orders' => $orders,
           //'address' => $address,
        ]);
    }

      // Actualizar información del usuario (nombre, apellido, correo)
      public function updateInfo(Request $request)
      {
          $request->validate([
              'name' => 'required|string|max:255',
              'last_name' => 'required|string|max:255',
              'email' => 'required|email|unique:users,email,' . Auth::id(),
          ]);
  
          $user = User::user();
          $user->update($request->only('name', 'last_name', 'email'));
  
          return response()->json(['message' => 'User info updated successfully.', 'user' => $user]);
      }
  
      // Actualizar contraseña
      public function updatePassword(Request $request)
      {
          $request->validate([
              'current_password' => 'required',
              'new_password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()],
              'confirm_password' => 'required|same:new_password',
          ]);
  
          $user = User::user();
  
          if (!Hash::check($request->current_password, $user->password)) {
              return response()->json(['message' => 'Current password is incorrect.'], 422);
          }
  
          $user->update(['password' => Hash::make($request->new_password)]);
  
          return response()->json(['message' => 'Password updated successfully.']);
      }
  
      // Actualizar datos de dirección
      public function updateAddress(Request $request)
      {
          $request->validate([
              'dni' => 'required|string|max:20',
              'gender' => 'required|string|max:10',
              'birth_date' => 'required|date',
              'address' => 'required|string|max:255',
              'postal_code' => 'required|string|max:20',
              'city' => 'required|string|max:100',
          ]);
  
          $address = Auth::user()->address;
          if (!$address) {
              return response()->json(['message' => 'Address not found.'], 404);
          }
  
          $address->update($request->only('dni', 'gender', 'birth_date', 'address', 'postal_code', 'city'));
  
          return response()->json(['message' => 'Address updated successfully.', 'address' => $address]);
      }
  
      // Eliminar usuario y sus datos
      public function deleteAccount()
      {
            $user = user::user();
            // Eliminar dirección asociada
            if ($user->address) {
                $user->address->delete();
            }
            // Eliminar usuario
            $user->address?->delete();
            $user->orders()->delete();
            $user->delete();

            return response()->json(['message' => 'User account deleted successfully.']);
      }
}
