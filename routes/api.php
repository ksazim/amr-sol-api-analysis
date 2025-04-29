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
Route::middleware('auth:sanctum')->post('/v1/logout', [AuthController::class, 'logout']);

// Product 
Route::middleware(['auth:sanctum', 'permission:list product'])->get('v1/list', [ProductController::class, 'list']);
Route::middleware(['auth:sanctum', 'permission:list create'])->get('v1/create', [ProductController::class, 'create']);
Route::middleware(['auth:sanctum', 'permission:list edit'])->get('v1/update', [ProductController::class, 'update']);
Route::middleware(['auth:sanctum', 'permission:list delete'])->get('v1/delete', [ProductController::class, 'delete']);