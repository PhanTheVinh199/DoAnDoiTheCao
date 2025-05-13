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
        // Lấy thông tin đơn hàng, bao gồm thông tin cổng thanh toán
        $order = NapTien::with('nganhang')->findOrFail($id);
        // dd($order);
        // Trả về view và truyền dữ liệu vào
        return view('wallet.order_detail', compact('order'));
    }

    public function confirm($id)
    {
        $order = NapTien::findOrFail($id);
        
        // Kiểm tra xem giao dịch đã được admin duyệt chưa
        if ($order->trang_thai !== 'da_duyet') {
            return redirect()->back()->with('error', 'Giao dịch chưa được admin duyệt!');
        }
        
        // Kiểm tra xem người dùng có phải chủ giao dịch không
        if ($order->thanhvien_id !== Auth::guard('thanhvien')->id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền xác nhận giao dịch này!');
        }

        // Cập nhật trạng thái đã xác nhận từ user
        $order->da_xac_nhan = true;
        $order->save();

        return redirect()->back()->with('success', 'Xác nhận giao dịch thành công!');
    }
}
