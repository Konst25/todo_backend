<?php

use App\Http\Controllers\Api\V1\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->middleware(['throttle:api'])->group(function () {
    Route::post('register', [\App\Http\Controllers\Api\V1\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login']);
    Route::get('tasks', [\App\Http\Controllers\Api\V1\TaskController::class, 'index']);
    Route::get('tasks/{task}', [\App\Http\Controllers\Api\V1\TaskController::class, 'show']);
    Route::get('statuses', [\App\Http\Controllers\Api\V1\StatusController::class, 'index']);
    Route::get('statuses/{status}', [\App\Http\Controllers\Api\V1\StatusController::class, 'show']);
});

Route::prefix('v1')->middleware(['throttle:api', 'auth:sanctum'])->group(function() {
    // Route::apiResource('statuses', \App\Http\Controllers\Api\V1\StatusController::class);
    // Route::apiResource('tasks', \App\Http\Controllers\Api\V1\TaskController::class);
    Route::post('statuses', [\App\Http\Controllers\Api\V1\StatusController::class, 'store']);
    Route::post('tasks', [\App\Http\Controllers\Api\V1\TaskController::class, 'store']);
    Route::put('tasks/{task}', [\App\Http\Controllers\Api\V1\TaskController::class, 'update']);
    Route::delete('tasks/{task}', [\App\Http\Controllers\Api\V1\TaskController::class, 'destroy']);
    Route::delete('logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout']);
});
