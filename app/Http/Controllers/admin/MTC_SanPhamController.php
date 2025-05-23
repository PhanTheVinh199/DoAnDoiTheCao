<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaThe_SanPham;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        try {
            $dsSanPham = MaThe_SanPham::findOrFail($id);
            $dsNhaCungCap = MaThe_SanPham::getAllSuppliers();

            return view('admin.mathecao.loaima.mathecao_danhsach_edit', compact('dsSanPham', 'dsNhaCungCap'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.mathecao.loaima.index')
                ->with('error', 'Dữ liệu không tồn tại!.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'menh_gia' => 'required|numeric|min:1000',
                'chiet_khau' => 'required|numeric|min:0|max:100',
                'trang_thai' => 'required|in:hoat_dong,an',
                'ngay_cap_nhat' => 'required|string',
            ]);

            $dsSanPham = MaThe_SanPham::findOrFail($id);

            // So sánh ngay_cap_nhat để phát hiện dữ liệu bị thay đổi đồng thời
            if ($request->input('ngay_cap_nhat') !== $dsSanPham->ngay_cap_nhat->format('Y-m-d H:i:s')) {
                return redirect()
                    ->route('admin.mathecao.loaima.index')
                    ->with('concurrency_error', 'Dữ liệu đã bị thay đổi trước đó, trang sẽ tự động cập nhật dữ liệu mới nhất.');
            }

            MaThe_SanPham::updateProduct(
                $id,
                $request->only('menh_gia', 'chiet_khau', 'trang_thai'),
            );

            return redirect()
                ->route('admin.mathecao.loaima.index')
                ->with('success', 'Cập nhật thành công!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.mathecao.loaima.index')
                ->with('error', 'Dữ liệu không tồn tại!.');
        }
    }


    public function destroy(Request $request, $id)
    {
        try {
            // Gọi đúng hàm deleteProduct trên model MaThe_SanPham
            MaThe_SanPham::deleteProduct($id);

            if ($request->ajax()) {
                return response()->json(['success' => 'Xóa thành công!'], 200);
            }

            return redirect()
                ->route('admin.mathecao.loaima.index')
                ->with('success', 'Xóa thành công!');
        } catch (ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Dữ liệu không tồn tại!'], 404);
            }

            return redirect()
                ->route('admin.mathecao.loaima.index')
                ->with('error', 'Dữ liệu không tồn tại!');
        }
    }
}
