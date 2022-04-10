<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CategoryController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/registr', [UsersController::class, 'register']);
Route::post('/auth', [UsersController::class, 'auth']);
Route::post('/logout', [UsersController::class, 'logout']);

Route::post('/order', [OrdersController::class, 'addOrder'])->middleware("Admin");
Route::get('/getorders', [OrdersController::class, 'getOrders'])->middleware("apiAuth");
Route::delete('/deleteorders', [OrdersController::class, 'deleteOrders'])->middleware("apiAuth");

Route::post('/addcategory', [CategoryController::class, 'addCategory'])->middleware(["apiAuth", "Admin"]);
Route::delete('/deletecategory', [CategoryController::class, 'deleteCategory'])->middleware(["apiAuth", "Admin"]);
Route::get('/getcategory', [CategoryController::class, 'getCategory'])->middleware(["apiAuth", "Admin"]);



