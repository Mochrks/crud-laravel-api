<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->prefix('/food-order')->group(function () {
    Route::get('/foods', [FoodController::class, 'getAllFoods']);
    Route::post('/cart', [FoodController::class, 'addToCart']);
    Route::put('/foods/{foodId}/favorites', [FoodController::class, 'toggleFavorite']);
    Route::delete('/cart/{cartId}', [FoodController::class, 'deleteFromCart']);
});
Route::post('/user-management/users/sign-up', [UserController::class, 'signup']);
Route::post('/user-management/users/sign-in', [UserController::class, 'signin']);
