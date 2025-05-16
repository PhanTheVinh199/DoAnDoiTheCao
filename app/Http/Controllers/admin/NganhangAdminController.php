<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NganhangAdmin;
use App\Models\ThanhVien;
use App\Models\NapTien;
use Illuminate\Http\Request;

class NganhangAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = NganhangAdmin::with('thanhvien');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ten_ngan_hang', 'like', "%{$search}%")
                  ->orWhere('so_tai_khoan', 'like', "%{$search}%")
                  ->orWhere('chu_tai_khoan', 'like', "%{$search}%");
            });
        }

        $banks = $query->latest()->paginate(5);
        return view('admin.NganHangAdmin.nganhangAdmin', compact('banks'));
    }

    public function create()
    {
        $admins = ThanhVien::where('quyen', 'admin')->get();
        return view('admin.NganHangAdmin.caidat_nganhang.caidat_nganhang', compact('admins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'thanhvien_id' => 'required|exists:thanhvien,id_thanhvien',
            'ten_ngan_hang' => 'required|string|max:255',
            'so_tai_khoan' => 'required|string|max:100|unique:nganhang_admin,so_tai_khoan',
            'chu_tai_khoan' => 'required|string|max:255',
            'trang_thai' => 'required|in:hoat_dong,khong_hoat_dong',
        ]);

        NganhangAdmin::create($validated);

        return redirect()->route('admin.nganhang.admin.index')->with('success', 'Thêm ngân hàng admin thành công');
    }

    public function destroy($id)
    {
        $bank = NganhangAdmin::findOrFail($id);
        $bank->delete();

        return redirect()->route('admin.nganhang.admin.index')->with('success', 'Xóa ngân hàng admin thành công');
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
}
