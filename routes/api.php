<?php

use App\Http\Controllers\Api\Auth\AuthUserController;
use App\Http\Controllers\Api\Categories\CategoryController;
use App\Http\Controllers\Api\Movies\MovieController;
use App\Http\Controllers\Api\Plans\PlanController;
use App\Http\Controllers\Api\Reviews\ReviewController;
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

Route::post('v1/users/login', [AuthUserController::class, 'login']);
Route::post('v1/users/register', [AuthUserController::class, 'register']);

Route::group(['prefix' => 'v1/users', 'middleware' => ['auth:sanctum']], function () {
    Route::get('profile/{user}', [AuthUserController::class, 'profile']);
    Route::put('profile/update/{user}', [AuthUserController::class, 'update']);
    Route::post('logout', [AuthUserController::class, 'logout']);
});

Route::apiResource('v1/categories', CategoryController::class);

Route::apiResource('v1/movies', MovieController::class);

Route::apiResource('v1/plans', PlanController::class);

Route::apiResource('v1/reviews', ReviewController::class)->except(['index']);
