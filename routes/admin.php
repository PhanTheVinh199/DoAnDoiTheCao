<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MTC_NhaCungCapController;
use App\Http\Controllers\Admin\MTC_SanPhamController;
use App\Http\Controllers\Admin\MTC_DonHangController;
use App\Http\Controllers\admin\NganhangController;

use App\Http\Controllers\admin\ThanhvienController;


Route::get('/index', function () {
    return view('admin.main');
})->name('index');


Route::prefix('mathecao')->name('mathecao.')->group(function () {
    Route::get('/donhang', [MTC_DonHangController::class, 'index'])->name('donhang.index');
    Route::post('/donhang/store', [MTC_DonHangController::class, 'store'])->name('donhang.store');
    Route::get('/donhang/{id}/edit', [MTC_DonHangController::class, 'edit'])->name('donhang.edit'); 
    Route::put('/donhang/{id}', [MTC_DonHangController::class, 'update'])->name('donhang.update');
    Route::resource('/donhang', MTC_DonHangController::class);
    

    Route::get('/loaima', [MTC_SanPhamController::class, 'index'])->name('loaima.index');
    Route::get('/loaima/create', [MTC_SanPhamController::class, 'create'])->name('loaima.create');
    Route::post('/loaima/store', [MTC_SanPhamController::class, 'store'])->name('loaima.store');
    Route::get('/loaima/{id}/edit', [MTC_SanPhamController::class, 'edit'])->name('loaima.edit');
    Route::put('/loaima/{id}', [MTC_SanPhamController::class, 'update'])->name('loaima.update');
    Route::resource('/loaima', MTC_SanPhamController::class);
    

    Route::get('/nhacungcap', [MTC_NhaCungCapController::class, 'index'])->name('nhacungcap.index');
    Route::get('/nhacungcap/create', [MTC_NhaCungCapController::class, 'create'])->name('nhacungcap.create');
    Route::post('/nhacungcap/store', [MTC_NhaCungCapController::class, 'store'])->name('nhacungcap.store');
    Route::get('/nhacungcap/{id}/edit', [MTC_NhaCungCapController::class, 'edit'])->name('nhacungcap.edit');
    Route::put('/nhacungcap/{id}', [MTC_NhaCungCapController::class, 'update'])->name('nhacungcap.update');
    Route::resource('/nhacungcap', MTC_NhaCungCapController::class);
    
});

Route::prefix('nganhang')->name('nganhang.')->group(function () {
    // Route hiển thị danh sách ngân hàng
    Route::get('/', [NganhangController::class, 'index'])->name('index');
    // Route xóa ngân hàng
    Route::delete('/delete/{id}', [NganhangController::class, 'delete_nganhang'])->name('delete');


    

    //Route hiển thị lịch sử rút
    Route::get('/ruttien', [NganhangController::class, 'ruttien'])->name('ruttien.index');
    // Route Rút xóa lịch sử rút tiền
    Route::delete('/ruttien/delete/{id}', [NganhangController::class, 'destroyRutTien'])->name('ruttien.delete');
    //Route chỉnh sửa rút tiền
    Route::get('/ruttien/edit/{id}', [NganhangController::class, 'editRutTien'])->name('ruttien.edit');
    Route::put('/ruttien/edit/{id}', [NganhangController::class, 'updateRutTien'])->name('ruttien.update');




    //Route hiển thị lịch sử nạp
    Route::get('/naptien', [NganhangController::class, 'naptien'])->name('naptien.index');
     // Xóa lịch sử nạp tiền
     Route::delete('/naptien/delete/{id}', [NganhangController::class, 'destroyNapTien'])->name('naptien.delete');

    //Route sửa lịch sử nạp 
     Route::get('/naptien/edit/{id}', [NganhangController::class, 'editNapTien'])->name('naptien.edit');
     Route::put('/naptien/edit/{id}', [NganhangController::class, 'updateNapTien'])->name('naptien.update');
     
});





Route::prefix('thanhvien')->name('thanhvien.')->group(function () {
    Route::get('/', [ThanhVienController::class, 'index'])->name('danhsach');


     // Route chỉnh sửa thông tin thành viên
     Route::get('/edit/{id}', [ThanhvienController::class, 'edit'])->name('edit');
     Route::put('/edit/{id}', [ThanhvienController::class, 'update'])->name('update');
     //Xóa thành viên
     Route::delete('/delete/{id}', [ThanhvienController::class, 'destroy'])->name('delete');
});
