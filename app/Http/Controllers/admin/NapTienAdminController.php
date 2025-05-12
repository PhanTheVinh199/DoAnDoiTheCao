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


public function approve($id)
{
    // Lấy giao dịch nạp tiền theo ID
    $transaction = NapTien::find($id);

    if (!$transaction) {
        return redirect()->route('admin.nganhang.naptien.index')->with('error', 'Giao dịch không tồn tại.');
    }

    // Kiểm tra trạng thái giao dịch, nếu đã duyệt thì không làm gì
    if ($transaction->trang_thai == 'da_duyet') {
        return redirect()->route('admin.nganhang.naptien.index')->with('info', 'Giao dịch đã được duyệt trước đó.');
    }

    // Cập nhật trạng thái giao dịch thành "đã duyệt"
    $transaction->trang_thai = 'da_duyet';
    $transaction->save();

    // Cập nhật số dư người dùng
    $user = ThanhVien::find($transaction->thanhvien_id);
    if ($user) {
        $user->so_du += $transaction->so_tien_nap; // Cộng số tiền nạp vào số dư
        $user->save();
    } else {
        return redirect()->route('admin.nganhang.naptien.index')->with('error', 'Không tìm thấy người dùng.');
    }
    
    return redirect()->route('admin.nganhang.naptien.index')->with('success', 'Giao dịch đã được duyệt và số dư người dùng đã được cập nhật.');
    Auth::guard('thanhvien')->user()->refresh();
}

    // Xóa giao dịch nạp tiền
    public function delete($id)
    {
        // Lấy giao dịch nạp tiền theo ID
        $transaction = NapTien::find($id);

        if (!$transaction) {
            return redirect()->route('admin.naptien.index')->with('error', 'Giao dịch không tồn tại.');
        }

        // Xóa giao dịch
        $transaction->delete();

        return redirect()->route('admin.naptien.index')->with('success', 'Giao dịch đã được xóa.');

}
    // Hủy giao dịch nạp tiền
    public function cancel($id)
    {
        // Lấy giao dịch nạp tiền theo ID
        $transaction = NapTien::find($id);

        if (!$transaction) {
            return redirect()->route('admin.naptien.index')->with('error', 'Giao dịch không tồn tại.');
        }

        // Cập nhật trạng thái giao dịch thành "đã hủy"
        $transaction->trang_thai = 'da_huy';
        $transaction->save();

        return redirect()->route('admin.naptien.index')->with('success', 'Giao dịch đã được hủy.');
    }
    
}
