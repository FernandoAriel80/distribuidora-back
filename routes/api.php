<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActionLogController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategotyController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProfileController;
Use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LayoutController;

// Ruta pública para el índice principal
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/getAllOffer', [HomeController::class, 'getAllOffer']);
Route::get('/getAll', [HomeController::class, 'getAll']);

Route::prefix('categories')->group(function(){
    Route::get('/',[CategotyController::class,'index']);
    Route::get('/show/{id}',[CategotyController::class,'show']);
});

Route::get('/search', [LayoutController::class, 'search']);
Route::get('/search/show/{id}', [LayoutController::class, 'show']);

// Rutas públicas para usuarios invitados
Route::middleware('guest')->group(function() {
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

});
// Rutas autenticadas para usuarios registrados
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::prefix('address')->group(function() {
        Route::get('/',[AuthController::class,'hasAddress']);
        Route::post('/create',[AuthController::class,'createAddress']);
    });

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
        Route::delete('/all/{id}',[CartController::class,'removeCart']);
        Route::post('/all/online',[CartController::class,'removeCartOnline']);
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

            Route::prefix('customers')->group(function(){
                Route::get('/',[CustomerController::class, 'index']);
            });

            
        });
        
        // Rutas solo para super administradores (super_admin)
        Route::middleware('is_admin:super_admin')->group(function () {
            Route::prefix('employees')->group(function() {
                Route::get('/', [EmployeeController::class, 'index']);
                Route::post('/create', [EmployeeController::class, 'store']);
                Route::put('/edit/{id}', [EmployeeController::class, 'update']);
                Route::delete('/{id}', [EmployeeController::class, 'destroy']);
            });
            
            Route::get('/dashboard', [DashboardController::class, 'index']);
            Route::get('/action_logs', [ActionLogController::class, 'index']);
        });
    }); 
});
