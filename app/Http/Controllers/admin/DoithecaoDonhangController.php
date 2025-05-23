<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoDonhang;
use App\Models\DoithecaoDanhsach;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class DoithecaoDonhangController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng, có hỗ trợ tìm kiếm
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('ma_don', '');
        $donhang = DoithecaoDonhang::getDonHangWithFilter($searchTerm, 5);

        return view('admin.doithecao.donhang.doithecao_donhang', compact('donhang', 'searchTerm'));
    }

    /**
     * Hiển thị form sửa đơn hàng
     */
    public function edit($id_dondoithe)
    {
        $donhang = DoithecaoDonhang::findOrFail($id_dondoithe);
        $sanphams = DoithecaoDanhsach::all();

        return view('admin.doithecao.donhang.doithecao_donhang_edit', compact('donhang', 'sanphams'));
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
public function update(Request $request, $id_dondoithe)
{
    $request->validate([
        'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly',
        'updated_at' => 'required',
    ]);

    try {
        $donhang = DoithecaoDonhang::findOrFail($id_dondoithe);

        // So sánh updated_at từ form với DB
        $formUpdatedAt = \Carbon\Carbon::parse($request->input('updated_at'));
        $dbUpdatedAt = $donhang->updated_at;

        if (!$dbUpdatedAt->equalTo($formUpdatedAt)) {
            return redirect()->route('admin.doithecao.donhang.index')
                ->with('error', 'Đơn hàng đã bị thay đổi bởi người khác. Vui lòng tải lại trang và thử lại.');
        }

        // Cập nhật trạng thái đơn hàng
        if ($donhang->trang_thai !== $request->trang_thai) {
            \DB::transaction(function () use ($donhang, $request) {
                if ($request->trang_thai === 'hoat_dong' && $donhang->trang_thai !== 'hoat_dong') {
                    $thanhvien = $donhang->thanhvien;
                    if ($thanhvien) {
                        $thanhvien->so_du += $donhang->thanh_tien;
                        $thanhvien->save();
                    }
                }
                $donhang->trang_thai = $request->trang_thai;
                $donhang->save();
            });
        }

        return redirect()->route('admin.doithecao.donhang.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->route('admin.doithecao.donhang.index')->with('error', 'Đơn hàng không tồn tại hoặc đã bị xóa.');
    } catch (\Exception $e) {
        return redirect()->route('admin.doithecao.donhang.index')->with('error', 'Lỗi khi cập nhật: ' . $e->getMessage());
    }
}



    /**
     * Xóa đơn hàng
     */
    public function destroy($id)
    {
        try {
            $donhang = DoithecaoDonhang::findOrFail($id);
            $donhang->delete();

            return redirect()->route('admin.doithecao.donhang.index')->with('success', 'Xóa đơn hàng thành công');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.doithecao.donhang.index')->with('error', 'Đơn hàng không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            return redirect()->route('admin.doithecao.donhang.index')->with('error', 'Lỗi khi xóa đơn hàng: ' . $e->getMessage());
        }
    }
}
