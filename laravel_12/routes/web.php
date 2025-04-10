<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/header', function () {
    return view('header');
})->name('header');

Route::get('/card', function () {
    return view('card');
})->name('card');

Route::get('/ruttien', function () {
    return view('ruttien');
})->name('ruttien');

Route::get('/naptien', function () {
    return view('naptien');
})->name('naptien');

Route::get('/lichsu', function () {
    return view('lichsudoithe');
})->name('lichsudoithe');

Route::get('/lichsumuathe', function () {
    return view('lichsumuathe');
})->name('lichsumuathe');

Route::get('/lichsusodu', function () {
    return view('lichsusodu');
})->name('lichsusodu');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
