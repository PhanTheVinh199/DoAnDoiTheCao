<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

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

    Route::get('/nhacungcap', fn() => view('admin.mathecao.nhacungcap.mathecao_nhacungcap'))->name('nhacungcap');
    Route::get('/nhacungcap/add', fn() => view('admin.mathecao.nhacungcap.mathecao_nhacungcap_add'))->name('nhacungcap_add');
    Route::get('/nhacungcap/edit', fn() => view('admin.mathecao.nhacungcap.mathecao_nhacungcap_edit'))->name('nhacungcap_edit');
    // Route::get('/nhacungcap/edit/{id}', fn($id) => view('admin.mathecao.nhacungcap.mathecao_edit', ['id' => $id]))->name('nhacungcap_edit');
});