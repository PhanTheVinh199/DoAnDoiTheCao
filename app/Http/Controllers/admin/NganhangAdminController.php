<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NganhangAdmin;
use App\Models\ThanhVien;

class NganhangAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $banks = NganhangAdmin::getBanks($search, 5);
        return view('admin.NganHangAdmin.nganhangAdmin', compact('banks'));
    }

    public function create()
    {
        $admins = ThanhVien::where('quyen', 'admin')->get();
        return view('admin.NganHangAdmin.caidat_nganhang.caidat_nganhang', compact('admins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'thanhvien_id' => 'required|exists:thanhvien,id_thanhvien',
            'ten_ngan_hang' => 'required|string|max:255',
            'so_tai_khoan' => 'required|string|max:100|unique:nganhang_admin,so_tai_khoan',
            'chu_tai_khoan' => 'required|string|max:255',
            'trang_thai' => 'required|in:hoat_dong,khong_hoat_dong',
        ]);

        NganhangAdmin::createBank($validated);

        return redirect()->route('admin.nganhang.admin.index')->with('success', 'Thêm ngân hàng admin thành công');
    }

    public function destroy($id)
    {
        NganhangAdmin::deleteBank($id);

        return redirect()->route('admin.nganhang.admin.index')->with('success', 'Xóa ngân hàng admin thành công');
    }
}
