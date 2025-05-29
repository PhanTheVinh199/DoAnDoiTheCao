<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MaThe_DonHang;
use App\Models\MaThe_SanPham;
use App\Models\MaThe_NhaCungCap;
use App\Models\ThanhVien;

class LichSuMuaTheController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('thanhvien')->user();

        if (!$user) {
            return view('card')->with('message', 'Vui lòng đăng nhập để tiếp tục thanh toán.');
        }

        $filters = [
            'order_code' => $request->input('order_code', ''),
            'status' => $request->input('status', ''),
            'from_date' => $request->input('from_date', ''),
        ];

        $pageInput = $request->input('page', '1');

        if (!ctype_digit($pageInput) || (int)$pageInput < 1) {
            return redirect('/lichsumuathe')->with('error', 'Trang không hợp lệ!');
        }

        $page = (int) $pageInput;
        $perPage = 10;
        $dsDonHang = MaThe_DonHang::getUserOrders($user->id_thanhvien, $filters, $perPage);

        if ($dsDonHang->lastPage() > 0 && $page > $dsDonHang->lastPage()) {
            return redirect('/lichsumuathe')->with('error', 'Trang không tồn tại!');
        }

        $dsSanPham = MaThe_SanPham::all();
        $dsThanhVien = ThanhVien::all();
        $dsNhaCungCap = MaThe_NhaCungCap::all();

        return view('lichsumuathe', compact('dsDonHang', 'dsSanPham', 'dsThanhVien', 'dsNhaCungCap'));
    }
}
