<?php

use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('/login', [AdminAuthController::class, 'login']);
            Route::get('/logout', [AdminAuthController::class, 'logout'])->middleware(['auth:sanctum', 'ability:admin']);
        });
    });
});
