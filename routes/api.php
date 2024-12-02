<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProfileController;
Use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;

// Ruta pública para el índice principal
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Rutas públicas para usuarios invitados
Route::middleware('guest')->group(function() {
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

});
// Rutas autenticadas para usuarios registrados
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    //Ruta para el perfil
    Route::prefix('profile')->group(function() {
        Route::get('/overview', [ProfileController::class, 'overview']);
        Route::put('/update_info', [ProfileController::class, 'updateInfo']);
        Route::put('/update_password', [ProfileController::class, 'updatePassword']);
        Route::put('/update_address', [ProfileController::class, 'updateAddress']);
        Route::delete('/delete_account', [ProfileController::class, 'deleteAccount']);
    });
    
    
    // Rutas para el carrito
    Route::prefix('cart')->group(function() {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/create', [CartController::class, 'add']);
        Route::delete('/{id}', [CartController::class, 'remove']);
    });

    //mercado pago
    Route::post('/process_mercado_pago_payment', [PaymentController::class, 'createMercadoPagoPayment']);
    //orders
    Route::post('/payment_mercado_pago_orders', [OrderController::class, 'createMercadoPagoOrder']);
    Route::post('/payment_in_store_orders', [OrderController::class, 'createInStoreOrder']);

 
    // Rutas de administración
     Route::prefix('admin')->group(function () {      
        // Rutas solo para administradores (admin y super_admin)
        Route::middleware('is_admin:admin,super_admin')->group(function () {
            
            Route::prefix('products')->group(function () {
                Route::get('/', [ProductController::class, 'index']);
                Route::get('/create', [ProductController::class, 'create']);
                Route::post('/create', [ProductController::class, 'store']);
                Route::post('/edit/{id}', [ProductController::class, 'update']);
                Route::delete('/{id}', [ProductController::class, 'destroy']);
            });

            Route::prefix('orders')->group(function () {
                Route::get('/', [OrderController::class, 'index']);
                Route::put('/{id}', [OrderController::class, 'update']);
            });
            Route::get('/dashboard', [DashboardController::class, 'getDashboardData']);
            Route::get('/clients', [CustomerController::class, 'getClients']);
        });

        // Rutas solo para super administradores (super_admin)
         Route::middleware('is_admin:super_admin')->group(function () {
            Route::prefix('employees')->group(function() {
                Route::get('/', [EmployeeController::class, 'index']);
                Route::post('/create', [EmployeeController::class, 'store']);
                Route::put('/edit/{id}', [EmployeeController::class, 'update']);
                Route::delete('/{id}', [EmployeeController::class, 'destroy']);
            });
        });
    }); 
});
