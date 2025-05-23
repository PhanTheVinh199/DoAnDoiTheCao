<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoDanhsach;
use Illuminate\Support\Facades\DB;

class DoithecaoDanhsachController extends Controller
{
    public function index()
    {
        $danhsach = DoithecaoDanhsach::getAllWithSupplier();
        $nhacungcap = DoithecaoDanhsach::getAllSuppliers();
        $newestSupplier = DoithecaoDanhsach::getNewestSupplier();

        return view('admin.doithecao.danhsach.doithecao_danhsach', compact('danhsach', 'nhacungcap', 'newestSupplier'));
    }

    public function create()
    {
        $nhacungcaps = DoithecaoDanhsach::getAllSuppliers();
        return view('admin.doithecao.danhsach.doithecao_danhsach_add', compact('nhacungcaps'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nhacungcap_id' => 'required',
            'menh_gia' => 'required|numeric',
            'chiet_khau' => 'required|numeric',
            'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly',
        ]);

        DoithecaoDanhsach::createProduct($request->all());

        return redirect()->route('admin.doithecao.danhsach.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $sanpham = DoithecaoDanhsach::findOrFail($id);
        $nhacungcaps = DoithecaoDanhsach::getAllSuppliers();

        return view('admin.doithecao.danhsach.doithecao_danhsach_edit', compact('sanpham', 'nhacungcaps'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nhacungcap_id' => 'required',
            'menh_gia' => 'required|numeric',
            'chiet_khau' => 'required|numeric',
            'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly',
        ]);

        DoithecaoDanhsach::updateProduct($id, $request->all());

        return redirect()->route('admin.doithecao.danhsach.index')->with('success', 'Cập nhật thành công!');
    }

    public function checkExists($id)
    {
        $exists = DoithecaoDanhsach::where('id_doithecao', $id)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = DoithecaoDanhsach::lockForUpdate()->find($id);

            if (!$product) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Sản phẩm này đã bị xóa bởi người dùng khác.');
            }

            $product->delete();
            DB::commit();

            return redirect()->back()
                ->with('success', 'Xóa sản phẩm thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa sản phẩm.');
        }
    }
}
