<?php

use App\Http\Controllers\Api\Auth\AuthUserController;
use App\Http\Controllers\Api\Categories\CategoryController;
use Illuminate\Http\Request;
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

Route::post('users/login', [AuthUserController::class, 'login']);
Route::post('users/register', [AuthUserController::class, 'register']);

Route::group(['prefix' => 'users', 'middleware' => ['auth:sanctum']], function () {
    Route::get('profile/{user}', [AuthUserController::class, 'profile']);
    Route::put('profile/update/{user}', [AuthUserController::class, 'update']);
    Route::post('logout', [AuthUserController::class, 'logout']);
});

Route::apiResource('categories', CategoryController::class);
