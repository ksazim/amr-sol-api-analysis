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

// Route::middleware(['permission:publish articles'])->get('test', [AuthController::class, 'test']);
// Route::get('test', [AuthController::class, 'test']);

// Authentication

Route::post('/v1/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/v1/logout', [AuthController::class, 'logout']);

// Product 
Route::middleware(['permission:publish articles'])->get('list', [ProductController::class, 'list']);
Route::middleware(['permission:publish articles'])->get('create', [ProductController::class, 'create']);
Route::middleware(['permission:publish articles'])->get('update', [ProductController::class, 'update']);
Route::middleware(['permission:publish articles'])->get('delete', [ProductController::class, 'delete']);