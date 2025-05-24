<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NapTien;

class NapTienAdminController extends Controller
{
    public function showHistory()
    {
        $dsNapTien = NapTien::orderBy('ngay_tao', 'desc')->paginate(5);
        return view('admin.nganhang.naptien.nganhang_naptien', compact('dsNapTien'));
    }

    public function edit($id)
    {
        $napTien = NapTien::find($id);
        if (!$napTien) {
            return redirect()->route('admin.naptien.index')->with('error', 'Đơn nạp không tồn tại hoặc đã bị xóa.');
        }
        return view('admin.nganhang.naptien.nganhang_naptien_edit', compact('napTien'));

    }



    public function update(Request $request, $id)
    {
        $napTien = NapTien::find($id);

if (!$napTien) {
    return redirect()->route('admin.naptien.index')->with('error', 'Đơn nạp không tồn tại hoặc đã bị xóa.');
}

if ($request->input('updated_at') !== $napTien->updated_at->toDateTimeString()) {
    return redirect()->back()->withErrors('Dữ liệu đã được thay đổi bởi người khác. Vui lòng tải lại trang.');
}


        $validated = $request->validate([
            'trang_thai' => 'required|in:cho_duyet,da_duyet,huy',
        ]);
        $oldStatus = $napTien->trang_thai;
        $newStatus = $request->trang_thai;

        $napTien->trang_thai = $newStatus;
        $napTien->save();
        if ($oldStatus != 'da_duyet' && $newStatus == 'da_duyet') {
            // Cộng tiền cho user
            $thanhvien = $napTien->thanhvien;
            if ($thanhvien) {
                $thanhvien->so_du += $napTien->so_tien_nap;
                $thanhvien->save();
            }
        }
        try {
            // Cập nhật trạng thái
            $napTien->trang_thai = $validated['trang_thai'];
            $napTien->save();

            return redirect()->route('admin.naptien.index')->with('success', 'Cập nhật trạng thái thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    // API kiểm tra tồn tại đơn nạp tiền (dùng cho Ajax)
    public function checkNapTienExists($id)
    {
        try {
            $exists = NapTien::where('id_lichsunap', $id)->exists();
            return response()->json(['exists' => $exists]);
        } catch (\Exception $e) {
            \Log::error('Error checking deposit existence: ' . $e->getMessage());
            return response()->json(['exists' => false]);
        }
    }

    // API kiểm tra updated_at (dùng cho optimistic locking)
    public function checkUpdatedAt($id)
    {
        $napTien = NapTien::find($id);
        if (!$napTien) {
            return response()->json(['updated_at' => null]);
        }
        return response()->json(['updated_at' => $napTien->updated_at->toDateTimeString()]);
    }
}
