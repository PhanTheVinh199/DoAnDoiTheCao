<?php

namespace App\Http\Controllers\User;

use App\Models\DoithecaoDanhsach;
use App\Models\DoithecaoNhacungcap;
use App\Models\DoithecaoDonhang; // Đảm bảo import model DoithecaoDonhang
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MenhGia; // Import model MenhGia
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;  // Correct namespace for Auth


class DoiTheCaoController extends Controller
{
public function index(Request $request)
{
    // Lấy giá trị tìm kiếm từ form (nếu có)
    $searchTerm = $request->input('search', ''); // Mặc định là không có tìm kiếm

    // Lấy danh sách nhà cung cấp thẻ cào đang hoạt động
    $nhacungcap = DoithecaoNhacungcap::where('trang_thai', 'hoat_dong')->get();

    // Lấy danh sách mệnh giá thẻ cào
    $menhgia = DoithecaoDanhsach::all();




    // Lấy danh sách đơn hàng của người dùng hiện tại với tìm kiếm và phân trang
    $donhangs = DoithecaoDonhang::with('doithecao', 'doithecao.nhacungcap')
        
        ->when($searchTerm, function ($query, $searchTerm) {
            // Nếu có tìm kiếm theo mã đơn hoặc mã thẻ thì áp dụng điều kiện where
            return $query->where('ma_don', 'like', '%' . $searchTerm . '%')
                         ->orWhere('ma_the', 'like', '%' . $searchTerm . '%');
        })
        ->orderBy('ngay_tao', 'desc')  // Sắp xếp theo ngày tạo, từ mới nhất
        ->paginate(10);  // Phân trang, lấy 10 đơn hàng mỗi trang

    // Trả về view và truyền dữ liệu cho view
    return view('index', compact('nhacungcap', 'menhgia', 'donhangs', 'searchTerm'));
}


    // Xử lý form đổi thẻ cào
public function exchange(Request $request)
{
    // Kiểm tra dữ liệu từ form
    $request->validate([
        'telco' => 'required|array',
        'telco.*' => 'required|exists:doithecao_nhacungcap,id_nhacungcap',
        'code' => 'required|array',
        'serial' => 'required|array',
        'amount' => 'required|array',
        'amount.*' => 'required|integer',
        // Kiểm tra mã thẻ và serial phải là số và có từ 1 đến 30 ký tự
        'code.*' => 'required|regex:/^\d{1,30}$/', // Mã thẻ phải là số và có từ 1 đến 30 ký tự
        'serial.*' => 'required|regex:/^\d{1,30}$/', // Serial phải là số và có từ 1 đến 30 ký tự
    ]);

    // Lấy người dùng hiện tại (người đang đăng nhập)
    $user = auth()->user();

    // Duyệt qua từng thẻ và lưu vào database
    foreach ($request->telco as $index => $telco) {

        // Lấy thông tin mệnh giá từ bảng doithecao_danhsach
        $doithecao = DoithecaoDanhsach::where('nhacungcap_id', $telco)
            ->where('menh_gia', $request->amount[$index])
            ->first();

        // Kiểm tra nếu không tìm thấy mệnh giá
        if (!$doithecao) {
            return redirect()->back()->withErrors(['menhgia' => 'Mệnh giá không hợp lệ']);
        }

        // Tính thành tiền sau chiết khấu
        $thanh_tien = $request->amount[$index] - ($request->amount[$index] * ($doithecao->chiet_khau / 100));

        // Thêm dữ liệu vào bảng doithecao_donhang
        DoithecaoDonhang::create([
            'ma_don' => 'DTC-' . Str::random(10), // Tạo mã đơn ngẫu nhiên
            'ma_the' => $request->code[$index],
            'serial' => $request->serial[$index],
            'doithecao_id' => $doithecao->id_doithecao, // Lấy id của sản phẩm từ bảng doithecao_danhsach
            'so_luong' => 1, // Giả sử mỗi thẻ 1
            'thanh_tien' => $thanh_tien,
            'thanhvien_id' => $user->id_thanhvien, // Correctly set the field to 'thanhvien_id'
            'ngay_tao' => now(),
            'trang_thai' => 'cho_xu_ly', // Trạng thái là chờ xử lý
        ]);
    }

    // Trả về thông báo thành công
    return redirect()->back()->with('success', 'Đổi thẻ thành công!');
}


}
