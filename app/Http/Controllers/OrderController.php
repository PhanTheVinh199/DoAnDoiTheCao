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
        // Lấy thông tin đơn hàng
        $order = NapTien::findOrFail($id);

        // Kiểm tra nếu trạng thái hiện tại là "Chờ duyệt"
        if ($order->trang_thai == 'cho_duyet') {
            // Cập nhật trạng thái đơn hàng thành "Đã duyệt"
            $order->trang_thai = 'da_duyet';
            $order->save();

            // Cập nhật số dư người dùng
            $user = ThanhVien::find($order->thanhvien_id);
            if ($user) {
                $user->so_du += $order->so_tien_nap; // Cộng số tiền vào số dư của người dùng
                $user->save();
            }

            return redirect()->route('order.show', ['id' => $order->id_lichsunap])
                             ->with('success', 'Giao dịch nạp tiền đã được duyệt và số dư người dùng đã được cập nhật.');
        } else {
            return redirect()->route('order.show', ['id' => $order->id_lichsunap])
                             ->with('error', 'Giao dịch đã bị duyệt hoặc bị hủy trước đó.');
        }
    }
}
