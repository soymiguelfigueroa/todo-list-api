<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/todos', [TodoController::class, 'store'])->middleware('auth:sanctum');
Route::put('/todos/{todo}', [TodoController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/todos/{todo}', [TodoController::class, 'delete'])->middleware('auth:sanctum');
