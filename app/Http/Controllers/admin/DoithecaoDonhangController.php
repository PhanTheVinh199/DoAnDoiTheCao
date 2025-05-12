<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoithecaoDonhang;
use App\Models\DoithecaoDanhsach;

class DoithecaoDonhangController extends Controller
{
public function index(Request $request)
{
    // Lấy giá trị tìm kiếm từ form
    $searchTerm = $request->input('ma_don', '');  // Mặc định là không có tìm kiếm

    // Truy vấn các đơn hàng kèm theo các quan hệ và phân trang
    $donhang = DoithecaoDonhang::with('doithecao', 'doithecao.nhacungcap', 'thanhvien')
        ->when($searchTerm, function ($query, $searchTerm) {
            // Nếu có tìm kiếm theo mã đơn thì áp dụng điều kiện where
            return $query->where('ma_don', 'like', '%' . $searchTerm . '%');
        })
        ->orderBy('ngay_tao', 'desc')  // Sắp xếp theo ngày tạo, từ mới nhất đến cũ nhất
        ->paginate(10);  // Phân trang, lấy 10 đơn hàng mỗi trang

    // Trả về view và truyền dữ liệu tìm kiếm cùng kết quả phân trang
    return view('admin.doithecao.donhang.doithecao_donhang', compact('donhang', 'searchTerm'));
}


    // Xóa public function create()
    // public function create()
    // {
    //     return view('admin.doithecao.donhang.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'ma_don' => 'required|string|max:50|unique:doithecao_donhang',
    //         'ma_the' => 'required|string|max:100',
    //         'serial' => 'required|string|max:100',
    //         'doithecao_id' => 'required|exists:doithecao_danhsach,id_doithecao',
    //         'so_luong' => 'required|integer|min:1',
    //         'thanh_tien' => 'required|integer|min:0',
    //         'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly',
    //     ]);

    //     DoithecaoDonhang::create($request->all());

    //     return redirect()->route('admin.doithecao.donhang.index')->with('success', 'Thêm đơn hàng thành công');
    // }

   public function edit($id_dondoithe)
{
    // Đảm bảo sử dụng đúng khóa chính 'id_dondoithe'
    $donhang = DoithecaoDonhang::findOrFail($id_dondoithe); 
    // $donhang = DoithecaoDonhang::where('id_dondoithe', $id_dondoithe)->firstOrFail();

    $sanphams = DoithecaoDanhsach::all(); // Lấy danh sách sản phẩm để chọn
    return view('admin.doithecao.donhang.doithecao_donhang_edit', compact('donhang', 'sanphams'));
}

public function update(Request $request, $id_dondoithe)
{
    // Lấy đơn hàng theo ID
    $donhang = DoithecaoDonhang::findOrFail($id_dondoithe);

    // Validate yêu cầu cập nhật chỉ cho phép thay đổi trạng thái
    $request->validate([
        'trang_thai' => 'required|in:hoat_dong,da_huy,cho_xu_ly',  // Chỉ validate trạng thái
    ]);

    // Kiểm tra nếu trạng thái chuyển sang "hoat_dong"
    if ($request->trang_thai == 'hoat_dong') {
        // Cộng tổng tiền vào tài khoản người dùng
        $thanhvien = $donhang->thanhvien;  // Lấy người dùng liên quan đến đơn hàng
        $thanhvien->so_du += $donhang->thanh_tien;  // Cộng tiền vào tài khoản người dùng
        $thanhvien->save();  // Lưu thay đổi vào cơ sở dữ liệu
    }

    // Cập nhật trạng thái của đơn hàng
    $donhang->update([
        'trang_thai' => $request->trang_thai,
    ]);

    // Redirect về trang danh sách đơn hàng và thông báo thành công
    return redirect()->route('admin.doithecao.donhang.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công');
}





    public function destroy($id)
    {
        $donhang = DoithecaoDonhang::findOrFail($id);
        $donhang->delete();

        return redirect()->route('admin.doithecao.donhang.index')->with('success', 'Xóa đơn hàng thành công');
    }
}
