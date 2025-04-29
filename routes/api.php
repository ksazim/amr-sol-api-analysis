<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\v1\ProductController;

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

// Authentication

Route::post('/v1/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/v1/logout', [AuthController::class, 'logout']);

// Product 
Route::middleware(['auth:sanctum', 'permission:list product'])->get('v1/list', [ProductController::class, 'list']);
Route::middleware(['auth:sanctum', 'permission:view product'])->get('v1/view/{id}', [ProductController::class, 'getById']);

Route::middleware(['auth:sanctum', 'permission:create product'])->post('v1/create', [ProductController::class, 'create']);
Route::middleware(['auth:sanctum', 'permission:edit product'])->post('v1/update/{id}', [ProductController::class, 'update']);

Route::middleware(['auth:sanctum', 'permission:delete product'])->delete('v1/delete/{id}', [ProductController::class, 'delete']);