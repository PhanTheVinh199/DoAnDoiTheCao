<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NganhangAdmin;
use App\Models\ThanhVien;
use Illuminate\Http\Request;

class NganhangAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = NganhangAdmin::with('thanhvien');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ten_ngan_hang', 'like', "%{$search}%")
                  ->orWhere('so_tai_khoan', 'like', "%{$search}%")
                  ->orWhere('chu_tai_khoan', 'like', "%{$search}%");
            });
        }

        $banks = $query->latest()->paginate(10);
         dd($banks);
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

        NganhangAdmin::create($validated);

        return redirect()->route('admin.nganhang.admin.index')->with('success', 'Thêm ngân hàng admin thành công');
    }

    public function destroy($id)
    {
        $bank = NganhangAdmin::findOrFail($id);
        $bank->delete();

        return redirect()->route('admin.nganhang.admin.index')->with('success', 'Xóa ngân hàng admin thành công');
    }
}
