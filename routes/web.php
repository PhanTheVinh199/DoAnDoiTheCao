<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\ThanhToanController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\SanPhamController;
use App\Http\Controllers\User\RutTienController;



// Trang chủ
Route::get('/', fn() => view('index'))->name('index');

// Các trang tĩnh khác
Route::view('/header', 'header')->name('header');
Route::get('/card', [SanPhamController::class, 'index'])->name('card');
Route::view('/ruttien', 'ruttien')->name('ruttien');
Route::view('/naptien', 'naptien')->name('naptien');
Route::view('/lichsu', 'lichsudoithe')->name('lichsudoithe');
Route::view('/lichsumuathe', 'lichsumuathe')->name('lichsumuathe');
Route::view('/lichsusodu', 'lichsusodu')->name('lichsusodu');


// Các trang login_register

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/logout', function () {
    Auth::guard('thanhvien')->logout(); // Đăng xuất guard "thanhvien"
    request()->session()->invalidate(); // Hủy session
    request()->session()->regenerateToken(); // Tạo lại token CSRF

    return redirect()->route('login')->with('message', 'Bạn đã đăng xuất.');
})->name('logout');

Route::get('/get-product-prices/{id}', [SanPhamController::class, 'getProductPrices']);
Route::get('/thanh-toan', [ThanhToanController::class, 'index'])->name('pay');
Route::post('/process-payment', [ThanhToanController::class, 'process'])->name('process.payment');


// Ngan hang User
// Route::get('/user/them-ngan-hang', [UserController::class, 'addBank'])->name('add_nganhang_user');



// Hiển thị form thêm ngân hàng
Route::get('/user/add_nganhang_user', [RutTienController::class, 'showAddBankForm'])->name('add_nganhang_user');
//Xử lý thêm ngân hàng
Route::post('/user/add_nganhang_user', [RutTienController::class, 'addBank'])->name('add_nganhang_user_store');
//Rút tiền
Route::post('/user/rut-tien', [RutTienController::class, 'processRutTien'])->name('rut-tien');


    //Route hiển thị lịch sử rút
Route::get('ruttien', [RutTienController::class, 'showRutTienHistory'])->name('ruttien');



