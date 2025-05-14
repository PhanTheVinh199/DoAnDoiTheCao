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
        $dsNapTien = NapTien::latest()->paginate(10); // Sử dụng phân trang để giảm tải
        return view('admin.nganhang.naptien.nganhang_naptien', compact('dsNapTien'));
    }

    // Duyệt giao dịch nạp tiền
public function approve(Request $request, $id)
{
    // Lấy thông tin giao dịch nạp tiền
    $dsNapTien = NapTien::find($id);

    // Kiểm tra giao dịch có tồn tại hay không
    if (!$dsNapTien) {
        return redirect()->route('admin.naptien.index')->with('error', 'Giao dịch không tồn tại.');
    }

    // Kiểm tra trạng thái giao dịch, không cho phép cập nhật nếu đã hủy
    if ($dsNapTien->trang_thai == 'huy') {
        return redirect()->route('admin.naptien.index')->with('info', 'Giao dịch này đã bị hủy và không thể cập nhật.');
    }

    // Cập nhật trạng thái giao dịch
    $dsNapTien->trang_thai = $request->input('trang_thai');
    $dsNapTien->save();

    // Nếu trạng thái là "đã duyệt", cộng số tiền vào tài khoản người dùng
    if ($dsNapTien->trang_thai == 'da_duyet') {
        $user = ThanhVien::find($dsNapTien->thanhvien_id);
        if ($user) {
            $user->so_du += $dsNapTien->so_tien_nap;
            $user->save();
        } else {
            return redirect()->route('admin.naptien.index')->with('error', 'Không tìm thấy người dùng.');
        }
    }

    return redirect()->route('admin.naptien.index')->with('success', 'Trạng thái giao dịch đã được cập nhật.');
}




}
