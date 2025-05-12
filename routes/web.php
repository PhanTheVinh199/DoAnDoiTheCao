<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NapTienController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;


// Trang chủ
Route::get('/', fn() => view('index'))->name('index');

// Các trang tĩnh khác
Route::view('/header', 'header')->name('header');
Route::view('/card', 'card')->name('card');
Route::view('/ruttien', 'ruttien')->name('ruttien');
Route::view('/lichsu', 'lichsudoithe')->name('lichsudoithe');
Route::view('/lichsumuathe', 'lichsumuathe')->name('lichsumuathe');
Route::view('/lichsusodu', 'lichsusodu')->name('lichsusodu');
Route::view('/naptiendienthoai', 'naptiendienthoai')->name('naptiendienthoai');

// Các trang login_register chỉ dành cho khách
Route::middleware('guest:thanhvien')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Đăng xuất
Route::get('/logout', function () {
    Auth::guard('thanhvien')->logout(); // Đăng xuất guard "thanhvien"
    request()->session()->invalidate(); // Hủy session
    request()->session()->regenerateToken(); // Tạo lại token CSRF

    return redirect()->route('login')->with('message', 'Bạn đã đăng xuất.');
})->name('logout');

// Các route yêu cầu người dùng phải đăng nhập
Route::middleware('auth:thanhvien')->group(function () {
    Route::get('/naptien', [NapTienController::class, 'showForm'])->name('naptien.form'); 
    Route::post('/naptien', [NapTienController::class, 'store'])->name('naptien.store');
    Route::get('/lichsunap', [NapTienController::class, 'showHistory'])->name('lichsunap');
});



// Route để xem chi tiết đơn hàng
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

Route::post('order/confirm/{id}', [OrderController::class, 'confirm'])->name('order.confirm');


Route::post('admin/naptien/approve/{id}', [NapTienAdminController::class, 'approve'])->name('admin.naptien.approve');