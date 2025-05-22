<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThanhVien;

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
        $thanhvien = ThanhVien::findOrFail($id);
        return view('admin.thanhvien.thanhvien_edit', compact('thanhvien'));
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
        ]);

        ThanhVien::updateMember($id, $data);

        return redirect()->route('admin.thanhvien.danhsach')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        ThanhVien::deleteMember($id);
        return redirect()->route('admin.thanhvien.danhsach')->with('success', 'Đã xóa bản ghi thành công.');
    }

    public function naptienForm($id)
    {
        $thanhvien = ThanhVien::findOrFail($id);
        return view('admin.thanhvien.thanhvien_naptien', compact('thanhvien'));
    }

    public function naptien(Request $request, $id)
    {
        $thanhvien = ThanhVien::findOrFail($id);

        $amount = $request->so_tien ?? 0;
        $type = $request->transaction_type ?? null;

        try {
            if ($type == 'naptien') {
                $thanhvien->adjustBalance($amount);
            } elseif ($type == 'rutien') {
                $thanhvien->adjustBalance(-$amount);
            } else {
                return redirect()->back()->with('error', 'Loại giao dịch không hợp lệ');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.thanhvien.danhsach')->with('success', 'Cập nhật thành công');
    }

    public function rutienForm($id)
    {
        $thanhvien = ThanhVien::findOrFail($id);
        return view('admin.thanhvien.rutien', compact('thanhvien'));
    }

    public function rutien(Request $request, $id)
    {
        $request->validate([
            'so_tien_rut' => 'required|numeric|min:0',
        ]);

        $thanhvien = ThanhVien::findOrFail($id);

        try {
            $thanhvien->adjustBalance(-$request->so_tien_rut);

            // Thêm lịch sử rút tiền
            \App\Models\LichSuRut::create([
                'thanhvien_id' => $thanhvien->id_thanhvien,
                'so_tien_rut' => $request->so_tien_rut,
                'trang_thai' => 'da_duyet',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.thanhvien.danhsach')->with('success', 'Rút tiền thành công!');
    }
}
