<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaThe_SanPham;
use App\Models\MaThe_DonHang;
use App\Models\MaThe_NhaCungCap;
use App\Models\ThanhVien;
use Illuminate\Support\Facades\Auth;

class LichSuMuaTheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        $user = Auth::guard('thanhvien')->user();

        if (!$user) {
            return view('card')->with('message', 'Vui lòng đăng nhập để tiếp tục thanh toán.');
        }

        $dsNhaCungCap = MaThe_NhaCungCap::all();

        $query = MaThe_DonHang::where('thanhvien_id', $user->id_thanhvien)
            ->with('sanpham.nhacungcap');

        if ($request->filled('order_code')) {
            $query->where('ma_don', 'like', '%' . $request->order_code . '%');
        }

        if ($request->filled('status') && in_array($request->status, ['hoat_dong', 'da_huy', 'cho_xu_ly'])) {
            $query->where('trang_thai', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->where('ngay_tao', '>=', $request->from_date);
        }

        $dsDonHang = $query->orderBy('ngay_tao', 'desc')->paginate(10);


        // Các dữ liệu khác để hiển thị (ví dụ sản phẩm, nhà cung cấp, thành viên)
        $dsSanPham = MaThe_SanPham::all();
        $dsThanhVien = ThanhVien::all();
        $dsNhaCungCap = MaThe_NhaCungCap::all();

        return view('lichsumuathe', compact('dsDonHang', 'dsSanPham', 'dsThanhVien', 'dsNhaCungCap'));
    
    }
}
