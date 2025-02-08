<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::put('/tasks/{id}/status', [TaskController::class, 'updateStatusTask'])->name('tasks.updateStatus');
Route::delete('/tasks/{id}', [TaskController::class, 'deleteTask'])->name('tasks.delete');
Route::get('/tasks/create', function () {
    return view('tasks.create');
})->name('tasks.create');

use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

