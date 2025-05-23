<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NganHang;

use App\Models\RutTien;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;

class NganhangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $dsNganHang = NganHang::getBanks($search, 5);
        return view('admin.nganhang.danhsach.nganhang', compact('dsNganHang'));
    }

public function delete_nganhang($id)
{
    try {
        NganHang::deleteBank($id);
        return redirect()->route('admin.nganhang.index')->with('success', 'Đã xóa ngân hàng thành công.');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->route('admin.nganhang.index')->with('error', 'Ngân hàng không tồn tại hoặc đã bị xóa.');
    } catch (\Exception $e) {
        return redirect()->route('admin.nganhang.index')->with('error', 'Lỗi không xác định: ' . $e->getMessage());
    }
}



    public function ruttien(Request $request)
    {
        $search = $request->input('search');
        $dsRutTien = NganHang::getRutTiens($search, 5);
        return view('admin.nganhang.ruttien.nganhang_ruttien', compact('dsRutTien'));
    }

    public function destroyRutTien($id)
    {
        try {
            $record = RutTien::findOrFail($id);
            $record->delete();
            return redirect()->route('admin.nganhang.ruttien.index')->with('success', 'Đã xóa lịch sử rút tiền thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.nganhang.ruttien.index')->with('error', 'Lịch sử rút tiền không tồn tại hoặc đã bị xóa.');
        }
    }

    public function editRutTien($id)
    {
        $rutTien = RutTien::findOrFail($id);
        return view('admin.nganhang.ruttien.nganhang_ruttien_edit', compact('rutTien'));
    }

    public function updateRutTien(Request $request, $id)
    {
        $data = $request->validate([
            'trang_thai' => 'required|in:cho_duyet,da_duyet,huy',
            'updated_at' => 'nullable', // optional for backward compatibility
        ]);

        try {
            $rutTien = RutTien::findOrFail($id);

            // Check updated_at if present
            if ($request->has('updated_at')) {
                $formUpdatedAt = Carbon::parse($request->input('updated_at'));
                $dbUpdatedAt = $rutTien->updated_at;

                if (!$dbUpdatedAt->equalTo($formUpdatedAt)) {
                    return redirect()->route('admin.nganhang.ruttien.index')->with('error', 'Dữ liệu đã bị thay đổi bởi người khác. Vui lòng tải lại trang.');
                }
            }

            $rutTien->trang_thai = $data['trang_thai'];
            $rutTien->save();

            return redirect()->route('admin.nganhang.ruttien.index')->with('success', 'Cập nhật thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.nganhang.ruttien.index')->with('error', 'Lịch sử rút tiền không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            return redirect()->route('admin.nganhang.ruttien.index')->with('error', 'Lỗi khi cập nhật: ' . $e->getMessage());
        }
    }





    public function naptien(Request $request)
    {
        $search = $request->input('ma_don');
        $dsNapTien = NganHang::getNapTiens($search, 5);
        return view('admin.nganhang.naptien.nganhang_naptien', compact('dsNapTien'));
    }

    public function destroyNapTien($id)
    {
        NganHang::deleteNapTien($id);
        return redirect()->route('admin.nganhang.naptien.index')->with('success', 'Đã xóa lịch sử nạp tiền thành công.');
    }

    public function editNapTien($id)
    {
        $napTien = \App\Models\NapTien::findOrFail($id);
        return view('admin.nganhang.naptien.nganhang_naptien_edit', compact('napTien'));
    }

    public function updateNapTien(Request $request, $id)
    {
        $ma_don = $request->ma_don ?? \Illuminate\Support\Str::uuid();
        $data = $request->only(['so_tien_nap', 'noi_dung', 'trang_thai']);
        $data['ma_don'] = $ma_don;
        NganHang::updateNapTien($id, $data);
        return redirect()->route('admin.nganhang.naptien.index')->with('success', 'Cập nhật thành công');
    }



    

    public function create()
    {
        $banks = NganHang::all();
        return view('admin.nganhang.caidat_nganhang.caidat_nganhang', compact('banks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_thanhvien' => 'required|string',
            'ten_ngan_hang' => 'required|string|max:255',
            'so_tai_khoan' => 'required|string|max:100',
            'chu_tai_khoan' => 'required|string|max:100',
            'trang_thai' => 'nullable|boolean',
        ]);

        try {
            NganHang::createBank($validated);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('admin.nganhang.index')->with('success', 'Thêm ngân hàng thành công!');
    }
}