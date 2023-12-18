<?php

use App\Http\Controllers\API\ArticlesController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserPreferencesController;
use App\Http\Controllers\API\UsersController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::put('/profile', [UsersController::class, 'update']);
    Route::get('/articles', [ArticlesController::class, 'index']);
    Route::get('/articles/{id}', [ArticlesController::class, 'show']);
    Route::get('/articles-meta', [ArticlesController::class, 'getArticlesMeta']);
    Route::get('/user-preferences', [UserPreferencesController::class,'fetch']);
    Route::put('/user-preferences',[UserPreferencesController::class, 'update']);

});


Route::get('/articles', [ArticlesController::class, 'index']);
Route::get('/articles/{id}', [ArticlesController::class, 'show']);
Route::get('/articles-meta', [ArticlesController::class, 'getArticlesMeta']);