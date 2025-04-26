<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
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

        // Admin CRUD
        Route::get('/', [AdminController::class, 'index']);
        Route::post('/', [AdminController::class, 'create']);
        Route::get('/{id}', [AdminController::class, 'retrieve']);
        Route::put('/{id}', [AdminController::class, 'update']);
        Route::delete('/{id}', [AdminController::class, 'delete']);
    });
});
