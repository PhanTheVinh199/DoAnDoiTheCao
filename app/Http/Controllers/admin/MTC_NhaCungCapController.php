<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaThe_NhaCungCap;

class MTC_NhaCungCapController extends Controller
{
    public function index()
    {
        $dsNhaCungCap = MaThe_NhaCungCap::orderBy('ngay_tao', 'desc')->paginate(10);
        return view('admin.mathecao.nhacungcap.mathecao_nhacungcap', compact('dsNhaCungCap'));
    }

    public function create()
    {
        return view('admin.mathecao.nhacungcap.mathecao_nhacungcap_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'hinhanh' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        MaThe_NhaCungCap::createSupplier($request->all(), $request->file('hinhanh'));

        return redirect()->route('admin.mathecao.nhacungcap.index')->with('success', 'Thêm thành công!');
    }

    public function edit($id)
    {
        $ncc = MaThe_NhaCungCap::findOrFail($id);
        return view('admin.mathecao.nhacungcap.mathecao_nhacungcap_edit', compact('ncc'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trang_thai' => 'required|in:hoat_dong,an'
        ]);

        MaThe_NhaCungCap::updateSupplier($id, $request->all(), $request->file('hinhanh'));

        return redirect()->route('admin.mathecao.nhacungcap.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        MaThe_NhaCungCap::deleteSupplier($id);
        return redirect()->route('admin.mathecao.nhacungcap.index')->with('success', 'Xóa thành công!');
    }
}
