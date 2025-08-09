<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
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

Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth',
], function () {
    //Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
});

// User API routes
Route::group([
    'middleware' => ['api'],
    'prefix' => 'users',
], function () {
    Route::get('/', [UserController::class, 'list'])->middleware('auth:api');
    Route::post('/', [UserController::class, 'store'])->middleware('auth:api');
    Route::get('/{id}', [UserController::class, 'profile'])->middleware('auth:api');
    Route::delete('/{id}', [UserController::class, 'delete'])->middleware('auth:api');
    Route::put('/{id}/roles', [UserController::class, 'changeRole'])->middleware('auth:api');
});
