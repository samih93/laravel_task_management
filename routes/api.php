<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckUserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {



    // Route::post('tasks', [TaskController::class, 'store']);
    // Route::get('tasks', [TaskController::class, 'index']);
    // Route::put('tasks/{id}', [TaskController::class, 'update']);
    // Route::get('tasks/{id}', [TaskController::class, 'show']);
    // Route::delete('tasks/{id}', [TaskController::class, 'destroy']);




    Route::post('logout', [UserController::class, 'logout']);


    Route::prefix('profile')->group(function () {
        Route::post('', [ProfileController::class, 'store']);
        Route::get('/{id}', [ProfileController::class, 'show']);
    });

    Route::get('user/{id}/profile', [UserController::class, 'getProfile']);

    Route::get('user/{id}/tasks', [UserController::class, 'getUserTasks']);

    Route::apiResource('tasks', TaskController::class);
    Route::get('task/all', [TaskController::class, 'getAllTasks'])->middleware('CheckUser');
    Route::get('task/ordered', [TaskController::class, 'getTasksByPriority']);

    Route::post('task/{id}/favorite', [TaskController::class, 'addToFavorites']);
    Route::delete('task/{id}/favorite', [TaskController::class, 'removeFromFavorites']);
    Route::get('task/favorites', [TaskController::class, 'getFavoriteTasks']);

    Route::post('tasks/{taskId}/categories', [TaskController::class, 'addCateogoriesToTask']);
    Route::get('tasks/{taskId}/categories', [TaskController::class, 'getTaskCategories']);



    Route::get('categories/{categoryId}/tasks', [CategoryController::class, 'getCategoryTasks']);
});
