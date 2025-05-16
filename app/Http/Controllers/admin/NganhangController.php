<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\NganHang;
use App\Models\ThanhVien;
use App\Models\RutTien;
use App\Models\NapTien;



class NganhangController extends Controller
{
    //Hiển thị danh sách ngân hàng
    public function index(Request $request)
    {
        // Tạo query để lấy tất cả dữ liệu ngân hàng
        $query = NganHang::query();

        // Kiểm tra xem có tìm kiếm theo từ khóa không
        if ($request->has('search') && $request->search != '') {
            // Lấy từ khóa tìm kiếm
            $searchTerm = $request->search;

            // Lọc theo tài khoản hoặc số tài khoản có chứa từ khóa
            $query->whereHas('thanhvien', function ($q) use ($searchTerm) {
                $q->where('tai_khoan', 'like', '%' . $searchTerm . '%')
                    ->orWhere('so_tai_khoan', 'like', '%' . $searchTerm . '%');
            });
        }

        // Sắp xếp theo thời gian tạo (created_at) theo thứ tự tăng dần
        $dsNganHang = $query->orderBy('created_at', 'asc')->paginate(5);

        // Trả về view và truyền dữ liệu vào
        return view('admin.nganhang.danhsach.nganhang', compact('dsNganHang'));
    }

    //Xóa 1 ngân hàng
    public function delete_nganhang($id)
    {
        // Tìm ngân hàng theo id và xóa
        $nganhang = NganHang::findOrFail($id);
        $nganhang->delete();

        // Chuyển hướng về danh sách ngân hàng và thông báo
        return redirect()->route('admin.nganhang.index')->with('success', 'Đã xóa ngân hàng thành công.');
    }






    public function ruttien(Request $request)
    {
        // Khởi tạo query
        $query = RutTien::query();

        // Tìm kiếm theo Mã Đơn
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('ma_don', 'like', '%' . $searchTerm . '%');
            // Uncomment the following to add search by account as well
            // $query->orWhereHas('thanhvien', function ($q) use ($searchTerm) {
            //     $q->where('tai_khoan', 'like', '%' . $searchTerm . '%');
            // });
        }

        // Sắp xếp theo thời gian tạo từ cũ đến mới
        $dsRutTien = $query->with(['thanhvien', 'nganhang'])
            ->orderBy('created_at', 'asc')  // Sắp xếp theo thời gian từ cũ đến mới
            ->paginate(5);

