<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoDonhang;
use App\Models\DoithecaoDanhsach;

class DoithecaoDonhangController extends Controller
{
    public function index()
    {
        $donhang = DoithecaoDonhang::all();
        return view('admin.doithecao.donhang.doithecao_donhang', compact('donhang'));
    }

    // Xóa public function create()
    // public function create()
    // {
    //     return view('admin.doithecao.donhang.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'ma_don' => 'required|string|max:50|unique:doithecao_donhang',
    //         'ma_the' => 'required|string|max:100',
    //         'serial' => 'required|string|max:100',
    //         'doithecao_id' => 'required|exists:doithecao_danhsach,id_doithecao',
    //         'so_luong' => 'required|integer|min:1',
    //         'thanh_tien' => 'required|integer|min:0',
    //         'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly',
    //     ]);

    //     DoithecaoDonhang::create($request->all());

    //     return redirect()->route('admin.doithecao.donhang.index')->with('success', 'Thêm đơn hàng thành công');
    // }

    public function edit($id)
    {
        $donhang = DoithecaoDonhang::findOrFail($id);
        $sanphams = DoithecaoDanhsach::all(); // Lấy danh sách sản phẩm để chọn
        return view('admin.doithecao.donhang.doithecao_donhang_edit', compact('donhang'));
    }

    public function update(Request $request, $id)
    {
        $donhang = DoithecaoDonhang::findOrFail($id);

        $request->validate([
            'ma_don' => 'required|string|max:50|unique:doithecao_donhang,ma_don,' . $id,
            'ma_the' => 'required|string|max:100',
            'serial' => 'required|string|max:100',
            'doithecao_id' => 'required|exists:doithecao_danhsach,id_doithecao',
            'so_luong' => 'required|integer|min:1',
            'thanh_tien' => 'required|integer|min:0',
            'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly',
        ]);

        $donhang->update($request->all());

        return redirect()->route('admin.doithecao.donhang.index')->with('success', 'Cập nhật đơn hàng thành công');
    }

    public function destroy($id)
    {
        $donhang = DoithecaoDonhang::findOrFail($id);
        $donhang->delete();

        return redirect()->route('admin.doithecao.donhang.index')->with('success', 'Xóa đơn hàng thành công');
    }
}
