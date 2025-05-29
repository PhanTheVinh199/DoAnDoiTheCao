<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NganhangAdmin;
use App\Models\ThanhVien;
use Illuminate\Validation\Rule;

class NganhangAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $banks = NganhangAdmin::getBanks($search, 5);
        $query = NganhangAdmin::orderBy('created_at', 'desc');
        $page = $request->query('page');

        if (!is_null($page)) {
            if (!ctype_digit($page) || $page < 1 || $page > $banks->lastPage()) {
                return redirect()->route('admin.nganhang.admin.index')
                    ->with('error', 'Trang không hợp lệ!');
            }
        }
        return view('admin.NganHangAdmin.nganhangAdmin', compact('banks'));
    }

    public function create()
    {
        $admins = ThanhVien::where('quyen', 'admin')->get();
        return view('admin.NganHangAdmin.caidat_nganhang.caidat_nganhang', compact('admins'));
    }

    public function store(Request $request)
{
    $request->validate([
        'thanhvien_id' => 'required|exists:thanhvien,id_thanhvien',
        'ten_ngan_hang' => 'required|string|max:255',
        'so_tai_khoan' => [
            'required',
            'string',
            'max:255',
            Rule::unique('nganhang_admin')->where(function ($query) use ($request) {
                return $query->where('ten_ngan_hang', $request->ten_ngan_hang);
            }),
        ],
        'chu_tai_khoan' => 'required|string|max:255',
        'trang_thai' => 'required|in:hoat_dong,khong_hoat_dong',
    ], [
        'so_tai_khoan.unique' => 'Số tài khoản này đã tồn tại trong ngân hàng đã chọn.',
    ]);

    NganhangAdmin::create($request->all());

    return redirect()->route('admin.nganhang.admin.index')
                     ->with('success', 'Thêm ngân hàng thành công!');
}

    public function check($id)
    {
        $exists = Bank::where('id_danhsach', $id)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function destroy($id, Request $request)
{
    try {
        $bank = NganhangAdmin::findOrFail($id);
        $bank->delete();

        if ($request->ajax()) {
            return response()->json(['message' => 'Xóa ngân hàng thành công!']);
        }

        return redirect()->route('admin.nganhang.admin.index')
            ->with('success', 'Xóa ngân hàng thành công!');
    } catch (ModelNotFoundException $e) {
        $errorMessage = 'Ngân hàng này đã bị xóa trước đó hoặc không tồn tại.';
        if ($request->ajax()) {
            return response()->json(['message' => $errorMessage], 404);
        }
        return redirect()->route('admin.nganhang.admin.index')
            ->with('error', $errorMessage);
    } catch (\Exception $e) {
        $errorMessage = 'Có lỗi xảy ra khi xóa ngân hàng.';
        if ($request->ajax()) {
            return response()->json(['message' => $errorMessage], 500);
        }
        return redirect()->route('admin.nganhang.admin.index')
            ->with('error', $errorMessage);
    }
}


}
