<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MTC_NhaCungCapController;
use App\Http\Controllers\Admin\MTC_SanPhamController;
use App\Http\Controllers\Admin\MTC_DonHangController;
use App\Http\Controllers\admin\NganhangController;

use App\Http\Controllers\admin\ThanhvienController;
use App\Http\Controllers\admin\DoithecaoNhacungcapController;
use App\Http\Controllers\admin\DoithecaoDanhsachController;
use App\Http\Controllers\admin\DoithecaoDonhangController;


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

// web.php(đổi thẻ cào nhà cung cấp)
Route::prefix('doithecao/nhacungcap')->name('doithecao.nhacungcap.')->group(function () {

    // Hiển thị danh sách nhà cung cấp
    Route::get('/', [DoithecaoNhacungcapController::class, 'index'])->name('index');

    // Hiển thị form thêm mới nhà cung cấp
    Route::get('/add', [DoithecaoNhacungcapController::class, 'create'])->name('add');

    // Xử lý dữ liệu gửi từ form thêm mới và lưu vào CSDL
    Route::post('/them', [DoithecaoNhacungcapController::class, 'store'])->name('them');

    // Hiển thị form chỉnh sửa nhà cung cấp theo ID
    Route::get('/edit/{id}', [DoithecaoNhacungcapController::class, 'edit'])->name('edit');

    // Cập nhật thông tin nhà cung cấp đã chỉnh sửa
    Route::put('/update/{nhacungcap}', [DoithecaoNhacungcapController::class, 'update'])->name('update');

    // Xoá nhà cung cấp khỏi hệ thống
    Route::delete('/delete/{nhacungcap}', [DoithecaoNhacungcapController::class, 'destroy'])->name('delete');

    // Ẩn nhà cung cấp (thay đổi trạng thái hoạt động)
    Route::post('/hide/{id}', [DoithecaoNhacungcapController::class, 'hide'])->name('hide');

    // Hiện nhà cung cấp (kích hoạt lại)
    Route::post('/show/{id}', [DoithecaoNhacungcapController::class, 'show'])->name('show');

});


//web.php(đổi thẻ cào Danh Sách)
Route::prefix('doithecao/danhsach')->name('doithecao.danhsach.')->group(function () {
    Route::get('/', [DoithecaoDanhsachController::class, 'index'])->name('index');
    Route::get('/create', [DoithecaoDanhsachController::class, 'create'])->name('create');
    Route::post('/them', [DoithecaoDanhsachController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [DoithecaoDanhsachController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [DoithecaoDanhsachController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [DoithecaoDanhsachController::class, 'destroy'])->name('destroy');
});


Route::prefix('doithecao/donhang')->name('doithecao.donhang.')->group(function () {
    Route::get('/', [DoithecaoDonhangController::class, 'index'])->name('index');
    // Xóa route tạo mới đơn hàng (create)
    // Route::get('/create', [DoithecaoDonhangController::class, 'create'])->name('create');
    Route::post('/them', [DoithecaoDonhangController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [DoithecaoDonhangController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [DoithecaoDonhangController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [DoithecaoDonhangController::class, 'destroy'])->name('destroy');
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
