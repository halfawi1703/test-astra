<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/user', [AuthenticationController::class, 'user']);
    
    // Transaction
    Route::get('/order', [TransactionController::class, 'index']);
    Route::post('/order', [TransactionController::class, 'store']);
    Route::delete('/order/{id}', [TransactionController::class, 'destroy']);
    // Route::get('order/export', [TransactionController::class, 'export']);
});

// Register
Route::post('/register', [RegisterController::class, 'store']);

// Login
Route::post('/login', [AuthenticationController::class, 'login']);

// Product
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'detail']);
Route::post('/products', [ProductController::class, 'store']);
Route::patch('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::get('order/export', [TransactionController::class, 'export']);
