<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransectionController;
use App\Http\Controllers\BillController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// create route for register controller UserController
Route::post('/register', [UserController::class, 'register']);
// create route for login controller UserController
Route::post('/login', [UserController::class, 'login']);
// create route for logout controller UserController
Route::get('/logout', [UserController::class, 'logout']);

// create route group for CategoryController crud 
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/category', [CategoryController::class, 'index']);
    Route::post('/category/add', [CategoryController::class, 'add']);
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('/category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/delete/{id}', [CategoryController::class, 'delete']);
});

// create route group for ProductController crud
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/product', [ProductController::class, 'index']);
    Route::post('/product/add', [ProductController::class, 'add']);
    Route::get('/product/edit/{id}', [ProductController::class, 'edit']);
    Route::post('/product/update/{id}', [ProductController::class, 'update']);
    Route::delete('/product/delete/{id}', [ProductController::class, 'delete']);
});

// create route group for TransectionController crud
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/transection', [TransectionController::class, 'index']);
    Route::post('/transection/add', [TransectionController::class, 'add']);
    // Route::get('/transection/edit/{id}', [TransectionController::class, 'edit']);
    // Route::post('/transection/update/{id}', [TransectionController::class, 'update']);
    // Route::delete('/transection/delete/{id}', [TransectionController::class, 'delete']);
});

// create route group for print bill
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/bill/print/{id}', [BillController::class, 'print_bill']);
});
