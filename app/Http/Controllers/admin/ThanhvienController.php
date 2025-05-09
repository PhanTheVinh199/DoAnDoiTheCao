<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ThanhVien; // Đảm bảo bạn đã import model ThanhVien
use Illuminate\Http\Request;

class ThanhvienController extends Controller
{
    // Hiển thị danh sách thành viên
    // ThanhvienController.php

    public function index(Request $request)
    {
       
        $query = ThanhVien::query();
    
       
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
    
            // Lọc theo tài khoản hoặc email có chứa từ khóa
            $query->where('tai_khoan', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
        }
    
       
        $dsThanhVien = $query->orderBy('created_at', 'asc') // Sắp xếp theo thời gian từ cũ đến mới
                             ->paginate(5);
    
        // Trả về view và gửi dữ liệu vào view
        return view('admin.thanhvien.danhsach', compact('dsThanhVien'));
    }
    
    


    //Sửa thành viên
    public function edit($id)
{
    $thanhvien = ThanhVien::findOrFail($id);
    return view('admin.thanhvien.thanhvien_edit', compact('thanhvien'));
}

    //Cập nhật thành viên
public function update(Request $request, $id)
{
    // Validate các dữ liệu đầu vào
    $request->validate([
        'ho_ten' => 'required|string|max:100',
        'tai_khoan' => 'required|string|max:50',
        'mat_khau' => 'nullable|string|min:6', 
        'email' => 'nullable|email|max:150',
        'phone' => 'nullable|string|max:20',
        'quyen' => 'nullable|in:admin,user',
    ]);

    // Tìm thành viên theo ID
    $thanhvien = ThanhVien::findOrFail($id);

    // Cập nhật thông tin thành viên
    $thanhvien->ho_ten = $request->ho_ten;
    $thanhvien->tai_khoan = $request->tai_khoan;
    $thanhvien->email = $request->email;
    $thanhvien->phone = $request->phone;
    $thanhvien->quyen = $request->quyen;


    if ($request->filled('mat_khau')) {
        $thanhvien->mat_khau = bcrypt($request->mat_khau); // Mã hóa mật khẩu
    }

    // Lưu thành viên
    $thanhvien->save();

    // Quay lại trang danh sách với thông báo
    return redirect()->route('admin.thanhvien.danhsach')->with('success', 'Cập nhật thành công!');
}



//Xóa thành viên
public function destroy($id)
{
    $thanhvien = ThanhVien::findOrFail($id); // Tìm bản ghi theo ID
    $thanhvien->delete(); // Xóa bản ghi

    return redirect()->route('admin.thanhvien.danhsach')->with('success', 'Đã xóa bản ghi thành công.');
}




// public function naptien(Request $request, $id)
// {
//     // Tìm thành viên theo id
//     $thanhvien = ThanhVien::findOrFail($id);

//     // Kiểm tra loại giao dịch và thực hiện hành động tương ứng (nạp tiền hoặc rút tiền)
//     if ($request->has('transaction_type')) {
//         // Kiểm tra loại giao dịch (nạp tiền hay rút tiền)
//         if ($request->transaction_type == 'naptien') {
//             $thanhvien->so_du += $request->so_tien; // Cộng tiền vào tài khoản
//         } elseif ($request->transaction_type == 'rutien') {
//             if ($thanhvien->so_du >= $request->so_tien) {
//                 $thanhvien->so_du -= $request->so_tien; // Trừ tiền từ tài khoản
//             } else {
//                 return redirect()->back()->with('error', 'Số dư không đủ để rút');
//             }
//         }
//     }

//     $thanhvien->save(); // Lưu thông tin cập nhật

//     return redirect()->route('admin.thanhvien.danhsach')->with('success', 'Cập nhật thành công');
// }










// //Cộng tiền thành viên
// public function naptienForm($id)
// {
//     $thanhvien = ThanhVien::findOrFail($id);
//     return view('admin.thanhvien.naptien', compact('thanhvien'));
// }

// public function naptien(Request $request, $id)
// {
//     // Validate số tiền nạp
//     $request->validate([
//         'so_tien_nap' => 'required|numeric|min:0',
//     ]);

//     $thanhvien = ThanhVien::findOrFail($id);

//     // Cộng tiền vào tài khoản của thành viên
//     $thanhvien->so_du += $request->so_tien_nap; // Cộng số tiền nạp vào số dư

//     // Lưu lại thông tin thành viên
//     $thanhvien->save();

//     // Thêm lịch sử nạp tiền (tùy vào yêu cầu của bạn)
//     // Lịch sử nạp tiền có thể lưu trong một bảng lịch sử
//     LichSuNap::create([
//         'thanhvien_id' => $thanhvien->id_thanhvien,
//         'so_tien_nap' => $request->so_tien_nap,
//         'trang_thai' => 'da_duyet', // Hoặc trạng thái của bạn
//     ]);

//     return redirect()->route('thanhvien.danhsach')->with('success', 'Nạp tiền thành công!');
// }


// //Trừ tiền thành viên
// public function rutienForm($id)
// {
//     $thanhvien = ThanhVien::findOrFail($id);
//     return view('admin.thanhvien.rutien', compact('thanhvien'));
// }

// public function rutien(Request $request, $id)
// {
//     // Validate số tiền rút
//     $request->validate([
//         'so_tien_rut' => 'required|numeric|min:0',
//     ]);

//     $thanhvien = ThanhVien::findOrFail($id);

//     // Kiểm tra xem số dư có đủ để rút hay không
//     if ($thanhvien->so_du < $request->so_tien_rut) {
//         return redirect()->back()->with('error', 'Số dư không đủ để rút!');
//     }

//     // Trừ tiền khỏi tài khoản của thành viên
//     $thanhvien->so_du -= $request->so_tien_rut; // Trừ số tiền rút khỏi số dư

//     // Lưu lại thông tin thành viên
//     $thanhvien->save();

//     // Thêm lịch sử rút tiền (tùy vào yêu cầu của bạn)
//     // Lịch sử rút tiền có thể lưu trong một bảng lịch sử
//     LichSuRut::create([
//         'thanhvien_id' => $thanhvien->id_thanhvien,
//         'so_tien_rut' => $request->so_tien_rut,
//         'trang_thai' => 'da_duyet', // Hoặc trạng thái của bạn
//     ]);

//     return redirect()->route('thanhvien.danhsach')->with('success', 'Rút tiền thành công!');
// }




}