<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/students', [StudentController::class, 'store'])->name('store');
    Route::patch('/students/{student}', [StudentController::class, 'update'])->name('update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('destroy');
});
