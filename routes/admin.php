<?php

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

Route::prefix('doithecao')->name('doithecao.')->group(function (){
    Route::get('/donhang' , fn() => view('admin.doithecao.donhang.doithecao_donhang'))->name('donhang');
    Route::get('/donhang/edit' , fn() => view('admin.doithecao.donhang.doithecao_donhang_edit'))->name('donhang_edit');

    Route::get('/danhsach',fn() => view('admin.doithecao.danhsach.doithecao_danhsach'))->name('danhsach');
    Route::get('/danhsach/edit',fn() => view('admin.doithecao.danhsach.doithecao_danhsach_edit'))->name('danhsach_edit');
    Route::get('/danhsach/add',fn() => view('admin.doithecao.danhsach.doithecao_danhsach_add'))->name('danhsach_add');

    Route::get('/nhacungcap',fn() => view('admin.doithecao.nhacungcap.doithecao_nhacungcap_add'))->name('nhacungcap');
    Route::get('/nhacungcap/add',fn() => view('admin.doithecao.nhacungcap.doithecao_nhacungcap_add'))->name('nhacungcap_add');
    Route::get('/nhacungcap/edit',fn() => view('admin.doithecao.nhacungcap.doithecao_nhacungcap_edit'))->name('nhacungcap_edit');

});