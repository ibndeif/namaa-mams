<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('cacheResponse:600')->group(function () {
    Route::get('articles', [ArticleController::class, 'index']);
    Route::get('articles/{article:slug}', [ArticleController::class, 'show']);
    Route::get('articles/{article:slug}/comments', [CommentController::class, 'index']);
});
