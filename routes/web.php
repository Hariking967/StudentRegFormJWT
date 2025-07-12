<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

//welcome page for users
Route::get('/', function () {
    return view('welcome');
});

//login routes
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

//student routes (get)
Route::view('/students/create', 'student.create')->name('student.create');
Route::view('/students/edit', 'student.edit')->name('student.edit');
Route::view('/students/show', 'student.show')->name('student.show');
