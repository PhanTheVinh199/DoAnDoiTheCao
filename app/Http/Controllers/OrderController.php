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
        // Lấy thông tin đơn hàng
        $order = NapTien::with('nganhang')->findOrFail($id);

        // Trả về view và truyền dữ liệu vào
        return view('wallet.order_detail', compact('order'));
    }

    public function confirm($id)
    {
        $order = NapTien::findOrFail($id);

        if ($order->trang_thai !== 'cho_duyet') {
            return redirect()->route('order.show', ['id' => $order->id_lichsunap])
                             ->with('error', 'Giao dịch đã bị duyệt hoặc bị hủy trước đó.');
        }

        // Kiểm tra quyền admin
        if (Auth::user()->quyen !== 'admin') {
            return redirect()->route('order.show', ['id' => $order->id_lichsunap])
                             ->with('error', 'Bạn không có quyền duyệt giao dịch.');
        }

        // Cập nhật trạng thái và cộng tiền
        $order->trang_thai = 'da_duyet';
        $order->save();

        $user = ThanhVien::find($order->thanhvien_id);
        if ($user) {
            $user->so_du += $order->so_tien_nap;
            $user->save();
        }

        return redirect()->route('order.show', ['id' => $order->id_lichsunap])
                         ->with('success', 'Giao dịch nạp tiền đã được duyệt và số dư người dùng đã được cập nhật.');
    }

}
