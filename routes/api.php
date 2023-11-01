<?php

use App\Http\Controllers\BlogController;
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
Route::apiResource('blogs', BlogController::class)->only(['index', 'show']);

// Protected routes
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::resource('blogs', BlogController::class)->except(['index', 'show']);

    Route::get('/user/{id}', function (string $id) {
        return new UserResource(User::findOrFail($id));
    });

    Route::get('/users', function () {
        return UserResource::collection(User::all());
    });
});