        return view('admin.nganhang.ruttien.nganhang_ruttien', compact('dsRutTien'));
    }





    //Xóa lịch sử rút tiền
    public function destroyRutTien($id)
    {
        $rutTien = RutTien::findOrFail($id);
        $rutTien->delete();

        return redirect()->route('admin.nganhang.ruttien.index')->with('success', 'Đã xóa lịch sử rút tiền thành công.');
    }



    //Sửa Lịch sử rút tiền
    public function editRutTien($id)
    {
        $rutTien = RutTien::findOrFail($id);
        return view('admin.nganhang.ruttien.nganhang_ruttien_edit', compact('rutTien'));
    }


    //Cập nhật lịch sử rút tiền
    public function updateRutTien(Request $request, $id)
    {
        $rutTien = RutTien::findOrFail($id);

        // Cập nhật thông tin
        $rutTien->update([
            'ma_don' => $request->ma_don,
            'so_tien_rut' => $request->so_tien_rut,
            'trang_thai' => $request->trang_thai
        ]);

        // Chuyển hướng trở lại trang danh sách và thông báo thành công
        return redirect()->route('admin.nganhang.ruttien.index')->with('success', 'Cập nhật thành công');
    }



    public function naptien(Request $request)
    {
        // Lấy dữ liệu nạp tiền từ cơ sở dữ liệu với điều kiện tìm kiếm
        $query = NapTien::query();

        // Kiểm tra có từ khóa tìm kiếm trong yêu cầu không
        if ($request->has('ma_don') && $request->ma_don != '') {
            $query->where('ma_don', 'like', '%' . $request->ma_don . '%'); // Tìm kiếm theo mã đơn
        }

        // Sắp xếp theo thời gian tạo từ cũ đến mới
        $dsNapTien = $query->orderBy('created_at', 'asc') // Sắp xếp theo thời gian tạo từ cũ đến mới
            ->paginate(5); // Lấy 2 bản ghi mỗi trang

        // Trả về view và truyền dữ liệu vào
        return view('admin.nganhang.naptien.nganhang_naptien', compact('dsNapTien'));
    }





    //Xóa lịch sử nạp tiền
    public function destroyNapTien($id)
    {
        // Tìm lịch sử nạp tiền theo ID
        $napTien = NapTien::findOrFail($id);

        // Xóa bản ghi
        $napTien->delete();

        // Quay lại trang danh sách và thông báo thành công
        return redirect()->route('admin.nganhang.naptien.index')->with('success', 'Đã xóa lịch sử nạp tiền thành công.');
    }

    public function editNapTien($id)
    {
        $napTien = NapTien::findOrFail($id);  // Đảm bảo rằng bạn đang sử dụng đúng tên model
        return view('admin.nganhang.naptien.nganhang_naptien_edit', compact('napTien'));
    }

    public function updateNapTien(Request $request, $id)
    {
        $napTien = NapTien::findOrFail($id);

        // Đảm bảo ma_don không bị bỏ trống, hoặc gán giá trị mặc định nếu cần
        $ma_don = $request->ma_don ?? Str::uuid(); // Gán giá trị mặc định nếu ma_don không được cung cấp

        // Cập nhật thông tin
        $napTien->update([
            'ma_don' => $ma_don,
            'so_tien_nap' => $request->so_tien_nap,
            'noi_dung' => $request->noi_dung,
            'trang_thai' => $request->trang_thai
        ]);

        return redirect()->route('admin.nganhang.naptien.index')->with('success', 'Cập nhật thành công');
    }




    // Hiển thị form thêm ngân hàng
    public function create()
    {
        $banks = NganHang::all(); // Lấy danh sách ngân hàng để hiển thị nếu cần
        return view('admin.nganhang.caidat_nganhang.caidat_nganhang', compact('banks'));
    }

    // Xử lý lưu ngân hàng mới
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'ten_thanhvien' => 'required|string',
            'ten_ngan_hang' => 'required|string|max:255',
            'so_tai_khoan' => 'required|string|max:100',
            'chu_tai_khoan' => 'required|string|max:100',
            'trang_thai' => 'nullable|boolean', // Đảm bảo trang_thai là kiểu boolean
        ]);

        // Tìm kiếm thành viên bằng tài khoản
        $thanhvien = ThanhVien::where('tai_khoan', $validated['ten_thanhvien'])->first();

        // Kiểm tra nếu không tìm thấy thành viên
        if (!$thanhvien) {
            return back()->with('error', 'Không tìm thấy thành viên: ' . $validated['ten_thanhvien'])
                ->withInput();  // Giữ lại dữ liệu đã nhập
        }

        // Xử lý giá trị trang_thai, nếu không có thì mặc định là true
        $trang_thai = $request->has('trang_thai') ? $request->trang_thai : true;

        // Tạo mới ngân hàng
        NganHang::create([
            'thanhvien_id' => $thanhvien->id_thanhvien,  // Sử dụng ID thành viên hợp lệ
            'ten_ngan_hang' => $validated['ten_ngan_hang'],
            'so_tai_khoan' => $validated['so_tai_khoan'],
            'chu_tai_khoan' => $validated['chu_tai_khoan'],
            'trang_thai' => $trang_thai,  // Sử dụng giá trị trang_thai đã kiểm tra
        ]);

        // Trả về trang trước với thông báo thành công
        return redirect()->route('admin.nganhang.index')->with('success', 'Thêm ngân hàng thành công!');
    }
}
