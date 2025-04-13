<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\admin\NganhangController;

use App\Http\Controllers\admin\ThanhvienController;

Route::get('/main', function () {
    return view('admin.main');
})->name('main');


Route::prefix('mathecao')->name('mathecao.')->group(function () {
    Route::get('/donhang', fn() => view('admin.mathecao.donhang.mathecao_donhang'))->name('donhang');
    // Route::get('/donhang/edit/{id}', fn($id) => view('admin.mathecao.donhang.mathecao_donhang_edit', ['id' => $id]))->name('donhang_edit');
    Route::get('/donhang/edit', fn() => view('admin.mathecao.donhang.mathecao_donhang_edit'))->name('donhang_edit');

    Route::get('/loaima', fn() => view('admin.mathecao.loaima.mathecao_danhsach'))->name('loaima');
    Route::get('/loaima/add', fn() => view('admin.mathecao.loaima.mathecao_danhsach_add'))->name('loaima_add');
    Route::get('/loaima/edit', fn() => view('admin.mathecao.loaima.mathecao_danhsach_edit'))->name('loaima_edit');
    // Route::get('/loaima/edit/{id}', fn($id) => view('admin.mathecao.loaima.mathecao_danhsach_edit', ['id' => $id]))->name('loaima_edit');

    Route::get('/nhacungcap', fn() => view('admin.mathecao.nhacungcap.mathecao_nhacungcap'))->name('nhacungcap');
    Route::get('/nhacungcap/add', fn() => view('admin.mathecao.nhacungcap.mathecao_nhacungcap_add'))->name('nhacungcap_add');
    Route::get('/nhacungcap/edit', fn() => view('admin.mathecao.nhacungcap.mathecao_nhacungcap_edit'))->name('nhacungcap_edit');
    // Route::get('/nhacungcap/edit/{id}', fn($id) => view('admin.mathecao.nhacungcap.mathecao_edit', ['id' => $id]))->name('nhacungcap_edit');
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
     



    

// Route::put('/naptien/{id}', [ThanhvienController::class, 'naptien'])->name('thanhvien.naptien');
    

});