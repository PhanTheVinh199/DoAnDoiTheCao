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
    public function index(Request $request)
    {
        $user = Auth::guard('thanhvien')->user();

        if (!$user) {
            return view('card')->with('message', 'Vui lòng đăng nhập để tiếp tục thanh toán.');
        }

        // Lấy danh sách nhà cung cấp có trạng thái 'Hoạt động'
        $dsNhaCungCap = MaThe_NhaCungCap::where('trang_thai', 'hoat_dong')->get();

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

        $dsDonHang = $query->orderBy('ngay_tao', 'desc')->take(5)->get();
        return view('card', compact('dsNhaCungCap', 'dsDonHang'));
    }

    public function getProductPrices($id)
    {
        $products = MaThe_SanPham::where('nhacungcap_id', $id)
            ->where('trang_thai', 'hoat_dong')
            ->get();

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
