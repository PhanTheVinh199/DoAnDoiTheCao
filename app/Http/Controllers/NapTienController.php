<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\NapTien;
use App\Models\ThanhVien;
use App\Models\NganHang;

class NapTienController extends Controller
{
    // Hiển thị form nạp tiền
    public function showForm()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::guard('thanhvien')->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để nạp tiền!');
        }

        $user = Auth::guard('thanhvien')->user();

        // Lấy lịch sử giao dịch của user
        $transactions = NapTien::where('thanhvien_id', $user->id_thanhvien)
                                ->latest()
                                ->get();

        // Lấy danh sách ngân hàng của admin (admin có id 1)
        $banks = NganHang::where('id_danhsach', '>=', 1)
                        ->where('trang_thai', 'hoat_dong')
                        ->get();

        // Các biến hạn mức
        $hanMucNgay = 100000000;  // Hạn mức nạp tiền tối đa trong ngày
        $soTienToiThieu = 10000;  // Số tiền tối thiểu
        $soTienToiDa = 10000000;   // Số tiền tối đa
        session(['hanMucNgay' => $hanMucNgay]);

        // Trả về view với dữ liệu
        return view('naptien', compact('hanMucNgay', 'soTienToiThieu', 'soTienToiDa', 'banks', 'transactions'));
    }

    // Xử lý yêu cầu nạp tiền
    public function store(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!Auth::guard('thanhvien')->check()) {
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để nạp tiền!');
    }

    // Lấy thông tin người dùng đã đăng nhập
    $user = Auth::guard('thanhvien')->user();

    // Xác thực dữ liệu người dùng nhập vào
    $request->validate([
        'net_amount' => 'required|numeric|min:10000|max:10000000', // Tăng giới hạn tối đa
        'paygate_code' => 'required|string|exists:nganhang,id_danhsach',  // Đảm bảo mã thanh toán hợp lệ
    ]);

    // Kiểm tra hạn mức nạp tiền trong ngày
    $hanMucNgay = session('hanMucNgay', 100000000);  // Hạn mức nạp tiền tối đa trong ngày
    $totalToday = NapTien::where('thanhvien_id', $user->id_thanhvien)
                         ->whereDate('created_at', now()->toDateString())
                         ->sum('so_tien_nap');
    
    if ($totalToday + $request->net_amount > $hanMucNgay) {
        return back()->with('error', 'Bạn đã đạt hạn mức nạp tiền trong ngày.');
    }

    // Xử lý thanh toán qua ngân hàng nội bộ
    $bank = NganHang::where('id_danhsach', $request->paygate_code)
                    ->where('trang_thai', 'hoat_dong')
                    ->first();

    if (!$bank) {
        return back()->with('error', 'Ngân hàng không hợp lệ hoặc đã bị vô hiệu hóa.');
    }

    // Tạo giao dịch nạp tiền và lưu thông tin ngân hàng vào bảng nap_tiens
    $order = NapTien::create([
        'thanhvien_id' => $user->id_thanhvien,
        'so_tien_nap' => $request->net_amount,
        'noi_dung' => 'Nạp qua ngân hàng ' . $bank->ten_ngan_hang . ' (' . $bank->so_tai_khoan . ')',
        'trang_thai' => 'cho_duyet',
        'ma_don' => Str::uuid(),
        'bank_name' => $bank->ten_ngan_hang, // Lưu tên ngân hàng
        'bank_account' => $bank->so_tai_khoan, // Lưu số tài khoản ngân hàng
        'bank_account_name' => $bank->chu_tai_khoan, // Lưu tên chủ tài khoản
        'transfer_note' => 'NAP' . strtoupper(Str::random(6)), // Nội dung chuyển khoản
    ]);

    // Redirect đến chi tiết đơn hàng
    return redirect()->route('order.show', ['id' => $order->id_lichsunap]);
    }

    // Xử lý thanh toán qua ngân hàng nội bộ
    protected function handleInternalBankPayment(Request $request, $user)
    {
        // Kiểm tra ngân hàng có hợp lệ và còn hoạt động không
        $bank = NganHang::where('id_danhsach', $request->paygate_code)
                        ->where('trang_thai', 'hoat_dong')
                        ->first();

        if (!$bank) {
            return back()->with('error', 'Ngân hàng không hợp lệ hoặc đã bị vô hiệu hóa.');
        }

        // Tạo nội dung chuyển khoản ngẫu nhiên
        $transferNote = 'NAP' . strtoupper(Str::random(6));

        // Tạo giao dịch nạp tiền và lưu thông tin ngân hàng vào bảng nap_tiens
        $order = NapTien::create([
            'thanhvien_id' => $user->id_thanhvien,
            'so_tien_nap' => $request->net_amount,
            'noi_dung' => 'Nạp qua ngân hàng ' . $bank->ten_ngan_hang . ' (' . $bank->so_tai_khoan . ')',
            'trang_thai' => 'cho_duyet',
            'ma_don' => Str::uuid(),
            'bank_name' => $bank->ten_ngan_hang, // Lưu tên ngân hàng
            'bank_account' => $bank->so_tai_khoan, // Lưu số tài khoản ngân hàng
            'bank_account_name' => $bank->chu_tai_khoan, // Lưu tên chủ tài khoản
            'transfer_note' => $transferNote, // Lưu nội dung chuyển khoản
        ]);

        // Trả về view hoặc redirect đến chi tiết đơn hàng
        return redirect()->route('order.show', ['id' => $order->id_lichsunap]);  // Đổi sang route 'order.show' để hiển thị chi tiết đơn hàng
    }

    // Xem lịch sử nạp tiền
    public function showHistory()
    {
        $user = Auth::guard('thanhvien')->user();
        $transactions = NapTien::where('thanhvien_id', $user->id_thanhvien)->latest()->get();
        return view('lichsunap', compact('transactions'));
    }
}
