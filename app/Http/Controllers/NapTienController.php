<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NapTien;
use App\Models\ThanhVien;
use App\Models\NganHang;

class NapTienController extends Controller
{
    // Hiển thị form nạp tiền
    public function showForm()
    {
        if (!Auth::guard('thanhvien')->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để nạp tiền!');
        }

        $user = Auth::guard('thanhvien')->user();

        // Lịch sử nạp tiền của user
        $transactions = NapTien::where('thanhvien_id', $user->id_thanhvien)
                                ->latest()
                                ->get();

        // Lấy ngân hàng của admin (giả sử admin có ID là 1)
        $banks = NganHang::where('thanhvien_id', 1)
                        ->where('trang_thai', 'hoat_dong')
                        ->get();

        // Các biến hạn mức ngày, số tiền tối thiểu, số tiền tối đa
        $hanMucNgay = 10000000; // Hạn mức nạp tiền tối đa trong ngày
        $soTienToiThieu = 10000; // Số tiền tối thiểu
        $soTienToiDa = 1000000; // Số tiền tối đa

        // Trả về view và truyền dữ liệu vào
        return view('naptien', [
            'hanMucNgay' => $hanMucNgay,
            'soTienToiThieu' => $soTienToiThieu,
            'soTienToiDa' => $soTienToiDa,
            'banks' => $banks,
            'transactions' => $transactions,
        ]);
    }

    // Xử lý yêu cầu nạp tiền
    public function store(Request $request)
    {
        if (!Auth::guard('thanhvien')->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để nạp tiền!');
        }

        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'net_amount' => 'required|numeric|min:1',
            'paygate_code' => 'required|exists:nganhang,id_danhsach',  // Kiểm tra mã ngân hàng
        ]);

        $user = Auth::guard('thanhvien')->user();

        // ✅ Lấy ngân hàng admin được chọn (không kiểm tra theo người dùng nữa)
        $bank = NganHang::where('id_danhsach', $request->paygate_code)
                        ->where('trang_thai', 'hoat_dong')  // Ngân hàng đang hoạt động
                        ->first();

        if (!$bank) {
            return back()->with('error', 'Ngân hàng không hợp lệ hoặc đã bị vô hiệu hóa.');
        }

        // Tạo giao dịch nạp tiền
        NapTien::create([
            'thanhvien_id' => $user->id_thanhvien,
            'so_tien_nap' => $request->net_amount,
            'noi_dung' => 'Nạp qua ngân hàng ' . $bank->ten_ngan_hang . ' (' . $bank->so_tai_khoan . ')',
            'trang_thai' => 'cho_duyet', // Giao dịch chờ duyệt
        ]);

        return redirect()->route('naptien.form')->with('success', 'Tạo yêu cầu nạp tiền thành công. Vui lòng chờ duyệt.');
    }

    // Xem lịch sử nạp tiền
    public function showHistory()
    {
        $user = Auth::guard('thanhvien')->user();
        $transactions = NapTien::where('thanhvien_id', $user->id_thanhvien)->latest()->get();
        return view('lichsunap', compact('transactions'));
    }
}
