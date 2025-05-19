<?php
namespace App\Http\Controllers;

use App\Models\NapTien;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $order = NapTien::getOrderDetail($id);
        return view('wallet.order_detail', compact('order'));
    }

    // Xác nhận nạp tiền
    public function confirm($id)
    {
        try {
            NapTien::confirmTransaction($id);
        } catch (\Exception $e) {
            return redirect()->route('order.show', ['id' => $id])
                ->with('error', $e->getMessage());
        }

        return redirect()->route('naptien')
            ->with('success', 'Giao dịch nạp tiền đã được duyệt và số dư người dùng đã được cập nhật.');
    }
}
