<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NotesController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public Routes
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::apiResource('/category', CategoryController::class);
    Route::post('/notes/{id}', [NotesController::class, 'update']);
    Route::apiResource('/notes', NotesController::class);

});
