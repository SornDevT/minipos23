<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// create route for register controller UserController
Route::post('/register', [UserController::class, 'register']);
// create route for login controller UserController
Route::post('/login', [UserController::class, 'login']);
// create route for logout controller UserController
Route::get('/logout', [UserController::class, 'logout']);