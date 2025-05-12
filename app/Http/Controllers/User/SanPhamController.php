<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaThe_SanPham;
use App\Models\MaThe_DonHang;
use App\Models\MaThe_NhaCungCap;
use Illuminate\Support\Facades\Auth;

class SanPhamController extends Controller
{
    // Phương thức hiển thị danh sách nhà cung cấp và lịch sử đơn hàng
    public function index(Request $request)
    {
        // Lấy thông tin người dùng hiện tại
        $user = Auth::guard('thanhvien')->user();

        // Lấy danh sách nhà cung cấp
        $dsNhaCungCap = MaThe_NhaCungCap::all();

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

        // Lấy danh sách đơn hàng của người dùng
        $dsDonHang = $query->orderBy('ngay_tao', 'desc')->paginate(10);

        return view('card', compact('dsNhaCungCap', 'dsDonHang'));
    }

    // Phương thức lấy mệnh giá sản phẩm theo nhà cung cấp
    public function getProductPrices($id)
    {
        $products = MaThe_SanPham::where('nhacungcap_id', $id)->get();

        if ($products->isEmpty()) {
            return response()->json(['html' => '<div class="price-item">Không có sản phẩm</div>']);
        }

        $html = '';
        foreach ($products as $product) {
            $html .= '<div class="price-item" data-id-mathecao="' . $product->id_mathecao . '" data-price="' . $product->menh_gia . '" data-discount="' . $product->chiet_khau . '">';
            $html .= number_format($product->menh_gia, 0, ',', '.') . ' VND</div>';
        }

        return response()->json(['html' => $html]);
    }
}
