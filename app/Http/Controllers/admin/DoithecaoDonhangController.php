<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoDonhang;
use App\Models\DoithecaoDanhsach;

class DoithecaoDonhangController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('ma_don', '');
        $donhang = DoithecaoDonhang::getDonHangWithFilter($searchTerm, 5);

        return view('admin.doithecao.donhang.doithecao_donhang', compact('donhang', 'searchTerm'));
    }

    public function edit($id_dondoithe)
    {
        $donhang = DoithecaoDonhang::findOrFail($id_dondoithe);
        $sanphams = DoithecaoDanhsach::all();

        return view('admin.doithecao.donhang.doithecao_donhang_edit', compact('donhang', 'sanphams'));
    }

    public function update(Request $request, $id_dondoithe)
    {
        $request->validate([
            'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly',
        ]);

        DoithecaoDonhang::updateStatus($id_dondoithe, $request->trang_thai);

        return redirect()->route('admin.doithecao.donhang.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }

    public function destroy($id)
    {
        $donhang = DoithecaoDonhang::findOrFail($id);
        $donhang->delete();

        return redirect()->route('admin.doithecao.donhang.index')->with('success', 'Xóa đơn hàng thành công');
    }
}
