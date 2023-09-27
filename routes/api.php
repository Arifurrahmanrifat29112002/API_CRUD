<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ProdutController;
use App\Models\Product;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//Authentication user 
Route::post('/user/registration',[AuthenticationController::class,'Registration'])->name('registration');
Route::post('/user/login',[AuthenticationController::class,'Login'])->name('login');
Route::get('/user/logout',[AuthenticationController::class,'logout'])->middleware('auth:sanctum')->name('logout');

//product 
Route::get('/get/products',[ProdutController::class,'index'])->name('allProducts');
Route::get('/get/product/{id}',[ProdutController::class,'show'])->name('Product');

Route::controller(ProdutController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/create/product','store')->name('Product.store');
    Route::put('/edit/product/{product}','update')->name('Product.update');
    Route::delete('/delete/product/{product}','destroy')->name('Product.update');
});

