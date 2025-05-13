<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\ThanhToanController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\SanPhamController;
use App\Http\Controllers\User\LichSuMuaTheController;
use App\Http\Controllers\NapTienController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\NapTienAdminController;
use App\Http\Controllers\User\RutTienController;
use App\Http\Controllers\User\DoiTheCaoController;



// Trang chủ
Route::get('/', fn() => view('index'))->name('index');

// Các trang tĩnh khác
Route::view('/header', 'header')->name('header');
Route::view('/footer', 'footer')->name('footer');
Route::get('/card', [SanPhamController::class, 'index'])->name('card');
Route::view('/ruttien', 'ruttien')->name('ruttien');
Route::view('/naptien', 'naptien')->name('naptien');
Route::view('/lichsu', 'lichsudoithe')->name('lichsudoithe');
Route::get('/lichsumuathe', [LichSuMuaTheController::class, 'index'])->name('lichsumuathe');
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

Route::get('/get-product-prices/{id}', [SanPhamController::class, 'getProductPrices']);
Route::get('/thanh-toan', [ThanhToanController::class, 'index'])->name('pay');
Route::post('/process-payment', [ThanhToanController::class, 'process'])->name('process.payment');

Route::middleware('auth:thanhvien')->group(function () {
    Route::get('/naptien', [NapTienController::class, 'showForm'])->name('naptien.form'); 
    Route::post('/naptien', [NapTienController::class, 'store'])->name('naptien.store');
    Route::get('/lichsunap', [NapTienController::class, 'showHistory'])->name('lichsunap');
});

Route::get('/user/add_nganhang_user', [RutTienController::class, 'showAddBankForm'])->name('add_nganhang_user');
//Xử lý thêm ngân hàng
Route::post('/user/add_nganhang_user', [RutTienController::class, 'addBank'])->name('add_nganhang_user_store');
//Rút tiền
Route::post('/user/rut-tien', [RutTienController::class, 'processRutTien'])->name('rut-tien');


    //Route hiển thị lịch sử rút
Route::get('ruttien', [RutTienController::class, 'showRutTienHistory'])->name('ruttien');


//Đổi Thẻ Cào
Route::get('/', [DoiTheCaoController::class, 'index'])->name('index');

// Route xử lý việc đổi thẻ cào khi người dùng submit form
Route::post('/', [DoithecaoController::class, 'exchange'])->name('doithecao.exchange');




// Route để xem chi tiết đơn hàng
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

Route::post('order/confirm/{id}', [OrderController::class, 'confirm'])->name('order.confirm');

Route::post('admin/naptien/approve/{id}', [NapTienAdminController::class, 'approve'])->name('admin.naptien.approve');