<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Home;
use App\Http\Controllers\ProjectController;
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
    Route::post('/auth/user', [AuthController::class, 'updateProfile']);
    Route::get('/auth/logout', [AuthController::class, 'logout']);

    // Halaman Home
    Route::get('/home_project', [Home::class, 'projects']);
    Route::get('/notifications', [Home::class, 'notifications']);

    // Halaman Project
    Route::group(['prefix' => 'project'], function () {
        Route::get('/', [ProjectController::class, 'index']);
        Route::post('/store_private', [ProjectController::class, 'storePrivate']);

        // detail
        Route::get('/{id}', [ProjectController::class, 'detail']);
        // update deskripsi project
        Route::post('/{id}/updateDeskripsi', [ProjectController::class, 'updateDeskripsiProject']);
        Route::post('/{id}/updateDeadline', [ProjectController::class, 'updateDeadlineProject']);

        // Checklist
        Route::post('/add_checklist/{id}', [ProjectController::class, 'addChecklist']);
        Route::post('/add_sub_checklist/{id}', [ProjectController::class, 'addSubChecklist']);

        Route::post('/update_sub_checklist/{id}', [ProjectController::class, 'updateSubChecklist']);
    });
});

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
