<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::group(['prefix' => 'users'], function () {
    Route::post('/register', [AuthController::class, 'create']);
	Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
	Route::group(['prefix' => 'users'], function () {
		Route::get('/index/{user?}', [AuthController::class, 'index']);
	    Route::put('/logout', [AuthController::class, 'logout']);
	    Route::put('/update/{user}', [AuthController::class, 'update']);
	    Route::delete('/delete/{user}', [AuthController::class, 'delete']);
	    Route::post('/image/', [AuthController::class, 'uploadImage']);
	    Route::get('/image/{user}', [AuthController::class, 'image']);
    });
});