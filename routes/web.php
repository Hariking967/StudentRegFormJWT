<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/login', 'auth.login');
Route::view('/register', 'auth.register');

Route::get('students/create', [StudentController::class, 'create']);
Route::get('students/create', [StudentController::class, 'create']);
Route::get('/students/{student}', [StudentController::class, 'show'])->name('show');
Route::get('/students', [StudentController::class, 'index'])->name('index');
Route::get('/students/edit', [StudentController::class, 'layoutedit'])->name('layoutedit');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('edit');
Route::get('/students/edit', [StudentController::class, 'layoutedit'])->name('layoutedit');
