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
         // Lấy thông tin người dùng hiện tại
        $user = Auth::guard('thanhvien')->user();

        // Tạo truy vấn để lọc các đơn hàng của người dùng
        $query = MaThe_DonHang::where('thanhvien_id', $user->id_thanhvien)
            ->with('sanpham.nhacungcap');

        // Lọc theo mã đơn
        if ($request->filled('order_code')) {
            $query->where('ma_don', 'like', '%' . $request->order_code . '%');
        }

        // Lọc theo trạng thái
        if ($request->filled('status') && in_array($request->status, ['Hoạt động', 'Đã huỷ', 'Chờ xử lý'])) {
            $query->where('trang_thai', $request->status);
        }

        // Lọc theo ngày từ
        if ($request->filled('from_date')) {
            $query->where('ngay_tao', '>=', $request->from_date);
        }

        // Lọc theo ngày đến
        if ($request->filled('to_date')) {
            $query->where('ngay_tao', '<=', $request->to_date);
        }

        // Lấy danh sách đơn hàng
        $dsDonHang = $query->orderBy('ngay_tao', 'desc')->paginate(10);

        // Các dữ liệu khác để hiển thị (ví dụ sản phẩm, nhà cung cấp, thành viên)
        $dsSanPham = MaThe_SanPham::all();
        $dsThanhVien = ThanhVien::all();
        $dsNhaCungCap = MaThe_NhaCungCap::all();

        return view('lichsumuathe', compact('dsDonHang', 'dsSanPham', 'dsThanhVien', 'dsNhaCungCap'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       
    }
}
