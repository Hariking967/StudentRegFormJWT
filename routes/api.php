<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout',    [AuthController::class, 'logout']);
    Route::post('/refresh',   [AuthController::class, 'refresh']);
    Route::get('/student',    [StudentController::class, 'getMyStudent']);
    Route::post('/students',  [StudentController::class, 'store']);
    Route::patch('/students/{rollno}', [StudentController::class, 'update']);
    Route::delete('/students/{rollno}', [StudentController::class, 'destroy']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return response()->json([
        'user' => $request->user()
    ]);
});
