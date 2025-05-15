<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NganHang;
use App\Models\ThanhVien;
use Illuminate\Http\Request;

class NganhangAdminController extends Controller
{
    // Hiển thị danh sách ngân hàng admin
    public function index()
    {
        $banks = NganHang::whereHas('thanhvien', function($q) {
            $q->where('role', 'admin');
        })->with('thanhvien')->latest()->paginate(10);  // paginate tốt hơn get()

        return view('admin.nganhang.NganHangAdmin.nganhangAdmin', compact('banks'));
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
}
