<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Home;
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

Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [Home::class, 'home']);
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::get('/auth/logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
