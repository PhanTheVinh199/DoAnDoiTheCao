<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaThe_NhaCungCap;
use App\Models\MaThe_SanPham;

class SanPhamController extends Controller
{
    // Phương thức index hiển thị nhà cung cấp
    public function index(Request $request)
    {
        $dsNhaCungCap = MaThe_NhaCungCap::all();
        return view('card', compact('dsNhaCungCap'));
    }

    public function getProductPrices($id)
    {
        // Lấy danh sách mệnh giá sản phẩm theo nhà cung cấp
        $products = MaThe_SanPham::where('nhacungcap_id', $id)->get();
    
        // Nếu không có sản phẩm, trả về thông báo
        if ($products->isEmpty()) {
            return response()->json(['html' => '<div class="price-item">Không có sản phẩm</div>']);
        }
    
        // Trả về dữ liệu mệnh giá dưới dạng HTML để hiển thị trên frontend
        $html = '';
        foreach ($products as $product) {
            $html .= '<div class="price-item" data-price="' . $product->menh_gia . '" data-discount="' . $product->chiet_khau . '">';
            $html .= number_format($product->menh_gia, 0, ',', '.') . ' VND</div>';
        }
    
        return response()->json(['html' => $html]);
    }
}




