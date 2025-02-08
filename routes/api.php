<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/autenticacion',[AuthController::class,'loginApi']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/me',[AuthController::class,'me']);
    Route::get('/listUser',[AuthController::class,'listUsers']);
    Route::post('/createUser',[AuthController::class,'register']);
    Route::post('/createTask',[TaskController::class,'createTask']);
    Route::get('/listTask',[TaskController::class,'listTask']);
    Route::get('listTaskByUser/{id?}',[TaskController::class,'listTaskByUser']);
    Route::put('/updateTask/{id}',[TaskController::class,'updateTask']);
    Route::patch('/updateStatusTask/{id}',[TaskController::class,'updateStatusTask']);
    Route::delete('/deleteTask/{id}',[TaskController::class,'deleteTask']);
});
