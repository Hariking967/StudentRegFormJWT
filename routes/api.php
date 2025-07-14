<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

// login and register routes are not protected with jwt tokens cos they are generated throught these routes only.
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/refresh',   [AuthController::class, 'refresh']);

// Student post, patch, delete are protected with jwt
Route::middleware('auth:api')->group(function () {
    Route::post('/logout',    [AuthController::class, 'logout']);
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
