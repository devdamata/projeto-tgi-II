<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;

Route::get('/user', function (Request $request) {
   return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/auth/verify', [AuthController::class, 'verifyToken']);


    Route::post('/logout', [AuthController::class, 'logout']);

    //Categorias
    Route::get('/category/list', [CategoryController::class, 'index']);
    Route::post('/category', [CategoryController::class, 'store']);

    Route::post('/count/tasks/for/category', [CategoryController::class, 'countTasksForCategory']);

    //Tarefas
    Route::get('/task/list', [TaskController::class, 'index']);
});

