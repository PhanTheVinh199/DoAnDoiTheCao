<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoDonhang;
use App\Models\DoithecaoDanhsach;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $order = DoithecaoDonhang::lockForUpdate()->find($id);

            if (!$order) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Đơn hàng này đã bị xóa bởi người dùng khác.');
            }

            $order->delete();
            DB::commit();

            return redirect()->back()
                ->with('success', 'Xóa đơn hàng thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa đơn hàng.');
        }
    }

    public function checkExists($id)
    {
        $exists = DoithecaoDonhang::where('id_dondoithe', $id)->exists();
        return response()->json(['exists' => $exists]);
    }
}
