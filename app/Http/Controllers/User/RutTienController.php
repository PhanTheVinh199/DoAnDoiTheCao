<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\NganHang;
use App\Models\ThanhVien;
use App\Models\RutTien;  // Import model RutTien để lưu lịch sử rút tiền
use Illuminate\Http\Request;

class RutTienController extends Controller
{
    // Hiển thị form rút tiền với danh sách ngân hàng
    public function showRutTienForm()
    {
        $user = auth()->user(); // Lấy người dùng hiện tại
    
        // Lấy danh sách các ngân hàng của người dùng
        $banks = $user->nganHang;
    
        // Trả về view và truyền danh sách ngân hàng
        return view('user.add_nganhang_user', compact('banks'));
    }

     // Hiển thị lịch sử rút tiền của người dùng
     public function showRutTienHistory()
     {
         $user = auth()->user(); // Lấy người dùng hiện tại
         
         // Lấy lịch sử rút tiền của người dùng từ bảng RutTien
         $dsRutTien = RutTien::where('thanhvien_id', $user->id_thanhvien)
                             ->orderBy('created_at', 'desc')
                             ->paginate(1);  // Phân trang, lấy 10 bản ghi mỗi trang

                             

       
    
 
         // Trả về view và truyền dữ liệu vào
         return view('ruttien', compact('dsRutTien'));
     }
 
    

    // Hiển thị form thêm ngân hàng
    public function showAddBankForm()
    {
        return view('add_nganhang_user');
    }

    // Xử lý thêm ngân hàng
    public function addBank(Request $request)
    {
        // Lấy người dùng hiện tại (người đang đăng nhập)
        $user = auth()->user();
    
        // Kiểm tra dữ liệu từ form
       $request->validate([
    'ten_ngan_hang' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:125', // Chỉ cho phép chữ và khoảng trắng
    'so_tai_khoan' => 'required|numeric', // Phải là số
    'chu_tai_khoan' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:100', // Chỉ cho phép chữ và khoảng trắng
]);

    
        // Thêm dữ liệu vào bảng nganhang
        NganHang::create([
            'thanhvien_id' => $user->id_thanhvien,  // Sử dụng ID của người dùng
            'ten_ngan_hang' => $request->input('ten_ngan_hang'),
            'so_tai_khoan' => $request->input('so_tai_khoan'),
            'chu_tai_khoan' => $request->input('chu_tai_khoan'),
            'trang_thai' => 'hoat_dong',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // Chuyển hướng về trang rút tiền
        return redirect()->route('ruttien')->with('success', 'Ngân hàng đã được thêm thành công.');
    }

    // Xử lý rút tiền
    public function processRutTien(Request $request)
    {
        $user = auth()->user(); // Lấy người dùng đang đăng nhập
        $amount = $request->input('amount'); // Số tiền người dùng muốn rút
        $bankId = $request->input('bankinfo_id'); // ID ngân hàng mà người dùng chọn
    
        // Kiểm tra nếu số tiền rút không hợp lệ
        if ($amount < 10000 || $amount > 5000000) {
            return redirect()->back()->with('error', 'Số tiền rút không hợp lệ. Số tiền phải nằm trong khoảng từ 10,000 đến 5,000,000 VND.');
        }
    
        // Kiểm tra số dư tài khoản
        if ($user->so_du < $amount) {
            return redirect()->back()->with('error', 'Số dư tài khoản không đủ để rút.');
        }
    
        // Lấy thông tin ngân hàng
        $bank = NganHang::find($bankId);
        
        if (!$bank || $bank->thanhvien_id != $user->id_thanhvien) {
            return redirect()->back()->with('error', 'Ngân hàng không hợp lệ.');
        }
    
        // Giảm số dư tài khoản sau khi rút tiền
        $user->so_du -= $amount;
        $user->save(); // Lưu lại số dư mới vào cơ sở dữ liệu

        // Tạo mã đơn rút tiền ngẫu nhiên
        $ma_don = 'RUT' . strtoupper(uniqid());

        // Lưu thông tin rút tiền vào bảng lichsu_rut
        RutTien::create([
            'ma_don' => $ma_don,  // Mã đơn
            'thanhvien_id' => $user->id_thanhvien,  // ID người dùng
            'danhsach_id' => $bankId,  // ID ngân hàng
            'so_tien_rut' => $amount,  // Số tiền rút
            'trang_thai' => 'cho_duyet',  // Trạng thái giao dịch: đã hoàn thành
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // Chuyển hướng với thông báo thành công
        return redirect()->route('ruttien')->with('success', 'Rút tiền thành công. Số dư hiện tại của bạn là ' . number_format($user->so_du) . ' VND.');
    }
}
