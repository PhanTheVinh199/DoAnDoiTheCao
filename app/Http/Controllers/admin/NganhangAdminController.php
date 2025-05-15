<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NganHang;
use App\Models\ThanhVien;
use Illuminate\Http\Request;

class NganhangAdminController extends Controller
{
    // Hiển thị danh sách ngân hàng admin
    public function index(Request $request)
    {
       $search = $request->input('search');

    $query = NganHang::where('loai_ngan_hang', 'admin')  // Chỉ lấy ngân hàng admin
        ->whereHas('thanhvien', function($q) use ($search) {
            $q->where('role', 'admin');
            if ($search) {
                $q->where('tai_khoan', 'like', '%' . $search . '%');
            }
        })
        ->with('thanhvien')
        ->latest();

    $dsNganHang = $query->paginate(10);

    return view('admin.nganhang.NganHangAdmin.nganhangAdmin', compact('dsNganHang'));
    }

    // Hiển thị form tạo mới
    public function create()
    {
        $admins = ThanhVien::where('role', 'admin')->get();
        return view('admin.nganhang.caidat_nganhang.caidat_nganhang', compact('admins'));
    }

    // Lưu ngân hàng mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_thanhvien' => 'required|exists:thanhvien,tai_khoan',
            'ten_ngan_hang' => 'required',
            'so_tai_khoan' => 'required|unique:nganhang,so_tai_khoan',
            'chu_tai_khoan' => 'required',
            'trang_thai' => 'required|in:hoat_dong,khong_hoat_dong'
        ]);

        $thanhvien = ThanhVien::where('tai_khoan', $validated['ten_thanhvien'])
                              ->where('role', 'admin')
                              ->first();

        if (!$thanhvien) {
            return back()->with('error', 'Chỉ tài khoản Admin mới được thêm.');
        }

        NganHang::create([
            'thanhvien_id' => $thanhvien->id_thanhvien,
            'ten_ngan_hang' => $validated['ten_ngan_hang'],
            'so_tai_khoan' => $validated['so_tai_khoan'],
            'chu_tai_khoan' => $validated['chu_tai_khoan'],
            'trang_thai' => $validated['trang_thai'],
            'loai_ngan_hang' => 'admin',
        ]);

        return redirect()
            ->route('admin.nganhang.admin.index')
            ->with('success', 'Thêm ngân hàng admin thành công!');
    }
    public function destroy($id)
{
    $bank = NganHang::findOrFail($id);
    // Optional: chỉ cho phép xóa nếu liên kết admin
    if ($bank->thanhvien->role !== 'admin') {
        return back()->with('error', 'Chỉ được xóa ngân hàng admin.');
    }
    $bank->delete();

    return redirect()->route('admin.nganhang.admin.index')->with('success', 'Xóa ngân hàng admin thành công!');
}

}
