<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaThe_SanPham;
use App\Models\MaThe_DonHang;
use App\Models\MaThe_NhaCungCap;
use App\Models\ThanhVien;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MTC_DonHangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MaThe_DonHang::with('sanpham.nhacungcap');

        if ($request->filled('ma_don')) {
            $query->where('ma_don', 'like', '%' . $request->ma_don . '%');
        }

        $dsDonHang = $query->orderBy('ngay_tao', 'desc')->paginate(5);
        $dsSanPham = MaThe_SanPham::all();
        $dsThanhVien = ThanhVien::all();
        $dsNhaCungCap = MaThe_NhaCungCap::all();
        
        if ($request->filled('ma_don') && $dsDonHang->isEmpty()) {
            return view('admin.mathecao.donhang.mathecao_donhang', compact('dsDonHang', 'dsSanPham', 'dsThanhVien', 'dsNhaCungCap'))
                ->with('not_found', 'Không tìm thấy đơn hàng nào phù hợp với từ khóa "' . $request->ma_don . '"');
        }

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
            'trang_thai' => 'required|in:hoat_dong, da_huy, cho_xu_ly',
        ]);


        $sanPham = MaThe_SanPham::findOrFail($request->mathecao_id);
        $menhGia = $sanPham->menh_gia;
        $chietKhau = $sanPham->chiet_khau;

        $thanhTien = $request->so_luong * $menhGia * (1 - $chietKhau / 100);

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

    public function update(Request $request, $id)
    {
        $request->validate([
            'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly',
            'ngay_cap_nhat' => 'required|string',
        ]);

        $donHang = MaThe_DonHang::findOrFail($id);

        // So sánh ngay_cap_nhat để phát hiện dữ liệu bị thay đổi đồng thời
        if ($request->input('ngay_cap_nhat') !== $donHang->ngay_cap_nhat->format('Y-m-d H:i:s')) {
            return redirect()
                ->route('admin.mathecao.donhang.edit', $id)
                ->with('concurrency_error', 'Dữ liệu đã bị thay đổi trước đó, trang sẽ tự động cập nhật dữ liệu mới nhất.');
        }

        MaThe_DonHang::updateStatus(
            $id,
            $request->input('trang_thai')
        );
        return redirect()
            ->route('admin.mathecao.donhang.index')
            ->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $donHang = MaThe_DonHang::findOrFail($id);
            $donHang->delete();

            if ($request->ajax()) {
                return response()->json(['success' => 'Đơn hàng đã được xóa!'], 200);
            }

            return redirect()
                ->route('admin.mathecao.donhang.index')
                ->with('success', 'Đơn hàng đã được xóa!');
        } catch (ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Đơn hàng không tồn tại!'], 404);
            }

            return redirect()
                ->route('admin.mathecao.donhang.index')
                ->with('error', 'Đơn hàng không tồn tại!');
        }
    }
}
