<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MTC_NhaCungCapController;

Route::get('/index', function () {
    return view('admin.main');
})->name('index');


Route::prefix('mathecao')->name('mathecao.')->group(function () {
    Route::get('/donhang', fn() => view('admin.mathecao.donhang.mathecao_donhang'))->name('donhang');
    // Route::get('/donhang/edit/{id}', fn($id) => view('admin.mathecao.donhang.mathecao_donhang_edit', ['id' => $id]))->name('donhang_edit');
    Route::get('/donhang/edit', fn() => view('admin.mathecao.donhang.mathecao_donhang_edit'))->name('donhang_edit');

    Route::get('/loaima', fn() => view('admin.mathecao.loaima.mathecao_danhsach'))->name('loaima');
    Route::get('/loaima/add', fn() => view('admin.mathecao.loaima.mathecao_danhsach_add'))->name('loaima_add');
    Route::get('/loaima/edit', fn() => view('admin.mathecao.loaima.mathecao_danhsach_edit'))->name('loaima_edit');
    // Route::get('/loaima/edit/{id}', fn($id) => view('admin.mathecao.loaima.mathecao_danhsach_edit', ['id' => $id]))->name('loaima_edit');

    Route::get('/nhacungcap', [MTC_NhaCungCapController::class, 'index'])->name('nhacungcap.index');
    Route::get('/nhacungcap/create', [MTC_NhaCungCapController::class, 'create'])->name('nhacungcap.create');
    Route::post('/nhacungcap/store', [MTC_NhaCungCapController::class, 'store'])->name('nhacungcap.store');
    Route::get('/nhacungcap/{id}/edit', [MTC_NhaCungCapController::class, 'edit'])->name('nhacungcap.edit');
    Route::put('/nhacungcap/{id}', [MTC_NhaCungCapController::class, 'update'])->name('nhacungcap.update');
    Route::resource('/nhacungcap', MTC_NhaCungCapController::class);
    // Route::get('/nhacungcap/edit/{id}', fn($id) => view('admin.mathecao.nhacungcap.mathecao_edit', ['id' => $id]))->name('nhacungcap_edit');
});
