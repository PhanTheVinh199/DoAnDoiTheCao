<?php
// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use App\Models\NapTien;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ThanhVien;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        // Lấy thông tin đơn hàng từ bảng NapTien
        $order = NapTien::findOrFail($id);

        // Truyền dữ liệu vào view
        return view('wallet.order_detail', compact('order'));
    }
}
