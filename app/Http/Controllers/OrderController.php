<?php
// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use App\Models\NapTien;
use Illuminate\Http\Request;
use App\Models\ThanhVien;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        // Lấy thông tin đơn hàng, bao gồm thông tin cổng thanh toán
        $order = NapTien::with('nganhang')->findOrFail($id);
        return view('wallet.order_detail', compact('order'));
    }

    // Xác nhận nạp tiền
    public function confirm($id)
    {
        // Lấy thông tin đơn hàng
        $order = NapTien::findOrFail($id);

        // Kiểm tra trạng thái giao dịch
        if ($order->trang_thai == 'cho_duyet') {
            // Nếu giao dịch chưa được duyệt, thông báo lỗi
            return redirect()->route('order.show', ['id' => $order->id_lichsunap])
                             ->with('error', 'Giao dịch này vẫn chưa được admin phê duyệt.');
        }

        if ($order->trang_thai == 'da_duyet') {
            // Nếu giao dịch đã duyệt, cập nhật số dư người dùng
            $user = ThanhVien::find($order->thanhvien_id);
            if ($user) {
                // Cộng số tiền vào số dư người dùng
                $user->so_du += $order->so_tien_nap;
                $user->save();
            } else {
                // Nếu không tìm thấy người dùng, thông báo lỗi
                return redirect()->route('naptien')
                                 ->with('error', 'Không tìm thấy người dùng.');
            }

            // Thông báo thành công và điều hướng về trang nạp tiền
            return redirect()->route('naptien')
                             ->with('success', 'Giao dịch nạp tiền đã được duyệt và số dư người dùng đã được cập nhật.');
        }

        // Nếu trạng thái không hợp lệ, thông báo lỗi
        return redirect()->route('naptien')
                         ->with('error', 'Giao dịch không hợp lệ.');
    }
}


