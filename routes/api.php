<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/{id}', [PostController::class, 'show']);
        Route::post('/', [PostController::class, 'store']);
        Route::delete('/{id}', [PostController::class, 'destroy']);
        Route::put('/{id}', [PostController::class, 'update']);
    });
    Route::get('/posts-search', [PostController::class, 'search']);
});
