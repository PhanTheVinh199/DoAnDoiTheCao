<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// 🟢 import các model cần đếm
use App\Models\ThanhVien;
use App\Models\DoithecaoDonhang;
use App\Models\MaThe_DonHang;
use App\Models\NapTien;
use App\Models\RutTien;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Kiểm tra đăng nhập & quyền admin
        $user = Auth::guard('thanhvien')->user();
        if (!$user || $user->quyen !== 'admin') {
            return redirect()->route('login')
                ->with('error', 'Bạn không có quyền truy cập.');
        }

        // 2. Lấy dữ liệu thống kê
        $memberCount    = ThanhVien::count();
        $exchangeCount  = DoithecaoDonhang::count();
        $purchaseCount  = MaThe_DonHang::count();
        $exchangePending = DoithecaoDonhang::where('trang_thai', 'cho_xu_ly')->count();
        $purchasePending = MaThe_DonHang::where('trang_thai', 'cho_xu_ly')->count();
        $depositCount   = NapTien::count();
        $withdrawCount  = RutTien::count();
        $depositCountPending = NapTien::where('trang_thai', 'cho_duyet')->count();
        $withdrawPending = RutTien::where('trang_thai', 'cho_duyet')->count();
        $orders1 = MaThe_DonHang::with('sanpham')
            ->where('trang_thai', 'hoat_dong')
            ->get();
        $orders2 = DoithecaoDonhang::with('doithecao')
            ->where('trang_thai', 'hoat_dong')
            ->get();

        $revenueTotal1 = $orders1->sum(function ($orders1) {
            return $orders1->so_luong * ($orders1->sanpham->menh_gia ?? 0) - $orders1->thanh_tien;
        });
        $revenueTotal2 = $orders2->sum(function ($orders2) {
            return $orders2->so_luong * ($orders2->doithecao->menh_gia ?? 0) - $orders2->thanh_tien;
        });
        $revenueTotal = $revenueTotal1 + $revenueTotal2;
        // 3. Trả dữ liệu cho view
        return view('admin.index', compact(
            'memberCount',
            'exchangeCount',
            'purchaseCount',
            'exchangePending',
            'purchasePending',
            'depositCount',
            'withdrawCount',
            'depositCountPending',
            'withdrawPending',
            'revenueTotal'

        ));
    }
}
