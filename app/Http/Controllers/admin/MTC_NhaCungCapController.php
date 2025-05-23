<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaThe_NhaCungCap;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            'ten'      => 'required|string|max:255',
            'hinhanh'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        MaThe_NhaCungCap::createSupplier(
            $request->only('ten'),
            $request->file('hinhanh')
        );

        return redirect()
            ->route('admin.mathecao.nhacungcap.index')
            ->with('success', 'Thêm thành công!');
    }

    public function edit($id)
    {
        try {
            $ncc = MaThe_NhaCungCap::findOrFail($id);
            return view('admin.mathecao.nhacungcap.mathecao_nhacungcap_edit', compact('ncc'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.mathecao.nhacungcap.index')
                ->with('error', 'Dữ liệu không tồn tại!.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $ncc = MaThe_NhaCungCap::findOrFail($id);

            $request->validate([
                'ten'        => 'required|string|max:255',
                'hinhanh'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'trang_thai' => 'required|in:hoat_dong,an',
                'ngay_cap_nhat' => 'required|string',
            ]);

            if ($request->input('ngay_cap_nhat') !== $ncc->ngay_cap_nhat->format('Y-m-d H:i:s')) {
                return redirect()->route('admin.mathecao.nhacungcap.index')
                    ->with('concurrency_error', 'Dữ liệu đã bị thay đổi trước đó, trang sẽ tự động cập nhật dữ liệu mới nhất.');
            }

            MaThe_NhaCungCap::updateSupplier(
                $id,
                $request->only('ten', 'trang_thai'),
                $request->file('hinhanh')
            );

            return redirect()->route('admin.mathecao.nhacungcap.index')
                ->with('success', 'Cập nhật thành công!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.mathecao.nhacungcap.index')
                ->with('error', 'Dữ liệu không tồn tại!.');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            MaThe_NhaCungCap::deleteSupplier($id);

            if ($request->ajax()) {
                return response()->json(['success' => 'Xóa thành công!'], 200);
            }

            return redirect()
                ->route('admin.mathecao.nhacungcap.index')
                ->with('success', 'Xóa thành công!');
        } catch (ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Dữ liệu không tồn tại!'], 404);
            }

            return redirect()
                ->route('admin.mathecao.nhacungcap.index')
                ->with('error', 'Dữ liệu không tồn tại!');
        }
    }
}
