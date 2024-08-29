<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/test', [TestController::class, 'index']);

Route::get('/index', [UserController::class, 'index']);

Route::post('/register', [AuthController::class, 'register_user']);
Route::post('/login', [AuthController::class, 'user_login']);

Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

Route::post('/comment/{user}', [BlogController::class, 'store']);

Route::post('/update', [UserController::class, 'update']);
Route::post('/delete_user/{user}', [UserController::class, 'delete_user']);
// Route::post();
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');