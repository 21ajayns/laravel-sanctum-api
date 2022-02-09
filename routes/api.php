<?php

use App\Http\controllers\TCAcontroller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::resource('/tca', TCAcontroller::class); 
//tca for task-crud-app..!//
//Route::get('/tca', [TCAcontroller::class, 'index']);
//Route::post('/tca', [TCAcontroller::class, 'store']);





//Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);

//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/products', [productController::class, 'store']);
    Route::put('/products/{id}', [productController::class, 'update']);
    Route::delete('/products/{id}', [productController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
