<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaThe_SanPham;

class MTC_SanPhamController extends Controller
{
    public function index(Request $request)
    {
        $supplierId = $request->query('supplier_id', 'all');
        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 1);

        $dsSanPham = MaThe_SanPham::getProducts($supplierId, $perPage, $page);
        $dsNhaCungCap = MaThe_SanPham::getAllSuppliers();

        return view('admin.mathecao.loaima.mathecao_danhsach', compact('dsSanPham', 'dsNhaCungCap', 'supplierId', 'perPage'));
    }

    public function create()
    {
        $dsNhaCungCap = MaThe_SanPham::getAllSuppliers();
        return view('admin.mathecao.loaima.mathecao_danhsach_add', compact('dsNhaCungCap'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nhacungcap_id' => 'required|exists:mathecao_nhacungcap,id_nhacungcap',
            'menh_gia' => 'required|numeric|min:1000',
            'chiet_khau' => 'required|numeric|min:0|max:100',
        ]);

        MaThe_SanPham::createProduct($request->all());

        return redirect()->route('admin.mathecao.loaima.index')->with('success', 'Thêm thẻ cào thành công!');
    }

    public function edit($id)
    {
        $dsSanPham = MaThe_SanPham::findOrFail($id);
        $dsNhaCungCap = MaThe_SanPham::getAllSuppliers();

        return view('admin.mathecao.loaima.mathecao_danhsach_edit', compact('dsSanPham', 'dsNhaCungCap'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'menh_gia' => 'required|numeric|min:1000',
            'chiet_khau' => 'required|numeric|min:0|max:100',
            'trang_thai' => 'required|in:hoat_dong,an',
        ]);

        MaThe_SanPham::updateProduct($id, $request->all());

        return redirect()->route('admin.mathecao.loaima.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        MaThe_SanPham::deleteProduct($id);

        return redirect()->route('admin.mathecao.loaima.index')->with('success', 'Xóa thành công!');
    }
}
