<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoNhacungcap;
use Illuminate\Support\Facades\DB;

class DoithecaoNhacungcapController extends Controller
{
    public function index()
    {
        $nhacungcaps = DoithecaoNhacungcap::paginate(10);
        return view('admin.doithecao.nhacungcap.doithecao_nhacungcap', compact('nhacungcaps'));
    }

    public function create()
    {
        return view('admin.doithecao.nhacungcap.doithecao_nhacungcap_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        DoithecaoNhacungcap::createSupplier($request->all(), $request->file('hinh_anh'));

        return redirect()->route('admin.doithecao.nhacungcap.index')->with('success', 'Thêm nhà cung cấp thành công!');
    }

    public function edit($id)
    {
        $nhacungcap = DoithecaoNhacungcap::find($id);
        if (!$nhacungcap) {
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'Nhà cung cấp không tồn tại hoặc đã bị xóa.');
        }
        return view('admin.doithecao.nhacungcap.doithecao_nhacungcap_edit', compact('nhacungcap'));
    }

    public function update(Request $request, $id)
    {
        $nhacungcap = DoithecaoNhacungcap::find($id);
        if (!$nhacungcap) {
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'Nhà cung cấp không tồn tại hoặc đã bị xóa.');
        }

        $request->validate([
            'ten' => 'required|string|max:255',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        DoithecaoNhacungcap::updateSupplier($id, $request->all(), $request->file('hinh_anh'));

        return redirect()->route('admin.doithecao.nhacungcap.index')->with('success', 'Cập nhật nhà cung cấp thành công!');
    }

   public function destroy($id)
{
    DB::beginTransaction();

    try {
        $nhacungcap = DoithecaoNhacungcap::lockForUpdate()->find($id);

        if (!$nhacungcap) {
            DB::rollBack();
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'Nhà cung cấp đã bị xóa hoặc không tồn tại.');
        }

        if ($nhacungcap->danhsach()->exists()) {
            DB::rollBack();
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'Không thể xóa nhà cung cấp do có sản phẩm liên quan.');
        }

        if ($nhacungcap->hinh_anh && file_exists(public_path($nhacungcap->hinh_anh))) {
            unlink(public_path($nhacungcap->hinh_anh));
        }

        $nhacungcap->delete();

        DB::commit();

        return redirect()->route('admin.doithecao.nhacungcap.index')->with('success', 'Xóa nhà cung cấp thành công!');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Lỗi xóa nhà cung cấp ID ' . $id . ': ' . $e->getMessage());

        return redirect()->route('admin.doithecao.nhacungcap.index')->with('error', 'Có lỗi xảy ra khi xóa nhà cung cấp.');
    }
}


    // Ẩn nhà cung cấp
    public function hide($id)
    {
        $nhacungcap = DoithecaoNhacungcap::find($id);
        if (!$nhacungcap) {
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'Nhà cung cấp không tồn tại hoặc đã bị xóa.');
        }
        $nhacungcap->trang_thai = 'an';
        $nhacungcap->save();

        return redirect()->back()->with('success', 'Đã ẩn nhà cung cấp!');
    }

    // Hiện nhà cung cấp
    public function show($id)
    {
        $nhacungcap = DoithecaoNhacungcap::find($id);
        if (!$nhacungcap) {
            return redirect()->route('admin.doithecao.nhacungcap.index')
                ->with('error', 'Nhà cung cấp không tồn tại hoặc đã bị xóa.');
        }
        $nhacungcap->trang_thai = 'hoat_dong';
        $nhacungcap->save();

        return redirect()->back()->with('success', 'Đã hiện nhà cung cấp!');
    }
}
