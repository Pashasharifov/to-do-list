<?php

use App\Http\Controllers\ListController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('/lists', [ListController::class, 'store']);
    Route::get('/lists', [ListController::class, 'getLists']);
    Route::post("/lists/{id}/tasks", [TaskController::class, 'store']);
    Route::patch("tasks/{id}", [TaskController::class, "updateTask"]);
    Route::delete("tasks/{id}", [TaskController::class, "delete"]);
    Route::get("/getAuthorizedUserTasks", [TaskController::class, "getAuthorizedUserTasks"]);
});

Route::get("/tasks/search", [TaskController::class, "search"]);
