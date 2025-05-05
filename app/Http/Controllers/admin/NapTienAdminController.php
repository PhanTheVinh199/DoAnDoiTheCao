namespace App\Http\Controllers\Admin;

use App\Models\NapTien;
use App\Models\ThanhVien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NapTienAdminController extends Controller
{
    // Hiển thị tất cả các giao dịch nạp tiền
    public function showHistory()
    {
        // Lấy tất cả các giao dịch nạp tiền từ database
        $transactions = NapTien::latest()->get();
        return view('admin.naptien', compact('transactions'));
    }

    // Duyệt giao dịch nạp tiền
    public function approve($id)
    {
        // Lấy giao dịch nạp tiền theo ID
        $transaction = NapTien::find($id);

        if (!$transaction) {
            return redirect()->route('admin.naptien.index')->with('error', 'Giao dịch không tồn tại.');
        }

        // Cập nhật trạng thái giao dịch thành "đã duyệt"
        $transaction->trang_thai = 'da_duyet';
        $transaction->save();

        // Cập nhật số dư người dùng
        $user = ThanhVien::find($transaction->thanhvien_id);  // Tìm người dùng liên quan
        $user->so_du += $transaction->so_tien_nap;  // Cộng số tiền vào số dư của người dùng
        $user->save();

        return redirect()->route('admin.naptien.index')->with('success', 'Giao dịch đã được duyệt và số dư người dùng đã được cập nhật.');
    }
}
