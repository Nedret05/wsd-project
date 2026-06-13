<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EchoController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\ShortLinkController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\FeedController;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok'
    ]);
});

Route::get('/echo', [EchoController::class, 'echo']);
Route::post('/echo', [EchoController::class, 'echo']);

Route::prefix('79000/v1')->group(function () {
  Route::post(
    'users/{id}/follow',
    [FollowController::class, 'follow']
);

Route::delete(
    'users/{id}/follow',
    [FollowController::class, 'unfollow']
);

Route::get(
    'feed',
    [FeedController::class, 'index']
);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

    Route::apiResource('short-links', ShortLinkController::class)
        ->only(['index', 'store', 'show']);

    Route::get('/restaurants/nearby', [RestaurantController::class, 'nearby']);

    Route::get('/restaurants', [RestaurantController::class, 'index']);
    Route::post('/restaurants', [RestaurantController::class, 'store']);
    Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);
    Route::put('/restaurants/{id}', [RestaurantController::class, 'update']);
    Route::delete('/restaurants/{id}', [RestaurantController::class, 'destroy']);

    Route::apiResource('photos', PhotoController::class)
        ->only(['index', 'store', 'show', 'destroy']);
});