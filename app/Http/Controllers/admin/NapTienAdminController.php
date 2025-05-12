<?php

namespace App\Http\Controllers\Admin;

use App\Models\NapTien;
use App\Models\ThanhVien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class NapTienAdminController extends Controller
{
    // Hiển thị tất cả các giao dịch nạp tiền
    public function showHistory()
    {
        // Lấy tất cả các giao dịch nạp tiền từ database, sắp xếp theo thời gian tạo mới nhất
        $transactions = NapTien::latest()->paginate(10); // Sử dụng phân trang để giảm tải
        return view('admin.naptien', compact('transactions'));
    }

    // Duyệt giao dịch nạp tiền
    public function approve($id)
    {
        // Lấy giao dịch nạp tiền theo ID
        $transaction = NapTien::find($id);

        // Kiểm tra xem giao dịch có tồn tại hay không
        if (!$transaction) {
            return redirect()->route('admin.naptien.index')->with('error', 'Giao dịch không tồn tại.');
        }

        // Kiểm tra nếu trạng thái là "đã duyệt" rồi thì không làm gì
        if ($transaction->trang_thai == 'da_duyet') {
            return redirect()->route('admin.naptien.index')->with('info', 'Giao dịch đã được duyệt trước đó.');
        }

        // Cập nhật trạng thái giao dịch thành "đã duyệt"
        Log::info("Trạng thái trước khi cập nhật: " . $transaction->trang_thai);
        $transaction->trang_thai = 'da_duyet';
        $transaction->save();
        Log::info("Trạng thái sau khi cập nhật: " . $transaction->trang_thai);

        // Cập nhật số dư người dùng
        $user = ThanhVien::find($transaction->thanhvien_id);  // Tìm người dùng liên quan
        if ($user) {
            // Cộng số tiền vào số dư của người dùng
            $user->so_du += $transaction->so_tien_nap;  
            $user->save();
        } else {
            return redirect()->route('admin.naptien.index')->with('error', 'Không tìm thấy người dùng.');
        }

        // Thông báo thành công
        return redirect()->route('admin.naptien.index')->with('success', 'Giao dịch đã được duyệt và số dư người dùng đã được cập nhật.');
    }
}
