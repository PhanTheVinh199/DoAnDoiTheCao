<?php


use App\Http\Controllers\admin\DoithecaoNhacungcapController;
use App\Http\Controllers\admin\DoithecaoDanhsachController;
use App\Http\Controllers\admin\DoithecaoDonhangController;
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

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

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


