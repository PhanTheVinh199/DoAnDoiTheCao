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
        $danhsach = DoithecaoDanhsach::with('nhacungcap')->get();
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
        $validated = $request->validate([
            'nhacungcap_id' => 'required|exists:doithecao_nhacungcap,id_nhacungcap',
            'menh_gia' => 'required|numeric|min:0',
            'chiet_khau' => 'required|numeric|min:0|max:100',
            'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly',
        ]);

        DoithecaoDanhsach::createProduct($validated);

        return redirect()->route('admin.doithecao.danhsach.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $sanpham = DoithecaoDanhsach::find($id);
        if (!$sanpham) {
            return redirect()->route('admin.doithecao.danhsach.index')
                ->with('error', 'Sản phẩm không tồn tại hoặc đã bị xóa.');
        }
        $nhacungcaps = DoithecaoDanhsach::getAllSuppliers();

        return view('admin.doithecao.danhsach.doithecao_danhsach_edit', compact('sanpham', 'nhacungcaps'));
    }

    public function update(Request $request, $id)
    {
        $product = DoithecaoDanhsach::find($id);
        if (!$product) {
            return redirect()->route('admin.doithecao.danhsach.index')
                ->with('error', 'Sản phẩm không tồn tại hoặc đã bị xóa.');
        }

        $validated = $request->validate([
            'nhacungcap_id' => 'required|exists:doithecao_nhacungcap,id_nhacungcap',
            'menh_gia' => 'required|numeric|min:0',
            'chiet_khau' => 'required|numeric|min:0|max:100',
            'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly',
            'updated_at' => 'required',
        ]);

        // concurrency check
        $currentUpdatedAt = $product->updated_at ? $product->updated_at->toDateTimeString() : null;
        if ($validated['updated_at'] !== $currentUpdatedAt) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['concurrency' => 'Sản phẩm đã được cập nhật từ tab khác. Vui lòng tải lại trang trước khi sửa.']);
        }

        // Loại bỏ updated_at khỏi dữ liệu update
        $dataToUpdate = $validated;
        unset($dataToUpdate['updated_at']);

        DoithecaoDanhsach::updateProduct($id, $dataToUpdate);

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
                return redirect()->route('admin.doithecao.danhsach.index')
                    ->with('error', 'Sản phẩm này đã bị xóa bởi người dùng khác.');
            }

            $product->delete();
            DB::commit();

            return redirect()->route('admin.doithecao.danhsach.index')->with('success', 'Xóa sản phẩm thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi xóa sản phẩm ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa sản phẩm.');
        }
    }
}
