<?php



use App\Http\Controllers\admin\DoithecaoNhacungcapController;
use App\Http\Controllers\admin\DoithecaoDanhsachController;
use App\Http\Controllers\admin\DoithecaoDonhangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

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

// web.php(đổi thẻ cào nhà cung cấp)
Route::prefix('admin/doithecao/nhacungcap')->name('admin.doithecao.nhacungcap.')->group(function () {

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
Route::prefix('admin/doithecao/danhsach')->name('admin.doithecao.danhsach.')->group(function () {
    Route::get('/', [DoithecaoDanhsachController::class, 'index'])->name('index');
    Route::get('/create', [DoithecaoDanhsachController::class, 'create'])->name('create');
    Route::post('/them', [DoithecaoDanhsachController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [DoithecaoDanhsachController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [DoithecaoDanhsachController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [DoithecaoDanhsachController::class, 'destroy'])->name('destroy');
});


Route::prefix('admin/doithecao/donhang')->name('admin.doithecao.donhang.')->group(function () {
    Route::get('/', [DoithecaoDonhangController::class, 'index'])->name('index');
    // Xóa route tạo mới đơn hàng (create)
    // Route::get('/create', [DoithecaoDonhangController::class, 'create'])->name('create');
    Route::post('/them', [DoithecaoDonhangController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [DoithecaoDonhangController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [DoithecaoDonhangController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [DoithecaoDonhangController::class, 'destroy'])->name('destroy');
});

