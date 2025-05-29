<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThanhVien;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ThanhvienController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $dsThanhVien = ThanhVien::getThanhVienWithSearch($search, 5);
        return view('admin.thanhvien.danhsach', compact('dsThanhVien'));
    }

    public function edit($id)
    {
        try {
            $thanhvien = ThanhVien::findOrFail($id);
            return view('admin.thanhvien.thanhvien_edit', compact('thanhvien'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.thanhvien.danhsach')
                ->with('error', 'Thành viên không tồn tại hoặc đã bị xóa.');
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'ho_ten' => 'required|string|max:100',
            'tai_khoan' => 'required|string|max:50',
            'mat_khau' => 'nullable|string|min:6',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:20',
            'quyen' => 'nullable|in:admin,user',
            'updated_at' => 'required',
        ]);

        try {
            // Tìm thành viên
            $member = ThanhVien::findOrFail($id);

            // So sánh updated_at
            $formUpdatedAt = Carbon::parse($request->input('updated_at'));
            $dbUpdatedAt = $member->updated_at;

            if (!$dbUpdatedAt->equalTo($formUpdatedAt)) {
                return redirect()->route('admin.thanhvien.danhsach')->with('error', 'Dữ liệu đã bị thay đổi bởi người khác. Vui lòng tải lại trang và thử lại.');
            }

            // Thực hiện cập nhật
            $member = ThanhVien::updateMember($id, $data);

            if (!$member) {
                return redirect()->route('admin.thanhvien.danhsach')->with('error', 'Thành viên không tồn tại hoặc đã bị xóa.');
            }

            return redirect()->route('admin.thanhvien.danhsach')->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.thanhvien.danhsach')->with('error', 'Thành viên không tồn tại hoặc đã bị xóa.');
        }
    }

    public function destroy($id)
    {
        try {
            $result = ThanhVien::deleteMember($id);
            // Kiểm tra kết quả
            if ($result) {
                return redirect()->route('admin.thanhvien.danhsach')->with('success', 'Xóa thành công.');
            } else {
                return redirect()->route('admin.thanhvien.danhsach')->with('error', 'Thành viên không tồn tại. Load lại trang để cập nhật danh sách mới');
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.thanhvien.danhsach')->with('error', 'Thành viên không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            return redirect()->route('admin.thanhvien.danhsach')->with('error', 'Lỗi không xác định: ' . $e->getMessage());
        }
    }


    public static function deleteMember($id)
    {
        $member = self::findOrFail($id); // Nếu không tìm thấy sẽ throw ModelNotFoundException
        return $member->delete();
    }



    public function naptienForm($id)
    {
        try {
            $thanhvien = ThanhVien::findOrFail($id);
            return view('admin.thanhvien.thanhvien_naptien', compact('thanhvien'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.thanhvien.danhsach')
                ->with('error', 'Dữ liệu không tồn tại!.');
        }
    }

    public function naptien(Request $request, $id)
    {

        $thanhvien = ThanhVien::findOrFail($id);

        $amount = $request->so_tien ?? 0;
        $type = $request->transaction_type ?? null;

        $soDuCu = $request->so_du_cu ?? null;
        $soDuMoi = $thanhvien->so_du;

        if ($soDuCu !== null && $soDuCu != $soDuMoi) {
            if (!$request->has('force_update') || $request->input('force_update') != '1') {
                return redirect()->route('admin.thanhvien.danhsach')->with('error', 'Cập nhật không thành công do dữ liệu đã bị thay đổi');
            }
        }

        try {
            if ($type == 'naptien') {
                $thanhvien->adjustBalance($amount);
            } elseif ($type == 'rutien') {
                if ($amount > $soDuMoi) {
                    return redirect()->back()->with('error', 'Rút tiền không thành công: số dư không đủ');
                }
                $thanhvien->adjustBalance(-$amount);
            } else {
                return redirect()->back()->with('error', 'Loại giao dịch không hợp lệ');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.thanhvien.danhsach')->with('success', 'Cập nhật thành công');
    }
}
