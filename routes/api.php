<?php

use Illuminate\Http\Request;

//Route::apiResource('products', ProductController::class);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
//use App\Http\Controllers\Api\CartController;
//use App\Http\Controllers\Api\EmployeeController;

// Ruta pública para el índice principal
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Rutas públicas para usuarios invitados
Route::middleware('guest')->group(function() {
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

});
//Route::get('/admin/products', [ProductController::class, 'index']);
// Rutas autenticadas para usuarios registrados
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    //Route::get('/admin/products', [ProductController::class, 'index']);
    // Rutas para el carrito
   /*  Route::prefix('cart')->group(function() {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/create/{id}/{type}', [CartController::class, 'store'])->name('cart.store');
        Route::put('/update/{id}/{data}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    }); */

    // Rutas de administración
     Route::prefix('admin')->group(function () {      
        // Rutas solo para administradores (admin y super_admin)
        Route::middleware('is_admin:admin,super_admin')->group(function () {
            Route::prefix('products')->group(function () {
                Route::get('/', [ProductController::class, 'index']);
                Route::get('/create', [ProductController::class, 'create']);
                Route::post('/create', [ProductController::class, 'store']);
                Route::put('/edit/{id}', [ProductController::class, 'update']);
                Route::delete('/{id}', [ProductController::class, 'destroy']);
            });
        });
/*
        // Rutas solo para super administradores (super_admin)
         Route::middleware('is_admin:super_admin')->group(function () {
            Route::prefix('employees')->group(function() {
                Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
                Route::post('/create', [EmployeeController::class, 'store'])->name('employees.store');
                Route::put('/update/{id}', [EmployeeController::class, 'update'])->name('employees.update');
                Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
            });
        });*/
    }); 
});
