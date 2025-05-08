<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaThe_SanPham;
use App\Models\MaThe_DonHang;
use App\Models\MaThe_NhaCungCap;
use App\Models\ThanhVien;

class MTC_DonHangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        $query = MaThe_DonHang::with('sanpham.nhacungcap');

        if ($request->filled('ma_don')) {
            $query->where('ma_don', 'like', '%' . $request->ma_don . '%');
        }
    
        $dsDonHang = $query->orderBy('ngay_tao', 'desc')->paginate(10);
        $dsSanPham = MaThe_SanPham::all();
        $dsThanhVien = ThanhVien::all();
        $dsNhaCungCap = MaThe_NhaCungCap::all();
        

        return view('admin.mathecao.donhang.mathecao_donhang', compact('dsDonHang', 'dsSanPham', 'dsThanhVien', 'dsNhaCungCap'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tạo đơn hàng mới, không cần gì thêm ở đây
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ma_don' => 'required|unique:mathecao_donhang',
            'mathecao_id' => 'required|exists:mathecao_danhsach,id_mathecao',
            'so_luong' => 'required|numeric|min:1',
            'thanhvien_id' => 'required|exists:thanhvien,id_thanhvien',
            'trang_thai' => 'required|in:Hoạt động,Đã huỷ,Chờ xử lý',
        ]);

        // Lấy mệnh giá của sản phẩm
        $sanPham = MaThe_SanPham::findOrFail($request->mathecao_id);
        $thanhTien = $request->so_luong * $sanPham->menh_gia;

        // Tạo đơn hàng
        MaThe_DonHang::create([
            'ma_don' => $request->ma_don,
            'mathecao_id' => $request->mathecao_id,
            'so_luong' => $request->so_luong,
            'thanh_tien' => $thanhTien,
            'thanhvien_id' => $request->thanhvien_id,
            'trang_thai' => $request->trang_thai,
        ]);

        return redirect()->route('admin.mathecao.donhang.index')->with('success', 'Đơn hàng đã được tạo!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Không cần thiết nếu chỉ hiển thị chi tiết đơn hàng
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $donHang = MaThe_DonHang::findOrFail($id);
        $dsSanPham = MaThe_SanPham::all();
        $dsThanhVien = ThanhVien::all(); // 
        $dsNhaCungCap = MaThe_NhaCungCap::all();



        // Lấy tên nhà cung cấp từ quan hệ của donHang
        $nhaCungCap = $donHang->sanpham->nhacungcap->ten ?? '';
        return view('admin.mathecao.donhang.mathecao_donhang_edit', compact('donHang', 'dsSanPham', 'dsThanhVien', 'dsNhaCungCap', 'nhaCungCap'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'trang_thai' => 'required|in:Hoạt động,Chờ xử lý,Đã huỷ', // Chắc chắn rằng 'trang_thai' là một trường hợp hợp lệ
        ]);

        // Tìm đơn hàng theo ID
        $donHang = MaThe_DonHang::findOrFail($id);

        // Cập nhật đơn hàng
        $donHang->update([
            'trang_thai' => $request->trang_thai, // Cập nhật trạng thái
        ]);

        // Quay lại trang danh sách với thông báo thành công
        return redirect()->route('admin.mathecao.donhang.index')->with('success', 'Cập nhật đơn hàng thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $donHang = MaThe_DonHang::findOrFail($id);
        $donHang->delete();

        return redirect()->route('admin.mathecao.donhang.index')->with('success', 'Đơn hàng đã được xóa!');
    }
}
