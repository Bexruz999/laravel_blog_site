<?php

use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Api\V1\BlogApiController;
use App\Http\Resources\UserResource;
use App\Models\User;
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

// Public routes
//Route::apiResource('blogs', BlogApiController::class)->only(['index', 'show']);

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/logout', [AuthApiController::class, 'logout']);

    Route::apiResource('blogs', BlogApiController::class);

    Route::get('/user/{id}', function (string $id) {
        return new UserResource(User::findOrFail($id));
    });

    Route::get('/users', function () {
        return UserResource::collection(User::all());
    });
});
