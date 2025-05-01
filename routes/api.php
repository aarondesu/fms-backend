<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AdminPasswordController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'admin'], function () {
        // Auth
        Route::group(['prefix' => 'auth'], function () {
            Route::post('/login', [AdminAuthController::class, 'login']);
            Route::get('/logout', [AdminAuthController::class, 'logout'])->middleware(['auth:sanctum', 'ability:admin']);
            Route::get('/user', function (Request $request) {
                return response()->json(['success' => true, 'data' => $request->user()]);
            })->middleware('auth:sanctum');
        });

        // Password
        Route::group(['prefix' => 'password'], function () {
            Route::post('/reset', [AdminPasswordController::class, 'reset']);
            Route::post('/change', [AdminPasswordController::class, 'change']);
        });

        // Admin CRUD
        Route::get('/', [AdminController::class, 'index']);
        Route::post('/', [AdminController::class, 'create']);
        Route::get('/{id}', [AdminController::class, 'retrieve']);
        Route::put('/{id}', [AdminController::class, 'update']);
        Route::delete('/', [AdminController::class, 'delete']);
    });

    // SERVICES
    Route::group(['prefix' => 'services'], function () {
        Route::get('/', [ServiceController::class, 'index']);
        Route::post('/', [ServiceController::class, 'create']);
        Route::get('/{id}', [ServiceController::class, 'retrieve']);
        Route::put('/{id}', [ServiceController::class, 'update']);
        Route::delete('/{id}', [ServiceController::class, 'delete']);
    });
});
